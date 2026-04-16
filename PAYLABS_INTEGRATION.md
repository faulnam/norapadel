# Paylabs Payment Gateway Integration

## Overview
Integrasi payment gateway Paylabs untuk sistem pembayaran online dengan dukungan Virtual Account, QRIS, E-Wallet, dan Retail.

## Features
- ✅ Virtual Account (BCA, BNI, BRI, Mandiri, Permata)
- ✅ QRIS (Quick Response Code Indonesian Standard)
- ✅ E-Wallet (OVO, DANA, ShopeePay, LinkAja, GoPay)
- ✅ Retail (Alfamart, Indomaret)
- ✅ Auto check payment status
- ✅ Webhook callback handler
- ✅ Sandbox mode untuk testing
- ✅ Payment expiry timer

## Configuration

### 1. Environment Variables
Tambahkan ke file `.env`:
```env
PAYLABS_MERCHANT_ID=your_merchant_id
PAYLABS_API_KEY=your_api_key
PAYLABS_SANDBOX=true
```

### 2. Config File
File: `config/paylabs.php`
```php
return [
    'merchant_id' => env('PAYLABS_MERCHANT_ID'),
    'api_key' => env('PAYLABS_API_KEY'),
    'sandbox' => env('PAYLABS_SANDBOX', true),
    'base_url' => env('PAYLABS_SANDBOX', true) 
        ? 'https://sandbox-api.paylabs.co.id' 
        : 'https://api.paylabs.co.id',
    
    'payment_methods' => [
        'va' => ['BCA', 'BNI', 'BRI', 'Mandiri', 'Permata'],
        'qris' => ['QRIS'],
        'ewallet' => ['OVO', 'DANA', 'ShopeePay', 'LinkAja', 'GoPay'],
        'retail' => ['Alfamart', 'Indomaret'],
    ],
    
    'callback_url' => env('APP_URL') . '/webhook/paylabs',
    'return_url' => env('APP_URL') . '/customer/orders',
];
```

## Database Schema

### Migration: Add Paylabs Fields to Orders Table
File: `database/migrations/2026_04_16_100000_add_paylabs_fields_to_orders_table.php`

Fields yang ditambahkan:
- `paylabs_transaction_id` - Transaction ID dari Paylabs
- `payment_gateway` - Gateway yang digunakan (paylabs/pakasir)
- `payment_channel` - Channel pembayaran (VA_BCA, QRIS, dll)
- `payment_data` - JSON data pembayaran

```bash
php artisan migrate
```

## Payment Flow

### 1. Customer Checkout
```
Customer → Checkout → Select Payment Gateway → Pilih Paylabs
```

### 2. Select Payment Method
```
Paylabs → Pilih Metode (VA/QRIS/E-Wallet/Retail) → Process Payment
```

### 3. Waiting for Payment
```
Waiting Page → Show Instructions → Auto Check Status → Payment Success
```

### 4. Payment Confirmation
```
Webhook Callback → Update Order Status → Notify Customer
```

## Routes

### Customer Routes
```php
// Select payment gateway
Route::get('/customer/payment/{order}/select-gateway', [OrderController::class, 'selectGateway'])
    ->name('customer.payment.select-gateway');

// Paylabs payment
Route::get('/customer/payment/{order}/paylabs', [PaylabsPaymentController::class, 'show'])
    ->name('customer.payment.paylabs.show');
Route::post('/customer/payment/{order}/paylabs', [PaylabsPaymentController::class, 'process'])
    ->name('customer.payment.paylabs.process');
Route::get('/customer/payment/{order}/paylabs/waiting', [PaylabsPaymentController::class, 'waiting'])
    ->name('customer.payment.paylabs.waiting');
Route::get('/customer/payment/{order}/paylabs/check-status', [PaylabsPaymentController::class, 'checkStatus'])
    ->name('customer.payment.paylabs.check-status');
Route::post('/customer/payment/{order}/paylabs/simulate', [PaylabsPaymentController::class, 'simulatePayment'])
    ->name('customer.payment.paylabs.simulate');
```

### Webhook Route
```php
Route::post('/webhook/paylabs', [PaylabsWebhookController::class, 'handle'])
    ->name('webhook.paylabs');
```

## API Service

### PaylabsService Methods

#### 1. Create Transaction
```php
$paylabs = app(PaylabsService::class);

$result = $paylabs->createTransaction([
    'order_id' => $order->id,
    'order_number' => $order->order_number,
    'amount' => (int) $order->total,
    'customer_name' => $order->user->name,
    'customer_email' => $order->user->email,
    'customer_phone' => $order->user->phone,
    'payment_method' => 'va', // va, qris, ewallet, retail
    'payment_channel' => 'VA_BCA', // VA_BCA, QRIS, EWALLET_OVO, dll
]);

// Response:
[
    'success' => true,
    'data' => [
        'transaction_id' => 'TRX123456',
        'va_number' => '1234567890', // untuk VA
        'qr_url' => 'https://...', // untuk QRIS
        'deeplink_url' => 'https://...', // untuk E-Wallet
        'payment_code' => 'ABC123', // untuk Retail
        'expired_at' => '2024-01-01 23:59:59',
    ]
]
```

