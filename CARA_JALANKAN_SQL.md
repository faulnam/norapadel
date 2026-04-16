# CARA MENJALANKAN SQL DI PHPMYADMIN

## Step-by-Step (Ikuti dengan teliti!)

### 1. Buka phpMyAdmin
- Buka browser
- Ketik: `http://localhost/phpmyadmin`
- Login jika diminta

### 2. Pilih Database
- Di sidebar kiri, klik database: **`norapadel`** (atau nama database Anda)
- Pastikan database sudah terpilih (warna biru/highlight)

### 3. Buka Tab SQL
- Di bagian atas, klik tab **"SQL"**
- Akan muncul textarea kosong untuk menulis SQL

### 4. Copy-Paste SQL Ini

```sql
-- Update ENUM status (WAJIB!)
ALTER TABLE `orders` MODIFY COLUMN `status` ENUM(
    'pending_payment',
    'processing',
    'ready_to_ship',
    'shipped',
    'delivered',
    'completed',
    'cancelled'
) NOT NULL DEFAULT 'pending_payment';
```

### 5. Klik Tombol "Go" / "Kirim"
- Scroll ke bawah
- Klik tombol **"Go"** atau **"Kirim"** (warna oranye/biru)
- Tunggu beberapa detik

### 6. Cek Hasil
Jika berhasil, akan muncul pesan:
```
✓ Query berhasil dijalankan
✓ 1 row affected
```

### 7. Jalankan SQL Kedua (Tambah Kolom Kurir)

Copy-paste SQL ini di tab SQL yang sama:

```sql
-- Tambah kolom kurir driver
ALTER TABLE `orders` 
ADD COLUMN `courier_driver_name` VARCHAR(255) NULL AFTER `waybill_id`,
ADD COLUMN `courier_driver_phone` VARCHAR(255) NULL AFTER `courier_driver_name`,
ADD COLUMN `courier_driver_photo` VARCHAR(255) NULL AFTER `courier_driver_phone`,
ADD COLUMN `courier_driver_rating` DECIMAL(3,2) NULL AFTER `courier_driver_photo`,
ADD COLUMN `courier_driver_vehicle` VARCHAR(255) NULL AFTER `courier_driver_rating`,
ADD COLUMN `courier_driver_vehicle_number` VARCHAR(255) NULL AFTER `courier_driver_vehicle`,
ADD COLUMN `pickup_time` TIMESTAMP NULL AFTER `courier_driver_vehicle_number`;
```

Klik **"Go"** lagi.

### 8. Validasi (Opsional)

Jalankan SQL ini untuk cek:

```sql
-- Cek kolom status
SHOW COLUMNS FROM orders LIKE 'status';

-- Cek kolom kurir
SHOW COLUMNS FROM orders LIKE 'courier_driver%';
```

Harusnya muncul:
- `status` dengan type: `enum('pending_payment','processing','ready_to_ship','shipped','delivered','completed','cancelled')`
- 7 kolom `courier_driver_*`

---

## ⚠️ Jika Ada Error

### Error: "Column already exists"
**Artinya:** Kolom sudah ada, skip SQL kedua.
**Solusi:** Lanjut ke testing.

### Error: "Table 'orders' doesn't exist"
**Artinya:** Database salah atau belum ada tabel orders.
**Solusi:** Pastikan pilih database yang benar.

### Error: "Access denied"
**Artinya:** User MySQL tidak punya permission.
**Solusi:** Login sebagai root atau user dengan privilege ALTER.

---

## ✅ Setelah SQL Berhasil

### Test di Admin:

1. **Refresh halaman admin** (Ctrl+R atau F5)
2. **Buka order:** `http://127.0.0.1:8000/admin/orders/7`
3. **Scroll ke "Update Status"**
4. **Dropdown sekarang ada:**
   - Menunggu Pembayaran
   - Pesanan Diproses
   - **Siap Pickup** ← Baru!
   - Dikirim Ekspedisi
   - Sudah Sampai
   - Selesai
   - Dibatalkan

5. **Pilih "Siap Pickup"** → Klik "Update Status"
6. **✅ Berhasil!** Tidak ada error lagi

### Test Request Pickup:

1. Status = `ready_to_ship` (Siap Pickup)
2. Klik **"Request Pickup"**
3. Loading 2 detik
4. **Info kurir muncul!** ✅

---

## 📸 Screenshot Panduan

### Langkah 1-2: Pilih Database
```
phpMyAdmin
├── [norapadel] ← Klik ini
│   ├── orders
│   ├── products
│   └── ...
```

### Langkah 3: Tab SQL
```
[Structure] [SQL] [Search] [Insert] ...
            ^^^^
         Klik ini
```

### Langkah 4-5: Paste & Go
```
┌─────────────────────────────────────┐
│ ALTER TABLE `orders` ...            │
│                                     │
│                                     │
└─────────────────────────────────────┘
              [Go] ← Klik
```

---

## 🎯 Checklist

- [ ] Buka phpMyAdmin
- [ ] Pilih database `norapadel`
- [ ] Klik tab "SQL"
- [ ] Copy-paste SQL pertama (UPDATE ENUM)
- [ ] Klik "Go"
- [ ] Lihat pesan sukses
- [ ] Copy-paste SQL kedua (ADD COLUMN)
- [ ] Klik "Go"
- [ ] Refresh halaman admin
- [ ] Test ubah status ke "Siap Pickup"
- [ ] Test request pickup

---

## 💡 Tips

- **Jangan tutup phpMyAdmin** sampai semua SQL selesai
- **Backup database** sebelum jalankan SQL (opsional tapi recommended)
- **Catat error message** jika ada error, kirim ke developer

---

**Setelah SQL berhasil, error "Data truncated" akan hilang!** 🚀
