# Paylabs Payment Status Issue - Troubleshooting Guide

## Problem
Customer sudah transfer via QRIS tapi status order masih "Pembayaran belum diterima" padahal di dashboard Paylabs uang sudah masuk.

## Root Cause
1. **Webhook tidak terkirim/diterima** - Paylabs webhook mungkin gagal atau belum dikonfigurasi
2. **Status format berbeda** - Paylabs mengirim status code '02' atau 'SUCCESS' tapi sistem hanya cek 'paid'/'success'
3. **Field name berbeda** - Paylabs bisa kirim `platformTradeNo`, `tradeStatus`, dll dengan nama berbeda

## Solution Applied

### 1. Webhook Handler Enhancement
File: `app/Http/Controllers/PaylabsWebhookController.php`

**Changes:**
- Support multiple field names: `transaction_id`, `platformTradeNo`, `platform_trade_no`
- Support multiple status formats: `paid`, `success`, `02`, `SUCCESS`, `PAID`
- Added detailed logging untuk debugging
- Case-insensitive status checking

### 2. Check Status Enhancement
File: `app/Http/Controllers/Customer/PaylabsPaymentController.php`

**Changes:**
- Support status code '02' (Paylabs paid status code)
- Added logging untuk track status checking
- Update order saat status '02' detected

### 3. Paylabs Service Enhancement
File: `app/Services/PaylabsService.php`

**Changes:**
- Enhanced status mapping dengan match expression
- Support multiple status formats dari API response
- Added `raw_status` field untuk debugging
- Comprehensive logging

### 4. Manual Check Command
File: `app/Console/Commands/CheckPaylabsPaymentStatus.php`

**Usage:**
```bash
# Check specific order
php artisan paylabs:check-status ORDER-20240101-001

# Check all pending orders (last 7 days)
php artisan paylabs:check-status
```

## How to Fix Existing Orders

### Option 1: Run Manual Check Command
```bash
php artisan paylabs:check-status ORDER-NUMBER
```

### Option 2: Manual Database Update
```sql
UPDATE orders 
SET payment_status = 'paid', 
    paid_at = NOW(), 
    status = 'processing'
WHERE order_number = 'ORDER-NUMBER' 
AND payment_gateway = 'paylabs';
```

### Option 3: Via Tinker
```bash
php artisan tinker
```
```php
$order = Order::where('order_number', 'ORDER-NUMBER')->first();
$order->update([
    'payment_status' => 'paid',
    'paid_at' => now(),
    'status' => 'processing'
]);
```

## Testing

### 1. Check Webhook Logs
```bash
tail -f storage/logs/laravel.log | grep "Paylabs Webhook"
```

### 2. Test Webhook Manually
```bash
curl -X POST http://your-domain.com/webhook/paylabs \
  -H "Content-Type: application/json" \
  -d '{
    "platformTradeNo": "PAYLABS-123",
    "merchantTradeNo": "ORDER-20240101-001",
    "status": "02",
    "tradeStatus": "SUCCESS",
    "amount": "50000.00"
  }'
```

### 3. Check Status via Browser Console
```javascript
fetch('/customer/payment-paylabs/ORDER-ID/check-status')
  .then(r => r.json())
  .then(console.log)
```

## Paylabs Status Codes

| Code | Meaning | Action |
|------|---------|--------|
| 01 | Pending | Wait |
| 02 | Success/Paid | Update order to paid |
| 03 | Expired | Show expired message |
| 09 | Failed | Show failed message |

## Webhook Configuration

Pastikan webhook URL sudah dikonfigurasi di Paylabs dashboard:
```
https://your-domain.com/webhook/paylabs
```

**CSRF Protection:** Webhook route sudah di-exclude dari CSRF verification di `app/Http/Middleware/VerifyCsrfToken.php`

## Prevention

1. **Enable Webhook Logging**
   - Monitor `storage/logs/laravel.log` untuk webhook events
   
2. **Setup Cron Job**
   ```bash
   # Check pending payments every 5 minutes
   */5 * * * * cd /path/to/project && php artisan paylabs:check-status
   ```

3. **Alert System**
   - Setup notification saat ada order pending > 1 jam setelah created

## Debug Checklist

- [ ] Webhook URL accessible dari internet (not localhost)
- [ ] Webhook route tidak kena CSRF protection
- [ ] Paylabs transaction ID tersimpan di database
- [ ] Log webhook received di `storage/logs/laravel.log`
- [ ] Status code dari Paylabs API response
- [ ] Order number match dengan merchantTradeNo
- [ ] Database connection OK saat webhook hit

## Contact

Jika masalah masih terjadi, check:
1. Paylabs dashboard untuk transaction details
2. Laravel logs: `storage/logs/laravel.log`
3. Web server logs (nginx/apache)
4. Network logs (firewall, cloudflare, dll)
