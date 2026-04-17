# Integrasi Refund Paylabs

## Overview
Sistem refund otomatis menggunakan API Paylabs untuk mengembalikan dana customer ketika order dibatalkan.

## Fitur Utama

### 1. Refund Otomatis via Paylabs API
- Refund otomatis untuk pembayaran yang dilakukan melalui Paylabs gateway
- Mendukung semua metode pembayaran Paylabs (VA, QRIS, E-Wallet, Retail)
- Tracking refund dengan refund_id dari Paylabs

### 2. Fallback untuk Pembayaran Manual
- Untuk pembayaran manual (upload bukti transfer), refund ditandai sebagai completed untuk proses manual oleh admin
- Untuk metode pembayaran lain (non-Paylabs), refund juga diproses manual

### 3. Status Refund
- **REFUND_PENDING**: Refund sedang diproses
- **REFUND_COMPLETED**: Refund berhasil diproses
- **REFUND_FAILED**: Refund gagal, perlu penanganan manual

## Implementasi Teknis

### PaylabsService - Method refundTransaction()

```php
public function refundTransaction(string $transactionId, float $amount, string $reason = 'Order cancelled')
```

**Parameters:**
- `$transactionId`: Transaction ID dari Paylabs (disimpan di `payment_gateway_transaction_id`)
- `$amount`: Jumlah yang akan di-refund
- `$reason`: Alasan refund (default: 'Order cancelled')

**Return:**
```php
[
    'success' => true/false,
    'data' => [
        'refund_id' => 'REFUND-XXX',
        'transaction_id' => 'PAYLABS-XXX',
        'amount' => 100000,
        'status' => 'completed',
        'refunded_at' => '2024-01-01T10:00:00Z'
    ],
    'message' => 'Error message if failed'
]
```

**Sandbox Mode:**
- Menggunakan mock data untuk testing
- Selalu return success dengan refund_id dummy
- Status langsung 'completed'

**Production Mode:**
- Hit endpoint: `POST /v1/payment/refund`
- Memerlukan Authorization Bearer token
- Response sesuai dengan API Paylabs

### OrderController - Method processRefund()

**Flow Logic:**

1. **Set Refund Pending**
   ```php
   $order->update([
       'refund_status' => Order::REFUND_PENDING,
       'refund_amount' => $refundAmount,
       'refund_at' => now(),
   ]);
   ```

2. **Check Payment Gateway**
   - Jika `payment_gateway === 'paylabs'` dan ada `payment_gateway_transaction_id`:
     - Call `PaylabsService::refundTransaction()`
     - Jika success: Update status ke `REFUND_COMPLETED` dan simpan `refund_transaction_id`
     - Jika failed: Tetap `REFUND_PENDING` untuk proses manual, return error

3. **Fallback untuk Non-Paylabs**
   - Langsung set status ke `REFUND_COMPLETED`
   - Admin akan proses refund manual

### Database Fields

**orders table:**
- `payment_gateway`: Gateway yang digunakan ('paylabs', 'manual', dll)
- `payment_gateway_transaction_id`: Transaction ID dari gateway
- `refund_status`: Status refund (null, 'pending', 'completed', 'failed')
- `refund_amount`: Jumlah yang di-refund
- `refund_at`: Timestamp refund dimulai
- `refund_transaction_id`: Refund ID dari Paylabs

## API Endpoint Paylabs

### Refund Endpoint

**Sandbox:**
```
POST https://sandbox.paylabs.co.id/api/v1/payment/refund
```

**Production:**
```
POST https://api.paylabs.co.id/api/v1/payment/refund
```

**Headers:**
```
Authorization: Bearer {API_KEY}
Content-Type: application/json
```

**Request Body:**
```json
{
    "transaction_id": "PAYLABS-XXX",
    "amount": 100000,
    "reason": "Order cancelled by customer"
}
```

