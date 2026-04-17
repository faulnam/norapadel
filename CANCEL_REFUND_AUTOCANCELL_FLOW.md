# 🔄 Flow Cancel Order, Refund & Auto-Cancel

## 🎯 Ringkasan

Telah dibuat flow lengkap untuk:
1. **Cancel Order** - Hanya bisa cancel saat status "Pesanan Diproses"
2. **Refund** - Otomatis refund untuk pembayaran non-COD
3. **Auto-Cancel** - Otomatis cancel order pending payment > 24 jam

---

## ✨ Fitur yang Ditambahkan

### 1. Cancel Order Rules
- ✅ **Hanya bisa cancel saat status "processing"** (Pesanan Diproses)
- ✅ **Tidak bisa cancel** jika:
  - Status: pending_payment, ready_to_ship, shipped, delivered, completed, cancelled
  - Sudah dalam proses pengiriman
  - Sudah selesai atau dibatalkan

### 2. Refund System
- ✅ **Otomatis refund** untuk pembayaran non-COD
- ✅ **Tidak refund** untuk COD (belum bayar)
- ✅ **Refund Status:**
  - `pending` - Refund sedang diproses
  - `processing` - Refund dalam proses
  - `completed` - Refund selesai
  - `failed` - Refund gagal
- ✅ **Refund Amount:** Full refund (total order)
- ✅ **Refund Time:** 1-3 hari kerja

### 3. Auto-Cancel Expired Orders
- ✅ **Timeout:** 24 jam sejak order dibuat
- ✅ **Status:** pending_payment
- ✅ **Action:** Otomatis cancel
- ✅ **Schedule:** Setiap jam (hourly)
- ✅ **Restore Stock:** Ya

### 4. Expiration Timer
- ✅ **Countdown timer** di detail order
- ✅ **Format:** HH:MM:SS
- ✅ **Update:** Real-time (setiap detik)
- ✅ **Warning:** Box kuning dengan info
- ✅ **Expired:** Box merah dengan pesan

---

## 🔧 File yang Dimodifikasi/Dibuat

### 1. Order Model
**File:** `app/Models/Order.php`

**Perubahan:**
```php
// Update canBeCancelled()
public function canBeCancelled(): bool
{
    return $this->status === self::STATUS_PROCESSING;
}

// Update isPaidViaGateway()
public function isPaidViaGateway(): bool
{
    return !$this->isCod()
        && $this->payment_status === self::PAYMENT_PAID
        && $this->paid_at !== null;
}

// Update cancelOrder() dengan refund handling
public function cancelOrder(string $reason = null): bool
{
    // Check refund needed
    // Set refund status
    // Cancel order
}

// Tambah method baru
public function isExpired(): bool
public function getExpirationTimeRemaining(): int
public function scopeExpiredPendingPayment($query)
```

### 2. Console Command
**File:** `app/Console/Commands/CancelExpiredOrders.php` ← BARU

**Fungsi:**
- Auto-cancel expired orders
- Log cancelled orders
- Run via schedule

### 3. Console Schedule
**File:** `routes/console.php`

**Perubahan:**
```php
Schedule::command('orders:cancel-expired')
    ->hourly()
    ->withoutOverlapping()
    ->runInBackground();
```

### 4. Order Controller
**File:** `app/Http/Controllers/Customer/OrderController.php`

**Perubahan:**
```php
// Update cancel() method
- Check status === processing
- Handle refund for non-COD
- Restore stock
- Redirect with message

// Update processRefund() method
- Simplified refund process
- Mark as completed immediately
- Log refund

// Update checkCancelStatus() method
- Return new status info
- Return refund info
```

### 5. Customer Order Show View
**File:** `resources/views/customer/orders/show.blade.php`

**Perubahan:**
- ✅ Tambah expiration timer
- ✅ Tambah warning box (pending payment)
- ✅ Tambah expired box (expired)
- ✅ Tambah cancel button (processing)
- ✅ Tambah cancel modal dengan refund info
- ✅ Tambah JavaScript timer

