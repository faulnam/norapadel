# 🎨 FITUR VARIAN PRODUK - DOKUMENTASI LENGKAP

## 📋 RINGKASAN
Fitur ini memungkinkan admin menambahkan varian produk (warna, ukuran, dll) dengan gambar, harga, dan stok berbeda untuk setiap varian.

---

## ✅ FITUR YANG SUDAH DIBUAT

### 1️⃣ **ADMIN PANEL**
- ✅ Toggle "Produk ini memiliki Varian" di form create/edit
- ✅ Tambah varian dinamis (nama, stok, tambahan harga, gambar)
- ✅ Upload gambar berbeda untuk setiap varian
- ✅ Stok produk otomatis dihitung dari total stok varian
- ✅ Edit/hapus varian existing

### 2️⃣ **CUSTOMER (Halaman Produk)**
- ✅ Tampil tombol pilihan varian (jika ada varian aktif)
- ✅ Gambar produk berubah smooth saat klik varian
- ✅ Harga update otomatis (harga dasar + tambahan harga varian)
- ✅ Stok update sesuai varian
- ✅ Tombol "Tambah ke Keranjang" disabled sampai varian dipilih
- ✅ Quantity selector disabled sampai varian dipilih
- ✅ Varian stok habis ditandai disabled
- ✅ Pesan error jelas jika belum pilih varian

### 3️⃣ **KERANJANG**
- ✅ Tampil info varian yang dipilih (nama + icon)
- ✅ Gambar varian di keranjang
- ✅ Harga sesuai varian
- ✅ Validasi stok per varian

### 4️⃣ **BACKEND VALIDATION**
- ✅ Validasi wajib pilih varian (hanya jika ada varian aktif)
- ✅ Validasi varian belongs to product
- ✅ Validasi stok per varian
- ✅ Smart logic: produk tanpa varian tetap bisa dibeli langsung

---

## 🚀 CARA PAKAI

### **A. SETUP DATABASE**
```bash
# Jalankan migration
php artisan migrate

# Jika ada error "column already exists", sudah otomatis di-handle
```

### **B. FIX PRODUK EXISTING (Opsional)**
Jika ada produk lama yang `has_variants = true` tapi tidak punya varian:

```bash
# Jalankan SQL di MySQL/phpMyAdmin
# File: fix_products_without_variants.sql
```

Atau manual:
```sql
UPDATE products p
LEFT JOIN product_variants pv ON p.id = pv.product_id AND pv.is_active = 1
SET p.has_variants = 0
WHERE p.has_variants = 1 AND pv.id IS NULL;
```

---

## 📝 CARA TAMBAH PRODUK DENGAN VARIAN

### **1. Login Admin**
```
/admin/products/create
```

### **2. Isi Data Produk**
- Nama produk
- Deskripsi
- **Harga Dasar** (harga sebelum tambahan varian)
- Kategori
- Berat
- Gambar utama produk

### **3. Aktifkan Toggle Varian**
☑️ **"Produk ini memiliki Varian"**

### **4. Tambah Varian**
Klik **"Tambah Varian"**, lalu isi:

| Field | Contoh | Keterangan |
|-------|--------|------------|
| **Nama Varian** | Merah, Biru, XL, M | Wajib diisi |
| **Stok** | 10 | Stok khusus varian ini |
| **Tambahan Harga** | 50000 | Tambahan dari harga dasar (bisa 0) |
| **Gambar** | Upload | Gambar khusus varian (opsional) |

**Contoh:**
- Produk: Raket Padel Pro
- Harga Dasar: Rp 1.500.000
- Varian 1: Merah (+Rp 0) → Harga Final: Rp 1.500.000
- Varian 2: Biru (+Rp 100.000) → Harga Final: Rp 1.600.000
- Varian 3: Gold (+Rp 300.000) → Harga Final: Rp 1.800.000

### **5. Simpan**
Stok produk akan otomatis dihitung dari total stok semua varian.

---

## 🛒 FLOW CUSTOMER

### **Produk TANPA Varian**
```
1. Buka produk
2. Pilih quantity
3. Klik "Tambah ke Keranjang" ✅ (langsung bisa)
```

### **Produk DENGAN Varian**
```
1. Buka produk
2. ❌ Tombol "Tambah ke Keranjang" DISABLED
3. ❌ Quantity selector DISABLED
4. ⚠️ Pesan: "Wajib pilih varian terlebih dahulu"
5. Klik salah satu varian (misal: Merah)
   → Gambar berubah (fade effect)
   → Harga update
   → Stok update
6. ✅ Tombol "Tambah ke Keranjang" ENABLED
7. ✅ Quantity selector ENABLED
8. Pilih quantity
9. Klik "Tambah ke Keranjang" ✅
```

