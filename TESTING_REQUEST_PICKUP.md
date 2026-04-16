# Testing Request Pickup - Panduan Lengkap

## Masalah: Tombol Request Pickup Tidak Muncul

Jika tombol "Request Pickup" tidak muncul di halaman `/admin/orders/{id}`, kemungkinan:

### 1. Order Belum Punya Ekspedisi (`courier_code` = NULL)
**Penyebab:**
- Order dibuat sebelum sistem ekspedisi diimplementasikan
- Customer skip pilih ekspedisi saat checkout
- Bug di halaman checkout

**Solusi:**
- Lihat section "Ekspedisi & Pickup" - akan ada pesan warning
- Kirim paket manual ke ekspedisi
- Input nomor resi manual setelah dapat dari ekspedisi

### 2. Status Order Bukan `paid`
**Penyebab:**
- Order masih `pending_payment` (belum bayar)
- Order sudah `processing` atau `shipped` (sudah request pickup)

**Solusi:**
- Jika `pending_payment`: Tunggu customer bayar, lalu admin verifikasi
- Jika sudah `processing`: Tombol tidak perlu muncul, info kurir sudah ada

### 3. Payment Status Bukan `paid`
**Penyebab:**
- Pembayaran belum diverifikasi admin

**Solusi:**
- Verifikasi pembayaran dulu di sidebar kanan

---

## Cara Testing yang Benar

### Step 1: Buat Order Baru dari Customer

1. **Login sebagai customer** di `/login`
2. **Buka halaman produk** dan tambah ke cart
3. **Checkout** di `/customer/checkout`
4. **Pilih lokasi pengiriman** di peta (klik di map)
5. **Pilih ekspedisi** (JNT/AnterAja/Paxel) dengan layanan (Reguler/Express/dll)
6. **Klik "Buat Pesanan"**
7. **Pilih metode pembayaran** (Paylabs atau COD)
8. **Upload bukti pembayaran** (jika Paylabs)

### Step 2: Verifikasi Pembayaran (Admin)

1. **Login sebagai admin** di `/admin/login`
2. **Buka** `/admin/orders`
3. **Klik order** yang baru dibuat
4. **Scroll ke sidebar kanan** - section "Pembayaran"
5. **Klik "Verifikasi Pembayaran"**
6. Status berubah: `pending_payment` → `paid`

### Step 3: Request Pickup

1. **Scroll ke section "Ekspedisi & Pickup"**
2. **Cek kondisi:**
   - ✅ Status order = `paid`
   - ✅ Payment status = `paid`
   - ✅ Ada ekspedisi terpilih (JNT/AnterAja/Paxel)
   - ✅ Belum pernah request pickup
3. **Klik tombol "Request Pickup ke {Ekspedisi}"**
4. **Konfirmasi popup**
5. **Loading muncul** "Mencari Kurir Terdekat..." (2 detik)
6. **Halaman refresh otomatis**
7. **Info kurir muncul:**
   - Foto profil
   - Nama & rating
   - Telepon
   - Kendaraan & plat
   - Estimasi pickup

---

## Cek Database Manual

Jika masih bingung, cek database:

```sql
-- Cek order ID 4
SELECT 
    id,
    order_number,
    status,
    payment_status,
    courier_code,
    courier_name,
    biteship_order_id,
    waybill_id
FROM orders 
WHERE id = 4;
```

**Hasil yang diharapkan untuk bisa request pickup:**
```
status = 'paid'
payment_status = 'paid'
courier_code = 'jnt' atau 'anteraja' atau 'paxel' (NOT NULL)
biteship_order_id = NULL (belum pernah request)
```

---

## Update Order Lama (Manual)

Jika ingin testing dengan order lama yang belum punya ekspedisi:

```sql
-- Update order ID 4 dengan ekspedisi dummy
UPDATE orders 
SET 
    courier_code = 'jnt',
    courier_name = 'J&T Express',
    courier_service_name = 'EZ (Reguler)',
    status = 'paid',
    payment_status = 'paid'
WHERE id = 4;
```

Setelah itu refresh halaman `/admin/orders/4` dan tombol request pickup akan muncul.

---

## Kondisi Tombol Request Pickup

```php
@if(!$order->biteship_order_id && $order->payment_status === 'paid' && $order->status === 'paid')
    <!-- Tombol Request Pickup Muncul -->
@endif
```

**Checklist:**
- [ ] `biteship_order_id` = NULL (belum pernah request)
- [ ] `payment_status` = 'paid' (sudah bayar & verified)
- [ ] `status` = 'paid' (siap pickup)
- [ ] `courier_code` NOT NULL (ada ekspedisi)

---

## Alur Lengkap (End-to-End)

```
1. Customer Checkout
   ↓ (pilih ekspedisi JNT/AnterAja/Paxel)
   
2. Customer Bayar
   ↓ (upload bukti)
   
3. Admin Verifikasi Pembayaran
   ↓ (status: paid, payment_status: paid)
   
4. Admin Request Pickup
   ↓ (klik tombol, loading 2 detik)
   
5. Info Kurir Muncul
   ↓ (status: processing)
   
6. Kurir Ambil Paket
   ↓ (status: shipped)
   
7. Customer Terima
   ↓ (status: delivered → completed)
```

---

## Troubleshooting

### Error: "Customer belum memilih ekspedisi"
**Solusi:** Order lama sebelum sistem ekspedisi. Update manual di database atau buat order baru.

### Error: "Pickup sudah pernah direquest"
**Solusi:** Order sudah pernah request pickup. Cek `biteship_order_id` di database.

### Tombol Tidak Muncul Tapi Kondisi Sudah Benar
**Solusi:** 
1. Clear cache browser (Ctrl+Shift+R)
2. Cek console browser (F12) untuk error JavaScript
3. Pastikan file `_pickup_section.blade.php` sudah terupdate

### Loading Tidak Muncul
**Solusi:**
1. Cek modal element ada di HTML (inspect element)
2. Cek JavaScript error di console
3. Pastikan jQuery/Bootstrap sudah load

---

## File Penting

1. `resources/views/admin/orders/show.blade.php` - Halaman detail order
2. `resources/views/admin/orders/_pickup_section.blade.php` - Section pickup
3. `app/Http/Controllers/Admin/PickupController.php` - Controller pickup
4. `app/Services/BiteshipService.php` - Mock data kurir
5. `database/migrations/2024_01_20_100000_add_courier_driver_info_to_orders.php` - Migration

---

## Next Steps

Setelah testing berhasil:
1. ✅ Request pickup dengan loading animation
2. ✅ Info kurir muncul dengan data lengkap
3. ✅ Status berubah ke `processing`
4. ✅ Customer dapat notifikasi

Lanjut ke:
- Testing tracking pengiriman
- Testing update status manual
- Testing dengan ekspedisi berbeda (JNT vs AnterAja vs Paxel)
