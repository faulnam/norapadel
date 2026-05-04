# 🚀 Production Checklist - Biteship Integration

## 📋 Persiapan Sebelum Production

### 1. Dapatkan API Key Production dari Biteship
- Login ke dashboard Biteship: https://app.biteship.com
- Buat akun production (bukan sandbox)
- Dapatkan **Production API Key** dari menu Settings → API Keys
- Copy API key yang dimulai dengan `biteship_live.`

### 2. Update File `.env`
```env
# Biteship Production Settings
BITESHIP_API_KEY=biteship_live.YOUR_PRODUCTION_API_KEY_HERE
BITESHIP_SANDBOX=false
```

**PENTING**: 
- Ganti `YOUR_PRODUCTION_API_KEY_HERE` dengan API key production Anda
- Set `BITESHIP_SANDBOX=false` untuk menggunakan API real

### 3. Verifikasi Konfigurasi Origin (Toko)
Update file `config/biteship.php`:
```php
'origin' => [
   'latitude' => -7.278417,  // Koordinat toko Anda
   'longitude' => 112.632583,
    'postal_code' => '60119', // Kode pos toko
],
```

### 4. Test API Connection
Jalankan command untuk test koneksi:
```bash
php artisan tinker
```

Kemudian test:
```php
$biteship = app(\App\Services\BiteshipService::class);
$result = $biteship->getRatesFromAPI([
    'destination_postal_code' => '61219',
    'items' => [
        ['name' => 'Test Product', 'value' => 100000, 'weight' => 1000, 'quantity' => 1]
    ]
]);
dd($result);
```

## 🔄 Perubahan Mode: Sandbox → Production

### Mode Sandbox (Development)
```env
BITESHIP_SANDBOX=true
```
- Menggunakan data dummy/mock
- Tidak ada biaya real
- Nomor resi dummy
- Kurir dummy
- Untuk testing saja

### Mode Production (Live)
```env
BITESHIP_SANDBOX=false
```
- Menggunakan API Biteship real
- Ada biaya per transaksi
- Nomor resi asli dari ekspedisi
- Kurir real akan pickup
- Data masuk ke dashboard Biteship

## ⚙️ Cara Kerja Sistem

### Saat `BITESHIP_SANDBOX=true` (Sandbox Mode)
1. `BiteshipService::getRates()` → menggunakan mock data
2. Harga dihitung berdasarkan zona & berat
3. Kurir dummy (J&T, AnterAja, Paxel, GoSend, GrabExpress)
4. Estimasi berdasarkan `EstimationHelper`

### Saat `BITESHIP_SANDBOX=false` (Production Mode)
1. `BiteshipService::getRatesFromAPI()` → hit API Biteship real
2. Harga dari Biteship API (real-time)
3. Kurir real yang tersedia di area tujuan
4. Estimasi dari Biteship + adjustment `EstimationHelper`

## 📊 Monitoring Production

### 1. Log Monitoring
Cek file log Laravel:
```bash
tail -f storage/logs/laravel.log
```

### 2. Biteship Dashboard
- Login: https://app.biteship.com
- Monitor semua order
- Tracking real-time
- Download invoice

### 3. Error Handling
Jika API error, sistem akan:
- Log error ke `storage/logs/laravel.log`
- Return error message ke user
- Tidak crash aplikasi

## 💰 Biaya Production

### Biteship Pricing (Estimasi)
- **Pay per use**: Bayar per transaksi
- **Biaya admin**: ~Rp 1.000 - 3.000 per order
- **Ongkir**: Sesuai tarif ekspedisi + markup Biteship

### Tips Hemat
1. Gunakan sandbox untuk development/testing
2. Switch ke production hanya saat deploy
3. Monitor usage di dashboard Biteship

## 🔐 Security Checklist

- [ ] API Key production tidak di-commit ke Git
- [ ] File `.env` ada di `.gitignore`
- [ ] API Key disimpan aman (tidak di share)
- [ ] HTTPS enabled di production server
- [ ] Rate limiting enabled untuk API endpoint

## 🧪 Testing Sebelum Go Live

### Test Scenario
1. **Test Checkout Flow**
   - Pilih lokasi dalam kota → cek ongkir
   - Pilih lokasi luar kota → cek ongkir
   - Pilih lokasi luar pulau → cek ongkir
   - Pastikan estimasi berubah sesuai zona

2. **Test Order Creation**
   - Buat order test
   - Cek apakah muncul di dashboard Biteship
   - Cek nomor resi valid
   - Test tracking

3. **Test Error Handling**
   - Matikan internet → cek error message
   - Gunakan koordinat invalid → cek fallback
   - API key salah → cek error log

## 📝 Rollback Plan

Jika ada masalah di production:

1. **Quick Rollback ke Sandbox**
   ```bash
   # Edit .env
   BITESHIP_SANDBOX=true
   
   # Clear cache
   php artisan config:clear
   php artisan cache:clear
   ```

2. **Cek Log Error**
   ```bash
   tail -100 storage/logs/laravel.log
   ```

3. **Contact Support**
   - Biteship Support: support@biteship.com
   - Biteship Docs: https://biteship.com/docs

## ✅ Production Ready Checklist

- [ ] API Key production sudah didapat
- [ ] `.env` sudah diupdate dengan `BITESHIP_SANDBOX=false`
- [ ] Koordinat origin (toko) sudah benar
- [ ] Test API connection berhasil
- [ ] Test checkout flow berhasil
- [ ] Test order creation berhasil
- [ ] Error handling sudah ditest
- [ ] Log monitoring sudah setup
- [ ] Backup plan sudah siap
- [ ] Team sudah training

## 🎯 Next Steps After Production

1. Monitor order pertama di dashboard Biteship
2. Verifikasi kurir pickup
3. Track pengiriman real-time
4. Collect feedback dari customer
5. Optimize berdasarkan data

---

**Note**: Sistem sudah siap production. Tinggal ganti API key dan set `BITESHIP_SANDBOX=false` di `.env`.
