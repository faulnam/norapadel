<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaylabsService
{
    protected string $merchantId;
    protected string $apiKey;
    protected string $baseUrl;
    protected bool   $mockMode;
    protected int    $timeout;
    protected int    $connectTimeout;

    public function __construct()
    {
        $this->merchantId     = (string) config('paylabs.merchant_id');
        $this->apiKey         = (string) config('paylabs.api_key');
        $this->baseUrl        = rtrim((string) config('paylabs.base_url'), '/');
        $this->mockMode       = (bool) config('paylabs.mock_mode', false);
        $this->timeout        = (int) config('paylabs.timeout', 30);
        $this->connectTimeout = (int) config('paylabs.connect_timeout', 10);
    }

    protected function canCallLiveApi(): bool
    {
        return !empty($this->merchantId) && !empty($this->apiKey) && !empty($this->baseUrl);
    }

    protected function getHttpClient()
    {
        $verifySsl = filter_var(config('paylabs.verify_ssl', true), FILTER_VALIDATE_BOOLEAN);
        return Http::timeout($this->timeout)
            ->connectTimeout($this->connectTimeout)
            ->withOptions(['verify' => $verifySsl]);
    }

    /**
     * Buat signature SHA256 untuk sistem iotpay
     * stringA = semua param diurutkan A-Z
     * sign = SHA256(stringA + "&key=" + apiKey).toUpperCase()
     */
    protected function buildSign(array $params): string
    {
        $params = array_filter($params, fn($v) => $v !== null && $v !== '');
        ksort($params);
        $stringA    = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
        $stringTemp = $stringA . '&key=' . $this->apiKey;
        return strtoupper(hash('sha256', $stringTemp));
    }

    public function createTransaction(array $data): array
    {
        if ($this->mockMode) {
            return $this->mockCreateTransaction($data);
        }

        if (!$this->canCallLiveApi()) {
            return ['success' => false, 'message' => 'Konfigurasi Paylabs belum lengkap.'];
        }

        $paymentType = $data['payment_channel'];
        $requestId   = (string) Str::uuid();
        $notifyUrl   = config('paylabs.callback_url');
        $returnUrl   = str_replace('{order_id}', $data['order_id'], config('paylabs.return_url'));

        // Payload tanpa sign dulu
        $payload = array_filter([
            'merchantId'      => $this->merchantId,
            'merchantTradeNo' => $data['order_number'],
            'requestId'       => $requestId,
            'paymentType'     => $paymentType,
            'amount'          => number_format((float) $data['amount'], 2, '.', ''),
            'productName'     => $data['description'] ?? 'Order #' . $data['order_number'],
            'notifyUrl'       => $notifyUrl,
            'phoneNumber'     => $data['customer_phone'] ?? null,
            'email'           => $data['customer_email'] ?? null,
        ], fn($v) => $v !== null && $v !== '');

        // Tambahkan sign
        $payload['sign'] = $this->buildSign($payload);

        $url = $this->baseUrl . '/v1/payment/create';

        Log::info('Paylabs request', ['url' => $url, 'payload' => $payload]);

        try {
            $response = $this->getHttpClient()
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, $payload);

            Log::info('Paylabs response', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['errCode']) && $result['errCode'] === '0') {
                $actions = $result['paymentActions'] ?? [];
                return [
                    'success' => true,
                    'data'    => [
                        'transaction_id'  => $result['platformTradeNo'] ?? null,
                        'merchant_ref_no' => $result['merchantTradeNo'] ?? null,
                        'payment_url'     => $actions['payUrl'] ?? $result['payUrl'] ?? null,
                        'va_number'       => $actions['bankCardNo'] ?? $result['bankCardNo'] ?? null,
                        'qr_string'       => $result['qrCode'] ?? null,
                        'qr_url'          => $result['qrisUrl'] ?? null,
                        'deeplink_url'    => $actions['mobilePayUrl'] ?? null,
                        'payment_code'    => $actions['payCode'] ?? $result['payCode'] ?? null,
                        'expired_at'      => $result['expiredTime'] ?? null,
                        'payment_method'  => $data['payment_method'],
                        'payment_channel' => $paymentType,
                        'raw_data'        => $result,
                    ],
                ];
            }

            $errMsg = $result['errCodeDes'] ?? $result['message'] ?? $response->body();
            Log::error('Paylabs failed', ['errCode' => $result['errCode'] ?? '-', 'msg' => $errMsg]);
            return ['success' => false, 'message' => $errMsg];

        } catch (\Exception $e) {
            Log::error('Paylabs exception', ['message' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function checkStatus(string $transactionId): array
    {
        if ($this->mockMode) {
            return $this->mockCheckStatus($transactionId);
        }

        $payload = array_filter([
            'merchantId'      => $this->merchantId,
            'merchantTradeNo' => $transactionId,
            'requestId'       => (string) Str::uuid(),
        ]);
        $payload['sign'] = $this->buildSign($payload);

        try {
            $response = $this->getHttpClient()
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($this->baseUrl . '/v1/payment/query', $payload);

            $result = $response->json();

            if ($response->successful() && ($result['errCode'] ?? '') === '0') {
                $rawStatus = $result['status'] ?? '01';
                $status = match ($rawStatus) {
                    '02'    => 'paid',
                    '09'    => 'failed',
                    default => 'pending',
                };
                return [
                    'success' => true,
                    'data'    => [
                        'transaction_id'  => $result['platformTradeNo'] ?? null,
                        'merchant_ref_no' => $result['merchantTradeNo'] ?? null,
                        'status'          => $status,
                        'amount'          => $result['amount'] ?? 0,
                        'paid_at'         => $result['successTime'] ?? null,
                    ],
                ];
            }

            return ['success' => false, 'message' => $result['errCodeDes'] ?? 'Failed to check status'];

        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function cancelTransaction(string $transactionId): bool { return true; }

    public function refundTransaction(string $transactionId, float $amount, string $reason = ''): array
    {
        return ['success' => true, 'data' => ['refund_id' => 'REFUND-' . uniqid()]];
    }

    protected function mockCreateTransaction(array $data): array
    {
        $transactionId = 'MOCK-' . strtoupper(uniqid());
        $channel       = $data['payment_channel'] ?? '';
        $mockData = [
            'transaction_id'  => $transactionId,
            'payment_method'  => $data['payment_method'],
            'payment_channel' => $channel,
            'expired_at'      => now()->addHours(24)->toIso8601String(),
        ];
        if (str_ends_with($channel, 'VA')) {
            $mockData['va_number'] = '8808' . rand(10000000, 99999999);
        } elseif ($channel === 'QRIS') {
            $mockData['qr_url'] = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode('MOCK-' . $transactionId);
        } elseif (str_ends_with($channel, 'BALANCE')) {
            $mockData['deeplink_url'] = '#mock-ewallet';
        } else {
            $mockData['payment_code'] = 'MOCK' . rand(100000, 999999);
        }
        return ['success' => true, 'data' => $mockData];
    }

    protected function mockCheckStatus(string $transactionId): array
    {
        return ['success' => true, 'data' => ['transaction_id' => $transactionId, 'status' => 'pending', 'amount' => 0]];
    }
}