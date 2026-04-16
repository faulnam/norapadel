<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaylabsService
{
    protected $merchantId;
    protected $apiKey;
    protected $baseUrl;
    protected $sandbox;

    public function __construct()
    {
        $this->merchantId = config('paylabs.merchant_id');
        $this->apiKey = config('paylabs.api_key');
        $this->baseUrl = config('paylabs.base_url');
        $this->sandbox = config('paylabs.sandbox', true);
    }

    /**
     * Create payment transaction
     * 
     * @param array $data
     * @return array
     */
    public function createTransaction(array $data)
    {
        // Mock data for sandbox testing
        if ($this->sandbox) {
            return $this->mockCreateTransaction($data);
        }

        try {
            $payload = [
                'merchant_id' => $this->merchantId,
                'merchant_ref_no' => $data['order_number'],
                'amount' => $data['amount'],
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'customer_phone' => $data['customer_phone'],
                'payment_method' => $data['payment_method'],
                'payment_channel' => $data['payment_channel'] ?? null,
                'description' => $data['description'] ?? 'Order #' . $data['order_number'],
                'callback_url' => config('paylabs.callback_url'),
                'return_url' => str_replace('{order_id}', $data['order_id'], config('paylabs.return_url')),
                'expired_at' => now()->addHours(24)->toIso8601String(),
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/v1/payment/create', $payload);

            if ($response->successful()) {
                $result = $response->json();
                
                return [
                    'success' => true,
                    'data' => [
                        'transaction_id' => $result['data']['transaction_id'] ?? null,
                        'payment_url' => $result['data']['payment_url'] ?? null,
                        'va_number' => $result['data']['va_number'] ?? null,
                        'qr_string' => $result['data']['qr_string'] ?? null,
                        'expired_at' => $result['data']['expired_at'] ?? null,
                        'payment_method' => $data['payment_method'],
                        'payment_channel' => $data['payment_channel'] ?? null,
                    ],
                ];
            }

            Log::error('Paylabs createTransaction failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to create payment: ' . ($response->json()['message'] ?? $response->body()),
            ];

        } catch (\Exception $e) {
            Log::error('Paylabs createTransaction exception', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check transaction status
     * 
     * @param string $transactionId
     * @return array
     */
    public function checkStatus(string $transactionId)
    {
        // Mock data for sandbox
        if ($this->sandbox) {
            return $this->mockCheckStatus($transactionId);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get($this->baseUrl . '/v1/payment/status/' . $transactionId);

            if ($response->successful()) {
                $result = $response->json();
                
                return [
                    'success' => true,
                    'data' => [
                        'transaction_id' => $result['data']['transaction_id'] ?? null,
                        'merchant_ref_no' => $result['data']['merchant_ref_no'] ?? null,
                        'status' => $result['data']['status'] ?? 'pending',
                        'amount' => $result['data']['amount'] ?? 0,
                        'paid_at' => $result['data']['paid_at'] ?? null,
                    ],
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to check status',
            ];

        } catch (\Exception $e) {
            Log::error('Paylabs checkStatus exception', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Cancel transaction
     * 
     * @param string $transactionId
     * @return bool
     */
    public function cancelTransaction(string $transactionId)
    {
        // Mock for sandbox
        if ($this->sandbox) {
            return true;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->post($this->baseUrl . '/v1/payment/cancel', [
                'transaction_id' => $transactionId,
            ]);

            return $response->successful();

        } catch (\Exception $e) {
            Log::error('Paylabs cancelTransaction exception', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Mock create transaction for sandbox testing
     */
    protected function mockCreateTransaction(array $data)
    {
        $transactionId = 'PAYLABS-' . strtoupper(uniqid());
        
        $mockData = [
            'transaction_id' => $transactionId,
            'payment_method' => $data['payment_method'],
            'payment_channel' => $data['payment_channel'] ?? null,
            'expired_at' => now()->addHours(24)->toIso8601String(),
        ];

        // Generate mock data based on payment method
        if ($data['payment_method'] === 'va') {
            $channel = strtolower(str_replace('VA_', '', $data['payment_channel'] ?? ''));
            $vaNumbers = [
                'bca' => '8808' . rand(10000000, 99999999),
                'bni' => '8808' . rand(10000000, 99999999),
                'bri' => '8808' . rand(10000000, 99999999),
                'mandiri' => '8808' . rand(1000000000, 9999999999),
                'permata' => '8808' . rand(10000000, 99999999),
            ];
            $mockData['va_number'] = $vaNumbers[$channel] ?? '8808' . rand(10000000, 99999999);
            $mockData['payment_url'] = null;
        } elseif ($data['payment_method'] === 'qris') {
            $mockData['qr_url'] = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode('PAYLABS-MOCK-' . $transactionId);
            $mockData['payment_url'] = null;
        } elseif ($data['payment_method'] === 'ewallet') {
            $mockData['deeplink_url'] = '#mock-ewallet-deeplink';
            $mockData['payment_url'] = null;
        } elseif ($data['payment_method'] === 'retail') {
            $mockData['payment_code'] = 'MOCK' . rand(100000, 999999);
            $mockData['payment_url'] = null;
        }

        return [
            'success' => true,
            'data' => $mockData,
        ];
    }

    /**
     * Mock check status for sandbox testing
     */
    protected function mockCheckStatus(string $transactionId)
    {
        return [
            'success' => true,
            'data' => [
                'transaction_id' => $transactionId,
                'merchant_ref_no' => 'ORDER-' . rand(1000, 9999),
                'status' => 'pending',
                'amount' => 0,
                'paid_at' => null,
            ],
        ];
    }
}
