# Test GoSend & GrabExpress di Checkout

## Cara Test

1. **Login sebagai customer**
   - Buka: http://127.0.0.1:8000/login
   - Login dengan akun customer

2. **Tambah produk ke keranjang**
   - Pilih produk dengan berat (pastikan ada weight di database)
   - Tambahkan ke keranjang

3. **Buka halaman checkout**
   - URL: http://127.0.0.1:8000/customer/checkout
   - Atau klik tombol checkout dari keranjang

4. **Pilih lokasi pengiriman**
   - Klik "Lokasi Saya" atau pilih di peta
   - Pastikan koordinat terisi

5. **Cek ekspedisi yang muncul**
   Seharusnya muncul 5 ekspedisi:
   - ✅ J&T Express (icon truck)
   - ✅ AnterAja (icon shipping-fast)
   - ✅ Paxel (icon bolt)
   - ✅ GoSend (icon motorcycle) ← BARU
   - ✅ GrabExpress (icon car) ← BARU

## Expected Result

### Zona: Dalam Kota (≤30 km)
```
J&T Express
├─ EZ (Reguler) - 2-4 hari - Rp 16.000
└─ Express - 1-2 hari - Rp 17.600

AnterAja
├─ Reguler - 2-4 hari - Rp 15.200
└─ Same Day - Hari ini - Rp 40.000

Paxel
├─ Regular - 2-4 hari - Rp 16.800
├─ Same Day - Hari ini - Rp 44.000
└─ Instant - 2-4 jam - Rp 60.000

GoSend ← BARU
├─ Instant - 2-4 jam - Rp 60.000
└─ Same Day - Hari ini - Rp 34.000

GrabExpress ← BARU
├─ Instant - 2-4 jam - Rp 57.000
└─ Same Day - Hari ini - Rp 32.000
```

### Zona: Kota Tetangga (30-150 km)
```
J&T Express
├─ EZ (Reguler) - 2-4 hari - Rp 24.000
└─ Express - 1-2 hari - Rp 26.400

AnterAja
├─ Reguler - 2-4 hari - Rp 22.800
└─ Same Day - Hari ini - Rp 70.000

Paxel
├─ Regular - 2-4 hari - Rp 25.200
├─ Same Day - Hari ini - Rp 77.000
└─ Instant - 2-4 jam - Rp 90.000

GoSend ← BARU
├─ Instant - 2-4 jam - Rp 90.000
└─ Same Day - Hari ini - Rp 59.500

GrabExpress ← BARU
├─ Instant - 2-4 jam - Rp 85.500
└─ Same Day - Hari ini - Rp 56.000
```

### Zona: Antar Kota (>150 km)
GoSend & GrabExpress TIDAK MUNCUL (hanya Regular & Express tersedia)

## Troubleshooting

### GoSend & GrabExpress tidak muncul?

1. **Clear cache Laravel**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

2. **Cek config biteship**
   File: `config/biteship.php`
   Pastikan ada:
   ```php
   'couriers' => [
       'gosend' => 'GoSend',
       'grabexpress' => 'GrabExpress',
   ],
   ```

3. **Cek zona pengiriman**
   - GoSend & GrabExpress hanya untuk zona `same_city` dan `nearby`
   - Jika jarak >150 km, tidak akan muncul

4. **Cek browser console**
   - Buka Developer Tools (F12)
   - Tab Console
   - Lihat response dari `/customer/shipping/rates`
   - Pastikan ada `gosend` dan `grabexpress` di array rates

5. **Cek Network tab**
   - Developer Tools → Network
   - Filter: XHR
   - Klik request `rates`
   - Lihat Response → rates array

## Debug Mode

Tambahkan di `BiteshipService.php` method `calculateRates()`:

```php
// Sebelum return $rates
\Log::info('Calculated Rates:', ['rates' => $rates]);
return $rates;
```

Lalu cek file: `storage/logs/laravel.log`

## Verifikasi Database

Pastikan produk punya berat:
```sql
SELECT id, name, weight FROM products WHERE weight IS NULL OR weight = 0;
```

Jika ada yang NULL, update:
```sql
UPDATE products SET weight = 500 WHERE weight IS NULL;
```

## Success Indicators

✅ GoSend muncul dengan icon motorcycle
✅ GrabExpress muncul dengan icon car
✅ Instant & Same Day tersedia untuk zona dalam kota
✅ Harga sesuai dengan berat produk
✅ Bisa dipilih dan lanjut checkout
✅ Nomor resi generate otomatis saat pickup