---

## 🔧 TROUBLESHOOTING

### ❌ **Error: "Silakan pilih varian produk terlebih dahulu"**
**Penyebab:** Produk `has_variants = true` tapi tidak ada varian aktif.

**Solusi:**
```sql
-- Jalankan SQL ini
UPDATE products p
LEFT JOIN product_variants pv ON p.id = pv.product_id AND pv.is_active = 1
SET p.has_variants = 0
WHERE p.has_variants = 1 AND pv.id IS NULL;
```

### ❌ **Varian tidak muncul di halaman produk**
**Cek:**
1. Apakah varian `is_active = 1`?
2. Apakah varian punya stok > 0?
3. Refresh cache: `php artisan cache:clear`

### ❌ **Gambar varian tidak berubah**
**Cek:**
1. Apakah varian punya gambar?
2. Jika tidak, akan fallback ke gambar produk utama
3. Cek console browser (F12) untuk error JS

---

## 📊 STRUKTUR DATABASE

### **Table: products**
```sql
has_variants BOOLEAN DEFAULT 0  -- Toggle varian
```

### **Table: product_variants**
```sql
id                  BIGINT
product_id          BIGINT (FK)
name                VARCHAR(255)      -- Nama varian
image               VARCHAR(255)      -- Gambar varian
stock               INT               -- Stok varian
price_adjustment    DECIMAL(12,2)     -- Tambahan harga
is_active           BOOLEAN
sort_order          INT
```

### **Table: carts**
```sql
product_variant_id  BIGINT (FK, nullable)  -- ID varian yang dipilih
```

---

## 🎯 LOGIC PENTING

### **Kapan Varian WAJIB Dipilih?**
```php
$hasActiveVariants = $product->has_variants 
    && $product->activeVariants()->exists();

if ($hasActiveVariants && !$request->variant_id) {
    return error('Pilih varian dulu!');
}
```

### **Harga Final Varian**
```php
$finalPrice = $product->price + $variant->price_adjustment;

// Jika ada diskon produk:
$basePrice = $product->hasActiveDiscount() 
    ? $product->discounted_price 
    : $product->price;
    
$finalPrice = $basePrice + $variant->price_adjustment;
```

---

## 📁 FILE YANG DIUBAH

### **Migration**
- `2026_05_01_000001_create_product_variants_table.php`
- `2026_05_01_000002_add_variant_to_carts_table.php`
- `2026_05_01_000003_fix_product_variants_columns.php`

### **Model**
- `app/Models/ProductVariant.php` (baru)
- `app/Models/Product.php` (update)
- `app/Models/Cart.php` (update)

### **Controller**
- `app/Http/Controllers/Admin/ProductController.php`
- `app/Http/Controllers/Customer/CartController.php`
- `app/Http/Controllers/PageController.php`

### **View**
- `resources/views/admin/products/create.blade.php`
- `resources/views/admin/products/edit.blade.php`
- `resources/views/pages/produk/show.blade.php`
- `resources/views/customer/cart/index.blade.php`

---

## 🎨 UI/UX HIGHLIGHTS

1. **Smooth Image Transition** - Fade effect saat ganti varian
2. **Clear Validation** - Pesan error merah jelas
3. **Disabled State** - Tombol disabled sampai varian dipilih
4. **Visual Feedback** - Varian aktif highlight biru
5. **Stock Info** - Tampil stok per varian
6. **Mobile Responsive** - Tombol varian wrap otomatis

---

## 🚨 CATATAN PENTING

1. **Jangan hapus varian yang sudah ada di cart/order** - akan error
2. **Gambar varian opsional** - jika kosong, pakai gambar produk utama
3. **Stok produk auto-calculated** - jangan edit manual jika ada varian
4. **Varian bisa punya harga lebih murah** - gunakan nilai negatif di `price_adjustment`

---

## 📞 SUPPORT

Jika ada bug atau pertanyaan, cek:
1. `storage/logs/laravel.log`
2. Browser console (F12)
3. Database: cek `has_variants` vs jumlah varian aktif

---

**✅ FITUR SUDAH SIAP PAKAI!**

Tinggal:
1. `php artisan migrate`
2. Login admin → tambah produk dengan varian
3. Test di customer side

**Happy coding! 🚀**
