# 🚀 QUICK START - Testing Sistem Refund

## ⚡ 5 Menit Testing

### Step 1: Setup Environment (30 detik)

```bash
# Edit .env
nano .env
```

Tambahkan/pastikan ada:
```env
# Paylabs Mock Mode
PAYLABS_MOCK_MODE=true
PAYLABS_SANDBOX=true

# Biteship Mock Mode
BITESHIP_USE_MOCK=true
BITESHIP_SANDBOX=true
```

```bash
# Clear cache
php artisan config:clear
php artisan cache:clear
```

---

### Step 2: Buat Order Test (2 menit)

1. **Login sebagai Customer**
   - Email: customer@test.com
   - Password: password

2. **Tambah Produk ke Cart**
   - Pilih produk apapun
   - Quantity: 1
   - Klik "Tambah ke Keranjang"

3. **Checkout**
   - Isi alamat pengiriman
   - Pilih ekspedisi (apapun)
   - Klik "Lanjut ke Pembayaran"

4. **Pilih Paylabs Payment**
   - Pilih metode: QRIS / VA / E-Wallet
   - Klik "Bayar"

5. **Simulasi Payment Success**
   - Karena mock mode, payment auto-success
   - Order status berubah: `pending_payment` → `processing`

---

### Step 3: Cancel Order & Test Refund (1 menit)

1. **Buka Order Detail**
   - Menu: "Pesanan Saya"
   - Klik order yang baru dibuat

2. **Cancel Order**
   - Klik tombol "Batalkan Pesanan"
   - Isi alasan: "Test refund"
   - Klik "Ya, Batalkan"

3. **Expected Result:**
   ```
   ✅ Pesanan berhasil dibatalkan
   ✅ Dana sebesar Rp XXX akan dikembalikan dalam 1-3 hari kerja
   ```

---

### Step 4: Verify (1.5 menit)

**Check Database:**
```sql
SELECT 
    order_number,
    status,
    refund_status,
    refund_amount,
    refund_transaction_id
FROM orders 
ORDER BY created_at DESC 
LIMIT 1;
```

**Expected:**
```
status = 'cancelled'
refund_status = 'completed'
refund_amount = [total order]
refund_transaction_id = 'REFUND-MOCK-XXXXX'
```

**Check Log:**
```bash
tail -50 storage/logs/laravel.log | grep -i refund
```

**Expected:**
```
[INFO] Paylabs MOCK refund
[INFO] Paylabs payment refund completed for order #NP-20250207-XXXXX
[INFO] Biteship shipping refund processed for order #NP-20250207-XXXXX
```

---

## ✅ HASIL TESTING

### Jika Semua Berhasil:

✅ Order berhasil dibatalkan
✅ Refund status = 'completed'
✅ Refund transaction ID tersimpan
✅ Log menunjukkan refund berhasil
✅ Stock produk dikembalikan

**Kesimpulan: SISTEM REFUND BERFUNGSI!** 🎉

---

### Jika Ada Error:

❌ Order tidak bisa dibatalkan
❌ Refund status = 'failed'
❌ Error di log

**Action:**
1. Check log detail: `tail -100 storage/logs/laravel.log`
2. Check database: Query orders table
3. Baca file: `REFUND_CHECKLIST.md`

---

## 🔄 Test Scenarios Lainnya

### Scenario 2: COD Order (No Refund)

1. Buat order dengan metode: Cash on Delivery
2. Order status = `processing`
3. Cancel order
4. Expected: Tidak ada refund (COD belum bayar)

---

### Scenario 3: Manual Payment

1. Buat order dengan metode: Transfer Manual
2. Upload bukti transfer
3. Admin verify payment
4. Cancel order
5. Expected: Refund manual by admin

---

### Scenario 4: Stock Restoration

1. Check stock produk: 10 pcs
2. Buat order: 3 pcs
3. Stock sekarang: 7 pcs
4. Cancel order
5. Check stock: 10 pcs (restored)

---

## 📊 Quick Commands