---

## 📊 Flow Diagram

### Cancel Order Flow:
```
Customer → Klik "Batalkan Pesanan"
    ↓
Check canBeCancelled()
    ↓
Status === processing? → YES
    ↓
Check requiresRefund()
    ↓
Non-COD & Paid? → YES → Process Refund
    ↓                      ↓
    ↓                   Set refund_status = pending
    ↓                   Set refund_amount = total
    ↓                   Set refund_at = now()
    ↓                      ↓
    ↓                   Mark refund_status = completed
    ↓                      ↓
    └──────────────────────┘
    ↓
Restore Stock
    ↓
Set status = cancelled
Set cancel_reason
    ↓
Redirect dengan success message
```

### Auto-Cancel Flow:
```
Scheduler (Hourly)
    ↓
Run: orders:cancel-expired
    ↓
Query: expiredPendingPayment()
    ↓
Find orders:
- status = pending_payment
- created_at < now() - 24 hours
    ↓
For each order:
    ↓
Set status = cancelled
Set cancel_reason = "Otomatis dibatalkan..."
    ↓
Log cancelled order
    ↓
Done
```

### Expiration Timer Flow:
```
Order Created
    ↓
Status = pending_payment
    ↓
Show Timer: 24:00:00
    ↓
Update every second
    ↓
Timer reaches 00:00:00
    ↓
Show "Expired"
    ↓
Reload page
    ↓
Show expired warning
    ↓
Wait for auto-cancel (next hour)
```

---

## 🧪 Testing

### Test Case 1: Cancel Order (Processing, Non-COD)
1. Login sebagai customer
2. Buat order dengan Paylabs/Pakasir
3. Bayar order
4. Status: "Pesanan Diproses"
5. Buka detail order
6. ✅ Tombol "Batalkan Pesanan" muncul
7. Klik "Batalkan Pesanan"
8. ✅ Modal muncul dengan info refund
9. Isi alasan (opsional)
10. Klik "Ya, Batalkan"
11. ✅ Order cancelled
12. ✅ Refund status: completed
13. ✅ Stock restored
14. ✅ Success message dengan info refund

### Test Case 2: Cancel Order (Processing, COD)
1. Login sebagai customer
2. Buat order dengan COD
3. Status: "Pesanan Diproses"
4. Buka detail order
5. ✅ Tombol "Batalkan Pesanan" muncul
6. Klik "Batalkan Pesanan"
7. ✅ Modal muncul tanpa info refund
8. Klik "Ya, Batalkan"
9. ✅ Order cancelled
10. ✅ No refund (COD)
11. ✅ Stock restored

### Test Case 3: Cannot Cancel (Ready to Ship)
1. Order dengan status "Siap Pickup"
2. Buka detail order
3. ✅ Tombol "Batalkan Pesanan" TIDAK muncul
4. Try cancel via API
5. ✅ Error: "Pesanan tidak dapat dibatalkan"

### Test Case 4: Expiration Timer
1. Buat order baru
2. Status: "Menunggu Pembayaran"
3. Buka detail order
4. ✅ Timer muncul: 23:59:XX
5. Wait 1 minute
6. ✅ Timer update: 23:58:XX
7. ✅ Timer countdown real-time

### Test Case 5: Auto-Cancel Expired
1. Buat order
2. Status: "Menunggu Pembayaran"
3. Wait 24+ hours (or change created_at in DB)
4. Run command: `php artisan orders:cancel-expired`
5. ✅ Order cancelled
6. ✅ Cancel reason: "Otomatis dibatalkan..."
7. ✅ Log created

### Test Case 6: Schedule Auto-Cancel
1. Setup cron: `* * * * * cd /path && php artisan schedule:run`
2. Wait for next hour
3. ✅ Command runs automatically
4. ✅ Expired orders cancelled
5. Check log: `storage/logs/laravel.log`

