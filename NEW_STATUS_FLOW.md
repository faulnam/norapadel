# Alur Status Baru - Processing → Ready to Ship

## 🔄 Alur Status Baru

```
1. Customer Checkout & Bayar
   ↓
2. Admin Verifikasi Pembayaran → STATUS: PROCESSING (Pesanan Diproses)
   ↓
3. Admin Pack Barang → Ubah Status Manual ke READY_TO_SHIP (Siap Pickup)
   ↓
4. Admin Request Pickup → STATUS tetap READY_TO_SHIP (Info kurir muncul)
   ↓
5. Kurir Ambil Paket → STATUS: SHIPPED (Dikirim)
   ↓
6. Customer Terima → STATUS: DELIVERED → COMPLETED
```

---

## 📊 Status Definitions

| Status | Label | Keterangan | Action Admin |
|--------|-------|-----------|--------------|
| `pending_payment` | Menunggu Pembayaran | Customer belum bayar | Tunggu customer bayar |
| `processing` | Pesanan Diproses | Pembayaran verified, admin pack barang | **Pack barang** → Ubah ke `ready_to_ship` |
| `ready_to_ship` | Siap Pickup | Barang sudah siap, bisa request pickup | **Request Pickup** |
| `shipped` | Dikirim Ekspedisi | Kurir sudah ambil, sedang dikirim | Tracking otomatis |
| `delivered` | Sudah Sampai | Paket sampai ke customer | Tunggu customer konfirmasi |
| `completed` | Selesai | Customer konfirmasi selesai | - |
| `cancelled` | Dibatalkan | Order dibatalkan | - |

---

## 🚀 Cara Menjalankan

### 1. Jalankan SQL di phpMyAdmin

Buka file `fix_status_enum.sql` dan copy-paste ke phpMyAdmin, atau jalankan manual:

```sql
-- Update ENUM status
ALTER TABLE `orders` MODIFY COLUMN `status` ENUM(
    'pending_payment',
    'processing',
    'ready_to_ship',
    'shipped',
    'delivered',
    'completed',
    'cancelled'
) NOT NULL DEFAULT 'pending_payment';

-- Tambah kolom kurir driver
ALTER TABLE `orders` 
ADD COLUMN `courier_driver_name` VARCHAR(255) NULL AFTER `waybill_id`,
ADD COLUMN `courier_driver_phone` VARCHAR(255) NULL AFTER `courier_driver_name`,
ADD COLUMN `courier_driver_photo` VARCHAR(255) NULL AFTER `courier_driver_phone`,
ADD COLUMN `courier_driver_rating` DECIMAL(3,2) NULL AFTER `courier_driver_photo`,
ADD COLUMN `courier_driver_vehicle` VARCHAR(255) NULL AFTER `courier_driver_rating`,
ADD COLUMN `courier_driver_vehicle_number` VARCHAR(255) NULL AFTER `courier_driver_vehicle`,
ADD COLUMN `pickup_time` TIMESTAMP NULL AFTER `courier_driver_vehicle_number`;
```

### 2. Test Alur Lengkap

#### A. Customer Checkout
1. Login customer
2. Tambah produk ke cart
3. Checkout → Pilih ekspedisi (JNT/AnterAja/Paxel)
4. Bayar → Upload bukti

#### B. Admin Verifikasi Pembayaran
1. Login admin → `/admin/orders`
2. Klik order baru
3. Sidebar kanan → **"Verifikasi Pembayaran"**
4. ✅ Status berubah: `pending_payment` → `processing`
5. ✅ Alert muncul: "Pesanan sedang diproses. Silakan pack barang..."

#### C. Admin Pack Barang & Ubah Status
1. Pack barang pesanan
2. Scroll ke sidebar kanan → **"Update Status"**
3. Pilih status: **"Siap Pickup"** (`ready_to_ship`)
4. Klik **"Update Status"**
5. ✅ Status berubah: `processing` → `ready_to_ship`
6. ✅ Alert berubah: "Barang sudah siap. Silakan request pickup..."

