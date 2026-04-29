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

    protected function generateTimestamp(): string
    {
        $dt = now('Asia/Jakarta');
        $milliseconds = str_pad((string)floor($dt->micro / 1000), 3, '0', STR_PAD_LEFT);
        return $dt->format('Y-m-d\TH:i:s') . '.' . $milliseconds . '+07:00';
    }

    protected function minifyJson(array $body): string
    {
        return json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * RSA SHA256withRSA signature untuk v4.8.1
     * Format: POST:endpoint:lowercase(sha256(body)):timestamp
     */
    protected function buildSignatureRSA(string $endpoint, string $minifiedBody, string $timestamp): string
    {
        // Hash body dengan SHA256 dan lowercase
        $bodyHash = strtolower(hash('sha256', $minifiedBody));
        
        // Format: POST:endpoint:bodyHash:timestamp
        $stringToSign = "POST:{$endpoint}:{$bodyHash}:{$timestamp}";

        Log::debug('Paylabs signature debug', [
            'endpoint' => $endpoint,
            'body' => $minifiedBody,
            'bodyHash' => $bodyHash,
            'timestamp' => $timestamp,
            'stringToSign' => $stringToSign,
        ]);

        // Load private key
        $privateKeyContent = file_get_contents($this->privateKeyPath);
        $privateKey = openssl_pkey_get_private($privateKeyContent);

        if ($privateKey === false) {
            $error = openssl_error_string();
            Log::error('Failed to load private key', ['error' => $error]);
            throw new \RuntimeException('Failed to load private key: ' . $error);
        }

        // Sign dengan SHA256
        $success = openssl_sign($stringToSign, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        
        if (!$success) {
            $error = openssl_error_string();
            Log::error('Failed to sign', ['error' => $error]);
            throw new \RuntimeException('Failed to sign: ' . $error);
        }

        openssl_free_key($privateKey);

        // Base64 encode
        $signatureBase64 = base64_encode($signature);
        
        Log::debug('Paylabs signature result', [
            'length' => strlen($signatureBase64),
            'full_signature' => $signatureBase64,
        ]);

        return $signatureBase64;
    }

    protected function buildHeaders(string $endpoint, array $body, string $requestId, string $timestamp): array
    {
        $minified  = $this->minifyJson($body);
        $signature = $this->buildSignatureRSA($endpoint, $minified, $timestamp);

        return [
            'Content-Type' => 'application/json;charset=utf-8',
            'X-TIMESTAMP'  => $timestamp,
            'X-SIGNATURE'  => $signature,
            'X-PARTNER-ID' => $this->merchantId,
            'X-REQUEST-ID' => $requestId,
        ];
    }

    public function createTransaction(array $data): array
    {
        if ($this->mockMode) {
            return $this->mockCreateTransaction($data);
        }

        if (!$this->canCallLiveApi()) {
            return ['success' => false, 'message' => 'Konfigurasi Paylabs belum lengkap.'];
        }

        $paymentChannel = $data['payment_channel'] ?? 'QRIS';
        $requestId      = (string) Str::uuid();
        $timestamp      = $this->generateTimestamp();
        $returnUrl      = str_replace('{order_id}', $data['order_id'], config('paylabs.return_url'));

        $payerName  = trim((string) ($data['customer_name']  ?? 'Customer')) ?: 'Customer';
        $payerPhone = trim((string) ($data['customer_phone'] ?? '08000000000')) ?: '08000000000';

        [$endpoint, $body] = $this->buildEndpointAndBody(
            $paymentChannel, $requestId, $data, $payerName, $payerPhone, $returnUrl
        );

        $headers = $this->buildHeaders($endpoint, $body, $requestId, $timestamp);
        $url     = $this->baseUrl . $endpoint;

        Log::info('Paylabs createTransaction request', [
            'url'      => $url,
            'endpoint' => $endpoint,
            'body'     => $body,
            'headers'  => array_merge($headers, ['X-SIGNATURE' => '***HIDDEN***']),
        ]);

        try {
            $response = $this->getHttpClient()
                ->withHeaders($headers)
                ->withBody($this->minifyJson($body), 'application/json')
                ->post($url);

            Log::info('Paylabs createTransaction response', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            if (str_contains($response->body(), '<!DOCTYPE html>')) {
                return ['success' => false, 'message' => 'Endpoint tidak ditemukan (404).'];
            }

            $result = $response->json();

            if (($result['errCode'] ?? '') === '0') {
                return [
                    'success' => true,
                    'data'    => [
                        'transaction_id'  => $result['platformTradeNo'] ?? $result['merchantTradeNo'] ?? null,
                        'merchant_ref_no' => $result['merchantTradeNo'] ?? null,
                        'payment_url'     => $result['url'] ?? $result['payUrl'] ?? null,
                        'qrCode'          => $result['qrCode'] ?? null,
                        'qrisUrl'         => $result['qrisUrl'] ?? null,
                        'vaCode'          => $result['vaCode'] ?? null,
                        'expired_at'      => $result['expiredTime'] ?? now()->addHours(24)->toIso8601String(),
                        'payment_method'  => $data['payment_method'],
                        'payment_channel' => $paymentChannel,
                        'raw_data'        => $result,
                    ],
                ];
            }

            $errMsg = $result['errCodeDes'] ?? $result['message'] ?? $response->body();
            Log::error('Paylabs createTransaction failed', [
                'errCode'       => $result['errCode'] ?? '-',
                'msg'           => $errMsg,
                'full_response' => $result,
            ]);
            return ['success' => false, 'message' => $errMsg];

        } catch (\Exception $e) {
            Log::error('Paylabs createTransaction exception', ['message' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    protected function buildEndpointAndBody(
        string $channel,
        string $requestId,
        array $data,
        string $payerName,
        string $payerPhone,
        string $returnUrl
    ): array {
        $amount    = number_format((float) $data['amount'], 2, '.', '');
        $goodsInfo = $data['description'] ?? 'Order #' . $data['order_number'];
        $notifyUrl = config('paylabs.callback_url');

        // QRIS - exact order from Signature Playground
        if ($channel === 'QRIS') {
            return [
                '/payment/v2.1/qris/create',
                [
                    'requestId'       => $requestId,
                    'merchantId'      => $this->merchantId,
                    'merchantTradeNo' => $data['order_number'],
                    'paymentType'     => 'QRIS',
                    'amount'          => $amount,
                    'productName'     => $goodsInfo,
                ],
            ];
        }

        // Virtual Account - exact order from Signature Playground
        if (str_starts_with($channel, 'VA_')) {
            $bankCode = strtoupper(substr($channel, 3));
            $vaTypeMap = [
                'BCA'     => 'BCAVA',
                'BNI'     => 'BNIVA',
                'BRI'     => 'BRIVA',
                'MANDIRI' => 'MandiriVA',
                'PERMATA' => 'PermataVA',
                'CIMB'    => 'CIMBVA',
                'BTN'     => 'BTNVA',
            ];
            $paymentType = $vaTypeMap[$bankCode] ?? ($bankCode . 'VA');
            
            return [
                '/payment/v2.1/va/create',
                [
                    'requestId'       => $requestId,
                    'merchantId'      => $this->merchantId,
                    'merchantTradeNo' => $data['order_number'],
                    'paymentType'     => $paymentType,
                    'amount'          => $amount,
                    'productName'     => $goodsInfo,
                    'payer'           => $payerName,
                ],
            ];
        }

        // E-Wallet
        if (str_starts_with($channel, 'EWALLET_')) {
            $walletType = strtoupper(substr($channel, 8));
            $expiredTime = now('Asia/Jakarta')->addHours(24)->format('Y-m-d\TH:i:s.v') . '+07:00';
            return [
                '/payment/v2.3/h5/createLink',
                [
                    'amount'          => $amount,
                    'expiredTime'     => $expiredTime,
                    'merchantId'      => $this->merchantId,
                    'merchantTradeNo' => $data['order_number'],
                    'notifyUrl'       => $notifyUrl,
                    'payer'           => $payerName,
                    'paymentType'     => $walletType,
                    'phoneNumber'     => $payerPhone,
                    'productName'     => $goodsInfo,
                    'redirectUrl'     => $returnUrl,
                    'requestId'       => $requestId,
                ],
            ];
        }

        // H5 fallback
        $expiredTime = now('Asia/Jakarta')->addHours(24)->format('Y-m-d\TH:i:s.v') . '+07:00';
        return [
            '/payment/v2.3/h5/createLink',
            [
                'amount'          => $amount,
                'expiredTime'     => $expiredTime,
                'merchantId'      => $this->merchantId,
                'merchantTradeNo' => $data['order_number'],
                'notifyUrl'       => $notifyUrl,
                'payer'           => $payerName,
                'paymentType'     => 'SHOPEEPAY',
                'phoneNumber'     => $payerPhone,
                'productName'     => $goodsInfo,
                'redirectUrl'     => $returnUrl,
                'requestId'       => $requestId,
            ],
        ];
    }

    public function checkStatus(string $transactionId): array
    {
        if ($this->mockMode) {
            return $this->mockCheckStatus($transactionId);
        }

        if (!$this->canCallLiveApi()) {
            return ['success' => false, 'message' => 'Konfigurasi Paylabs belum lengkap.'];
        }

        $endpoint  = '/payment/v2.3/qris/query';
        $requestId = (string) Str::uuid();
        $timestamp = $this->generateTimestamp();

        $body = [
            'merchantId'      => $this->merchantId,
            'requestId'       => $requestId,
            'merchantTradeNo' => $transactionId,
        ];

        $headers = $this->buildHeaders($endpoint, $body, $requestId, $timestamp);

        try {
            $response = $this->getHttpClient()
                ->withHeaders($headers)
                ->withBody($this->minifyJson($body), 'application/json')
                ->post($this->baseUrl . $endpoint);

            $result = $response->json();

            if (($result['errCode'] ?? '') === '0') {
                $status = match ($result['status'] ?? '01') {
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
        return [
            'success' => true,
            'data'    => [
                'transaction_id'  => 'MOCK-' . strtoupper(uniqid()),
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
