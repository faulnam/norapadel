# Setup Paylabs Payment Gateway - Dokumentasi Lengkap

## ⚠️ PENTING - Perubahan dari Versi Lama

Versi sebelumnya menggunakan:
- ❌ Base URL: `https://www.iotpay.club/posp-api` (SALAH)
- ❌ Signature: SHA256 dengan API Key (SALAH)
- ❌ Endpoint: `/v1/payment/create` (SALAH)

Versi baru (sesuai dokumentasi v4.8.1):
- ✅ Base URL: `https://sandbox.paylabs.co.id`
- ✅ Signature: RSA SHA256withRSA dengan Private Key
- ✅ Endpoint: `/payment/v2.3/h5/createLink`

---

## 📋 Checklist Setup

### 1. Generate RSA Key Pair (Sudah Ada)

Anda sudah punya key pair di:
- Private Key: `storage/app/paylabs/private-key.pem`
- Public Key: `storage/app/paylabs/public-key.pem`

### 2. Kirim Public Key ke Paylabs

**WAJIB DILAKUKAN SEBELUM TESTING!**

1. Buka file `storage/app/paylabs/public-key.pem`
2. Copy seluruh isinya (termasuk `-----BEGIN PUBLIC KEY-----` dan `-----END PUBLIC KEY-----`)
3. Kirim email ke: **cs@paylabs.co.id**

**Template Email:**
```
Subject: Aktivasi Public Key - Merchant ID 124101811100001

Halo Tim Paylabs,

Saya merchant dengan:
- Merchant ID: 124101811100001
- Nama: [Nama Toko Anda]
- Environment: Sandbox

Mohon aktivasi public key berikut untuk akun saya:

-----BEGIN PUBLIC KEY-----
[paste isi public-key.pem di sini]
-----END PUBLIC KEY-----

Terima kasih.
```

4. Tunggu konfirmasi dari Paylabs (biasanya 1-2 hari kerja)

### 3. Update .env

File `.env` sudah diupdate dengan konfigurasi yang benar:

```env
# Paylabs Payment Gateway
PAYLABS_ENV=sandbox
PAYLABS_MERCHANT_ID=124101811100001
PAYLABS_SANDBOX=true
PAYLABS_MOCK_MODE=false
PAYLABS_BASE_URL=https://sandbox.paylabs.co.id
PAYLABS_TIMEOUT=30
PAYLABS_CONNECT_TIMEOUT=10
PAYLABS_VERIFY_SSL=true

# Path RSA Key
PAYLABS_PRIVATE_KEY_PATH=D:/laragonzo/www/norapadell/storage/app/paylabs/private-key.pem
PAYLABS_PUBLIC_KEY_PATH=D:/laragonzo/www/norapadell/storage/app/paylabs/public-key.pem

# URL Callback (pakai ngrok)
PAYLABS_CALLBACK_URL=https://stem-delicacy-bogus.ngrok-free.dev/webhook/paylabs
PAYLABS_RETURN_URL=https://stem-delicacy-bogus.ngrok-free.dev/customer/payment-paylabs/{order_id}/callback
```

### 4. Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

---

## 🔧 Perubahan Kode

### File yang Diubah:

1. **`app/Services/PaylabsService.php`**
   - Hapus `$apiKey`, ganti dengan `$privateKeyPath` dan `$publicKeyPath`
   - Hapus method `buildSign()` (SHA256 lama)
   - Tambah method `buildSignature()` (RSA SHA256withRSA baru)
   - Tambah method `generateTimestamp()` (format ISO 8601 dengan millisecond)
   - Tambah method `minifyJson()` (hapus whitespace dari JSON)
   - Tambah method `buildHeaders()` (X-TIMESTAMP, X-SIGNATURE, X-PARTNER-ID, X-REQUEST-ID)
   - Update `createTransaction()` untuk pakai endpoint H5 baru
   - Update `checkStatus()` untuk pakai signature RSA

2. **`app/Http/Controllers/Customer/PaylabsPaymentController.php`**
   - Hapus method `simulatePayment()` (tidak perlu lagi)
   - Hapus parameter `$canSimulate` dari view `waiting()`

