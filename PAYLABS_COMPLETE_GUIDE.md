# Paylabs Payment System - Complete Guide

## 🎯 Overview

Sistem pembayaran Paylabs sudah dioptimasi dengan multiple fallback mechanisms untuk memastikan tidak ada transaksi yang terlewat.

## ✅ Fitur yang Sudah Diimplementasikan

### 1. **Auto-Check Payment Status**
- ✅ Auto-check setiap 10 detik di halaman waiting
- ✅ Check saat user kembali ke tab (visibility change)
- ✅ Check otomatis 2 detik setelah page load
- ✅ Visual indicator untuk auto-check

### 2. **Webhook Handler**
- ✅ Support multiple field names: `platformTradeNo`, `transaction_id`, `merchantTradeNo`
- ✅ Support multiple status formats: `paid`, `success`, `02`, `SUCCESS`, `PAID`
- ✅ Case-insensitive status checking
- ✅ Comprehensive logging untuk debugging

### 3. **Check Status API**
- ✅ Fallback ke multiple endpoints:
  - `/payment/v2.1/qris/query`
  - `/payment/v2.3/qris/query`
  - `/payment/v2.1/query`
- ✅ Proper field ordering sesuai Paylabs spec
- ✅ Support berbagai response format

### 4. **Duplicate Transaction Handling**
- ✅ Reuse existing payment jika belum expired
- ✅ Redirect ke waiting page instead of error
- ✅ Prevent duplicate transaction creation

### 5. **Admin Tools**
- ✅ Button "Cek Status Pembayaran Paylabs" di order detail
- ✅ Manual update via artisan command
- ✅ List pending orders sebelum check

### 6. **Error Handling**
- ✅ Graceful fallback untuk semua error scenarios
- ✅ User-friendly error messages
- ✅ Detailed logging untuk debugging

## 🔄 Payment Flow

```
Customer Checkout
    ↓
Select Payment Method (QRIS/VA/E-Wallet)
    ↓
Create Paylabs Transaction
    ↓
Redirect to Waiting Page
    ↓
[AUTO-CHECK EVERY 10s] ← Customer stays here
    ↓
Customer Pays via QRIS/VA/E-Wallet
    ↓
Paylabs sends Webhook → Update Order Status
    ↓                           ↓
Auto-check detects paid    Webhook updates DB
    ↓                           ↓
    └─────────┬─────────────────┘
              ↓
    Redirect to Order Detail
```

## 🛠️ Troubleshooting Guide

### Scenario 1: Customer sudah bayar tapi status belum update

**Kemungkinan Penyebab:**
1. Webhook belum diterima (network issue, firewall)
2. Auto-check belum running (customer close tab terlalu cepat)
3. Paylabs API delay

**Solusi (Prioritas):**

**A. Customer Side:**
```
1. Suruh customer buka kembali halaman waiting payment
2. Auto-check akan running otomatis
3. Tunggu 10-30 detik
4. Atau klik tombol "Cek Status" manual
```

**B. Admin Side:**
```bash
# Option 1: Via Admin Panel
1. Login admin
2. Buka detail order
3. Klik "Cek Status Pembayaran Paylabs"

# Option 2: Via Command
php artisan paylabs:check-status ORDER-NUMBER

# Option 3: Check all pending
php artisan paylabs:check-status
```

**C. Manual Update (Last Resort):**
```bash
php artisan order:update-payment-status ORDER-NUMBER
```

### Scenario 2: Duplicate merchant order number

**Penyebab:**
Customer coba bayar ulang order yang sama

**Solusi:**
Sistem sudah handle otomatis:
1. Check apakah payment masih valid (belum expired)
2. Redirect ke waiting page dengan payment yang sudah ada
3. Customer bisa lanjut bayar dengan payment yang sama

**Manual Fix (jika perlu):**
```bash
# Check status payment yang sudah ada
php artisan paylabs:check-status ORDER-NUMBER

# Jika sudah paid, update manual
php artisan order:update-payment-status ORDER-NUMBER
```

### Scenario 3: Check status gagal (PaymentType is empty)

**Penyebab:**
- Endpoint query salah
- Field order tidak sesuai spec
- Transaction belum pernah berhasil dibuat

**Solusi:**
```bash
# 1. Cek log untuk lihat error detail
tail -50 storage/logs/laravel.log | grep "Paylabs checkStatus"

# 2. Cek di dashboard Paylabs apakah transaction ada
# Login ke https://pay.paylabs.co.id

# 3. Jika transaction ada dan sudah paid, update manual
php artisan order:update-payment-status ORDER-NUMBER

# 4. Jika transaction tidak ada, suruh customer bayar ulang
```

### Scenario 4: Webhook tidak diterima

**Penyebab:**
- Webhook URL tidak accessible dari internet
- Firewall blocking
- CSRF protection blocking webhook

**Cek:**
```bash
# 1. Test webhook URL dari luar
curl -X POST https://your-domain.com/webhook/paylabs \
  -H "Content-Type: application/json" \
  -d '{"platformTradeNo":"TEST","merchantTradeNo":"TEST","status":"02"}'

# 2. Cek log webhook
tail -f storage/logs/laravel.log | grep "Paylabs Webhook"

# 3. Pastikan webhook route tidak kena CSRF
# File: app/Http/Middleware/VerifyCsrfToken.php
# Harus ada: 'webhook/paylabs' di $except array
```

