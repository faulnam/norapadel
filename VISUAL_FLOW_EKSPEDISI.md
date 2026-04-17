# Visual Flow: GoSend & GrabExpress

## 🗺️ Zona Pengiriman

```
┌─────────────────────────────────────────────────────────────┐
│                    ZONA PENGIRIMAN                          │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  🏪 TOKO (Origin)                                           │
│      │                                                      │
│      ├─── ≤30 km ───► 🏘️ DALAM KOTA (same_city)           │
│      │                 ✅ Instant, Same Day, Express, Regular│
│      │                                                      │
│      ├─── 30-150 km ─► 🏙️ KOTA TETANGGA (nearby)          │
│      │                 ✅ Instant, Same Day, Express, Regular│
│      │                                                      │
│      ├─── 150-500 km ► 🌆 ANTAR KOTA (inter_city)          │
│      │                 ❌ Instant, Same Day                 │
│      │                 ✅ Express, Regular                  │
│      │                                                      │
│      └─── >500 km ───► 🏝️ ANTAR PULAU (inter_island)       │
│                        ❌ Instant, Same Day                 │
│                        ✅ Express, Regular                  │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

## 📦 Ekspedisi yang Tersedia

```
┌──────────────────────────────────────────────────────────────┐
│                    DAFTAR EKSPEDISI                          │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  1. 🚚 J&T Express                                           │
│     ├─ EZ (Reguler) - 2-4 hari                              │
│     └─ Express - 1-2 hari                                    │
│                                                              │
│  2. 🚛 AnterAja                                              │
│     ├─ Reguler - 2-4 hari                                    │
│     └─ Same Day - Hari ini                                   │
│                                                              │
│  3. ⚡ Paxel                                                 │
│     ├─ Regular - 2-4 hari                                    │
│     ├─ Same Day - Hari ini                                   │
│     └─ Instant - 2-4 jam                                     │
│                                                              │
│  4. 🏍️ GoSend ⭐ BARU                                        │
│     ├─ Instant - 2-4 jam                                     │
│     └─ Same Day - Hari ini                                   │
│                                                              │
│  5. 🚗 GrabExpress ⭐ BARU                                   │
│     ├─ Instant - 2-4 jam                                     │
│     └─ Same Day - Hari ini                                   │
│                                                              │
└──────────────────────────────────────────────────────────────┘
```

## 💰 Harga per KG (Zona Dalam Kota)

```
┌─────────────────────────────────────────────────────────────┐
│              HARGA ONGKIR PER KG (DALAM KOTA)               │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  Layanan      │ Base Rate │ Multiplier │ Final (2kg)       │
│  ────────────┼───────────┼────────────┼──────────────────  │
│  Regular     │ Rp 8.000  │ 0.95-1.05  │ Rp 15.200-16.800  │
│  Express     │ Rp 14.000 │ 1.0-1.1    │ Rp 28.000-30.800  │
│  Same Day    │ Rp 20.000 │ 0.8-1.1    │ Rp 32.000-44.000  │
│  Instant     │ Rp 30.000 │ 0.95-1.0   │ Rp 57.000-60.000  │
│                                                             │
└─────────────────────────────────────────────────────────────┘

Contoh untuk 2 kg:
- GoSend Instant: Rp 30.000 × 2 × 1.0 = Rp 60.000
- GoSend Same Day: Rp 20.000 × 2 × 0.85 = Rp 34.000
- GrabExpress Instant: Rp 30.000 × 2 × 0.95 = Rp 57.000
- GrabExpress Same Day: Rp 20.000 × 2 × 0.8 = Rp 32.000
```

## 🔄 Flow Checkout

```
┌─────────────────────────────────────────────────────────────┐
│                    CHECKOUT FLOW                            │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  1. 🛒 Customer buka checkout                               │
│      │                                                      │
│      ▼                                                      │
│  2. 📍 Pilih lokasi di peta                                 │
│      │ (klik peta / GPS / search)                          │
│      │                                                      │
│      ▼                                                      │
│  3. ⚙️ Sistem hitung:                                       │
│      ├─ Total berat produk                                  │
│      ├─ Jarak dari toko                                     │
│      ├─ Zona pengiriman                                     │
│      └─ Ongkir per ekspedisi                                │
│      │                                                      │
│      ▼                                                      │
│  4. 📋 Tampilkan ekspedisi:                                 │
│      ├─ J&T Express                                         │
│      ├─ AnterAja                                            │
│      ├─ Paxel                                               │
│      ├─ GoSend ⭐                                           │
│      └─ GrabExpress ⭐                                      │
│      │                                                      │
│      ▼                                                      │
│  5. ✅ Customer pilih ekspedisi & layanan                   │
│      │                                                      │
│      ▼                                                      │
│  6. 💳 Lanjut pembayaran                                    │
│      │                                                      │
│      ▼                                                      │
│  7. 📦 Admin request pickup                                 │
│      │                                                      │
│      ▼                                                      │
│  8. 🏍️ Kurir datang & ambil paket                          │
│      │                                                      │
│      ▼                                                      │
│  9. 🚚 Paket dikirim                                        │
│      │                                                      │
│      ▼                                                      │
│  10. ✅ Selesai!                                            │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