3. **`routes/web.php`**
   - Hapus route `payment.paylabs.simulate`

4. **`.env`**
   - Update `PAYLABS_BASE_URL` ke `https://sandbox.paylabs.co.id`
   - Hapus `PAYLABS_API_KEY`
   - Set `PAYLABS_MOCK_MODE=false`
   - Set `PAYLABS_VERIFY_SSL=true`

5. **`config/paylabs.php`**
   - Hapus `api_key`
   - Update `base_url` default ke sandbox Paylabs

---

## 🧪 Cara Testing

### 1. Pastikan Ngrok Running

```bash
ngrok http 80
```

Copy URL ngrok (contoh: `https://stem-delicacy-bogus.ngrok-free.dev`) dan update di `.env`:
```env
APP_URL=https://stem-delicacy-bogus.ngrok-free.dev
PAYLABS_CALLBACK_URL=https://stem-delicacy-bogus.ngrok-free.dev/webhook/paylabs
PAYLABS_RETURN_URL=https://stem-delicacy-bogus.ngrok-free.dev/customer/payment-paylabs/{order_id}/callback
```

### 2. Test Flow Lengkap

1. **Login sebagai customer**
   - Buka: `http://localhost/login`
   - Login dengan akun customer

2. **Buat pesanan**
   - Tambah produk ke cart
   - Checkout
   - Pilih ekspedisi
   - Klik "Lanjut ke Pembayaran"

3. **Pilih Paylabs**
   - Di halaman "Pilih Metode Pembayaran"
   - Klik "Paylabs"

4. **Pilih channel pembayaran**
   - Pilih salah satu (contoh: QRIS, Virtual Account, E-Wallet)
   - Klik "Bayar"

5. **Cek log**
   ```bash
   tail -f storage/logs/laravel.log | grep Paylabs
   ```

   Harus muncul:
   ```
   Paylabs createTransaction request
   - url: https://sandbox.paylabs.co.id/payment/v2.3/h5/createLink
   - body: {...}
   - timestamp: 2024-01-15T10:30:45.123+07:00
   
   Paylabs createTransaction response
   - status: 200
   - body: {"errCode":"0","url":"https://..."}
   ```

6. **Redirect ke halaman pembayaran Paylabs**
   - Jika berhasil, akan redirect ke URL pembayaran Paylabs
   - Lakukan pembayaran di halaman Paylabs
   - Setelah bayar, akan redirect kembali ke aplikasi

7. **Webhook callback**
   - Paylabs akan kirim webhook ke `PAYLABS_CALLBACK_URL`
   - Order status akan otomatis update ke "Processing"

---

## 🔍 Troubleshooting

### Error: "Failed to load private key"

**Penyebab:** File private key tidak ditemukan atau format salah

**Solusi:**
```bash
# Cek apakah file ada
ls -la storage/app/paylabs/

# Cek isi file
cat storage/app/paylabs/private-key.pem

# Pastikan format benar (harus ada BEGIN dan END)
-----BEGIN PRIVATE KEY-----
...
-----END PRIVATE KEY-----
```

### Error: "Failed to sign request"

**Penyebab:** Private key tidak valid atau corrupted

**Solusi:**
```bash
# Generate ulang key pair
openssl genrsa -out storage/app/paylabs/private-key.pem 2048
openssl rsa -in storage/app/paylabs/private-key.pem -pubout -out storage/app/paylabs/public-key.pem

# Kirim ulang public key ke Paylabs
```

### Error: "Invalid signature" dari Paylabs

**Penyebab:** Public key belum diaktivasi di Paylabs

**Solusi:**
1. Pastikan sudah kirim public key ke `cs@paylabs.co.id`
2. Tunggu konfirmasi aktivasi dari Paylabs
3. Coba lagi setelah aktivasi

### Error: "errCode": "40001" (Invalid parameter)

**Penyebab:** Format request tidak sesuai