#### D. Admin Request Pickup
1. Scroll ke section **"Ekspedisi & Pickup"**
2. Klik **"Request Pickup ke {Ekspedisi}"**
3. Loading 2 detik "Mencari Kurir Terdekat..."
4. ✅ Halaman refresh
5. ✅ Status tetap `ready_to_ship`
6. ✅ **Info kurir muncul:**
   - Foto profil
   - Nama: Eko Prasetyo (random)
   - Rating: ⭐ 4.9
   - Telepon: 081234567893
   - Kendaraan: Motor - L 3456 GH
   - Estimasi Pickup: 30 menit

---

## 🎯 UI Changes

### Admin Order Detail (`/admin/orders/{id}`)

#### Alert Berdasarkan Status:

**Status = `processing`:**
```
⚠️ Action Required: Pesanan sedang diproses. 
Silakan pack barang, lalu ubah status ke "Siap Pickup" atau langsung request pickup.
```

**Status = `ready_to_ship` (belum request pickup):**
```
ℹ️ Siap Pickup: Barang sudah siap. 
Silakan request pickup ke ekspedisi di bawah.
```

**Status = `ready_to_ship` (sudah request pickup):**
```
✅ Pickup Berhasil Direquest!
Kurir akan datang ke toko dalam 30 menit. Barang siap untuk diambil.
```

#### Dropdown Update Status:
- Menunggu Pembayaran
- **Pesanan Diproses** ← Baru
- **Siap Pickup** ← Baru
- Dikirim Ekspedisi
- Sudah Sampai
- Selesai
- Dibatalkan

### Admin Orders List (`/admin/orders`)

Filter status updated dengan:
- Pesanan Diproses
- Siap Pickup

Badge colors:
- `processing` = Biru
- `ready_to_ship` = Ungu
- `shipped` = Orange

---

## 📋 Testing Checklist

### Verifikasi Pembayaran
- [ ] Klik "Verifikasi Pembayaran"
- [ ] Status berubah `pending_payment` → `processing`
- [ ] Alert "Pesanan sedang diproses" muncul
- [ ] Customer dapat notifikasi

### Update Status Manual
- [ ] Dropdown "Update Status" ada opsi "Pesanan Diproses" dan "Siap Pickup"
- [ ] Ubah status dari `processing` → `ready_to_ship`
- [ ] Alert berubah menjadi "Barang sudah siap"
- [ ] Tombol "Request Pickup" tetap muncul

### Request Pickup
- [ ] Tombol "Request Pickup" muncul di status `processing` atau `ready_to_ship`
- [ ] Klik tombol → Loading 2 detik
- [ ] Status tetap `ready_to_ship` (tidak berubah)
- [ ] Info kurir muncul dengan data lengkap
- [ ] Alert berubah "Pickup Berhasil Direquest"

### Database Validation
```sql
SELECT id, order_number, status, courier_driver_name, waybill_id 
FROM orders 
WHERE id = 7;
```

Expected:
- `status` = `ready_to_ship`
- `courier_driver_name` = Nama kurir
- `waybill_id` = Nomor resi

---

## 🔧 Troubleshooting

### Error: "Data truncated for column 'status'"
**Solusi:** SQL belum dijalankan. Jalankan SQL di phpMyAdmin.

### Status Dropdown Tidak Ada "Siap Pickup"
**Solusi:** Clear cache browser (Ctrl+Shift+R)

### Tombol Request Pickup Tidak Muncul
**Cek:**
- Status = `processing` atau `ready_to_ship`
- Payment status = `paid`
- Ada ekspedisi (`courier_code` not null)
- Belum pernah request (`biteship_order_id` null)

---

## 📝 Summary

✅ **Status baru:** `processing` (Pesanan Diproses) dan `ready_to_ship` (Siap Pickup)
✅ **Alur jelas:** Verifikasi → Pack → Ubah Status → Request Pickup
✅ **Admin control:** Admin bisa ubah status manual sebelum request pickup
✅ **Info kurir:** Muncul setelah request pickup dengan data lengkap
✅ **Customer notif:** Dapat update setiap perubahan status

**Jalankan SQL dan test alur lengkap!** 🚀
