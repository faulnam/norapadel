# Welcome Bonus Feature - NoraPadel

## Fitur yang Dibuat

### 1. **Welcome Bonus Popup**
- Popup muncul otomatis saat user membuka website
- Menampilkan 2 benefit:
  - **100 Points** (senilai Rp 10.000)
  - **Free Grip** untuk pembelian pertama
- Tombol "Join Now" untuk guest user (redirect ke register)
- Tombol "Claim My Rewards" untuk user yang sudah login tapi belum claim
- Tombol X untuk menutup popup

### 2. **Points System**
- User baru otomatis mendapat 100 points saat registrasi
- 1 point = Rp 100
- Points bisa digunakan saat checkout
- Points akan dikurangi otomatis setelah order dibuat

### 3. **Free Grip untuk Pembelian Pertama**
- User yang melakukan pembelian pertama otomatis mendapat free grip
- Grip ditambahkan ke order items dengan harga Rp 0
- Setelah pembelian pertama, flag `first_purchase_completed` di-set true

## File yang Dibuat/Dimodifikasi

### Migration Files:
1. `database/migrations/2025_01_15_000001_add_points_and_first_purchase_to_users_table.php`
   - Menambah kolom: `points`, `first_purchase_completed`, `welcome_bonus_claimed`

2. `database/migrations/2025_01_15_000002_add_points_to_orders_table.php`
   - Menambah kolom: `points_used`, `points_discount`

### Model Updates:
1. `app/Models/User.php`
   - Menambah fillable: `points`, `first_purchase_completed`, `welcome_bonus_claimed`
   - Menambah casts untuk boolean fields

### Controllers:
1. `app/Http/Controllers/Customer/WelcomeBonusController.php` (NEW)
   - Handle claim welcome bonus

2. `app/Http/Controllers/Auth/AuthController.php`
   - Modified: Auto-assign 100 points saat registrasi

3. `app/Http/Controllers/Customer/OrderController.php`
   - Modified: Handle points usage di checkout
   - Modified: Auto-add free grip untuk first purchase

### Views:
1. `resources/views/components/welcome-bonus-popup.blade.php` (NEW)
   - Popup component dengan Alpine.js

2. `resources/views/layouts/app.blade.php`
   - Added: Alpine.js CDN
   - Added: Welcome bonus popup component

### Routes:
1. `routes/web.php`
   - Added: Route untuk claim welcome bonus

## Cara Menggunakan

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Buat Produk Grip
Buat produk dengan nama yang mengandung kata "grip" atau "Grip" di database.
Produk ini akan otomatis ditambahkan sebagai free item di pembelian pertama.

### 3. Testing Flow

#### A. User Baru (Guest):
1. Buka website → Popup muncul
2. Klik "Join Now" → Redirect ke register
3. Selesaikan registrasi → Auto dapat 100 points
4. Login → Popup muncul lagi dengan tombol "Claim My Rewards"
5. Klik "Claim" → Bonus claimed, popup tidak muncul lagi

#### B. User yang Sudah Login:
1. Buka website → Popup muncul jika belum claim
2. Klik "Claim My Rewards" → Bonus claimed
3. Popup tidak muncul lagi di visit berikutnya

#### C. Menggunakan Points di Checkout:
1. Tambah produk ke cart
2. Proceed to checkout
3. Di halaman checkout, ada opsi "Use Points"
4. Centang checkbox dan masukkan jumlah points
5. Total akan berkurang sesuai points yang digunakan
6. Setelah order dibuat, points user akan dikurangi

#### D. Free Grip di Pembelian Pertama:
1. User melakukan checkout pertama kali
2. Sistem otomatis menambahkan grip product dengan harga Rp 0
3. Grip muncul di order items
4. Flag `first_purchase_completed` di-set true
5. Pembelian berikutnya tidak dapat free grip lagi

## Konfigurasi

### Points Value
Untuk mengubah nilai points, edit di:
- `OrderController.php` line: `$pointsDiscount = $pointsUsed * 100;`
- Ubah 100 menjadi nilai yang diinginkan (1 point = Rp X)

### Welcome Points Amount
Untuk mengubah jumlah points welcome bonus, edit di:
- `AuthController.php` line: `'points' => 100,`
- Ubah 100 menjadi jumlah yang diinginkan

### Popup Display Logic
Popup akan muncul jika:
- User belum login ATAU
- User sudah login tapi `welcome_bonus_claimed` = false

Edit di `welcome-bonus-popup.blade.php`:
```php
x-data="{ show: @js(!auth()->check() || (auth()->check() && auth()->user()->role === 'customer' && !auth()->user()->welcome_bonus_claimed)) }"
```

## Database Schema

### users table:
```sql
points INT DEFAULT 0
first_purchase_completed BOOLEAN DEFAULT FALSE
welcome_bonus_claimed BOOLEAN DEFAULT FALSE
```

### orders table:
```sql
points_used INT DEFAULT 0
points_discount DECIMAL(10,2) DEFAULT 0
```

## Notes

1. **Grip Product**: Pastikan ada produk dengan nama mengandung "grip" di database
2. **Alpine.js**: Sudah ditambahkan via CDN di layout
3. **Popup Behavior**: Menggunakan Alpine.js untuk show/hide
4. **Points Calculation**: 1 point = Rp 100 (bisa diubah)
5. **Free Grip**: Hanya untuk pembelian pertama per user
6. **Guest Users**: Tidak bisa claim bonus, harus register dulu

## Troubleshooting

### Popup tidak muncul:
- Cek apakah Alpine.js sudah loaded
- Cek console browser untuk error
- Pastikan user belum claim bonus

### Points tidak berkurang:
- Cek apakah `points_used` tersimpan di order
- Cek apakah user decrement points di OrderController

### Free Grip tidak muncul:
- Pastikan ada produk dengan nama mengandung "grip"
- Cek apakah `first_purchase_completed` = false
- Cek order items di database

## Future Improvements

1. Admin panel untuk manage points value
2. Points history/transaction log
3. Multiple grip options untuk dipilih user
4. Points expiry date
5. Referral bonus points
6. Points untuk review/testimonial
