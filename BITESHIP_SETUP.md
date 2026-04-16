# Setup Biteship Integration

## 1. Daftar dan Dapatkan API Key

1. Buka https://biteship.com
2. Daftar akun baru
3. Verifikasi email
4. Login ke dashboard
5. Buka menu **Settings** → **API Keys**
6. Copy **Testing API Key** (untuk development)

## 2. Konfigurasi Environment

Tambahkan ke file `.env`:

```env
BITESHIP_API_KEY=your-testing-api-key-here
BITESHIP_SANDBOX=true
```

## 3. Jalankan Migration

```bash
php artisan migrate
```

Migration akan menambahkan field berikut ke tabel `orders`:
- `courier_code` - Kode kurir (jne, jnt, anteraja, spx, paxel)
- `courier_name` - Nama kurir (JNE, J&T Express, dll)
- `courier_service_name` - Nama layanan (REG, YES, dll)
- `biteship_order_id` - ID order dari Biteship
- `waybill_id` - Nomor resi
- `delivery_distance_km` - Jarak pengiriman dalam km

## 4. Testing API

### A. Test Get Rates (Cek Ongkir)

**Endpoint:** `POST /customer/shipping/rates`

**Request Body:**
```json
{
  "destination_latitude": -6.2088,
  "destination_longitude": 106.8456,
  "items": [
    {
      "name": "Raket Padel",
      "value": 2000000,
      "weight": 500,
      "quantity": 1
    }
  ]
}
```

**Response Success:**
```json
{
  "success": true,
  "data": {
    "origin": {
      "latitude": -7.4674,
      "longitude": 112.5274
    },
    "destination": {
      "latitude": -6.2088,
      "longitude": 106.8456
    },
    "pricing": [
      {
        "courier_code": "jne",
        "courier_name": "JNE",
        "courier_service_name": "REG",
        "description": "Layanan Reguler",
        "duration": "2-3 hari",
        "price": 25000,
        "formatted_price": "Rp 25.000"
      },
      {
        "courier_code": "jnt",
        "courier_name": "J&T Express",
        "courier_service_name": "EZ",
        "description": "Layanan Ekonomis",
        "duration": "3-5 hari",
        "price": 18000,
        "formatted_price": "Rp 18.000"
      }
    ]
  }
}
```

### B. Test dengan Postman/Thunder Client

1. Method: `POST`
2. URL: `http://127.0.0.1:8000/customer/shipping/rates`
3. Headers:
   - `Content-Type: application/json`
   - `Accept: application/json`
4. Body (raw JSON): Gunakan request body di atas
5. Klik Send

### C. Test dari Browser Console

Buka halaman checkout, lalu jalankan di console:

```javascript
fetch('/customer/shipping/rates', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
  },
  body: JSON.stringify({
    destination_latitude: -6.2088,
    destination_longitude: 106.8456,
    items: [
      {
        name: 'Raket Padel',
        value: 2000000,
        weight: 500,
        quantity: 1
      }
    ]
  })
})
.then(res => res.json())
.then(data => console.log(data));
```

## 5. Courier Codes yang Didukung

- `jne` - JNE
- `jnt` - J&T Express
- `anteraja` - AnterAja
- `spx` - Shopee Express
- `paxel` - Paxel

## 6. Format Items untuk API

Setiap item harus memiliki:
- `name` (string) - Nama produk
- `value` (number) - Nilai barang dalam Rupiah
- `weight` (number) - Berat dalam gram
- `quantity` (integer) - Jumlah item

## 7. Error Handling

**Error Response:**
```json
{
  "success": false,
  "message": "Failed to get shipping rates"
}
```

**Common Errors:**
- `401 Unauthorized` - API Key salah atau tidak valid
- `400 Bad Request` - Format request salah
- `422 Validation Error` - Data tidak lengkap

## 8. Next Steps

Setelah API berfungsi:
1. Update halaman checkout untuk menggunakan Biteship
2. Ganti input koordinat dengan dropdown kota/kecamatan
3. Tampilkan pilihan ekspedisi dan harga
4. Simpan data ekspedisi yang dipilih ke order
5. Implementasi create order ke Biteship setelah payment
6. Implementasi tracking order

## 9. Dokumentasi Biteship

- Rates API: https://biteship.com/id/docs/api/rates
- Orders API: https://biteship.com/id/docs/api/orders
- Tracking API: https://biteship.com/id/docs/api/tracking

## 10. Mode Production

Untuk production:
1. Ganti `BITESHIP_API_KEY` dengan Production API Key
2. Set `BITESHIP_SANDBOX=false`
3. Pastikan sudah verifikasi akun dan top up saldo
