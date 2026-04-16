# Panduan Alur Admin - Sistem Ekspedisi Real

## Alur Lengkap Order

```
1. Customer Checkout → Pilih Ekspedisi (JNT/AnterAja/Paxel) + Layanan
   ↓
2. Customer Bayar (Paylabs/COD)
   ↓
3. Admin Verifikasi Pembayaran → Status: PAID (Siap Pickup)
   ↓
4. Admin Pack Barang
   ↓
5. Admin Request Pickup → Status: PROCESSING (Pickup Requested)
   ↓
6. Kurir Ekspedisi Ambil Paket → Status: SHIPPED (Dikirim)
   ↓
7. Ekspedisi Antar ke Customer → Tracking Real-time
   ↓
8. Customer Terima → Status: DELIVERED
   ↓
9. Customer Konfirmasi → Status: COMPLETED
```

## Status Order

| Status | Keterangan | Action Admin |
|--------|-----------|--------------|
| `pending_payment` | Menunggu pembayaran customer | Tunggu customer bayar |
| `paid` | Sudah dibayar, siap pickup | **Pack barang & Request Pickup** |
| `processing` | Pickup sudah direquest | Tunggu kurir ekspedisi ambil |
| `shipped` | Dikirim oleh ekspedisi | Tracking otomatis via Biteship |
| `delivered` | Sudah sampai ke customer | Tunggu customer konfirmasi |
| `completed` | Selesai | - |
| `cancelled` | Dibatalkan | - |

## Halaman Admin Orders

### 1. Daftar Orders (`/admin/orders`)
- Filter by status: `pending_payment`, `processing`, `shipped`, `delivered`, `completed`, `cancelled`
- Filter by payment status: `unpaid`, `pending_verification`, `paid`
- Search by order number atau nama customer
- Filter by date range

### 2. Detail Order (`/admin/orders/{id}`)

#### A. Verifikasi Pembayaran
- Jika customer upload bukti transfer → Klik **"Verifikasi Pembayaran"**
- Status berubah: `pending_payment` → `paid`
- Customer dapat notifikasi

#### B. Request Pickup (Alur Baru)
**Kondisi:** Status = `paid` dan ada ekspedisi terpilih

**Langkah:**
1. Pack barang pesanan
2. Klik tombol **"Request Pickup ke {Ekspedisi}"**
3. Sistem otomatis:
   - Hit Biteship API untuk request pickup
   - Dapat nomor resi (waybill_id)
   - Update status → `processing`
   - Notifikasi customer
4. Kurir ekspedisi akan datang ke toko untuk ambil paket
5. Setelah kurir ambil, status otomatis → `shipped`

**Alternatif - Input Resi Manual:**
- Jika pickup dilakukan di luar sistem (langsung ke kantor ekspedisi)
- Input nomor resi manual
- Status langsung → `shipped`

#### C. Tracking
- Klik **"Lihat Tracking"** untuk cek status pengiriman real-time
- Data dari Biteship API

## Ekspedisi yang Didukung

| Ekspedisi | Code | Layanan |
|-----------|------|---------|
| J&T Express | `jnt` | Reguler, Express |
| AnterAja | `anteraja` | Reguler, Same Day |
| Paxel | `paxel` | Instant, Same Day |

## Sandbox Mode

Saat `BITESHIP_SANDBOX=true` di `.env`:
- Tidak hit API real Biteship
- Menggunakan mock data untuk testing
- Nomor resi dummy: `MOCK-{timestamp}`

## Troubleshooting

### Error: "Customer belum memilih ekspedisi"
- Customer checkout sebelum sistem ekspedisi diimplementasi
- Solusi: Input resi manual atau hubungi customer untuk re-order

### Error: "Pickup sudah pernah direquest"
- Pickup sudah direquest sebelumnya
- Cek `biteship_order_id` di database
- Solusi: Gunakan input resi manual jika perlu update

### Nomor Resi Tidak Muncul
- Biteship API belum generate resi
- Tunggu beberapa menit atau refresh halaman
- Jika tetap tidak muncul, input resi manual

### Tracking Tidak Ada Data
- Ekspedisi belum update tracking
- Tunggu kurir pickup paket
- Data tracking muncul setelah kurir scan barcode

## Notes

- **Tidak ada lagi assign kurir internal** - Semua menggunakan ekspedisi real
- **Customer pilih ekspedisi saat checkout** - Bukan admin yang pilih
- **Pickup otomatis via API** - Lebih cepat dan akurat
- **Tracking real-time** - Customer dan admin bisa cek status kapan saja