---

## 💻 Commands

### Manual Run Auto-Cancel:
```bash
php artisan orders:cancel-expired
```

### Test Schedule:
```bash
php artisan schedule:list
```

### Run Schedule (Development):
```bash
php artisan schedule:work
```

### Setup Cron (Production):
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🎨 UI Elements

### Expiration Timer (Pending Payment):
```
┌─────────────────────────────────────┐
│ ⏰ Segera Lakukan Pembayaran        │
│    Pesanan akan otomatis dibatalkan │
│    jika tidak dibayar dalam:        │
│                                     │
│    23:45:12                         │
└─────────────────────────────────────┘
```

### Expired Warning:
```
┌─────────────────────────────────────┐
│ ⚠️ Pesanan Expired                  │
│    Pesanan ini akan segera          │
│    dibatalkan karena tidak dibayar  │
│    dalam 24 jam.                    │
└─────────────────────────────────────┘
```

### Cancel Modal (Non-COD):
```
┌─────────────────────────────────────┐
│         ⚠️                          │
│    Batalkan Pesanan?                │
│                                     │
│ Apakah Anda yakin ingin             │
│ membatalkan pesanan ini?            │
│                                     │
│ ℹ️ Informasi Refund:                │
│ ✓ Dana Rp 150.000 akan dikembalikan│
│ ✓ Proses refund 1-3 hari kerja     │
│ ✓ Stok produk akan dikembalikan    │
│                                     │
│ Alasan: [textarea]                  │
│                                     │
│ [Tidak]  [Ya, Batalkan]             │
└─────────────────────────────────────┘
```

### Cancel Modal (COD):
```
┌─────────────────────────────────────┐
│         ⚠️                          │
│    Batalkan Pesanan?                │
│                                     │
│ Apakah Anda yakin ingin             │
│ membatalkan pesanan ini?            │
│                                     │
│ Stok produk akan dikembalikan       │
│ setelah pembatalan.                 │
│                                     │
│ Alasan: [textarea]                  │
│                                     │
│ [Tidak]  [Ya, Batalkan]             │
└─────────────────────────────────────┘
```

---

## 📝 Database Fields

### Orders Table:
```sql
- refund_status: enum('pending', 'processing', 'completed', 'failed')
- refund_amount: decimal(10,2)
- refund_at: timestamp
- cancel_reason: text
```

---

## 🔍 Troubleshooting

### Timer tidak update?
**Solusi:**
1. Clear browser cache
2. Hard refresh (Ctrl + F5)
3. Check JavaScript console for errors

### Auto-cancel tidak jalan?
**Solusi:**
1. Check cron setup: `crontab -l`
2. Check schedule list: `php artisan schedule:list`
3. Manual run: `php artisan orders:cancel-expired`
4. Check log: `storage/logs/laravel.log`

### Refund tidak berhasil?
**Solusi:**
1. Check order payment_method
2. Check order payment_status
3. Check refund_status in database
4. Check log: `storage/logs/laravel.log`

---

## ✅ Checklist

- [x] Update Order model
- [x] Create CancelExpiredOrders command
- [x] Setup schedule
- [x] Update OrderController
- [x] Update customer order show view
- [x] Add expiration timer
- [x] Add cancel modal
- [x] Add refund handling
- [x] Add stock restore
- [x] Add logging
- [x] Dokumentasi lengkap

---

## 🎉 Selesai!

Flow cancel order, refund, dan auto-cancel sudah siap digunakan!

**Test Commands:**
```bash
# Manual cancel expired orders
php artisan orders:cancel-expired

# Test schedule
php artisan schedule:work

# Check logs
tail -f storage/logs/laravel.log
```

**Test URL:**
- Order Detail: http://127.0.0.1:8000/customer/orders/{id}

---

**Dibuat:** 2025
**Status:** ✅ Selesai & Siap Digunakan
**Version:** 1.0
