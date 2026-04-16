# Setup Request Pickup dengan Kurir Dummy

## 1. Jalankan Migration

Buka terminal/command prompt di folder project, lalu jalankan:

```bash
php artisan migrate
```

Migration akan menambahkan kolom baru di tabel `orders`:
- `courier_driver_name` - Nama kurir
- `courier_driver_phone` - Telepon kurir
- `courier_driver_photo` - URL foto kurir
- `courier_driver_rating` - Rating kurir (0-5)
- `courier_driver_vehicle` - Jenis kendaraan (Motor/Mobil)
- `courier_driver_vehicle_number` - Nomor plat kendaraan
- `pickup_time` - Estimasi waktu pickup

## 2. Pastikan Sandbox Mode Aktif

Di file `.env`, pastikan:

```env
BITESHIP_SANDBOX=true
```

## 3. Alur Request Pickup

### A. Admin Dashboard
1. Buka `/admin/orders`
2. Pilih order dengan status `paid` (sudah dibayar)
3. Klik order untuk lihat detail

### B. Request Pickup
1. Di halaman detail order, scroll ke section "Ekspedisi & Pickup"
2. Klik tombol **"Request Pickup ke {Ekspedisi}"**
3. Konfirmasi popup
4. **Loading animation muncul** dengan text "Mencari Kurir Terdekat..."
5. Sistem simulasi scanning kurir (delay 2 detik)
6. Halaman refresh otomatis

### C. Info Kurir Muncul
Setelah request pickup berhasil, akan muncul card info kurir:

```
┌─────────────────────────────────────────┐
│ ✓ Pickup Berhasil Direquest!           │
│ Kurir akan datang ke toko dalam 30 menit│
├─────────────────────────────────────────┤
│ INFORMASI KURIR                         │
│                                         │
│ [Foto]  Budi Santoso                   │
│         ⭐ 4.8 rating                   │
│                                         │
│         Telepon: 081234567890          │
│         Kendaraan: Motor - L 1234 AB   │
│                                         │
│         🕐 Estimasi Pickup: 14:30 WIB  │
└─────────────────────────────────────────┘
```

## 4. Data Kurir Dummy

### J&T Express (jnt)
- **Budi Santoso** - 081234567890 - Rating 4.8 - Motor L 1234 AB
- **Ahmad Rizki** - 081234567891 - Rating 4.9 - Motor L 5678 CD

### AnterAja (anteraja)
- **Dedi Kurniawan** - 081234567892 - Rating 4.7 - Motor L 9012 EF
- **Eko Prasetyo** - 081234567893 - Rating 4.9 - Motor L 3456 GH

### Paxel (paxel)
- **Fajar Ramadhan** - 081234567894 - Rating 4.8 - Motor L 7890 IJ
- **Gilang Pratama** - 081234567895 - Rating 4.9 - Motor L 2345 KL

Sistem akan **random pilih salah satu kurir** dari ekspedisi yang dipilih customer.

## 5. Status Flow

```
paid → [Request Pickup] → processing (dengan info kurir) → shipped → delivered → completed
```

## 6. Testing Checklist

- [ ] Order dengan status `paid` menampilkan tombol "Request Pickup"
- [ ] Klik tombol muncul loading modal "Mencari Kurir Terdekat..."
- [ ] Loading delay 2 detik (simulasi scanning)
- [ ] Setelah sukses, halaman refresh dan status berubah `processing`
- [ ] Card info kurir muncul dengan:
  - [ ] Foto kurir (avatar)
  - [ ] Nama kurir
  - [ ] Rating bintang
  - [ ] Nomor telepon
  - [ ] Jenis kendaraan & plat nomor
  - [ ] Estimasi waktu pickup (30 menit dari sekarang)
- [ ] Nomor resi muncul di section ekspedisi
- [ ] Customer dapat notifikasi

## 7. Troubleshooting

### Tombol Request Pickup Tidak Muncul
**Cek:**
- Status order = `paid`
- Payment status = `paid`
- `courier_code` tidak null (customer sudah pilih ekspedisi)
- `biteship_order_id` masih null (belum pernah request)

### Loading Tidak Muncul
**Cek:**
- JavaScript error di console browser (F12)
- Modal element `pickupLoadingModal` ada di HTML

### Info Kurir Tidak Muncul
**Cek:**
- Migration sudah dijalankan
- Kolom `courier_driver_name` dst sudah ada di database
- Response dari API berisi data kurir

### Error "Column not found"
**Solusi:**
```bash
php artisan migrate:fresh --seed
```
⚠️ Warning: Ini akan hapus semua data!

Atau manual:
```bash
php artisan migrate
```

## 8. Production Mode

Saat `BITESHIP_SANDBOX=false`:
- Data kurir akan dari Biteship API real
- Kurir real dari ekspedisi akan dapat notifikasi
- Tidak ada delay simulasi
- Foto kurir dari sistem ekspedisi

## 9. File yang Diupdate

1. `app/Services/BiteshipService.php` - Mock data kurir
2. `app/Http/Controllers/Admin/PickupController.php` - Save data kurir
3. `app/Models/Order.php` - Fillable & casts
4. `database/migrations/2024_01_20_100000_add_courier_driver_info_to_orders.php` - Migration
5. `resources/views/admin/orders/_pickup_section.blade.php` - UI kurir
6. `ADMIN_FLOW_GUIDE.md` - Dokumentasi admin
