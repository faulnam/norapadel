# RINGKASAN PERBAIKAN BITESHIP

## Masalah
Pesanan tidak masuk ke dashboard Biteship untuk beberapa ekspedisi (terutama Grab dan GoSend).

## Penyebab
Format pengiriman data ke API Biteship tidak sesuai dokumentasi:
- Kurir instant (Grab, GoSend) WAJIB pakai `coordinate` object, tapi kode mengirim field redundan
- Kurir regular (JNE, J&T) WAJIB pakai `postal_code`, tapi format tidak konsisten

## Solusi
✅ Perbaiki `BiteshipService.php`:
- Method `createOrder()` - line ~520
- Method `createDraftOrder()` - line ~720

**Perubahan:**
```php
// Deteksi jenis kurir
$isInstantCourier = in_array($courierCode, ['grab', 'grabexpress', 'gojek', 'gosend'], true);

// Kirim data sesuai jenis kurir
if ($isInstantCourier) {
    // WAJIB: coordinate object
    $payload['origin_coordinate'] = ['latitude' => ..., 'longitude' => ...];
    $payload['destination_coordinate'] = ['latitude' => ..., 'longitude' => ...];
} else {
    // WAJIB: postal_code
    $payload['origin_postal_code'] = ...;
    $payload['destination_postal_code'] = ...;
    // OPTIONAL: coordinate (untuk akurasi)
    $payload['origin_coordinate'] = ['latitude' => ..., 'longitude' => ...];
}
```

## Testing

### 1. Via Command (Cepat)
```bash
# Test JNE
php artisan biteship:test-order jne

# Test Grab
php artisan biteship:test-order grab

# Test J&T
php artisan biteship:test-order jnt
```

### 2. Via Website (Real Flow)
1. Login sebagai customer
2. Checkout dengan ekspedisi yang berbeda
3. Bayar pesanan
4. Cek dashboard Biteship: https://dashboard.biteship.com/orders

## Verifikasi

### ✅ Cek Log
```bash
tail -f storage/logs/laravel.log | grep "Biteship createOrder"
```

Harus ada:
- `is_instant_courier: true/false`
- `has_origin_coordinate: true`
- `has_destination_coordinate: true`

### ✅ Cek Dashboard Biteship
- Order muncul dengan status "confirmed"
- Waybill ID ter-generate
- Detail lengkap (origin, destination, items)

### ✅ Cek Database
```sql
SELECT order_number, courier_code, biteship_order_id, waybill_id 
FROM orders 
WHERE biteship_order_id IS NOT NULL 
ORDER BY created_at DESC LIMIT 5;
```

## File yang Diubah
1. ✅ `app/Services/BiteshipService.php` - Perbaikan format koordinat
2. ✅ `app/Console/Commands/BiteshipTestOrderCommand.php` - Command testing
3. ✅ `BITESHIP_FIX_COORDINATE.md` - Dokumentasi lengkap
4. ✅ `BITESHIP_CHECKLIST.md` - Checklist verifikasi

## Next Steps
1. Test semua ekspedisi (JNE, J&T, AnterAja, Grab, GoSend)
2. Monitor log untuk error
3. Verifikasi di dashboard Biteship
4. Deploy ke production jika semua OK

## Kontak Support
Jika masih ada masalah:
- Biteship Support: support@biteship.com
- Dokumentasi: https://biteship.com/id/docs
- Dashboard: https://dashboard.biteship.com
