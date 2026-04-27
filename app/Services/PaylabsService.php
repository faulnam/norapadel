<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaylabsService
{
    protected string $merchantId;
    protected string $baseUrl;
    protected bool   $mockMode;
    protected int    $timeout;
    protected int    $connectTimeout;
    protected string $privateKeyPath;
    protected string $publicKeyPath;

    public function __construct()
    {
        $this->merchantId     = (string) config('paylabs.merchant_id');
        $this->baseUrl        = rtrim((string) config('paylabs.base_url'), '/');
        $this->mockMode       = (bool) config('paylabs.mock_mode', false);
        $this->timeout        = (int) config('paylabs.timeout', 30);
        $this->connectTimeout = (int) config('paylabs.connect_timeout', 10);
        $this->privateKeyPath = (string) config('paylabs.private_key_path');
        $this->publicKeyPath  = (string) config('paylabs.public_key_path');
    }

    protected function canCallLiveApi(): bool
    {
        return !empty($this->merchantId)
            && !empty($this->baseUrl)
            && file_exists($this->privateKeyPath)
            && file_exists($this->publicKeyPath);
    }

    protected function getHttpClient()
    {
        $verifySsl = filter_var(config('paylabs.verify_ssl', false), FILTER_VALIDATE_BOOLEAN);
        return Http::timeout($this->timeout)
            ->connectTimeout($this->connectTimeout)
            ->withOptions(['verify' => $verifySsl]);
    }

    /**
     * Generate timestamp format: 2022-09-16T16:58:47.964+07:00
     */
    protected function generateTimestamp(): string
    {
        $now = now(config('app.timezone', 'Asia/Jakarta'));
        return $now->format('Y-m-d\TH:i:s.') .
               substr($now->format('u'), 0, 3) .
               $now->format('P');
    }

    /**
     * Minify JSON - hapus whitespace/newline di luar string
     */
    protected function minifyJson(array $body): string
    {
        $body = array_filter($body, fn($v) => $v !== null && $v !== '');
        return json_encode($body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Build RSA SHA256withRSA signature
     * stringContent = POST:endpoint:lowercase(sha256hex(minifiedBody)):timestamp
     */
    protected function buildSignature(string $endpoint, string $minifiedBody, string $timestamp): string
    {
        $bodyHash      = strtolower(hash('sha256', $minifiedBody));
        $stringContent = "POST:{$endpoint}:{$bodyHash}:{$timestamp}";

        $privateKeyContent = file_get_contents($this->privateKeyPath);
        $privateKey        = openssl_pkey_get_private($privateKeyContent);

        if ($privateKey === false) {
            throw new \RuntimeException('Failed to load private key');
        }

        $signed = openssl_sign($stringContent, $rawSignature, $privateKey, OPENSSL_ALGO_SHA256);

        if (!$signed) {
            throw new \RuntimeException('Failed to sign request');
        }

        return base64_encode($rawSignature);
    }

    /**
     * Build headers + signature
     */
    protected function buildHeaders(string $endpoint, array $body, string $requestId, string $timestamp): array
    {
        $minified  = $this->minifyJson($body);
        $signature = $this->buildSignature($endpoint, $minified, $timestamp);

        return [
            'Content-Type'  => 'application/json;charset=utf-8',
            'X-TIMESTAMP'   => $timestamp,
            'X-SIGNATURE'   => $signature,
            'X-PARTNER-ID'  => $this->merchantId,
            'X-REQUEST-ID'  => $requestId,
        ];
    }

    /**
     * Create payment - coba berbagai endpoint yang mungkin
     */
    public function createTransaction(array $data): array
    {
        if ($this->mockMode) {
            return $this->mockCreateTransaction($data);
        }

        if (!$this->canCallLiveApi()) {
            return ['success' => false, 'message' => 'Konfigurasi Paylabs belum lengkap. Pastikan private key dan public key sudah ada.'];
        }

        // Coba endpoint v2.1 dulu (yang ada di playground)
        $endpoint  = '/payment/v2.1/va/create';
        $requestId = (string) Str::uuid();
        $timestamp = $this->generateTimestamp();

        $returnUrl = str_replace('{order_id}', $data['order_id'], config('paylabs.return_url'));

        $body = array_filter([
            'requestId'       => $requestId,
            'merchantId'      => $this->merchantId,
            'merchantTradeNo' => $data['order_number'],
            'paymentType'     => $data['payment_channel'] ?? 'QRIS',
            'amount'          => number_format((float) $data['amount'], 2, '.', ''),
            'productName'     => $data['description'] ?? 'Order #' . $data['order_number'],
            'phoneNumber'     => $data['customer_phone'] ?? '08000000000',
            'notifyUrl'       => config('paylabs.callback_url'),
            'redirectUrl'     => $returnUrl,
        ], fn($v) => $v !== null && $v !== '');

        $headers = $this->buildHeaders($endpoint, $body, $requestId, $timestamp);
        $url     = $this->baseUrl . $endpoint;

        Log::info('Paylabs createTransaction request', [
            'url' => $url,
            'endpoint' => $endpoint,
            'body' => $body,
            'headers' => array_merge($headers, ['X-SIGNATURE' => '***HIDDEN***']),
            'timestamp' => $timestamp,
        ]);

        try {
            $minified = $this->minifyJson($body);
            $response = $this->getHttpClient()
                ->withHeaders($headers)
                ->withBody($minified, 'application/json')
                ->post($url);

            Log::info('Paylabs createTransaction response', [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body'   => $response->body(),
            ]);

            // Cek apakah response HTML (404)
            if (str_contains($response->body(), '<!DOCTYPE html>')) {
                Log::error('Paylabs endpoint not found (404)', ['endpoint' => $endpoint]);
                return ['success' => false, 'message' => 'Endpoint tidak ditemukan. Silakan hubungi CS Paylabs untuk endpoint yang benar.'];
            }

            $result = $response->json();

            if ($response->successful() && ($result['errCode'] ?? '') === '0') {
                return [
                    'success' => true,
                    'data'    => [
                        'transaction_id'  => $result['merchantTradeNo'] ?? null,
                        'merchant_ref_no' => $result['merchantTradeNo'] ?? null,
                        'payment_url'     => $result['url'] ?? $result['payUrl'] ?? null,
                        'qr_url'          => $result['qrCode'] ?? $result['qrisUrl'] ?? null,
                        'va_number'       => $result['bankCardNo'] ?? null,
                        'expired_at'      => $result['expiredTime'] ?? now()->addHours(24)->toIso8601String(),
                        'payment_method'  => $data['payment_method'],
                        'payment_channel' => $data['payment_channel'] ?? null,
                        'raw_data'        => $result,
                    ],
                ];
            }

            $errMsg = $result['errCodeDes'] ?? $result['message'] ?? $response->body();
            Log::error('Paylabs createTransaction failed', [
                'errCode' => $result['errCode'] ?? '-',
                'msg' => $errMsg,
                'full_response' => $result,
            ]);
            return ['success' => false, 'message' => $errMsg];

        } catch (\Exception $e) {
            Log::error('Paylabs createTransaction exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Check payment status
     */
    public function checkStatus(string $transactionId): array
    {
        if ($this->mockMode) {
            return $this->mockCheckStatus($transactionId);
        }

        if (!$this->canCallLiveApi()) {
            return ['success' => false, 'message' => 'Konfigurasi Paylabs belum lengkap.'];
        }

        $endpoint  = '/payment/v2.3/query';
        $requestId = (string) Str::uuid();
        $timestamp = $this->generateTimestamp();

        $body = [
            'merchantId'      => $this->merchantId,
            'merchantTradeNo' => $transactionId,
            'requestId'       => $requestId,
        ];

        $headers = $this->buildHeaders($endpoint, $body, $requestId, $timestamp);
        $url     = $this->baseUrl . $endpoint;

        try {
            $minified = $this->minifyJson($body);
            $response = $this->getHttpClient()
                ->withHeaders($headers)
                ->withBody($minified, 'application/json')
                ->post($url);

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
            Log::error('Paylabs checkStatus exception', ['message' => $e->getMessage()]);
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
        return [
            'success' => true,
            'data'    => [
                'transaction_id'  => $transactionId,
                'payment_url'     => route('customer.payment.paylabs.waiting', ['order' => $data['order_id']]),
                'payment_method'  => $data['payment_method'],
                'payment_channel' => $data['payment_channel'] ?? null,
                'expired_at'      => now()->addHours(24)->toIso8601String(),
            ],
        ];
    }

    protected function mockCheckStatus(string $transactionId): array
    {
        return ['success' => true, 'data' => ['transaction_id' => $transactionId, 'status' => 'pending', 'amount' => 0]];
    }
}