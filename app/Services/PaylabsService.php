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
    protected $timeout;
    protected $connectTimeout;

    public function __construct()
    {
        $this->merchantId = config('paylabs.merchant_id');
        $this->apiKey = config('paylabs.api_key');
        $this->baseUrl = config('paylabs.base_url');
        $this->sandbox = config('paylabs.sandbox', true);
        $this->timeout = (int) config('paylabs.timeout', 30);
        $this->connectTimeout = (int) config('paylabs.connect_timeout', 10);
    }

    protected function canCallLiveApi(): bool
    {
        return !empty($this->merchantId) && !empty($this->apiKey) && !empty($this->baseUrl);
    }

    protected function getHttpClient()
    {
        $verifyOption = $this->resolveSslVerifyOption();

        return Http::timeout($this->timeout)
            ->connectTimeout($this->connectTimeout)
            ->withOptions([
                'verify' => $verifyOption,
            ]);
    }

    /**
     * Resolve SSL verification strategy for outgoing Paylabs requests.
     *
     * - string path: use custom CA bundle file
     * - false: disable SSL verification (local/testing only)
     * - true: default system verification
     */
    protected function resolveSslVerifyOption(): bool|string
    {
        $caBundle = trim((string) config('paylabs.ca_bundle', ''));

        $verifySslRaw = config('paylabs.verify_ssl', true);
        $verifySsl = filter_var($verifySslRaw, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if ($verifySsl === null) {
            $verifySsl = (bool) $verifySslRaw;
        }

        if ($caBundle !== '' && is_file($caBundle)) {
            return $caBundle;
        }

        if (!$verifySsl) {
            return false;
        }

        if ($caBundle !== '' && !is_file($caBundle)) {
            Log::warning('Paylabs CA bundle path tidak ditemukan, fallback ke default SSL verify.', [
                'ca_bundle' => $caBundle,
            ]);
        }

        return true;
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

        if (!$this->canCallLiveApi()) {
            return [
                'success' => false,
                'message' => 'Konfigurasi Paylabs production belum lengkap. Pastikan PAYLABS_MERCHANT_ID, PAYLABS_API_KEY, dan PAYLABS_BASE_URL/PAYLABS_SANDBOX sudah benar.',
            ];
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

            $response = $this->getHttpClient()->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/v1/payment/create', $payload);

            if ($response->successful()) {
                $result = $response->json();
                $resultData = $result['data'] ?? [];

                $vaNumber = $resultData['va_number']
                    ?? $resultData['virtual_account_number']
                    ?? $resultData['virtual_account']
                    ?? $resultData['account_number']
                    ?? $resultData['payment_number']
                    ?? null;

                $qrString = $resultData['qr_string']
                    ?? $resultData['qr_content']
                    ?? null;

                $qrUrl = $resultData['qr_url']
                    ?? $resultData['qr_image_url']
                    ?? $resultData['qr_code_url']
                    ?? null;

                $deeplinkUrl = $resultData['deeplink_url']
                    ?? $resultData['redirect_url']
                    ?? null;

                $paymentCode = $resultData['payment_code']
                    ?? $resultData['bill_code']
                    ?? $resultData['pay_code']
                    ?? null;
                
                return [
                    'success' => true,
                    'data' => [
                        'transaction_id' => $resultData['transaction_id'] ?? null,
                        'payment_url' => $resultData['payment_url'] ?? $resultData['redirect_url'] ?? null,
                        'va_number' => $vaNumber,
                        'qr_string' => $qrString,
                        'qr_url' => $qrUrl,
                        'deeplink_url' => $deeplinkUrl,
                        'payment_code' => $paymentCode,
                        'expired_at' => $resultData['expired_at'] ?? null,
                        'payment_method' => $data['payment_method'],
                        'payment_channel' => $data['payment_channel'] ?? null,
                        'raw_data' => $resultData,
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

        if (!$this->canCallLiveApi()) {
            return [
                'success' => false,
                'message' => 'Konfigurasi Paylabs production belum lengkap.',
            ];
        }

        try {
            $response = $this->getHttpClient()->withHeaders([
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

        if (!$this->canCallLiveApi()) {
            return false;
        }

        try {
            $response = $this->getHttpClient()->withHeaders([
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
     * Refund transaction
     * 
     * @param string $transactionId
     * @param float $amount
     * @param string $reason
     * @return array
     */
    public function refundTransaction(string $transactionId, float $amount, string $reason = 'Order cancelled')
    {
        // Mock for sandbox
        if ($this->sandbox) {
            return $this->mockRefundTransaction($transactionId, $amount);
        }

        if (!$this->canCallLiveApi()) {
            return [
                'success' => false,
                'message' => 'Konfigurasi Paylabs production belum lengkap.',
            ];
        }

        try {
            $response = $this->getHttpClient()->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/v1/payment/refund', [
                'transaction_id' => $transactionId,
                'amount' => $amount,
                'reason' => $reason,
            ]);

            if ($response->successful()) {
                $result = $response->json();
                
                return [
                    'success' => true,
                    'data' => [
                        'refund_id' => $result['data']['refund_id'] ?? null,
                        'transaction_id' => $transactionId,
                        'amount' => $amount,
                        'status' => $result['data']['status'] ?? 'pending',
                        'refunded_at' => $result['data']['refunded_at'] ?? now()->toIso8601String(),
                    ],
                ];
            }

            Log::error('Paylabs refund failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to process refund: ' . ($response->json()['message'] ?? $response->body()),
            ];

        } catch (\Exception $e) {
            Log::error('Paylabs refund exception', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
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

    /**
     * Mock refund for sandbox testing
     */
    protected function mockRefundTransaction(string $transactionId, float $amount)
    {
        return [
            'success' => true,
            'data' => [
                'refund_id' => 'REFUND-' . strtoupper(uniqid()),
                'transaction_id' => $transactionId,
                'amount' => $amount,
                'status' => 'completed',
                'refunded_at' => now()->toIso8601String(),
            ],
        ];
    }
}