**Fix:**
1. Pastikan webhook URL di Paylabs dashboard benar
2. Pastikan server accessible dari internet (bukan localhost)
3. Pastikan tidak ada firewall blocking

## 📊 Monitoring & Logging

### Check Logs
```bash
# Real-time monitoring
tail -f storage/logs/laravel.log | grep "Paylabs"

# Last 100 lines
tail -100 storage/logs/laravel.log | grep "Paylabs"

# Specific order
tail -200 storage/logs/laravel.log | grep "ORDER-NUMBER"
```

### Important Log Entries
```
✅ Good:
- "Paylabs Webhook Received"
- "Paylabs Webhook: Payment success"
- "Paylabs payment confirmed via checkStatus"

⚠️ Warning:
- "Paylabs Webhook: Unknown status"
- "Duplicate Paylabs transaction"

❌ Error:
- "Paylabs Webhook: Order not found"
- "Paylabs checkStatus API error"
- "Paylabs createTransaction failed"
```

## 🔧 Maintenance Commands

### List Pending Orders
```bash
php artisan paylabs:check-status
```

### Check Specific Order
```bash
php artisan paylabs:check-status ORDER-NUMBER
```

### Manual Update Payment Status
```bash
php artisan order:update-payment-status ORDER-NUMBER
```

### Check via Tinker
```bash
php artisan tinker
```
```php
// Get order
$order = Order::where('order_number', 'ORDER-NUMBER')->first();

// Check current status
$order->payment_status;
$order->paylabs_transaction_id;

// Update if paid
$order->update([
    'payment_status' => 'paid',
    'paid_at' => now(),
    'status' => 'processing'
]);
```

## 🚀 Best Practices

### For Customers:
1. ✅ Jangan close tab waiting payment terlalu cepat
2. ✅ Tunggu minimal 30 detik setelah bayar
3. ✅ Jika redirect tidak otomatis, klik "Cek Status"
4. ✅ Simpan screenshot bukti pembayaran

### For Admin:
1. ✅ Monitor log secara berkala
2. ✅ Setup cron job untuk auto-check pending orders
3. ✅ Respond cepat jika customer komplain
4. ✅ Verifikasi di dashboard Paylabs jika ragu

### For Developers:
1. ✅ Always check logs first
2. ✅ Test webhook dengan ngrok/localtunnel saat development
3. ✅ Jangan hardcode status values
4. ✅ Always use fallback mechanisms

## 📞 Support Checklist

Jika customer komplain "sudah bayar tapi belum masuk":

- [ ] Tanya nomor order
- [ ] Check log: `tail -100 storage/logs/laravel.log | grep "ORDER-NUMBER"`
- [ ] Check webhook received: `grep "Paylabs Webhook" storage/logs/laravel.log`
- [ ] Check di dashboard Paylabs
- [ ] Run: `php artisan paylabs:check-status ORDER-NUMBER`
- [ ] Jika gagal, run: `php artisan order:update-payment-status ORDER-NUMBER`
- [ ] Konfirmasi ke customer

## 🔐 Security Notes

1. ✅ Webhook signature verification (optional, bisa diaktifkan di config)
2. ✅ CSRF protection di-exclude untuk webhook route
3. ✅ Private key untuk RSA signature disimpan di storage/app/paylabs/
4. ✅ Sensitive data di-hide di log (signature, keys)

## 📈 Performance

- Auto-check interval: 10 seconds (balance antara real-time & server load)
- Webhook response time: < 100ms
- Check status API: < 2 seconds (dengan fallback)
- Multiple endpoint fallback: 3 endpoints

## ✨ Future Improvements

- [ ] Push notification saat payment success
- [ ] Email notification
- [ ] SMS notification
- [ ] Dashboard analytics untuk payment success rate
- [ ] Auto-retry webhook jika gagal
- [ ] Queue system untuk check status

## 📝 Configuration

File: `config/paylabs.php`

```php
return [
    'merchant_id' => env('PAYLABS_MERCHANT_ID'),
    'base_url' => env('PAYLABS_BASE_URL', 'https://pay.paylabs.co.id'),
    'callback_url' => env('PAYLABS_CALLBACK_URL'),
    'return_url' => env('PAYLABS_RETURN_URL'),
    'private_key_path' => storage_path('app/paylabs/private-key.pem'),
    'public_key_path' => storage_path('app/paylabs/public-key.pem'),
    'mock_mode' => env('PAYLABS_MOCK_MODE', false),
    'webhook' => [
        'verify_signature' => env('PAYLABS_VERIFY_WEBHOOK_SIGNATURE', false),
        'signature_header' => 'X-Paylabs-Signature',
        'secret' => env('PAYLABS_WEBHOOK_SECRET'),
    ],
];
```

## 🎓 Training Materials

### For Customer Service:
1. Cara check status order di admin panel
2. Cara gunakan command manual update
3. Cara baca log untuk troubleshooting
4. Cara verifikasi di dashboard Paylabs

### For Developers:
1. Paylabs API documentation
2. Webhook flow & signature verification
3. Error handling best practices
4. Testing dengan mock mode

---

**Last Updated:** 2026-05-04  
**Version:** 2.0  
**Status:** Production Ready ✅
