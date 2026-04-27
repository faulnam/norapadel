# Checklist Verifikasi Integrasi Biteship

## Persiapan

- [ ] Pastikan API Key Biteship sudah benar di `.env`
  ```
  BITESHIP_API_KEY=biteship_live.xxx
  BITESHIP_SANDBOX=false
  ```

- [ ] Pastikan koordinat toko sudah benar di `.env`
  ```
  BITESHIP_ORIGIN_LAT=-7.2575
  BITESHIP_ORIGIN_LNG=112.7521
  BITESHIP_ORIGIN_POSTAL_CODE=61219
  ```

- [ ] Clear cache Laravel
  ```bash
  php artisan config:clear
  php artisan cache:clear
  ```

## Testing Manual via Command

### 1. Test Kurir Regular

#### JNE
```bash
php artisan biteship:test-order jne
```
- [ ] Order berhasil dibuat
- [ ] Muncul di dashboard Biteship
- [ ] Waybill ID ter-generate
- [ ] Status: confirmed

#### J&T Express
```bash
php artisan biteship:test-order jnt
```
- [ ] Order berhasil dibuat
- [ ] Muncul di dashboard Biteship
- [ ] Waybill ID ter-generate
- [ ] Status: confirmed

#### AnterAja
```bash
php artisan biteship:test-order anteraja
```
- [ ] Order berhasil dibuat
- [ ] Muncul di dashboard Biteship
- [ ] Waybill ID ter-generate
- [ ] Status: confirmed

#### SiCepat
```bash
php artisan biteship:test-order sicepat
```
- [ ] Order berhasil dibuat
- [ ] Muncul di dashboard Biteship
- [ ] Waybill ID ter-generate
- [ ] Status: confirmed

### 2. Test Kurir Instant

#### Grab Express
```bash
php artisan biteship:test-order grab
```
- [ ] Order berhasil dibuat
- [ ] Muncul di dashboard Biteship
- [ ] Waybill ID ter-generate
- [ ] Status: confirmed
- [ ] Driver ter-assign (jika dalam jam operasional)

#### GoSend
```bash
php artisan biteship:test-order gosend
```
- [ ] Order berhasil dibuat
- [ ] Muncul di dashboard Biteship
- [ ] Waybill ID ter-generate
- [ ] Status: confirmed
- [ ] Driver ter-assign (jika dalam jam operasional)

## Testing via Website

### 1. Buat Pesanan Test

- [ ] Login sebagai customer
- [ ] Tambahkan produk ke cart
- [ ] Checkout dengan ekspedisi JNE
- [ ] Pilih metode pembayaran
- [ ] Bayar pesanan
- [ ] Cek dashboard Biteship - order harus muncul

### 2. Ulangi untuk Ekspedisi Lain

- [ ] J&T Express
- [ ] AnterAja
- [ ] SiCepat
- [ ] Grab (jika tersedia di area)
- [ ] GoSend (jika tersedia di area)

## Verifikasi Dashboard Biteship

Login ke https://dashboard.biteship.com

### Menu Orders
- [ ] Semua pesanan test muncul
- [ ] Status order benar (confirmed/allocated/picking_up)
- [ ] Detail order lengkap:
  - [ ] Origin address
  - [ ] Destination address
  - [ ] Items
  - [ ] Courier info
  - [ ] Waybill ID

### Menu Tracking
- [ ] Bisa track order dengan waybill ID
- [ ] Status tracking ter-update
- [ ] History tracking tersimpan

## Verifikasi Database

```sql
-- Cek orders yang sudah sync ke Biteship
SELECT 
    order_number,
    courier_code,
    courier_name,
    biteship_order_id,
    waybill_id,
    biteship_tracking_status,
    status,
    created_at
FROM orders
WHERE biteship_order_id IS NOT NULL
ORDER BY created_at DESC
LIMIT 10;
```