## 🎯 Format Nomor Resi

```
┌─────────────────────────────────────────────────────────────┐
│                    FORMAT NOMOR RESI                        │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  Ekspedisi      │ Format              │ Contoh             │
│  ──────────────┼─────────────────────┼──────────────────  │
│  J&T Express   │ JT + 12 digit       │ JT012345678901     │
│  AnterAja      │ 10000 + 10 digit    │ 100001234567890    │
│  Paxel         │ PXL + 8 digit + 2 L │ PXL12345678AB      │
│  GoSend ⭐     │ GOSEND-timestamp+4  │ GOSEND-17763116031234│
│  GrabExpress⭐ │ GRAB + 12 digit     │ GRAB123456789012   │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

## 👤 Data Kurir (Sandbox Mode)

```
┌─────────────────────────────────────────────────────────────┐
│                    KURIR DUMMY DATA                         │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  🏍️ GoSend:                                                 │
│     ├─ Hendra Wijaya (⭐ 4.9, 1580 trips)                   │
│     │  📞 081234567896 | 🏍️ Motor L 6789 MN                │
│     └─ Irfan Hakim (⭐ 4.8, 1320 trips)                     │
│        📞 081234567897 | 🏍️ Motor L 4321 OP                │
│                                                             │
│  🚗 GrabExpress:                                            │
│     ├─ Joko Susilo (⭐ 4.9, 1450 trips)                     │
│     │  📞 081234567898 | 🏍️ Motor L 8765 QR                │
│     └─ Kurniawan Adi (⭐ 4.8, 1290 trips)                   │
│        📞 081234567899 | 🏍️ Motor L 5432 ST                │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

## 🎨 UI Elements

```
┌─────────────────────────────────────────────────────────────┐
│                    TAMPILAN DI CHECKOUT                     │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  Pilih Ekspedisi *                                          │
│  ┌─────────────────────────────────────────────────────┐   │
│  │ Zona: Dalam Kota · Berat: 2 kg                      │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
│  ┌─────────────────────────────────────────────────────┐   │
│  │ 🚚 J&T Express              Pilih Layanan ▼         │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
│  ┌─────────────────────────────────────────────────────┐   │
│  │ 🚛 AnterAja                 Pilih Layanan ▼         │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
│  ┌─────────────────────────────────────────────────────┐   │
│  │ ⚡ Paxel                    Pilih Layanan ▼         │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
│  ┌─────────────────────────────────────────────────────┐   │
│  │ 🏍️ GoSend ⭐               Pilih Layanan ▼         │   │
│  │ ┌───────────────────────────────────────────────┐   │   │
│  │ │ ○ Instant      2-4 jam        Rp 60.000      │   │   │
│  │ │ ○ Same Day     Hari ini       Rp 34.000      │   │   │
│  │ └───────────────────────────────────────────────┘   │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
│  ┌─────────────────────────────────────────────────────┐   │
│  │ 🚗 GrabExpress ⭐           Pilih Layanan ▼         │   │
│  │ ┌───────────────────────────────────────────────┐   │   │
│  │ │ ○ Instant      2-4 jam        Rp 57.000      │   │   │
│  │ │ ○ Same Day     Hari ini       Rp 32.000      │   │   │
│  │ └───────────────────────────────────────────────┘   │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

---

**Legend:**
- ⭐ = Fitur baru
- ✅ = Tersedia
- ❌ = Tidak tersedia
- 🏍️ = Motor
- 🚗 = Mobil
- 🚚 = Truk
- 📦 = Paket