#### 2. Check Payment Status
```php
$result = $paylabs->checkStatus($transactionId);

// Response:
[
    'success' => true,
    'data' => [
        'status' => 'paid', // pending, paid, expired, failed
        'paid_at' => '2024-01-01 12:00:00',
    ]
]
```

#### 3. Cancel Transaction
```php
$result = $paylabs->cancelTransaction($transactionId);

// Response:
[
    'success' => true,
    'message' => 'Transaction cancelled'
]
```

## Payment Instructions

### Virtual Account
1. Buka aplikasi mobile banking atau ATM
2. Pilih menu Transfer / Bayar
3. Masukkan nomor Virtual Account
4. Masukkan nominal pembayaran
5. Konfirmasi pembayaran

### QRIS
1. Buka aplikasi e-wallet atau mobile banking
2. Pilih menu Scan QR
3. Scan QR Code yang ditampilkan
4. Konfirmasi pembayaran

### E-Wallet
1. Klik tombol "Buka Aplikasi"
2. Aplikasi e-wallet akan terbuka otomatis
3. Konfirmasi pembayaran di aplikasi

### Retail
1. Kunjungi Alfamart/Indomaret terdekat
2. Berikan kode pembayaran ke kasir
3. Bayar sejumlah yang tertera
4. Simpan struk pembayaran

## Webhook Handler

### Webhook Endpoint
```
POST /webhook/paylabs
```

### Webhook Payload
```json
{
    "transaction_id": "TRX123456",
    "order_number": "ORD-20240101-001",
    "status": "paid",
    "amount": 100000,
    "paid_at": "2024-01-01 12:00:00",
    "payment_method": "va",
    "payment_channel": "VA_BCA"
}
```

### Webhook Handler Logic
```php
public function handle(Request $request)
{
    // Verify signature
    if (!$this->verifySignature($request)) {
        return response()->json(['error' => 'Invalid signature'], 401);
    }

    // Find order
    $order = Order::where('order_number', $request->order_number)->first();
    
    // Update order status
    if ($request->status === 'paid') {
        $order->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
            'status' => 'paid',
        ]);
    }

    return response()->json(['success' => true]);
}
```

## Testing (Sandbox Mode)

### 1. Enable Sandbox Mode
```env
PAYLABS_SANDBOX=true
```

### 2. Test Credentials
```env
PAYLABS_MERCHANT_ID=sandbox_merchant
PAYLABS_API_KEY=sandbox_api_key
```

### 3. Simulate Payment
Pada halaman waiting, akan muncul tombol "Simulasi Pembayaran Berhasil" untuk testing.

### 4. Test Payment Methods
- **VA**: Gunakan nomor VA dummy: `1234567890`
- **QRIS**: Scan QR code dummy
- **E-Wallet**: Klik deeplink akan redirect ke success page
- **Retail**: Gunakan kode pembayaran dummy: `ABC123`

## Production Deployment

### 1. Disable Sandbox Mode
```env
PAYLABS_SANDBOX=false
```

### 2. Use Production Credentials
```env
PAYLABS_MERCHANT_ID=your_production_merchant_id
PAYLABS_API_KEY=your_production_api_key
```

### 3. Configure Webhook URL
Daftarkan webhook URL di dashboard Paylabs:
```
https://yourdomain.com/webhook/paylabs
```

### 4. SSL Certificate
Pastikan website menggunakan HTTPS untuk webhook callback.

## Troubleshooting

### Payment Not Updating
1. Cek webhook URL sudah terdaftar di Paylabs
2. Cek signature verification
3. Cek log di `storage/logs/laravel.log`

### Transaction Failed
1. Cek API credentials
2. Cek sandbox/production mode
3. Cek amount format (harus integer)

### Webhook Not Received
1. Cek firewall/security rules
2. Cek SSL certificate
3. Test webhook dengan tools seperti ngrok

## Security

### 1. Signature Verification
Semua webhook request harus diverifikasi signature-nya:
```php
protected function verifySignature(Request $request): bool
{
    $signature = $request->header('X-Paylabs-Signature');
    $payload = $request->getContent();
    $apiKey = config('paylabs.api_key');
    
    $expectedSignature = hash_hmac('sha256', $payload, $apiKey);
    
    return hash_equals($expectedSignature, $signature);
}
```

### 2. HTTPS Only
Webhook endpoint harus menggunakan HTTPS di production.

### 3. IP Whitelist
Tambahkan IP whitelist Paylabs di firewall untuk keamanan tambahan.

## Support

### Documentation
- Paylabs API Docs: https://docs.paylabs.co.id
- Laravel Docs: https://laravel.com/docs

### Contact
- Email: support@paylabs.co.id
- Phone: +62 21 1234 5678

## Changelog

### v1.0.0 (2024-01-01)
- Initial release
- Support VA, QRIS, E-Wallet, Retail
- Sandbox mode
- Webhook handler
- Auto check payment status
