# Admin Order Flow - Ekspedisi Real (JNT/AnterAja/Paxel)

## Overview
Alur admin menggunakan ekspedisi real dengan Biteship API untuk request pickup otomatis dan tracking real-time.

## Alur Lengkap

```
1. Customer Checkout
   ↓
   Pilih lokasi pengiriman di peta
   ↓
   Sistem fetch ongkir dari ekspedisi (JNT/AnterAja/Paxel)
   ↓
   Customer pilih ekspedisi & layanan (Reguler/Express/Same Day)
   ↓
   Buat pesanan (status: pending_payment)

2. Customer Bayar
   ↓
   Pilih metode: Paylabs (VA/QRIS/E-Wallet/Retail) atau COD
   ↓
   Upload bukti pembayaran (jika Paylabs)
   ↓
   Status: pending_verification

3. Admin Verifikasi Pembayaran
   ↓
   Admin cek bukti pembayaran
   ↓
   Klik "Verifikasi Pembayaran"
   ↓
   Status: paid (siap untuk request pickup)

4. Admin Pack Barang
   ↓
   Admin siapkan barang sesuai order
   ↓
   Pack dengan rapi dan label alamat

5. Admin Request Pickup
   ↓
   Klik "Request Pickup" di dashboard
   ↓
   Sistem otomatis request ke ekspedisi via Biteship API
   ↓
   Ekspedisi generate nomor resi otomatis
   ↓
   Status: processing
   ↓
   Customer dapat notifikasi: "Kurir [ekspedisi] akan segera mengambil paket"

6. Kurir Ekspedisi Ambil Paket
   ↓
   Kurir datang ke toko
   ↓
   Scan barcode/resi
   ↓
   Ambil paket
   ↓
   Status: shipped (otomatis dari ekspedisi)

7. Ekspedisi Antar ke Customer
   ↓
   Tracking real-time tersedia di web
   ↓
   Customer bisa cek status pengiriman
   ↓
   Status: on_delivery

8. Customer Terima Paket
   ↓
   Kurir ekspedisi serahkan paket
   ↓
   Customer konfirmasi di web
   ↓
   Status: delivered → completed
```

## Fitur Admin Dashboard

### 1. Order List
- Filter by status (pending_payment, paid, processing, shipped, delivered, completed)
- Filter by payment status (unpaid, pending, paid)
- Search by order number atau customer name
- Filter by date range

### 2. Order Detail
**Informasi Order:**
- Order number
- Customer info (nama, phone, alamat)
- Items (produk, qty, harga)
- Total pembayaran
- Status order & payment

**Informasi Ekspedisi:**
- Ekspedisi: JNT / AnterAja / Paxel
- Layanan: Reguler / Express / Same Day / Instant
- Ongkir: Rp XX.XXX
- Zona: Dalam Kota / Kota Tetangga / Antar Kota / Antar Pulau
- Berat: X kg

**Actions:**
- Verifikasi Pembayaran (jika pending_verification)
- Request Pickup (jika paid)
- Input Resi Manual (jika pickup di luar sistem)
- View Tracking (jika sudah ada resi)

### 3. Request Pickup Section
```html
<div class="card">
    <div class="card-header">Request Pickup ke Ekspedisi</div>
    <div class="card-body">
        <p>Ekspedisi: <strong>{{ $order->courier_name }}</strong></p>
        <p>Layanan: <strong>{{ $order->courier_service_name }}</strong></p>
        
        @if(!$order->biteship_order_id)
            <button class="btn btn-primary" onclick="requestPickup()">
                <i class="fas fa-truck"></i> Request Pickup
            </button>
        @else
            <div class="alert alert-success">
                Pickup sudah direquest!
                <br>Resi: <strong>{{ $order->waybill_id }}</strong>
            </div>
        @endif
    </div>
</div>
```

### 4. Tracking Section
```html
<div class="card">
    <div class="card-header">Tracking Pengiriman</div>
    <div class="card-body">
        @if($order->waybill_id)
            <p>Nomor Resi: <strong>{{ $order->waybill_id }}</strong></p>
            <button class="btn btn-info" onclick="viewTracking()">
                <i class="fas fa-map-marker-alt"></i> Lihat Tracking
            </button>
            
            <div id="tracking-timeline" style="display:none;">
                <!-- Timeline tracking dari Biteship -->
            </div>
        @else
            <p class="text-muted">Nomor resi belum tersedia</p>
        @endif
    </div>
</div>
```

## API Endpoints

### Admin Routes
```php
// Request pickup
POST /admin/orders/{order}/request-pickup

// Update waybill manual
POST /admin/orders/{order}/update-waybill

// Get tracking
GET /admin/orders/{order}/tracking
```

### Customer Routes
```php
// Get tracking (customer view)
GET /customer/orders/{order}/tracking
```

## Biteship API Integration