- [ ] Field `biteship_order_id` terisi
- [ ] Field `waybill_id` terisi
- [ ] Field `biteship_tracking_status` terisi
- [ ] Field `status` sesuai dengan tracking status

## Verifikasi Log

```bash
# Lihat log Biteship
tail -f storage/logs/laravel.log | grep Biteship
```

### Log yang Harus Ada:

1. **Saat Create Order**
   ```
   Biteship createOrder request
   - is_instant_courier: true/false
   - has_origin_coordinate: true
   - has_destination_coordinate: true
   - has_origin_postal_code: true/false (tergantung jenis kurir)
   ```

2. **Saat Order Sukses**
   ```
   Biteship createOrder response payment meta
   - biteship_order_id: xxx
   - status: confirmed
   ```

3. **Saat Payment Sukses**
   ```
   Create Biteship shipment sukses saat payment sukses
   - order_number: xxx
   - biteship_order_id: xxx
   - waybill_id: xxx
   ```

## Troubleshooting

### Jika Order Tidak Muncul di Dashboard

1. **Cek Log Error**
   ```bash
   tail -f storage/logs/laravel.log | grep "Biteship createOrder failed"
   ```

2. **Cek Response Biteship**
   - Lihat error message dari API
   - Cek apakah ada field yang missing
   - Cek apakah koordinat valid

3. **Cek API Key**
   - Pastikan menggunakan live key (bukan sandbox)
   - Pastikan key masih aktif
   - Cek quota/limit API

### Jika Koordinat Invalid

1. **Validasi Format**
   - Latitude: -90 sampai 90
   - Longitude: -180 sampai 180
   - Format: desimal (bukan DMS)

2. **Cek Koordinat di Database**
   ```sql
   SELECT 
       order_number,
       shipping_latitude,
       shipping_longitude
   FROM orders
   WHERE shipping_latitude = 0 OR shipping_longitude = 0;
   ```

3. **Test Koordinat di Google Maps**
   - Buka Google Maps
   - Input koordinat: `-7.2575, 112.7521`
   - Pastikan lokasi benar

### Jika Postal Code Invalid

1. **Validasi Format**
   - Harus 5 digit angka
   - Contoh: 61219, 60119

2. **Cek Postal Code di Database**
   ```sql
   SELECT 
       order_number,
       shipping_postal_code
   FROM orders
   WHERE shipping_postal_code IS NULL 
      OR LENGTH(shipping_postal_code) != 5;
   ```

3. **Gunakan Biteship Maps API**
   ```bash
   # Cari postal code berdasarkan koordinat
   curl -X GET "https://api.biteship.com/v1/maps/areas?countries=ID&input=surabaya&type=single" \
     -H "Authorization: YOUR_API_KEY"
   ```

## Monitoring Produksi

### Daily Check
- [ ] Cek jumlah order yang sync ke Biteship
- [ ] Cek order yang gagal sync
- [ ] Cek status tracking ter-update

### Weekly Check
- [ ] Review error log Biteship
- [ ] Cek performa API (response time)
- [ ] Cek quota API usage

### Monthly Check
- [ ] Review integrasi dengan ekspedisi baru
- [ ] Update dokumentasi jika ada perubahan
- [ ] Backup data tracking history

## Catatan Penting

1. **Jam Operasional Kurir Instant**
   - Grab: 09:00 - 21:00 WIB
   - GoSend: 08:00 - 20:00 WIB
   - Di luar jam operasional, order akan pending

2. **Area Coverage**
   - Kurir instant hanya tersedia di kota besar
   - Cek coverage area di dashboard Biteship
   - Gunakan fallback ke kurir regular jika instant tidak tersedia

3. **Rate Limit API**
   - Biteship memiliki rate limit per menit
   - Jika terlalu banyak request, akan dapat error 429
   - Implementasi retry mechanism jika perlu

4. **Webhook**
   - Pastikan webhook URL accessible dari internet
   - Gunakan ngrok untuk development
   - Set webhook URL di dashboard Biteship
