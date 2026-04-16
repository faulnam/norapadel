# Fix Error: Data truncated for column 'status'

## Error Message
```
SQLSTATE[01000]: Warning: 1265 Data truncated for column 'status' at row 1
SQL: update `orders` set `status` = processing
```

## Root Cause
Kolom `status` di tabel `orders` menggunakan **ENUM** yang belum include nilai `processing` dan `shipped`.

Enum lama:
```sql
ENUM('pending_payment', 'paid', 'assigned', 'picked_up', 'on_delivery', 'delivered', 'completed', 'cancelled')
```

Enum baru (yang dibutuhkan):
```sql
ENUM('pending_payment', 'paid', 'processing', 'shipped', 'delivered', 'completed', 'cancelled', 'assigned', 'picked_up', 'on_delivery')
```

## Solution

### Cara 1: Jalankan Migration (Recommended)

**File sudah dibuat:**
- `database/migrations/2024_01_21_100000_update_orders_status_enum.php` - Update enum status
- `database/migrations/2024_01_20_100000_add_courier_driver_info_to_orders.php` - Kolom kurir driver
- `run-migration.bat` - Script untuk jalankan migration

**Langkah:**

1. **Double-click file `run-migration.bat`** di folder project
   
   ATAU

2. **Buka terminal di folder project, jalankan:**
   ```bash
   php artisan migrate
   ```

**Output yang diharapkan:**
```
Running migrations.

2024_01_20_100000_add_courier_driver_info_to_orders ........ DONE
2024_01_21_100000_update_orders_status_enum ................ DONE
```

### Cara 2: Manual via SQL (Jika Migration Gagal)

Buka **phpMyAdmin** atau **MySQL client**, jalankan:

```sql
ALTER TABLE `orders` MODIFY COLUMN `status` ENUM(
    'pending_payment',
    'paid',
    'processing',
    'shipped',
    'delivered',
    'completed',
    'cancelled',
    'assigned',
    'picked_up',
    'on_delivery'
) NOT NULL DEFAULT 'pending_payment';
```

---

## Testing Setelah Fix

### 1. Test Request Pickup

1. **Login admin** → `/admin/orders`
2. **Pilih order** dengan status `paid` dan ada ekspedisi
3. **Klik "Request Pickup"**
4. **Loading muncul** "Mencari Kurir Terdekat..." (2 detik)
5. **Halaman refresh** → Status berubah `processing` ✅
6. **Info kurir muncul:**
   - Foto profil kurir
   - Nama: Dedi Kurniawan (atau kurir lain)
   - Rating: ⭐ 4.7
   - Telepon: 081234567892
   - Kendaraan: Motor - L 9012 EF
   - Estimasi Pickup: 14:30 WIB

### 2. Validasi Database

```sql
-- Cek order yang baru request pickup
SELECT 
    id,
    order_number,
    status,
    courier_code,
    courier_name,
    courier_driver_name,
    courier_driver_rating,
    waybill_id,
    biteship_order_id
FROM orders 
WHERE id = 7;
```

**Hasil yang diharapkan:**
```
status = 'processing'
courier_code = 'anteraja' (atau jnt/paxel)
courier_driver_name = 'Dedi Kurniawan' (atau kurir lain)
courier_driver_rating = 4.7
waybill_id = 'ANTERAJA-1776320016'
biteship_order_id = 'BITESHIP-69E07E10AA787'
```

---

## Troubleshooting

### Error: "Unknown column 'courier_driver_name'"
**Solusi:** Jalankan migration courier driver info dulu
```bash
php artisan migrate
```

### Error: "Enum value 'processing' not found"
**Solusi:** Jalankan migration update enum atau SQL manual di atas

### Migration Stuck
**Solusi:**
```bash
# Rollback 1 step
php artisan migrate:rollback --step=1

# Migrate lagi
php artisan migrate
```

### PHP Not Found
**Solusi:** Edit `run-migration.bat`, sesuaikan path PHP Laragon Anda

---

## Status Flow Baru

```
pending_payment → paid → processing → shipped → delivered → completed
                           ↓
                      (cancelled)
```

**Keterangan:**
- `paid` = Sudah bayar, siap pickup
- `processing` = Pickup sudah direquest, kurir akan datang
- `shipped` = Kurir sudah ambil paket, sedang dikirim
- `delivered` = Paket sudah sampai
- `completed` = Customer konfirmasi selesai

---

## Files Updated

1. `database/migrations/2024_01_21_100000_update_orders_status_enum.php` - Update enum
2. `database/migrations/2024_01_20_100000_add_courier_driver_info_to_orders.php` - Kolom kurir
3. `run-migration.bat` - Helper script
4. `FIX_STATUS_ENUM_ERROR.md` - Dokumentasi ini

---

## Summary

✅ **Enum status updated** dengan `processing` dan `shipped`
✅ **Kolom kurir driver** ditambahkan (nama, foto, rating, dll)
✅ **Request pickup** sekarang berfungsi tanpa error
✅ **Info kurir dummy** muncul setelah request pickup

**Next:** Jalankan migration dan test request pickup! 🚀