**Response Success:**
```json
{
    "success": true,
    "data": {
        "refund_id": "REFUND-XXX",
        "transaction_id": "PAYLABS-XXX",
        "amount": 100000,
        "status": "completed",
        "refunded_at": "2024-01-01T10:00:00Z"
    }
}
```

**Response Failed:**
```json
{
    "success": false,
    "message": "Transaction not found or already refunded"
}
```

## User Flow

### Customer Membatalkan Order

1. Customer klik tombol "Batalkan Pesanan" (hanya saat status = 'processing')
2. Sistem check apakah perlu refund:
   - Jika COD: Tidak perlu refund
   - Jika belum bayar: Tidak perlu refund
   - Jika sudah bayar (non-COD): Perlu refund

3. **Jika Perlu Refund:**
   - Sistem call `processRefund()`
   - Jika payment via Paylabs:
     - Call Paylabs API refund
     - Jika success: Refund completed, dana kembali 1-3 hari kerja
     - Jika failed: Refund pending, admin akan proses manual
   - Jika payment manual/lainnya:
     - Refund completed, admin proses manual

4. **Stock Restoration:**
   - Stock produk dikembalikan otomatis

5. **Order Cancelled:**
   - Status order menjadi 'cancelled'
   - Cancel reason disimpan

6. **Notifikasi ke Customer:**
   - "Pesanan berhasil dibatalkan"
   - Jika ada refund: "Dana sebesar Rp XXX akan dikembalikan dalam 1-3 hari kerja"

## Testing

### Sandbox Mode (Default)

```env
PAYLABS_SANDBOX=true
```

- Semua refund akan success dengan mock data
- Tidak hit API Paylabs sebenarnya
- Cocok untuk development dan testing

### Production Mode

```env
PAYLABS_SANDBOX=false
PAYLABS_MERCHANT_ID=your_merchant_id
PAYLABS_API_KEY=your_api_key
```

- Hit API Paylabs production
- Memerlukan credentials valid
- Refund akan diproses sebenarnya

## Error Handling

### Refund Failed Scenarios

1. **Transaction ID tidak valid**
   - Status: REFUND_PENDING
   - Action: Admin check dan proses manual

2. **Insufficient balance di Paylabs**
   - Status: REFUND_PENDING
   - Action: Top up balance Paylabs, retry refund

3. **Transaction sudah di-refund sebelumnya**
   - Status: REFUND_FAILED
   - Action: Check di dashboard Paylabs

4. **Network error**
   - Status: REFUND_PENDING
   - Action: Retry atau proses manual

### Logging

Semua proses refund di-log:

```php
// Success
Log::info("Paylabs refund completed for order #XXX", [
    'refund_id' => 'REFUND-XXX',
    'amount' => 100000,
]);

// Failed
Log::error("Paylabs refund failed for order #XXX", [
    'error' => 'Error message',
]);
```

## Admin Dashboard

Admin dapat melihat status refund di halaman order detail:

- **Refund Pending**: Tampilkan warning, admin perlu follow up
- **Refund Completed**: Tampilkan info success dengan refund_id
- **Refund Failed**: Tampilkan error, admin perlu proses manual

## Keamanan

1. **Authorization**: Semua request ke Paylabs menggunakan Bearer token
2. **Validation**: Amount dan transaction_id divalidasi sebelum refund
3. **Transaction**: Refund process dalam DB transaction untuk data consistency
4. **Logging**: Semua aktivitas refund di-log untuk audit trail

## Waktu Refund

- **Paylabs API**: Instant (status completed langsung)
- **Dana masuk ke customer**: 1-3 hari kerja (tergantung bank/payment method)
- **Manual refund**: Tergantung proses admin

## Limitasi

1. Refund hanya bisa dilakukan untuk order dengan status 'processing'
2. Refund amount harus sama dengan total order (full refund)
3. Partial refund belum didukung
4. Refund hanya untuk pembayaran yang sudah completed

## Future Improvements

1. Partial refund support
2. Refund history tracking
3. Automatic retry untuk failed refunds
4. Webhook dari Paylabs untuk update status refund
5. Admin panel untuk manual refund approval
