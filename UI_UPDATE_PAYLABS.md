# UI Update - Paylabs Payment Gateway

## Overview
Update UI halaman payment Paylabs agar konsisten dengan halaman utama (Apple-like minimalis).

## Changes Made

### 1. Order Detail Page (`customer/orders/show.blade.php`)
- ✅ Navbar Apple-like dengan Tailwind CSS
- ✅ Footer minimalis
- ✅ Card design dengan rounded-2xl dan shadow-sm
- ✅ Warna hitam (#000) untuk primary color
- ✅ Typography konsisten dengan halaman utama
- ✅ Responsive design

### 2. Select Gateway Page (`customer/payment/select-gateway.blade.php`)
- ✅ Navbar dan footer sama dengan halaman utama
- ✅ Card payment gateway dengan hover effect
- ✅ Icon design minimalis
- ✅ Badge "Recommended" dengan warna hitam
- ✅ Spacing dan padding konsisten

### 3. Paylabs Payment Page (`customer/payment/paylabs.blade.php`)
- ✅ UI Apple-like dengan Tailwind CSS
- ✅ Radio button custom dengan border hitam saat selected
- ✅ Section terpisah untuk VA, QRIS, E-Wallet, Retail
- ✅ Hover effect smooth
- ✅ Button hitam untuk primary action

### 4. Waiting Page (`customer/payment/paylabs-waiting.blade.php`)
- ✅ Design minimalis dengan icon clock
- ✅ QR Code display dengan border dan padding
- ✅ Copy button untuk VA number dan payment code
- ✅ Instruksi pembayaran yang jelas
- ✅ Auto check status setiap 5 detik
- ✅ Countdown timer untuk expiry
- ✅ Tombol simulasi untuk sandbox mode

### 5. Fix QR Code Issue
**Problem**: QR code tidak muncul saat pilih QRIS

**Solution**: 
- Update `PaylabsService.php` mock data
- Gunakan `urlencode()` untuk QR code URL
- Set size 300x300 untuk QR code yang lebih jelas

```php
$mockData['qr_url'] = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode('PAYLABS-MOCK-' . $transactionId);
```

## Color Scheme

### Before (Hijau/Biru)
- Primary: `#16a34a` (Green)
- Secondary: `#0071e3` (Blue)
- Success: `#10b981` (Emerald)

### After (Hitam/Minimalis)
- Primary: `#000000` (Black)
- Secondary: `#71717a` (Zinc)
- Accent: `#f59e0b` (Amber untuk warning)
- Success: `#10b981` (Emerald tetap untuk success state)

## Components

### Navbar
```html
<header class="sticky top-0 z-50 border-b border-black/6 bg-white/80 backdrop-blur-xl">
    <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
        <a href="/" class="text-xl font-semibold tracking-tight text-black">NoraPadel</a>
        <!-- Navigation links -->
    </div>
</header>
```

### Card
```html
<div class="rounded-2xl bg-white p-6 shadow-sm">
    <!-- Content -->
</div>
```

### Button Primary
```html
<button class="rounded-xl bg-black py-3 px-6 text-sm font-medium text-white hover:bg-black/90">
    Button Text
</button>
```

### Button Secondary
```html
<button class="rounded-xl border border-zinc-300 bg-white py-3 px-6 text-sm font-medium text-black hover:bg-zinc-50">
    Button Text
</button>
```

## Testing Checklist

### Visual Testing
- [x] Navbar konsisten di semua halaman
- [x] Footer konsisten di semua halaman
- [x] Warna hitam untuk primary elements
- [x] Spacing dan padding konsisten
- [x] Typography konsisten
- [x] Hover effects smooth

### Functional Testing
- [x] Select gateway redirect ke Paylabs
- [x] Pilih metode pembayaran (VA/QRIS/E-Wallet/Retail)
- [x] QR Code muncul untuk QRIS
- [x] Copy button berfungsi untuk VA dan Retail
- [x] Auto check status berjalan
- [x] Simulasi pembayaran berhasil (sandbox)
- [x] Redirect ke order detail setelah paid

### Responsive Testing
- [x] Mobile (< 640px)
- [x] Tablet (640px - 1024px)
- [x] Desktop (> 1024px)

## Sandbox Mode

### Enable Sandbox
```env
PAYLABS_SANDBOX=true
PAYLABS_API_KEY=sandbox_dummy_key
```

### Test Flow
1. Checkout → Pilih lokasi → Pilih ekspedisi
2. Buat pesanan → Redirect ke select gateway
3. Pilih Paylabs → Pilih metode (QRIS)
4. Waiting page → QR Code muncul ✅
5. Klik "Simulasi Pembayaran Berhasil"
6. Redirect ke order detail dengan status "Paid"

## Files Modified

```
resources/views/customer/orders/show.blade.php (new)
resources/views/customer/payment/select-gateway.blade.php (updated)
resources/views/customer/payment/paylabs.blade.php (updated)
resources/views/customer/payment/paylabs-waiting.blade.php (new)
app/Services/PaylabsService.php (fix QR code)
```

## Backup Files

Old files backed up with `_old` suffix:
- `show_old.blade.php`
- `paylabs-waiting-old.blade.php`

## Screenshots

### Before
- Warna hijau/biru
- Design Bootstrap standard
- QR code tidak muncul

### After
- Warna hitam minimalis
- Design Apple-like dengan Tailwind
- QR code muncul dengan jelas
- UI konsisten dengan halaman utama

## Notes

- Semua halaman menggunakan Tailwind CSS via CDN
- Navbar dan footer dari `layouts.app` di-hide dengan CSS
- Custom navbar dan footer di setiap halaman
- QR code menggunakan external API (qrserver.com)
- Sandbox mode dengan mock data untuk testing

## Next Steps

1. Test di production dengan API key real
2. Tambahkan loading state untuk QR code
3. Tambahkan error handling untuk QR code gagal load
4. Implementasi webhook handler untuk auto update status
5. Tambahkan notification push saat payment success
