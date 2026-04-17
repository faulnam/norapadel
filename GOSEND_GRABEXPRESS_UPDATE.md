# Update: Penambahan GoSend & GrabExpress

## Ringkasan Perubahan

Telah ditambahkan 2 ekspedisi baru dengan layanan instant dan same-day delivery:
- **GoSend** (Instant & Same Day)
- **GrabExpress** (Instant & Same Day)

## Detail Perubahan

### 1. BiteshipService.php
**File:** `app/Services/BiteshipService.php`

#### Penambahan Ekspedisi Baru
```php
[
    'courier_code'         => 'gosend',
    'courier_name'         => 'GoSend',
    'services' => [
        ['name' => 'Instant',      'type' => 'instant',  'multiplier' => 1.0],
        ['name' => 'Same Day',     'type' => 'sameday',  'multiplier' => 0.85],
    ],
],
[
    'courier_code'         => 'grabexpress',
    'courier_name'         => 'GrabExpress',
    'services' => [
        ['name' => 'Instant',      'type' => 'instant',  'multiplier' => 0.95],
        ['name' => 'Same Day',     'type' => 'sameday',  'multiplier' => 0.8],
    ],
],
```

#### Perhitungan Berat
- Semua ekspedisi menggunakan perhitungan berat yang sama
- Berat minimum: 1 kg
- Berat dihitung dari total berat produk dalam keranjang
- Formula: `$weightKg = max(1, ceil($weightGram / 1000))`

#### Zona Pengiriman
Instant delivery tersedia untuk zona:
- **same_city** (dalam kota, ≤30 km): Instant & Same Day tersedia
- **nearby** (kota tetangga, ≤150 km): Instant & Same Day tersedia
- **inter_city** (antar kota, ≤500 km): Hanya Regular & Express
- **inter_island** (antar pulau, >500 km): Hanya Regular & Express

#### Harga Dasar per KG per Zona
```php
'same_city'    => ['instant' => 30000, 'sameday' => 20000]
'nearby'       => ['instant' => 45000, 'sameday' => 35000]
```

#### Format Nomor Resi
- **GoSend**: `GOSEND-{timestamp}{4digit}` (contoh: GOSEND-17763116031234)
- **GrabExpress**: `GRAB{12digit}` (contoh: GRAB123456789012)

#### Data Kurir Dummy (Sandbox Mode)
**GoSend:**
- Hendra Wijaya (Rating 4.9, 1580 trips)
- Irfan Hakim (Rating 4.8, 1320 trips)

**GrabExpress:**
- Joko Susilo (Rating 4.9, 1450 trips)
- Kurniawan Adi (Rating 4.8, 1290 trips)

### 2. Checkout View
**File:** `resources/views/customer/orders/checkout.blade.php`

#### Icon Ekspedisi
```javascript
const courierIcons = { 
    jnt: 'fa-truck', 
    anteraja: 'fa-shipping-fast', 
    paxel: 'fa-bolt',
    gosend: 'fa-motorcycle',      // BARU
    grabexpress: 'fa-car'          // BARU
};
```

## Fitur yang Sudah Terintegrasi

### ✅ Perhitungan Ongkir
- Berat produk dihitung otomatis dari database
- Jarak dihitung berdasarkan koordinat GPS
- Zona deteksi otomatis (same_city, nearby, inter_city, inter_island)
- Harga disesuaikan dengan berat dan zona

### ✅ Label Resi
- Format resi sesuai dengan masing-masing ekspedisi
- Generate otomatis saat request pickup
- Tersimpan di database (field: `waybill_id`)

### ✅ Info Kurir
- Nama kurir
- Foto profil
- Rating & total trips
- Nomor telepon
- Jenis kendaraan & plat nomor
- Semua tersimpan di database saat pickup

### ✅ Tampilan UI
- Icon ekspedisi sesuai brand
- Badge layanan (Instant, Same Day, Express, Regular)
- Estimasi waktu pengiriman
- Harga per layanan

## Cara Penggunaan

### Customer (Checkout)
1. Pilih lokasi pengiriman di peta
2. Sistem otomatis menghitung ongkir dari semua ekspedisi
3. Pilih ekspedisi dan layanan yang diinginkan
4. Lihat estimasi waktu dan harga
5. Lanjut pembayaran

### Admin (Request Pickup)
1. Verifikasi pembayaran customer
2. Ubah status ke "Siap Pickup"
3. Klik "Request Pickup ke [Ekspedisi]"
4. Sistem otomatis:
   - Generate nomor resi
   - Assign kurir terdekat
   - Simpan info kurir
   - Update status ke "Shipped"

## Testing (Sandbox Mode)

Saat `BITESHIP_SANDBOX=true` di `.env`:
- Tidak ada biaya API
- Data kurir dummy otomatis
- Nomor resi generate otomatis
- Simulasi pickup dalam 2 detik

## Production Mode

Untuk menggunakan di production:
1. Verifikasi akun Biteship (KTP/NIB)
2. Top up saldo minimum Rp 100.000
3. Update `.env`:
   ```
   BITESHIP_API_KEY=biteship_live.xxxxx
   BITESHIP_SANDBOX=false
   ```
4. Sistem akan menggunakan API Biteship real

## Catatan Penting

- GoSend & GrabExpress hanya tersedia untuk zona **same_city** dan **nearby**
- Instant delivery memiliki harga lebih tinggi dari Same Day
- Berat minimum 1 kg untuk semua ekspedisi
- Koordinat GPS wajib diisi untuk perhitungan akurat
- Nomor resi otomatis sesuai format masing-masing ekspedisi

## File yang Dimodifikasi

1. `app/Services/BiteshipService.php` - Logika ekspedisi & pickup
2. `resources/views/customer/orders/checkout.blade.php` - UI checkout
3. `config/biteship.php` - Tambah GoSend & GrabExpress ke daftar courier
4. `app/Http/Controllers/Customer/ShippingController.php` - Tambah field duration_minutes & distance_km

## File yang Tidak Perlu Diubah

- `resources/views/customer/orders/show.blade.php` - Sudah support semua ekspedisi
- `resources/views/admin/orders/show.blade.php` - Sudah support semua ekspedisi
- `resources/views/admin/orders/_pickup_section.blade.php` - Sudah support semua ekspedisi
- Database migrations - Tidak perlu perubahan
- Models - Tidak perlu perubahan

## Kesimpulan

✅ GoSend dan GrabExpress berhasil ditambahkan
✅ Perhitungan berat sama dengan ekspedisi lain
✅ Format resi sesuai dengan masing-masing ekspedisi
✅ Label dan icon sudah disesuaikan
✅ Terintegrasi penuh dengan sistem yang ada
✅ Siap digunakan di sandbox maupun production