**Solusi:**
1. Cek log request body
2. Pastikan semua field required terisi:
   - `merchantId`
   - `merchantTradeNo`
   - `requestId`
   - `amount` (format: "100.00")
   - `phoneNumber`
   - `productName`
   - `notifyUrl`
   - `redirectUrl`

### Webhook tidak masuk

**Penyebab:** Ngrok URL tidak accessible atau webhook URL salah

**Solusi:**
1. Pastikan ngrok running
2. Test webhook URL:
   ```bash
   curl -X POST https://your-ngrok-url.ngrok-free.dev/webhook/paylabs \
     -H "Content-Type: application/json" \
     -d '{"test": "webhook"}'
   ```
3. Cek log Laravel untuk request masuk
4. Pastikan `PAYLABS_CALLBACK_URL` di `.env` benar

---

## 📊 Monitoring

### Log yang Harus Dimonitor

1. **Request ke Paylabs**
   ```
   Paylabs createTransaction request
   - url: ...
   - body: ...
   - timestamp: ...
   ```

2. **Response dari Paylabs**
   ```
   Paylabs createTransaction response
   - status: 200
   - body: {"errCode":"0",...}
   ```

3. **Webhook dari Paylabs**
   ```
   Paylabs Webhook Received
   - transaction_id: ...
   - status: paid
   - merchant_ref_no: ...
   ```

4. **Order Update**
   ```
   Paylabs Webhook: Payment success
   - order_number: ...
   - transaction_id: ...
   ```

### Database Check

```sql
-- Cek order yang sudah bayar via Paylabs
SELECT 
    order_number,
    payment_gateway,
    payment_channel,
    paylabs_transaction_id,
    payment_status,
    status,
    paid_at
FROM orders
WHERE payment_gateway = 'paylabs'
ORDER BY created_at DESC
LIMIT 10;
```

---

## 🚀 Production Checklist

Sebelum deploy ke production:

- [ ] Public key sudah diaktivasi di Paylabs
- [ ] Test semua payment channel (QRIS, VA, E-Wallet)
- [ ] Test webhook callback
- [ ] Test return URL redirect
- [ ] Monitor log untuk error
- [ ] Update `.env` production:
  ```env
  PAYLABS_SANDBOX=false
  PAYLABS_BASE_URL=https://api.paylabs.co.id
  PAYLABS_CALLBACK_URL=https://yourdomain.com/webhook/paylabs
  PAYLABS_RETURN_URL=https://yourdomain.com/customer/payment-paylabs/{order_id}/callback
  ```
- [ ] Generate key pair baru untuk production
- [ ] Kirim public key production ke Paylabs
- [ ] Test di production environment

---

## 📞 Support

Jika ada masalah:
- Email: cs@paylabs.co.id
- Dokumentasi: https://docs.paylabs.co.id
- WhatsApp: (cek di dashboard Paylabs)

---

## 📝 Catatan Penting

1. **Public Key WAJIB diaktivasi** sebelum bisa hit API
2. **Signature menggunakan RSA**, bukan SHA256 biasa
3. **Endpoint H5** paling mudah (Paylabs handle halaman pembayaran)
4. **Webhook URL** harus accessible dari internet (pakai ngrok untuk local)
5. **Return URL** untuk redirect setelah pembayaran
6. **Mock mode sudah dinonaktifkan** - semua request akan hit API Paylabs sandbox

---

## ✅ Summary Perubahan

| Aspek | Sebelum | Sesudah |
|-------|---------|---------|
| Base URL | `iotpay.club/posp-api` | `sandbox.paylabs.co.id` |
| Signature | SHA256 + API Key | RSA SHA256withRSA |
| Endpoint | `/v1/payment/create` | `/payment/v2.3/h5/createLink` |
| Headers | `Content-Type` only | `X-TIMESTAMP`, `X-SIGNATURE`, `X-PARTNER-ID`, `X-REQUEST-ID` |
| Mock Mode | Enabled | Disabled |
| Simulasi | Ada route simulasi | Dihapus |
| SSL Verify | False | True |

Sekarang sistem sudah siap untuk testing dengan Paylabs sandbox yang sebenarnya! 🎉