### 1. Create Order (Request Pickup)
```php
$biteship->createOrder([
    'origin_contact_name' => 'NoraPadel',
    'origin_contact_phone' => '081234567890',
    'origin_address' => 'Toko NoraPadel',
    'origin_latitude' => -7.278417,
    'origin_longitude' => 112.632583,
    
    'destination_contact_name' => $order->shipping_name,
    'destination_contact_phone' => $order->shipping_phone,
    'destination_address' => $order->shipping_address,
    'destination_latitude' => $order->shipping_latitude,
    'destination_longitude' => $order->shipping_longitude,
    
    'courier_code' => 'jnt', // jnt, anteraja, paxel
    'courier_service_code' => 'reg', // reg, express, sameday
    
    'items' => [
        [
            'name' => 'Raket Padel',
            'value' => 500000,
            'quantity' => 1,
            'weight' => 500, // gram
        ]
    ],
]);
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": "biteship_order_123",
        "courier": {
            "waybill_id": "JNT1234567890"
        }
    }
}
```

### 2. Track Order
```php
$biteship->trackOrder($waybillId);
```

**Response:**
```json
{
    "success": true,
    "data": {
        "status": "on_delivery",
        "history": [
            {
                "note": "Paket telah diterima di sorting center",
                "updated_at": "2024-01-01 10:00:00"
            },
            {
                "note": "Paket dalam perjalanan ke tujuan",
                "updated_at": "2024-01-01 14:00:00"
            }
        ]
    }
}
```

## Database Schema

### Orders Table
```sql
courier_code VARCHAR(50) -- jnt, anteraja, paxel
courier_name VARCHAR(100) -- J&T Express, AnterAja, Paxel
courier_service_name VARCHAR(100) -- EZ (Reguler), Express, Same Day
biteship_order_id VARCHAR(255) -- ID dari Biteship
waybill_id VARCHAR(255) -- Nomor resi dari ekspedisi
```

## Status Flow

```
pending_payment → paid → processing → shipped → delivered → completed
                                ↓
                          (cancelled)
```

### Status Definitions:
- **pending_payment**: Menunggu pembayaran customer
- **paid**: Pembayaran verified, siap request pickup
- **processing**: Pickup sudah direquest, menunggu kurir ambil
- **shipped**: Kurir sudah ambil paket, dalam pengiriman
- **delivered**: Paket sudah sampai ke customer
- **completed**: Customer konfirmasi terima
- **cancelled**: Order dibatalkan

## Notifications

### Customer Notifications:
1. **Payment Verified**: "Pembayaran Anda sudah diverifikasi. Pesanan sedang dipersiapkan."
2. **Pickup Requested**: "Pesanan Anda sedang diproses. Kurir [ekspedisi] akan segera mengambil paket."
3. **Shipped**: "Pesanan Anda sedang dikirim dengan nomor resi: [resi]"
4. **Delivered**: "Paket Anda sudah sampai. Silakan konfirmasi penerimaan."

### Admin Notifications:
1. **New Order**: "Pesanan baru dari [customer]"
2. **Payment Uploaded**: "Customer [name] mengupload bukti pembayaran"

## Sandbox Mode

### Enable Sandbox
```env
BITESHIP_SANDBOX=true
```

### Mock Data
- Request pickup akan return mock data
- Nomor resi: `MOCK-JNT-123456`
- Tracking akan return mock timeline
- Tidak hit API real Biteship

## Production Mode

### Disable Sandbox
```env
BITESHIP_SANDBOX=false
BITESHIP_API_KEY=your_real_api_key
```

### Setup Biteship
1. Daftar di https://biteship.com
2. Verifikasi akun & toko
3. Dapatkan API key
4. Setup origin address (alamat toko)
5. Aktifkan ekspedisi (JNT, AnterAja, Paxel)

## Troubleshooting

### Pickup Request Failed
**Problem**: Error saat request pickup

**Solution**:
1. Cek API key Biteship valid
2. Cek origin address sudah disetup
3. Cek ekspedisi aktif di Biteship dashboard
4. Cek log: `storage/logs/laravel.log`

### Tracking Not Available
**Problem**: Tracking tidak muncul

**Solution**:
1. Cek waybill_id sudah ada di database
2. Cek ekspedisi sudah scan paket
3. Tunggu beberapa menit setelah pickup
4. Cek Biteship API status

### Resi Not Generated
**Problem**: Nomor resi tidak muncul setelah request pickup

**Solution**:
1. Cek response dari Biteship API
2. Input resi manual jika perlu
3. Hubungi support Biteship

## Best Practices

1. **Verifikasi Pembayaran Cepat**: Max 1 jam setelah upload
2. **Pack Barang Rapi**: Gunakan bubble wrap untuk barang fragile
3. **Request Pickup Pagi**: Sebelum jam 12 siang untuk pickup hari yang sama
4. **Monitor Tracking**: Cek tracking setiap hari
5. **Follow Up Customer**: Hubungi customer jika ada kendala pengiriman

## Support

### Biteship Support
- Email: support@biteship.com
- WhatsApp: +62 812 3456 7890
- Dashboard: https://biteship.com/dashboard

### Ekspedisi Support
- **JNT**: 021-8066-1888
- **AnterAja**: 021-5091-6161
- **Paxel**: 021-5091-5050
