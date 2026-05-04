# Setup Paylabs di Server Production

## Masalah
Error: **"Konfigurasi Paylabs belum lengkap"**

## Penyebab
File private key dan public key tidak ditemukan di server karena path yang salah atau file tidak ada.

## Solusi

### 1. Upload File Key ke Server
Upload 2 file key ke server di path:
```
/path/to/project/storage/app/paylabs/private-key.pem
/path/to/project/storage/app/paylabs/public-key.pem
```

### 2. Set Permission File
```bash
chmod 600 storage/app/paylabs/private-key.pem
chmod 644 storage/app/paylabs/public-key.pem
```

### 3. Update .env di Server
Hapus atau comment baris ini di `.env` server (karena sudah ada default):
```env
# PAYLABS_PRIVATE_KEY_PATH=/custom/path/private-key.pem
# PAYLABS_PUBLIC_KEY_PATH=/custom/path/public-key.pem
```

Atau jika ingin custom path, gunakan absolute path server:
```env
PAYLABS_PRIVATE_KEY_PATH=/var/www/html/storage/app/paylabs/private-key.pem
PAYLABS_PUBLIC_KEY_PATH=/var/www/html/storage/app/paylabs/public-key.pem
```

### 4. Update Konfigurasi Production
Pastikan `.env` di server memiliki:
```env
PAYLABS_MERCHANT_ID=011367
PAYLABS_BASE_URL=https://pay.paylabs.co.id
PAYLABS_MOCK_MODE=false
PAYLABS_SANDBOX=false
```

### 5. Clear Config Cache
```bash
php artisan config:clear
php artisan config:cache
```

## Verifikasi
Cek apakah file key ada:
```bash
ls -la storage/app/paylabs/
```

Output yang benar:
```
-rw------- 1 www-data www-data 1675 private-key.pem
-rw-r--r-- 1 www-data www-data  451 public-key.pem
```

## Default Path
Jika tidak set `PAYLABS_PRIVATE_KEY_PATH` dan `PAYLABS_PUBLIC_KEY_PATH` di `.env`, sistem akan otomatis menggunakan:
- `storage/app/paylabs/private-key.pem`
- `storage/app/paylabs/public-key.pem`
