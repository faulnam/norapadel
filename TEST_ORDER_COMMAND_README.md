# Test Order Creation Command

## Overview
Command artisan untuk membuat test order dengan status `completed` atau `cancelled` untuk testing Biteship API key.

## Cara Penggunaan

### Via Batch Script (Rekomendasi)
Jalankan file `create-test-orders.bat` di folder root project:
```
create-test-orders.bat
```

Pilih opsi:
1. Create completed order - Membuat 1 order completed
2. Create cancelled order - Membuat 1 order cancelled
3. Create multiple completed orders (5 orders) - Membuat 5 order completed
4. Create multiple cancelled orders (5 orders) - Membuat 5 order cancelled
5. Exit - Keluar

### Via Command Line Manual

**Buat order completed:**
```bash
php artisan order:create-test completed
```

**Buat order cancelled:**
```bash
php artisan order:create-test cancelled
```

**Buat order dengan user ID tertentu:**
```bash
php artisan order:create-test completed --user=2
```

## Detail Order yang Dibuat

### Order Completed
- Status: `completed`
- Payment Status: `paid`
- AWB Number: Auto-generated (JP + random 10 digit)
- Biteship Order ID: Auto-generated
- Delivered At: 2 hari yang lalu
- Completed At: 2 hari yang lalu
- Courier: J&T Express (JNT)

### Order Cancelled
- Status: `cancelled`
- Payment Status: `paid`
- Cancel Reason: "Test cancellation via command"
- Refund At: Sekarang
- Refund Status: `completed`
- Refund Amount: Total order

## Data yang Digunakan
- Product: Produk pertama yang ditemukan di database
- User: User dengan ID 1 (default) atau sesuai parameter `--user`
- Shipping Address: Jl. Test No. 123, Surabaya
- Shipping Cost: Rp 15.000

## Output
Command akan menampilkan:
- Order Number
- Order ID
- Status
- Payment Status
- Total Amount
- Product Name
- User Name
- Created At
- Field tambahan sesuai status (AWB, Delivered At untuk completed / Cancel Reason, Refund untuk cancelled)

## Catatan
- Order yang dibuat adalah test order untuk testing API
- Order akan muncul di admin panel dan customer dashboard
- Pastikan ada minimal 1 user dan 1 product di database
- Order number format: NP-YYYYMMDD-XXXXX
