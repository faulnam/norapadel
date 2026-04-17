# CARA TESTING TRACKING KURIR

## 1. Pastikan Google Maps API Key sudah di .env
```env
GOOGLE_MAPS_API_KEY=your_api_key_here
```

## 2. Ubah status order menjadi 'shipped'
Buka database, table `orders`, ubah status order yang ingin di-test menjadi `shipped`

```sql
UPDATE orders SET status = 'shipped' WHERE id = 1;
```

## 3. Buka halaman order detail
```
http://127.0.0.1:8000/customer/orders/1
```

## 4. Apa yang akan terlihat:
- ✅ Peta Google Maps dengan 3 marker:
  - 🏪 Marker hijau = Toko
  - 📍 Marker merah = Alamat tujuan
  - 🏍️ Icon motor biru = Posisi kurir (BERGERAK)

- ✅ Rute biru mengikuti jalan dari kurir ke tujuan
- ✅ Motor bergerak smooth setiap 5 detik
- ✅ Progress bar menunjukkan % perjalanan
- ✅ Jarak dan estimasi waktu ditampilkan

## 5. Simulasi Tracking
Backend akan mensimulasikan pergerakan kurir dari toko ke alamat tujuan:
- Progress dihitung berdasarkan waktu order
- Motor bergerak secara bertahap (0% → 95%)
- Update setiap 5 detik
- Smooth animation

## 6. Troubleshooting

### Map tidak muncul?
- Check console browser (F12)
- Pastikan Google Maps API key valid
- Pastikan status order = 'shipped', 'on_delivery', atau 'delivered'

### Motor tidak bergerak?
- Check network tab, pastikan API `/courier-location` return success
- Check response JSON ada field `location` dengan lat/lng
- Refresh halaman

### Error "Route not defined"?
- Pastikan route sudah ditambahkan di `routes/web.php`
- Run: `php artisan route:clear`

## 7. Untuk Production (Real GPS)
Kurir harus update lokasi via courier app, data disimpan di table `courier_locations`

Backend akan otomatis gunakan data real jika tersedia, jika tidak akan fallback ke simulasi.
