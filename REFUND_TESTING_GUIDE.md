# Testing Guide - Sistem Refund

## 🧪 Cara Testing Sistem Refund

### Prerequisites

1. **Setup Environment**
```env
# Paylabs Mock Mode
PAYLABS_SANDBOX=true
PAYLABS_MOCK_MODE=true

# Biteship Mock Mode
BITESHIP_USE_MOCK=true
BITESHIP_SANDBOX=true
```

2. **Clear Cache**
```bash
php artisan config:clear
php artisan cache:clear
```

---

## Test Case 1: Refund Paylabs (Mock Mode)

### Scenario: Customer cancel order yang sudah dibayar via Paylabs

**Steps:**

1. **Buat Order Baru**
   - Login sebagai customer
   - Tambah produk ke cart
   - Checkout
   - Pilih metode pembayaran: Paylabs (QRIS/VA/E-Wallet)

2. **Simulasi Pembayaran Sukses**
   - Karena mock mode, payment akan auto-success
   - Order status berubah: `pending_payment` → `processing`
   - `payment_gateway` = 'paylabs'
   - `payment_gateway_transaction_id` = 'MOCK-XXXXX'

3. **Cancel Order**
   - Buka halaman order detail
   - Klik tombol "Batalkan Pesanan"
   - Isi alasan: "Salah pesan"
   - Konfirmasi

4. **Expected Result:**
   ```
   ✅ Pesanan berhasil dibatalkan
   ✅ Dana sebesar Rp XXX akan dikembalikan dalam 1-3 hari kerja
   ✅ Order status = 'cancelled'
   ✅ refund_status = 'completed'
   ✅ refund_amount = total order
   ✅ refund_transaction_id = 'REFUND-MOCK-XXXXX'
   ```

5. **Check Log:**
   ```bash
   tail -f storage/logs/laravel.log
   ```
   
   Expected log entries:
   ```
   [INFO] Paylabs MOCK refund
   [INFO] Paylabs payment refund completed for order #NP-20250207-XXXXX
   [INFO] Biteship shipping refund processed for order #NP-20250207-XXXXX
   ```

---

## Test Case 2: Refund Biteship Auto (Order Belum Pickup)

### Scenario: Cancel order sebelum kurir pickup

**Steps:**

1. **Buat Order dengan Biteship**
   - Order sudah dibayar (status = `processing`)
   - Biteship order sudah dibuat
   - Status Biteship: `confirmed` atau `allocated`

2. **Cancel Order**
   - Klik "Batalkan Pesanan"
   - Alasan: "Berubah pikiran"

3. **Expected Result:**
   ```
   ✅ Pesanan berhasil dibatalkan
   ✅ Refund ongkir akan diproses otomatis oleh Biteship
   ✅ Order status = 'cancelled'
   ✅ biteship_tracking_status = 'cancelled'
   ```

4. **Check Log:**
   ```
   [INFO] Biteship refund shipping cost check
   [INFO] Order berhasil dibatalkan. Refund ongkir akan diproses otomatis
   ```

---

## Test Case 3: Refund Manual (Order Sudah Pickup)

### Scenario: Cancel order setelah kurir pickup

**Steps:**

1. **Buat Order dengan Status Picked**
   - Order status = `shipped`
   - Biteship status = `picked` atau `dropping_off`

2. **Try Cancel Order**
   - Seharusnya TIDAK BISA cancel
   - Error: "Pesanan tidak dapat dibatalkan karena sudah dalam proses pengiriman"

3. **Expected Result:**
   ```
   ❌ Pesanan tidak dapat dibatalkan
   ℹ️ Status harus 'processing' untuk bisa cancel
   ```

---

## Test Case 4: Refund Payment Manual (Non-Paylabs)

### Scenario: Cancel order yang dibayar via transfer manual

**Steps:**

1. **Buat Order dengan Payment Manual**
   - Upload bukti transfer
   - Admin verify payment
   - Order status = `processing`
   - `payment_gateway` = null atau 'manual'

2. **Cancel Order**
   - Klik "Batalkan Pesanan"

3. **Expected Result:**
   ```
   ✅ Pesanan berhasil dibatalkan
   ✅ Refund pembayaran akan diproses manual oleh admin
   ✅ refund_status = 'completed'
   ℹ️ Admin perlu transfer manual ke customer
   ```

4. **Check Log:**
   ```
   [INFO] Manual payment refund marked for order #NP-20250207-XXXXX
   ```

---

## Test Case 5: Refund COD (No Refund Needed)

### Scenario: Cancel order COD (belum bayar)

**Steps:**

1. **Buat Order COD**
   - Pilih metode: Cash on Delivery
   - Order status = `processing`
   - `payment_method` = 'cod'

2. **Cancel Order**
   - Klik "Batalkan Pesanan"

3. **Expected Result:**
   ```
   ✅ Pesanan berhasil dibatalkan
   ℹ️ Tidak ada refund (COD belum bayar)
   ✅ Order status = 'cancelled'
   ✅ refund_status = null (tidak perlu refund)
   ```

---

## Test Case 6: Partial Refund (Payment Success, Shipping Failed)

### Scenario: Refund payment berhasil, tapi refund shipping gagal

**Steps:**

1. **Setup:**
   - Order dengan Paylabs payment (success)
   - Biteship order dengan status yang tidak eligible untuk auto-refund

2. **Cancel Order**

