# Fitur Testimonial dengan Gambar

## Fitur yang Ditambahkan:

### 1. Tombol Tambah Testimonial (Admin)
- Lokasi: `/admin/testimonials`
- Tombol "Tambah Testimonial" di pojok kanan atas halaman

### 2. Form Upload Testimonial
- **Hanya upload gambar** (JPG, PNG, WEBP, max 2MB)
- Preview gambar sebelum upload
- Rating dan content otomatis diset (rating: 5, content: kosong)

### 3. Galeri Bergerak di Halaman Utama
- Card besar: Gambar galeri utama (dari admin galeri)
- Card kecil bergerak: Gabungan gambar galeri + gambar testimonial
- Gambar testimonial:
  - **Tidak ada badge**
  - **Tidak ada nama user**
  - **Tidak bisa diklik** (tidak redirect kemana-mana)
  - Hanya tampil sebagai gambar saja
- Auto-scroll horizontal otomatis
- Pause saat hover

## File yang Dimodifikasi:

1. **Controller**: `app/Http/Controllers/Admin/TestimonialController.php`
   - Menambahkan method `create()` dan `store()`
   - Store hanya validasi gambar

2. **Routes**: `routes/web.php`
   - Menambahkan route untuk create dan store testimonial

3. **Views**:
   - `resources/views/admin/testimonials/index.blade.php` - Tombol tambah
   - `resources/views/admin/testimonials/create.blade.php` - Form upload (BARU)
   - `resources/views/pages/home_luxury.blade.php` - Galeri bergerak

4. **Model**: `app/Models/Testimonial.php`
   - Update relasi order dengan withDefault()

5. **Migration**: `database/migrations/2026_04_15_122509_make_order_id_nullable_in_testimonials_table.php` (BARU)
   - Membuat order_id dan content nullable

## Cara Menggunakan:

1. Jalankan migration:
   ```bash
   php artisan migrate
   ```

2. Login sebagai Admin

3. Buka menu "Testimoni" di sidebar admin

4. Klik tombol "Tambah Testimoni"

5. Upload gambar saja (tidak perlu isi rating atau keterangan)

6. Klik "Simpan Testimoni"

7. Gambar akan muncul di card kecil bergerak di halaman utama (tanpa badge, tanpa nama, tidak bisa diklik)

## Catatan:
- Testimonial yang ditambahkan admin tidak terkait dengan order tertentu
- Gambar disimpan di `storage/app/public/testimonials/`
- Gambar testimonial di halaman utama hanya tampil sebagai gambar polos tanpa interaksi
- Gambar galeri tetap bisa diklik dan ada judul, gambar testimonial tidak
