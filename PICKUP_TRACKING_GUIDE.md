# Fitur Pickup & Tracking Ekspedisi

## Overview
Sistem terintegrasi dengan Biteship API untuk request pickup dan tracking real-time pengiriman dari ekspedisi pihak ketiga (JNT, AnterAja, Paxel).

---

## Alur Lengkap

### 1. Customer Checkout
```
Customer pilih lokasi di peta
→ Sistem hitung ongkir berdasarkan zona + berat
→ Customer pilih ekspedisi (JNT/AnterAja/Paxel) + layanan (Reguler/Express/Same Day/Instant)
→ Customer bayar
→ Data ekspedisi tersimpan: courier_code, courier_name, courier_service_name
```

### 2. Admin Request Pickup
```
Admin buka detail order
→ Klik tombol "Request Pickup"
→ Sistem kirim request ke Biteship API
→ Biteship jadwalkan pickup ke ekspedisi
→ Sistem simpan: biteship_order_id, waybill_id (nomor resi)
→ Status order update ke "assigned"
```

### 3. Kurir Ekspedisi Pickup
```
Kurir ekspedisi datang ke toko
→ Ambil paket
→ Scan resi
→ Mulai pengiriman
```

### 4. Customer Tracking
```
Customer buka detail order
→ Lihat info ekspedisi + nomor resi
→ Klik "Lihat Status Pengiriman"
→ Sistem fetch data tracking dari Biteship API
→ Tampilkan timeline pengiriman real-time
```

---

## File yang Dibuat/Diupdate

### Backend
1. **app/Services/BiteshipService.php**
   - `getRates()` - Hitung ongkir berdasarkan zona + berat
   - `createOrder()` - Request pickup ke Biteship
   - `trackOrder()` - Get tracking data

2. **app/Http/Controllers/Admin/PickupController.php**
   - `requestPickup()` - Request pickup dari admin
   - `updateWaybill()` - Input resi manual
   - `getTracking()` - Get tracking untuk admin

3. **app/Http/Controllers/Customer/OrderController.php**
   - `getTracking()` - Get tracking untuk customer

4. **routes/web.php**
   - `POST /admin/orders/{order}/request-pickup`
   - `POST /admin/orders/{order}/update-waybill`
   - `GET /admin/orders/{order}/tracking`
   - `GET /customer/orders/{order}/tracking`

### Frontend
1. **resources/views/admin/orders/_pickup_section.blade.php**
   - Section pickup & tracking di admin order detail
   - Tombol Request Pickup
   - Form input resi manual
   - Tombol lihat tracking
   - Timeline tracking

2. **resources/views/customer/orders/_tracking_section.blade.php**
   - Section tracking di customer order detail
   - Info ekspedisi + nomor resi
   - Tombol salin resi
   - Tombol lihat tracking
   - Timeline tracking real-time

---

## Database Fields (sudah ada)

### orders table
- `courier_code` - Kode ekspedisi (jnt, anteraja, paxel)
- `courier_name` - Nama ekspedisi (J&T Express, AnterAja, Paxel)
- `courier_service_name` - Nama layanan (EZ, Regular, Same Day, Instant)
- `biteship_order_id` - ID order dari Biteship
- `waybill_id` - Nomor resi dari ekspedisi

---

## Cara Penggunaan

### Admin
1. Buka **Admin → Orders → Detail Order**
2. Scroll ke section **"Ekspedisi & Pickup"**
3. Klik **"Request Pickup"** untuk jadwalkan pickup otomatis
4. Atau input **nomor resi manual** jika pickup dilakukan di luar sistem
5. Klik **"Lihat Tracking"** untuk cek status pengiriman

### Customer
1. Buka **My Orders → Detail Order**
2. Scroll ke section **"Tracking Pengiriman"**
3. Lihat info ekspedisi + nomor resi
4. Klik **"Salin"** untuk copy nomor resi
5. Klik **"Lihat Status Pengiriman"** untuk tracking real-time

---

## Sistem Ongkir

### Zona Pengiriman
- **Dalam Kota** (≤30 km) - Harga paling murah
- **Kota Tetangga** (31-150 km) - Harga sedang
- **Antar Kota** (151-500 km) - Harga mahal
- **Antar Pulau** (>500 km) - Harga paling mahal

### Perhitungan
```
Ongkir = Harga Dasar per KG × Berat (kg) × Multiplier Ekspedisi
```

**Contoh:**
- Produk 1.5 kg
- Zona: Dalam Kota
- Ekspedisi: J&T Express - EZ (Reguler)
- Harga dasar: Rp 8.000/kg
- Multiplier: 1.0
- **Ongkir = 8.000 × 2 kg × 1.0 = Rp 16.000**

### Layanan Tersedia
- **Reguler** - 2-4 hari (paling murah)
- **Express** - 1-2 hari (lebih mahal 10%)
- **Same Day** - Hari ini (lebih mahal 100%)
- **Instant** - 2-4 jam (paling mahal, hanya dalam kota)

---

## Testing

### Mode Sandbox (Development)
Set di `.env`:
```
BITESHIP_SANDBOX=true
```
Sistem akan menggunakan mock data, tidak hit API Biteship real.

### Mode Production
Set di `.env`:
```
BITESHIP_SANDBOX=false
BITESHIP_API_KEY=your_real_api_key_here
```
Pastikan saldo Biteship cukup untuk request pickup.

---

## Troubleshooting

### Request Pickup Gagal
- Cek saldo Biteship
- Cek API key valid
- Cek order sudah paid
- Cek data ekspedisi tersimpan di order

### Tracking Tidak Muncul
- Cek nomor resi sudah ada
- Cek ekspedisi sudah scan paket
- Tunggu beberapa menit setelah pickup

### Ongkir Tidak Sesuai
- Cek berat produk di database
- Cek zona pengiriman (jarak dari toko)
- Cek multiplier ekspedisi di BiteshipService

---

## Notes
- Pickup hanya bisa direquest untuk order yang sudah **paid**
- Nomor resi otomatis didapat setelah request pickup berhasil
- Tracking real-time tersedia setelah kurir scan paket
- Admin bisa input resi manual jika pickup dilakukan di luar sistem
- Customer bisa salin nomor resi untuk tracking di website ekspedisi