3. **Expected Result:**
   ```
   ✅ Pesanan berhasil dibatalkan
   ✅ Refund pembayaran berhasil via Paylabs
   ⚠️ Refund ongkir akan diproses manual oleh admin
   ✅ refund_status = 'completed' (karena payment success)
   ```

---

## Test Case 7: Full Refund Failed

### Scenario: Kedua refund gagal (edge case)

**Steps:**

1. **Simulate Paylabs API Error**
   - Matikan mock mode
   - Gunakan invalid API key

2. **Cancel Order**

3. **Expected Result:**
   ```
   ❌ Gagal memproses pengembalian dana
   ℹ️ Silakan hubungi admin
   ✅ Order tetap status 'processing' (tidak jadi cancel)
   ```

---

## Test Case 8: Stock Restoration

### Scenario: Pastikan stock dikembalikan saat cancel

**Steps:**

1. **Check Stock Awal**
   - Produk A: Stock = 10

2. **Buat Order**
   - Beli 3 pcs Produk A
   - Stock sekarang = 7

3. **Cancel Order**
   - Batalkan pesanan

4. **Expected Result:**
   ```
   ✅ Stock dikembalikan
   ✅ Produk A: Stock = 10 (kembali seperti semula)
   ```

---

## Test Case 9: Notification Testing

### Scenario: Pastikan notifikasi terkirim

**Steps:**

1. **Cancel Order**

2. **Check Notifications:**
   - Customer dapat notifikasi: "Pesanan dibatalkan"
   - Admin dapat notifikasi: "Pesanan #XXX dibatalkan"
   - Push notification ke admin (jika enabled)

3. **Expected Result:**
   ```
   ✅ Customer notification sent
   ✅ Admin notification sent
   ✅ Push notification sent (optional)
   ```

---

## Test Case 10: Database Integrity

### Scenario: Pastikan data tersimpan dengan benar

**Steps:**

1. **Cancel Order**

2. **Check Database:**
   ```sql
   SELECT 
       order_number,
       status,
       refund_status,
       refund_amount,
       refund_at,
       refund_transaction_id,
       cancel_reason
   FROM orders 
   WHERE order_number = 'NP-20250207-XXXXX';
   ```

3. **Expected Result:**
   ```
   status = 'cancelled'
   refund_status = 'completed'
   refund_amount = 150000.00
   refund_at = '2025-02-07 10:30:00'
   refund_transaction_id = 'REFUND-MOCK-XXXXX'
   cancel_reason = 'Salah pesan'
   ```

---

## 🔍 Debugging Tips

### 1. Check Log Real-time
```bash
tail -f storage/logs/laravel.log | grep -i refund
```

### 2. Check Specific Order
```bash
tail -f storage/logs/laravel.log | grep "NP-20250207-XXXXX"
```

### 3. Enable Debug Mode
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

### 4. Check Database
```sql
-- Check refund status
SELECT order_number, status, refund_status, refund_amount 
FROM orders 
WHERE refund_status IS NOT NULL;

-- Check payment gateway
SELECT order_number, payment_gateway, payment_gateway_transaction_id 
FROM orders 
WHERE payment_gateway = 'paylabs';

-- Check Biteship orders
SELECT order_number, biteship_order_id, biteship_tracking_status 
FROM orders 
WHERE biteship_order_id IS NOT NULL;
```

---

## 🎯 Success Criteria

### Paylabs Refund
- ✅ Mock mode: Always success
- ✅ Production mode: Call real API
- ✅ Error handling: Fallback to manual
- ✅ Logging: All activities logged

### Biteship Refund
- ✅ Auto refund: Status eligible → cancel order
- ✅ Manual refund: Status not eligible → admin process
- ✅ Error handling: Graceful degradation
- ✅ Logging: All activities logged

### Overall System
- ✅ Stock restoration: Always restore
- ✅ Notifications: Customer & admin notified
- ✅ Database: Data integrity maintained
- ✅ Security: Authorization checks passed

---

## 📊 Test Results Template

```
Test Date: 2025-02-07
Tester: [Your Name]
Environment: Local/Staging/Production

| Test Case | Status | Notes |
|-----------|--------|-------|
| TC1: Paylabs Refund Mock | ✅ PASS | Refund ID: REFUND-MOCK-XXX |
| TC2: Biteship Auto Refund | ✅ PASS | Order cancelled successfully |
| TC3: Manual Refund | ✅ PASS | Cannot cancel after pickup |
| TC4: Payment Manual | ✅ PASS | Manual refund marked |
| TC5: COD No Refund | ✅ PASS | No refund needed |
| TC6: Partial Refund | ✅ PASS | Payment success, shipping manual |
| TC7: Full Failed | ✅ PASS | Order not cancelled |
| TC8: Stock Restoration | ✅ PASS | Stock restored correctly |
| TC9: Notifications | ✅ PASS | All notifications sent |
| TC10: Database | ✅ PASS | Data integrity maintained |

Overall: ✅ ALL TESTS PASSED
```

---

## 🚀 Production Testing Checklist

Sebelum deploy ke production:

- [ ] Test semua test cases di staging
- [ ] Verify Paylabs API credentials
- [ ] Verify Biteship API credentials
- [ ] Test dengan real payment (small amount)
- [ ] Test dengan real shipping order
- [ ] Check error handling
- [ ] Check logging
- [ ] Check notifications
- [ ] Backup database
- [ ] Prepare rollback plan

---

## 📞 Support

Jika ada masalah saat testing:

1. Check log: `storage/logs/laravel.log`
2. Check database: Query orders table
3. Check API response: Enable debug mode
4. Contact developer: Provide order_number & error message
