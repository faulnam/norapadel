# Paylabs Quick Start - Testing di Local

## 🚀 Langkah Cepat (5 Menit)

### 1. Kirim Public Key ke Paylabs (WAJIB!)

```bash
# Buka file public key
notepad storage\app\paylabs\public-key.pem

# Copy seluruh isinya, kirim email ke: cs@paylabs.co.id
```

**Template Email:**
```
Subject: Aktivasi Public Key - Merchant ID 124101811100001

Halo Tim Paylabs,

Mohon aktivasi public key untuk Merchant ID: 124101811100001 (Sandbox)

-----BEGIN PUBLIC KEY-----
[paste isi public-key.pem]
-----END PUBLIC KEY-----

Terima kasih.
```

⚠️ **TUNGGU KONFIRMASI DARI PAYLABS SEBELUM LANJUT!**

---

### 2. Start Ngrok

```bash
ngrok http 80
```

Copy URL ngrok (contoh: `https://abc123.ngrok-free.dev`)

---

### 3. Update .env

```env
APP_URL=https://abc123.ngrok-free.dev
PAYLABS_CALLBACK_URL=https://abc123.ngrok-free.dev/webhook/paylabs
PAYLABS_RETURN_URL=https://abc123.ngrok-free.dev/customer/payment-paylabs/{order_id}/callback
```

---

### 4. Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
```

---

### 5. Test Payment

1. Buka browser: `http://localhost`
2. Login sebagai customer
3. Tambah produk ke cart
4. Checkout → Pilih ekspedisi → Lanjut ke Pembayaran
5. Pilih "Paylabs"
6. Pilih payment channel (QRIS/VA/E-Wallet)
7. Klik "Bayar"

---

### 6. Monitor Log

```bash
# Terminal baru
tail -f storage/logs/laravel.log | grep Paylabs
```

**Harus muncul:**
```
✅ Paylabs createTransaction request
✅ Paylabs createTransaction response (status: 200, errCode: 0)
✅ Redirect ke payment URL Paylabs
```

**Jika error:**
```
❌ Failed to load private key → Cek path private key di .env
❌ Failed to sign request → Private key corrupted, generate ulang
❌ Invalid signature → Public key belum diaktivasi Paylabs
❌ errCode: 40001 → Parameter invalid, cek request body
```

---

## 🧪 Test Scenarios

### Scenario 1: QRIS Payment
1. Pilih "QRIS" di halaman pembayaran
2. Scan QR code dengan app e-wallet
3. Bayar
4. Tunggu webhook callback
5. Order status berubah ke "Processing"

### Scenario 2: Virtual Account
1. Pilih "BCA Virtual Account"
2. Copy nomor VA
3. Transfer via mobile banking
4. Tunggu webhook callback
5. Order status berubah ke "Processing"

### Scenario 3: E-Wallet
1. Pilih "OVO" / "DANA" / "GoPay"
2. Klik deeplink untuk buka app
3. Bayar di app
4. Redirect kembali ke website
5. Order status berubah ke "Processing"

---

## ✅ Checklist Sukses

- [ ] Public key sudah dikirim ke Paylabs
- [ ] Dapat konfirmasi aktivasi dari Paylabs
- [ ] Ngrok running dan URL sudah di .env
- [ ] Cache sudah di-clear
- [ ] Log menunjukkan request berhasil (errCode: 0)
- [ ] Redirect ke payment URL Paylabs
- [ ] Bisa bayar di halaman Paylabs
- [ ] Webhook callback masuk
- [ ] Order status update ke "Processing"

---

## 🔥 Common Issues

### "Failed to load private key"
```bash
# Cek file ada
dir storage\app\paylabs\

# Harus ada:
# - private-key.pem
# - public-key.pem
```

### "Invalid signature" dari Paylabs
```
❌ Public key belum diaktivasi!
✅ Kirim email ke cs@paylabs.co.id
✅ Tunggu konfirmasi (1-2 hari kerja)
```

### Webhook tidak masuk
```bash
# Test webhook URL
curl -X POST https://your-ngrok-url.ngrok-free.dev/webhook/paylabs ^
  -H "Content-Type: application/json" ^
  -d "{\"test\": \"webhook\"}"

# Cek log Laravel
tail -f storage/logs/laravel.log
```

### Payment URL tidak muncul
```bash
# Cek log response
tail -f storage/logs/laravel.log | grep "Paylabs createTransaction response"

# Harus ada field "url" di response
# Jika tidak ada, cek errCode dan errCodeDes
```

---

## 📞 Need Help?

1. Cek log: `storage/logs/laravel.log`
2. Cek dokumentasi: `PAYLABS_SETUP_GUIDE.md`
3. Email Paylabs: cs@paylabs.co.id
4. Cek docs: https://docs.paylabs.co.id

---

## 🎉 Setelah Berhasil

Jika semua test scenario berhasil:
1. ✅ Sistem siap untuk production
2. ✅ Generate key pair baru untuk production
3. ✅ Kirim public key production ke Paylabs
4. ✅ Update .env production
5. ✅ Deploy!

---

**Good luck! 🚀**
