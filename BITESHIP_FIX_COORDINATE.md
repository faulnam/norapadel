# Perbaikan Integrasi Biteship - Koordinat & Postal Code

## Masalah yang Ditemukan

Pesanan tidak masuk ke dashboard Biteship untuk beberapa ekspedisi, terutama kurir instant seperti Grab dan GoSend.

## Penyebab Masalah

Berdasarkan dokumentasi Biteship (https://biteship.com/id/docs/api/orders/create), ada perbedaan requirement antara kurir instant dan kurir regular:

### Kurir Instant (Grab, GoSend, dll)
- **WAJIB**: `origin_coordinate` dan `destination_coordinate` (object dengan latitude & longitude)
- **OPTIONAL**: `origin_postal_code` dan `destination_postal_code`

### Kurir Regular (JNE, J&T, AnterAja, dll)
- **WAJIB**: `origin_postal_code` dan `destination_postal_code`
- **OPTIONAL**: `origin_coordinate` dan `destination_coordinate` (tapi sangat membantu untuk akurasi)

## Perbaikan yang Dilakukan

### 1. BiteshipService.php - Method createOrder()

**Sebelum:**
```php
$payload = [
    'origin_latitude' => $originLatitude,
    'origin_longitude' => $originLongitude,
    'origin_postal_code' => $orderData['origin_postal_code'] ?? config('biteship.origin.postal_code'),
    'origin_coordinate_latitude' => $originLatitude,
    'origin_coordinate_longitude' => $originLongitude,
    'origin_coordinate' => [
        'latitude' => $originLatitude,
        'longitude' => $originLongitude,
    ],
    // ... field redundan lainnya
];
```

**Sesudah:**
```php
// Deteksi apakah ini kurir instant
$isInstantCourier = in_array($courierCode, ['grab', 'grabexpress', 'gojek', 'gosend'], true);

$payload = [
    'origin_contact_name' => ...,
    'origin_address' => ...,
    // ... field wajib lainnya
];

// Untuk kurir instant: WAJIB pakai coordinate, postal_code OPTIONAL
if ($isInstantCourier) {
    $payload['origin_coordinate'] = [
        'latitude' => $originLatitude,
        'longitude' => $originLongitude,
    ];
    $payload['destination_coordinate'] = [
        'latitude' => $destinationLatitude,
        'longitude' => $destinationLongitude,
    ];
} else {
    // Untuk kurir regular: postal_code WAJIB, coordinate OPTIONAL
    $payload['origin_postal_code'] = $orderData['origin_postal_code'] ?? config('biteship.origin.postal_code');
    $payload['destination_postal_code'] = $orderData['destination_postal_code'] ?? '61219';
    
    // Tetap kirim coordinate jika tersedia untuk akurasi lebih baik
    if ($originLatitude && $originLongitude) {
        $payload['origin_coordinate'] = [
            'latitude' => $originLatitude,
            'longitude' => $originLongitude,
        ];
    }
    if ($destinationLatitude && $destinationLongitude) {
        $payload['destination_coordinate'] = [
            'latitude' => $destinationLatitude,
            'longitude' => $destinationLongitude,
        ];
    }
}
```

### 2. BiteshipService.php - Method createDraftOrder()

Perbaikan yang sama diterapkan pada method `createDraftOrder()` untuk konsistensi.

### 3. Logging yang Ditingkatkan

Menambahkan logging detail untuk debugging:
```php
Log::info('Biteship createOrder request', [
    'reference_id' => $payloadWithPayment['reference_id'] ?? null,
    'courier_company' => $payloadWithPayment['courier_company'] ?? null,
    'courier_type' => $payloadWithPayment['courier_type'] ?? null,
    'is_instant_courier' => $isInstantCourier,
    'has_origin_coordinate' => isset($payloadWithPayment['origin_coordinate']),
    'has_destination_coordinate' => isset($payloadWithPayment['destination_coordinate']),
    'has_origin_postal_code' => isset($payloadWithPayment['origin_postal_code']),
    'has_destination_postal_code' => isset($payloadWithPayment['destination_postal_code']),
]);
```

## Cara Testing

### 1. Test Kurir Instant (Grab/GoSend)
```bash
# Buat pesanan dengan Grab atau GoSend
# Cek log Laravel untuk memastikan:
# - is_instant_courier: true
# - has_origin_coordinate: true
# - has_destination_coordinate: true
# - has_origin_postal_code: false (atau tidak ada)
```

### 2. Test Kurir Regular (JNE/J&T/AnterAja)
```bash
# Buat pesanan dengan JNE, J&T, atau AnterAja
# Cek log Laravel untuk memastikan:
# - is_instant_courier: false
# - has_origin_postal_code: true
# - has_destination_postal_code: true
# - has_origin_coordinate: true (jika koordinat tersedia)
```

### 3. Cek Dashboard Biteship
1. Login ke https://dashboard.biteship.com
2. Buka menu "Orders"
3. Pastikan pesanan muncul dengan status yang benar
4. Cek detail pesanan untuk memastikan semua data terkirim dengan benar

## Monitoring

Setelah perbaikan, monitor hal berikut:

1. **Log Laravel** (`storage/logs/laravel.log`):
   - Cari "Biteship createOrder request"
   - Pastikan field yang dikirim sesuai dengan jenis kurir

2. **Dashboard Biteship**:
   - Semua pesanan harus muncul
   - Status harus ter-update dengan benar
   - Waybill ID harus ter-generate

3. **Database** (tabel `orders`):
   - Field `biteship_order_id` harus terisi
   - Field `waybill_id` harus terisi setelah kurir pickup
   - Field `biteship_tracking_status` harus ter-update

## Troubleshooting

### Pesanan Masih Tidak Muncul di Dashboard Biteship

1. **Cek API Key**:
   ```bash
   # Pastikan menggunakan API key yang benar
   # .env
   BITESHIP_API_KEY=biteship_live.xxx
   BITESHIP_SANDBOX=false
   ```

2. **Cek Response Error**:
   ```bash
   # Lihat log error dari Biteship
   tail -f storage/logs/laravel.log | grep "Biteship createOrder failed"
   ```

3. **Cek Koordinat**:
   ```bash
   # Pastikan koordinat valid (tidak 0,0)
   # Latitude: -90 sampai 90
   # Longitude: -180 sampai 180
   ```

4. **Cek Postal Code**:
   ```bash
   # Untuk kurir regular, pastikan postal code valid
   # Format: 5 digit angka (contoh: 61219)
   ```

### Error "Invalid coordinate"

- Pastikan koordinat dalam format desimal (bukan DMS)
- Pastikan koordinat tidak null atau 0
- Untuk Indonesia:
  - Latitude: sekitar -11 sampai 6
  - Longitude: sekitar 95 sampai 141

### Error "Postal code required"

- Terjadi pada kurir regular (JNE, J&T, dll)
- Pastikan `origin_postal_code` dan `destination_postal_code` terisi
- Format: 5 digit angka

## Referensi

- Dokumentasi Biteship Orders API: https://biteship.com/id/docs/api/orders/create
- Dokumentasi Biteship Rates API: https://biteship.com/id/docs/api/rates
- Dokumentasi Biteship Maps API: https://biteship.com/id/docs/api/maps

## Catatan Penting

1. **Kurir Instant** (Grab, GoSend):
   - Hanya tersedia di area tertentu (kota besar)
   - Memerlukan koordinat yang akurat
   - Tidak memerlukan postal code

2. **Kurir Regular** (JNE, J&T, AnterAja):
   - Tersedia di seluruh Indonesia
   - Memerlukan postal code yang valid
   - Koordinat membantu tapi tidak wajib

3. **Best Practice**:
   - Selalu kirim koordinat jika tersedia (untuk semua jenis kurir)
   - Selalu kirim postal code untuk kurir regular
   - Validasi koordinat sebelum dikirim ke Biteship
   - Monitor log untuk error handling