### Monitor Log Real-time
```bash
tail -f storage/logs/laravel.log | grep -i refund
```

### Check All Refunds
```sql
SELECT 
    order_number,
    status,
    refund_status,
    refund_amount,
    created_at
FROM orders 
WHERE refund_status IS NOT NULL
ORDER BY created_at DESC;
```

### Check Paylabs Refunds
```sql
SELECT 
    order_number,
    payment_gateway,
    payment_gateway_transaction_id,
    refund_transaction_id,
    refund_status
FROM orders 
WHERE payment_gateway = 'paylabs'
AND refund_status IS NOT NULL;
```

### Check Biteship Refunds
```sql
SELECT 
    order_number,
    biteship_order_id,
    biteship_tracking_status,
    shipping_cost,
    refund_status
FROM orders 
WHERE biteship_order_id IS NOT NULL
AND refund_status IS NOT NULL;
```

---

## 🎯 Success Indicators

### ✅ Sistem Berfungsi Jika:

1. **Order bisa dibatalkan**
   - Status = 'processing' → 'cancelled'

2. **Refund diproses**
   - refund_status = 'completed'
   - refund_amount = total order
   - refund_transaction_id tersimpan

3. **Log menunjukkan aktivitas**
   - "Paylabs MOCK refund"
   - "payment refund completed"
   - "shipping refund processed"

4. **Stock dikembalikan**
   - Stock produk kembali ke jumlah awal

5. **Notifikasi terkirim**
   - Customer dapat notifikasi
   - Admin dapat notifikasi

---

## 🚨 Common Issues

### Issue 1: Order tidak bisa dibatalkan

**Symptom:**
```
❌ Pesanan tidak dapat dibatalkan
```

**Cause:**
- Order status bukan 'processing'
- Order sudah shipped/delivered

**Solution:**
- Hanya order dengan status 'processing' yang bisa dibatalkan

---

### Issue 2: Refund failed

**Symptom:**
```
❌ Gagal memproses pengembalian dana
refund_status = 'failed'
```

**Cause:**
- Paylabs API error
- Biteship API error
- Network error

**Solution:**
1. Check log: `tail -100 storage/logs/laravel.log`
2. Check API credentials
3. Retry atau manual refund

---

### Issue 3: Stock tidak dikembalikan

**Symptom:**
- Order dibatalkan
- Stock tidak bertambah

**Cause:**
- Error di restore stock logic

**Solution:**
1. Check log untuk error
2. Manual restore stock via admin panel

---

## 📞 Need Help?

### Documentation Files:

1. **`REFUND_SYSTEM_COMPLETE.md`**
   - Dokumentasi lengkap sistem

2. **`REFUND_TESTING_GUIDE.md`**
   - 10 test cases detail

3. **`REFUND_IMPLEMENTATION_SUMMARY.md`**
   - Summary implementasi

4. **`REFUND_CHECKLIST.md`**
   - Checklist verifikasi

5. **`REFUND_QUICKSTART.md`** (this file)
   - Quick start guide

---

## 🎉 Next Steps

### After Testing Success:

1. **Test di Staging**
   - Test dengan real API (small amount)
   - Verify refund masuk ke customer

2. **Production Deployment**
   - Update .env dengan real credentials
   - Set mock_mode = false
   - Monitor logs 24 jam

3. **Monitoring**
   - Setup alert untuk refund failed
   - Daily check refund pending
   - Weekly report

---

## ⚡ TL;DR - Super Quick Test

```bash
# 1. Setup
echo "PAYLABS_MOCK_MODE=true" >> .env
echo "BITESHIP_USE_MOCK=true" >> .env
php artisan config:clear

# 2. Test (via browser)
# - Login customer
# - Buat order dengan Paylabs
# - Cancel order

# 3. Verify
tail -50 storage/logs/laravel.log | grep -i refund

# Expected: "Paylabs MOCK refund" dan "payment refund completed"
```

**If you see those logs: ✅ SISTEM BERFUNGSI!**

---

**Happy Testing!** 🚀
