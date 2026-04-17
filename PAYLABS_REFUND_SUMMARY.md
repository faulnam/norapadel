# Summary: Integrasi Refund Paylabs

## Changes Made

### 1. PaylabsService.php
**Added:**
- `refundTransaction($transactionId, $amount, $reason)` - Method untuk refund via Paylabs API
- `mockRefundTransaction($transactionId, $amount)` - Mock refund untuk sandbox mode

**Endpoint:**
- Production: `POST https://api.paylabs.co.id/api/v1/payment/refund`
- Sandbox: Mock data dengan status 'completed'

**Return:**
```php
[
    'success' => true,
    'data' => [
        'refund_id' => 'REFUND-XXX',
        'transaction_id' => 'PAYLABS-XXX',
        'amount' => 100000,
        'status' => 'completed',
        'refunded_at' => '2024-01-01T10:00:00Z'
    ]
]
```

### 2. OrderController.php
**Updated:** `processRefund()` method

**Logic Flow:**
1. Set refund status ke PENDING
2. Check jika payment via Paylabs:
   - Call `PaylabsService::refundTransaction()`
   - Success: Update ke COMPLETED + simpan refund_id
   - Failed: Tetap PENDING, return error
3. Jika payment manual/lainnya: Langsung COMPLETED (proses manual admin)

## Key Features

✅ **Automatic Refund** - Refund otomatis via Paylabs API untuk pembayaran gateway
✅ **Sandbox Support** - Mock data untuk testing tanpa hit API production
✅ **Error Handling** - Proper error handling dengan status PENDING/COMPLETED/FAILED
✅ **Logging** - Semua proses refund di-log untuk audit trail
✅ **Fallback** - Manual refund untuk pembayaran non-Paylabs

## Database Fields Used

- `payment_gateway` - Gateway yang digunakan ('paylabs')
- `payment_gateway_transaction_id` - Transaction ID dari Paylabs
- `refund_status` - Status refund (pending/completed/failed)
- `refund_amount` - Jumlah refund
- `refund_at` - Timestamp refund
- `refund_transaction_id` - Refund ID dari Paylabs

## User Experience

**Customer membatalkan order:**
1. Klik "Batalkan Pesanan" (status = processing)
2. Sistem otomatis refund jika sudah bayar via Paylabs
3. Notifikasi: "Dana sebesar Rp XXX akan dikembalikan dalam 1-3 hari kerja"
4. Stock produk dikembalikan otomatis

**Refund Timeline:**
- API response: Instant
- Dana masuk customer: 1-3 hari kerja

## Testing

**Sandbox Mode (Default):**
```env
PAYLABS_SANDBOX=true
```
- Semua refund success dengan mock data
- Tidak hit API production

**Production Mode:**
```env
PAYLABS_SANDBOX=false
PAYLABS_MERCHANT_ID=your_merchant_id
PAYLABS_API_KEY=your_api_key
```

## Files Modified

1. `app/Services/PaylabsService.php` - Added refundTransaction() method
2. `app/Http/Controllers/Customer/OrderController.php` - Updated processRefund() logic
3. `PAYLABS_REFUND_INTEGRATION.md` - Comprehensive documentation
4. `PAYLABS_REFUND_SUMMARY.md` - This summary file
