# 🎨 UI VARIAN PRODUK - TAILWIND CSS

## ✨ FITUR BARU

### **Modern Variant Selector**
- ✅ Card-based design (bukan dropdown)
- ✅ Grid responsive (2-4 kolom)
- ✅ Hover effect smooth
- ✅ Active state dengan checkmark icon
- ✅ Stock badge (Habis / Sisa X)
- ✅ Price adjustment badge (+/- harga)
- ✅ Disabled state untuk stok habis

---

## 🎯 KOMPONEN UI

### **1. Variant Card**
```html
<button class="variant-card">
  <!-- Checkmark (hidden by default) -->
  <div class="variant-check">✓</div>
  
  <!-- Variant Name -->
  <span>Merah</span>
  
  <!-- Stock Badge -->
  <span class="text-red-500">Habis</span>
  
  <!-- Price Badge -->
  <span class="text-blue-600">+Rp 50.000</span>
</button>
```

**States:**
- **Default:** Border gray, background white
- **Hover:** Border darker, shadow
- **Active:** Border black, background gray-50, checkmark visible
- **Disabled:** Opacity 50%, cursor not-allowed

---

### **2. Quantity Selector**
```html
<div class="flex items-center border-2 rounded-lg">
  <button>−</button>
  <input type="number" value="1">
  <button>+</button>
</div>
```

**Features:**
- Disabled sampai varian dipilih
- Max sesuai stok varian
- Readonly input (hanya bisa via button)

---

### **3. Add to Cart Button**
```html
<button class="w-full py-3 bg-black text-white">
  <svg>🛒</svg>
  <span>Tambah ke Keranjang</span>
</button>
```

**States:**
- **Disabled:** Gray background, cursor not-allowed
- **Enabled:** Black background, hover darker

---

## 🔄 FLOW INTERAKSI

### **Produk DENGAN Varian:**
```
1. User buka produk
   ↓
2. Tampil grid varian (2-4 kolom)
   ↓
3. Tombol "Tambah ke Keranjang" DISABLED
   ↓
4. User klik varian (misal: Merah)
   → Border jadi hitam
   → Checkmark muncul
   → Gambar produk berubah (fade)
   → Harga update
   → Stok update
   ↓
5. Quantity selector ENABLED
   ↓
6. Tombol "Tambah ke Keranjang" ENABLED
   ↓
7. User klik tombol → Produk masuk cart ✅
```

### **Produk TANPA Varian:**
```
1. User buka produk
   ↓
2. Section varian TIDAK tampil
   ↓
3. Quantity selector langsung ENABLED
   ↓
4. Tombol "Tambah ke Keranjang" langsung ENABLED
   ↓
5. User klik tombol → Produk masuk cart ✅
```

---

## 🎨 DESIGN SYSTEM

### **Colors:**
- **Primary:** Black (#000000)
- **Border Default:** Gray-200
- **Border Active:** Black
- **Background Active:** Gray-50
- **Success:** Green-500/600
- **Error:** Red-500/600
- **Warning:** Orange-500

### **Spacing:**
- **Gap between cards:** 0.5rem (gap-2)
- **Card padding:** 0.75rem (p-3)
- **Button padding:** py-3 px-6

### **Typography:**
- **Variant name:** text-sm font-medium
- **Stock badge:** text-[10px]
- **Price badge:** text-[10px]
- **Button:** font-semibold

---

## 📱 RESPONSIVE

### **Mobile (< 640px):**
- Grid 2 kolom
- Variant card lebih kecil
- Stack quantity + button

### **Tablet (640px - 768px):**
- Grid 3 kolom
- Spacing lebih lega

### **Desktop (> 768px):**
- Grid 4 kolom
- Full features

---

## 🚀 JAVASCRIPT FUNCTIONS

### **selectVariant(btn)**
```js
// 1. Remove active dari semua card
// 2. Add active ke card yang diklik
// 3. Update gambar produk (fade effect)
// 4. Update harga
// 5. Update stok badge
// 6. Enable quantity selector
// 7. Enable add to cart button
// 8. Update hint message
```

### **decreaseQty() / increaseQty()**
```js
// Kurangi/tambah quantity
// Respect min (1) dan max (stok)
```

---

## ✅ CHECKLIST TESTING

- [ ] Klik varian → border jadi hitam
- [ ] Klik varian → checkmark muncul
- [ ] Klik varian → gambar berubah smooth
- [ ] Klik varian → harga update
- [ ] Klik varian → stok update
- [ ] Klik varian → quantity enabled
- [ ] Klik varian → button enabled
- [ ] Klik varian stok habis → button tetap disabled
- [ ] Produk tanpa varian → langsung bisa beli
- [ ] Mobile responsive → grid 2 kolom
- [ ] Tablet responsive → grid 3 kolom
- [ ] Desktop responsive → grid 4 kolom

---

## 🎯 KEUNGGULAN UI BARU

1. **Modern & Clean** - Card-based, bukan dropdown
2. **Visual Feedback** - Checkmark, border, background
3. **Informative** - Stock badge, price badge
4. **Accessible** - Disabled state jelas
5. **Responsive** - Mobile-first design
6. **Smooth** - Fade effect, transitions
7. **Intuitive** - User langsung paham cara pakai

---

## 📦 DEPENDENCIES

- **Tailwind CSS** - Via CDN (sudah include)
- **Heroicons** - SVG icons inline
- **Vanilla JS** - No jQuery needed

---

**✅ UI SUDAH SIAP PAKAI!**

Refresh halaman produk dan lihat hasilnya 🚀
