# Dev Onboarding — NoraPadel

## Stack
- Laravel 11, MySQL, Tailwind CSS, Vite
- Queue & Cache: database driver
- Auth: session-based (bukan token/JWT)

---

## Setup Lokal

```bash
git clone <repo>
cd norapadell
composer install
npm install && npm run build
cp .env.example .env
# isi .env dengan nilai di bawah, lalu:
php artisan migrate
php artisan storage:link
php artisan queue:work
```

---

## .env — Langsung Pakai Ini

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:b/veZ1zE0PhjzDuoV5EA8M6vd/Hssz1GhQ8dC5cHx5w=
APP_DEBUG=true
APP_URL=https://stem-delicacy-bogus.ngrok-free.dev
TRUSTED_PROXIES=*

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=norapadell
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=smtp
MAIL_SCHEME=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=syifakul.anm@gmail.com
MAIL_PASSWORD=mvklabnnpgjdggho
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="syifakul.anm@gmail.com"
CONTACT_RECEIVER_EMAIL="syifakul.anm@gmail.com"
CONTACT_RECEIVER_NAME="Nora Padel Support"

VAPID_PUBLIC_KEY=BG329_UvTVkqcaT7EsgBb1rx_qo8eDXounJbhQAFwVrHv_gm0whGjB0yk3-8XVFPxRp7OM0-58bG50W2t8ktmVA
VAPID_PRIVATE_KEY=fkW8iheiEEtPiyjTocWlaWM1eqqgSPxzZuVdfkaIWB8
VAPID_SUBJECT="mailto:admin@norapadel.id"

BRAND_NAME="Nora Padel"
BRAND_TAGLINE="Performa Maksimal, Game Makin Total"
BRAND_EMAIL="hello@norapadel.id"
BRAND_PHONE="+62 812 7788 9900"
BRAND_ADDRESS="Jl. Padel Arena No. 21, Surabaya"
BRAND_INSTAGRAM="@norapadel.id"
BRAND_WHATSAPP="6281277889900"
STORE_LATITUDE=-7.278417
STORE_LONGITUDE=112.632583

# Biteship (LIVE)
BITESHIP_API_KEY=biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoibm9yYXBhZGVsIiwidXNlcklkIjoiNjllMDU0NDk1ZjQ2MWQ3MTBlOTI4ZmU5IiwiaWF0IjoxNzc3MjU5ODUxfQ.lBJd9Jsd7S4CfUt8iPX-pZyoQezAq5IzlmDy4zupHPw
BITESHIP_SANDBOX=false
BITESHIP_USE_MOCK=false
BITESHIP_ORIGIN_LAT=-7.278417
BITESHIP_ORIGIN_LNG=112.632583
BITESHIP_ORIGIN_POSTAL_CODE=61219
BITESHIP_BASE_URL=https://api.biteship.com/v1

# Paylabs (Sandbox)
PAYLABS_ENV=sandbox
PAYLABS_MERCHANT_ID=011367
PAYLABS_API_KEY=
PAYLABS_SANDBOX=true
PAYLABS_MOCK_MODE=false
PAYLABS_BASE_URL=https://pay.paylabs.co.id
PAYLABS_TIMEOUT=30
PAYLABS_CONNECT_TIMEOUT=10
PAYLABS_VERIFY_SSL=false
PAYLABS_PRIVATE_KEY_PATH=D:/laragonzo/www/norapadell/storage/app/paylabs/private-key.pem
PAYLABS_PUBLIC_KEY_PATH=D:/laragonzo/www/norapadell/storage/app/paylabs/public-key.pem
PAYLABS_CALLBACK_URL=https://placeholder.example.com/webhook/paylabs
PAYLABS_RETURN_URL=http://localhost/customer/payment-paylabs/{order_id}/callback
PAYLABS_VERIFY_SIGNATURE=false
PAYLABS_SIGNATURE_HEADER=
PAYLABS_WEBHOOK_SECRET=
```

> ⚠️ Untuk `PAYLABS_PRIVATE_KEY_PATH` & `PAYLABS_PUBLIC_KEY_PATH` — sesuaikan path ke folder project kamu masing-masing. File `.pem`-nya minta ke owner.

> ⚠️ Kalau test webhook Paylabs/Biteship, jalankan ngrok dan update `APP_URL` + `PAYLABS_CALLBACK_URL` dengan URL ngrok kamu.

---

## Roles & Akses

| Role | Login Redirect | Middleware |
|------|---------------|------------|
| `admin` | `/admin/dashboard` | `auth`, `admin` |
| `courier` | `/courier/dashboard` | `auth`, `courier` |
| `customer` | `/` | `auth`, `customer` |

Buat akun admin lewat DB:
```sql
UPDATE users SET role = 'admin' WHERE email = '<email>';
```

---

## Auth Flow

**Login:** `POST /login` → email + password → redirect by role

**Register:**
1. `POST /register/request-otp` → kirim OTP 6 digit ke email
2. `POST /register/verify-otp` → verifikasi OTP → akun aktif

---

## Integrasi

| Service | Fungsi | Webhook |
|---------|--------|---------|
| **Paylabs** | Payment QRIS & VA | `POST /webhook/paylabs` |
| **Pakasir** | Payment alternatif | `POST /webhook/pakasir` |
| **Biteship** | Ongkir, pickup, tracking | `POST /webhook/biteship` |
| **Gmail SMTP** | OTP, notif order, contact | — |
| **Web Push VAPID** | Push notif browser | — |

---

## Yang Perlu Diminta ke Owner

- [ ] File `private-key.pem` & `public-key.pem` Paylabs → taruh di `storage/app/paylabs/`
- [ ] `PAYLABS_API_KEY` (kalau dibutuhkan untuk sandbox)
