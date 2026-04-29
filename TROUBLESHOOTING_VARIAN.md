# 🔍 TROUBLESHOOTING: VARIAN TIDAK MUNCUL

## ❌ MASALAH
Tombol varian tidak muncul di halaman produk customer.

---

## ✅ CHECKLIST DEBUGGING

### **1. CEK DATABASE**

#### **A. Cek apakah produk punya varian:**
```sql
SELECT 
    p.id,
    p.name,
    p.has_variants,
    COUNT(pv.id) as total_variants,
    COUNT(CASE WHEN pv.is_active = 1 THEN 1 END) as active_variants
FROM products p
LEFT JOIN product_variants pv ON p.id = pv.product_id
WHERE p.id = [PRODUCT_ID]
GROUP BY p.id, p.name, p.has_variants;
```

**Expected Result:**
- `has_variants` = 1
- `total_variants` > 0
- `active_variants` > 0

---

#### **B. Cek detail varian:**
```sql
SELECT 
    id,
    product_id,
    name,
    image,
    stock,
    price_adjustment,
    is_active,
    sort_order
FROM product_variants
WHERE product_id = [PRODUCT_ID]
ORDER BY sort_order;
```

**Expected Result:**
- Ada minimal 1 row
- `is_active` = 1
- `stock` >= 0 (boleh 0, tapi tetap tampil)

---

### **2. CEK BLADE CONDITION**

Buka file: `resources/views/pages/produk/show.blade.php`

Cari baris:
```blade
@if($product->has_variants && $product->activeVariants->count() > 0)
```

**Debug:**
```blade
{{-- Tambahkan ini untuk debug --}}
<div class="alert alert-info">
    <strong>Debug Info:</strong><br>
    has_variants: {{ $product->has_variants ? 'true' : 'false' }}<br>
    activeVariants count: {{ $product->activeVariants->count() }}<br>
    @if($product->activeVariants->count() > 0)
        Varian:
        <ul>
            @foreach($product->activeVariants as $v)
                <li>{{ $v->name }} (Stock: {{ $v->stock }}, Active: {{ $v->is_active }})</li>
            @endforeach
        </ul>
    @endif
</div>
```

---

### **3. CEK CONTROLLER**

Buka file: `app/Http/Controllers/PageController.php`

Method: `produkShow()`

**Pastikan ada:**
```php
$product->load('activeVariants');
```

**Jika tidak ada, tambahkan:**
```php
public function produkShow(Product $product)
{
    if (!$product->is_active) {
        abort(404);
    }

    // PENTING: Load varian aktif
    $product->load('activeVariants');

    $relatedProducts = Product::active()
        ->where('is_featured', false)
        ->where('id', '!=', $product->id)
        ->where('category', $product->category)
        ->take(4)
        ->get();

    return view('pages.produk.show', compact('product', 'relatedProducts'));
}
```

---

### **4. CEK MODEL RELATION**

Buka file: `app/Models/Product.php`

**Pastikan ada method:**
```php
public function activeVariants()
{
    return $this->hasMany(ProductVariant::class)
        ->where('is_active', true)
        ->orderBy('sort_order');
}
```

---

### **5. FIX PRODUK TANPA VARIAN AKTIF**

Jika produk `has_variants = 1` tapi tidak ada varian aktif:

```sql
-- Set has_variants = 0 untuk produk tanpa varian aktif
UPDATE products p
LEFT JOIN product_variants pv ON p.id = pv.product_id AND pv.is_active = 1
SET p.has_variants = 0
WHERE p.has_variants = 1 
AND pv.id IS NULL;
```

---

## 🎯 CARA TEST MANUAL

### **Step 1: Buat Produk dengan Varian**

1. Login admin
2. Products → Create
3. Isi data produk
4. ☑️ Centang "Produk ini memiliki Varian"
5. Klik "Tambah Varian"
6. Isi:
   - Nama: Merah
   - Stok: 10
   - Tambahan Harga: 0
   - Upload gambar (PENTING!)
7. Klik "Tambah Varian" lagi
8. Isi:
   - Nama: Biru
   - Stok: 5
   - Tambahan Harga: 50000
   - Upload gambar (PENTING!)
9. Simpan

---

### **Step 2: Cek di Customer**

1. Buka halaman produk
2. Scroll ke bawah setelah deskripsi
3. **Harus muncul:**
   - Box abu-abu dengan judul "Pilih Varian *"
   - Grid 2-6 kolom (tergantung screen size)
   - Setiap varian punya:
     - Gambar thumbnail (kotak)
     - Nama varian di bawah gambar
     - Badge stok (jika < 5 atau habis)
     - Badge harga (jika ada adjustment)

---

## 🐛 COMMON ISSUES

### **Issue 1: Varian tidak muncul sama sekali**

**Penyebab:**
- `has_variants` = 0
- Tidak ada varian aktif
- Controller tidak load `activeVariants`

**Solusi:**
```sql
-- Cek produk
SELECT id, name, has_variants FROM products WHERE id = [ID];

-- Cek varian
SELECT * FROM product_variants WHERE product_id = [ID];

-- Fix has_variants
UPDATE products SET has_variants = 1 WHERE id = [ID];
```

---

### **Issue 2: Varian muncul tapi gambar tidak ada**

**Penyebab:**
- Varian tidak punya gambar
- Path gambar salah

**Solusi:**
- Upload gambar untuk setiap varian
- Atau akan fallback ke gambar produk utama

---

### **Issue 3: Klik varian tidak ganti gambar**

**Penyebab:**
- JavaScript error
- `mainProductImage` ID tidak ada

**Solusi:**
- Buka Console (F12)
- Cek error JavaScript
- Pastikan ada element dengan ID `mainProductImage`

---

## 📝 QUERY HELPER

### **Lihat semua produk dengan varian:**
```sql
SELECT 
    p.id,
    p.name,
    p.has_variants,
    COUNT(pv.id) as total_variants
FROM products p
LEFT JOIN product_variants pv ON p.id = pv.product_id
GROUP BY p.id, p.name, p.has_variants
HAVING p.has_variants = 1;
```

### **Lihat varian per produk:**
```sql
SELECT 
    p.name as product_name,
    pv.name as variant_name,
    pv.stock,
    pv.is_active,
    pv.image
FROM products p
JOIN product_variants pv ON p.id = pv.product_id
WHERE p.id = [PRODUCT_ID]
ORDER BY pv.sort_order;
```

---

## ✅ EXPECTED OUTPUT

Jika berhasil, di halaman produk akan muncul:

```
┌─────────────────────────────────────┐
│ Pilih Varian *          ✓ Dipilih  │
├─────────────────────────────────────┤
│  ┌───┐  ┌───┐  ┌───┐  ┌───┐       │
│  │img│  │img│  │img│  │img│       │
│  └───┘  └───┘  └───┘  └───┘       │
│  Merah  Biru   Hijau  Kuning      │
│   10    Habis   5     +50k        │
└─────────────────────────────────────┘
⚠️ Pilih varian terlebih dahulu
```

Setelah klik varian:
```
✅ Varian dipilih: Merah
```

---

**Jika masih tidak muncul, jalankan:**
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

Lalu refresh browser (Ctrl+F5).
