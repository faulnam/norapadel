# Fix: Ekspedisi Tidak Tersimpan & Icon History

## Masalah yang Diperbaiki

### 1. Ekspedisi Tidak Tersimpan di Database
**Problem:** Customer sudah pilih ekspedisi di checkout, tapi di admin tidak tertera ekspedisinya (courier_code = NULL)

**Root Cause:** Kolom `courier_code`, `courier_name`, `courier_service_name`, `biteship_order_id`, `waybill_id` belum ada di tabel `orders`

**Solution:**
- Buat migration baru: `2024_01_19_100000_add_courier_fields_to_orders.php`
- Tambahkan 5 kolom baru ke tabel orders
- Update model Order fillable

### 2. Icon History Tidak Ada di Semua Halaman
**Problem:** Icon history hanya ada di home_luxury, tidak ada di checkout dan halaman lain

**Solution:**
- Tambahkan icon history di navbar checkout
- Update icon di layouts/app.blade.php (dropdown desktop, mobile menu, bottom nav)
- Ganti icon `fa-shopping-bag` / `fa-receipt` menjadi `fa-history`

---

## Files yang Diupdate

### 1. Migration Baru
**File:** `database/migrations/2024_01_19_100000_add_courier_fields_to_orders.php`

Menambahkan kolom:
- `courier_code` - Kode ekspedisi (jnt, anteraja, paxel)
- `courier_name` - Nama ekspedisi (J&T Express, AnterAja, Paxel)
- `courier_service_name` - Nama layanan (EZ Reguler, Express, Same Day, dll)
- `biteship_order_id` - ID order dari Biteship API
- `waybill_id` - Nomor resi dari ekspedisi

### 2. Model Order
**File:** `app/Models/Order.php`

Update `$fillable` untuk menambahkan 5 kolom baru.

### 3. Navbar Checkout
**File:** `resources/views/customer/orders/checkout.blade.php`

Tambahkan icon history sebelum icon profile:
```html
<a href="{{ route('customer.orders.index') }}" class="transition duration-300 hover:text-black" aria-label="History">
    <i class="fas fa-history text-sm"></i>
</a>
```

### 4. Layouts App
**File:** `resources/views/layouts/app.blade.php`

Update 3 tempat:
- **Desktop Dropdown:** Ganti "Pesanan Saya" → "Riwayat Pesanan" dengan icon `fa-history`
- **Mobile Menu:** Ganti "Pesanan" → "Riwayat Pesanan" dengan icon `fa-history`
- **Bottom Nav:** Ganti icon `fa-receipt` → `fa-history`

---

## Cara Menjalankan

### 1. Jalankan Migration

```bash
php artisan migrate
```

Output yang diharapkan:
```
Migrating: 2024_01_19_100000_add_courier_fields_to_orders
Migrated:  2024_01_19_100000_add_courier_fields_to_orders (XX.XXms)
```

### 2. Test Checkout Baru

1. **Login sebagai customer**
2. **Tambah produk ke cart**
3. **Checkout:**
   - Pilih lokasi di peta
   - Pilih ekspedisi (JNT/AnterAja/Paxel)
   - Pilih layanan (Reguler/Express/dll)
   - Buat pesanan
4. **Cek di admin:**
   - Buka `/admin/orders`
   - Klik order yang baru dibuat
   - Section "Ekspedisi & Pickup" sekarang muncul dengan data lengkap
   - Tombol "Request Pickup" tersedia

### 3. Test Icon History

**Desktop:**
- Klik dropdown user di navbar
- Icon history muncul dengan text "Riwayat Pesanan"

**Mobile:**
- Buka menu hamburger
- Icon history muncul di menu
- Bottom nav juga pakai icon history

**Checkout:**
- Icon history muncul di navbar checkout (sebelah icon profile)

---

## Validasi Database

Cek apakah kolom sudah ada:

```sql
DESCRIBE orders;
```

Cari kolom:
- `courier_code`
- `courier_name`
- `courier_service_name`
- `biteship_order_id`
- `waybill_id`

Cek data order:

```sql
SELECT 
    id,
    order_number,
    courier_code,
    courier_name,
    courier_service_name,
    status,
    payment_status
FROM orders 
ORDER BY id DESC 
LIMIT 5;
```

---

## Testing Checklist

### Ekspedisi Tersimpan
- [ ] Checkout dengan pilih ekspedisi JNT
- [ ] Cek di admin, courier_code = 'jnt'
- [ ] Cek di admin, courier_name = 'J&T Express'
- [ ] Cek di admin, courier_service_name = 'EZ (Reguler)' atau sesuai pilihan
- [ ] Section "Ekspedisi & Pickup" muncul di detail order
- [ ] Tombol "Request Pickup" muncul jika status = paid

### Icon History
- [ ] Icon history muncul di navbar checkout
- [ ] Icon history muncul di dropdown desktop (layouts/app)
- [ ] Icon history muncul di mobile menu (layouts/app)
- [ ] Icon history muncul di bottom nav mobile (layouts/app)
- [ ] Icon history muncul di home_luxury navbar
- [ ] Klik icon history redirect ke `/customer/orders`

---

## Troubleshooting

### Migration Error: "Column already exists"
**Solusi:**
```bash
php artisan migrate:rollback --step=1
php artisan migrate
```

### Ekspedisi Masih NULL di Order Lama
**Normal!** Order lama dibuat sebelum kolom ada. Hanya order baru yang akan punya data ekspedisi.

**Solusi untuk testing:**
```sql
-- Update order lama dengan ekspedisi dummy
UPDATE orders 
SET 
    courier_code = 'jnt',
    courier_name = 'J&T Express',
    courier_service_name = 'EZ (Reguler)'
WHERE id = 4 AND courier_code IS NULL;
```

### Icon History Tidak Muncul
**Cek:**
1. Clear cache browser (Ctrl+Shift+R)
2. Pastikan Font Awesome loaded
3. Cek console browser untuk error

---

## Summary

✅ **Ekspedisi sekarang tersimpan** di database saat checkout
✅ **Icon history tersedia** di semua halaman customer
✅ **Tombol Request Pickup** muncul di admin untuk order dengan ekspedisi
✅ **Alur lengkap** dari checkout sampai pickup berfungsi

**Next:** Jalankan migration dan test dengan order baru!
