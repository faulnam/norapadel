# Sistem Refund Lengkap - Paylabs & Biteship

## 📋 Overview

Sistem refund terintegrasi untuk mengembalikan dana pembayaran (via Paylabs) dan biaya ongkir (via Biteship) ketika customer membatalkan pesanan.

---

## ✅ Status Implementasi

### **PAYLABS REFUND - SUDAH BERFUNGSI** ✅

**Fitur:**
- ✅ Refund otomatis via Paylabs API
- ✅ Support semua metode pembayaran Paylabs (VA, QRIS, E-Wallet)
- ✅ Tracking refund dengan refund_id
- ✅ Fallback untuk pembayaran manual
- ✅ Mock mode untuk testing

**Endpoint API:**
```
POST /payment/v2.1/refund
```

**Method:**
```php
PaylabsService::refundTransaction(
    string $transactionId,  // Platform trade number dari Paylabs
    float $amount,          // Jumlah refund
    string $reason          // Alasan refund
)
```

---

### **BITESHIP REFUND - SUDAH BERFUNGSI** ✅

**Fitur:**
- ✅ Auto-refund ongkir jika order belum pickup
- ✅ Manual refund untuk order yang sudah dalam pengiriman
- ✅ Integrasi dengan cancel order Biteship
- ✅ Status checking sebelum refund

**Method:**
```php
BiteshipService::refundShippingCost(
    string $orderId,    // Biteship order ID
    float $amount,      // Jumlah ongkir
    string $reason      // Alasan refund
)
```

**Logic:**
- **Auto Refund:** Order dengan status `confirmed`, `allocated`, `pending` → Cancel order → Biteship auto-refund
- **Manual Refund:** Order dengan status `picked`, `dropping_off`, `delivered` → Perlu proses manual admin

---

## 🔄 Flow Refund Lengkap

### 1. Customer Membatalkan Order

```
Customer → Cancel Order → System Check
```

### 2. System Processing

```php
// Di Customer\OrderController::cancel()

1. Validasi: Apakah order bisa dibatalkan?
   ✓ Status harus 'processing'
   ✗ Tidak bisa jika sudah shipped/delivered

2. Cancel di Biteship (jika ada biteship_order_id)
   → BiteshipService::cancelOrder()

3. Process Refund
   → processRefund($order)
   
4. Restore Stock
   → Kembalikan stok produk

5. Update Order Status
   → status = 'cancelled'
   → refund_status = 'completed' / 'pending'

6. Send Notifications
   → Notify customer & admin
```

### 3. Process Refund Detail

```php
// Di Customer\OrderController::processRefund()

A. REFUND PAYMENT (Paylabs)
   ├─ Cek: payment_gateway === 'paylabs'?
   ├─ YES → Call PaylabsService::refundTransaction()
   │   ├─ Success → refund_status = 'completed'
   │   └─ Failed → refund_status = 'pending' (manual)
   └─ NO → refund_status = 'completed' (manual)

B. REFUND SHIPPING (Biteship)
   ├─ Cek: biteship_order_id exists?
   ├─ YES → Call BiteshipService::refundShippingCost()
   │   ├─ Status eligible → Auto refund via cancel
   │   └─ Status not eligible → Manual refund
   └─ NO → Skip (no shipping refund needed)

C. FINAL STATUS
   ├─ Both Success → refund_status = 'completed'
   ├─ Partial Success → refund_status = 'pending'
   └─ Both Failed → refund_status = 'failed'
```

---

## 🧪 Testing

### Test Paylabs Refund

**Mock Mode (Default):**
```env
PAYLABS_SANDBOX=true
PAYLABS_MOCK_MODE=true
```

**Test Flow:**
1. Buat order dengan payment via Paylabs
2. Bayar order (status → processing)
3. Cancel order
4. Check log: `storage/logs/laravel.log`

**Expected Result:**
```
[INFO] Paylabs MOCK refund
[INFO] Paylabs payment refund completed for order #NP-20250207-XXXXX
```

---

### Test Biteship Refund

**Mock Mode:**
```env
BITESHIP_USE_MOCK=true
```

**Test Scenarios:**

**Scenario 1: Auto Refund (Order Belum Pickup)**
```
1. Order status: confirmed/allocated
2. Cancel order
3. Expected: Auto refund via cancel
```

**Scenario 2: Manual Refund (Order Sudah Pickup)**
```
1. Order status: picked/dropping_off
2. Cancel order
3. Expected: Requires manual refund
```

**Check Log:**
```
[INFO] Biteship refund shipping cost check
[INFO] Biteship shipping refund processed for order #NP-20250207-XXXXX
```

---

## 📊 Database Fields

### Table: `orders`

**Refund Fields:**
```sql
refund_status           VARCHAR(20)     -- 'pending', 'completed', 'failed'
refund_amount           DECIMAL(10,2)   -- Total amount to refund
refund_at               TIMESTAMP       -- When refund started
refund_transaction_id   VARCHAR(100)    -- Paylabs refund ID
```

**Payment Fields:**
```sql
payment_gateway                 VARCHAR(50)     -- 'paylabs', 'manual'
payment_gateway_transaction_id  VARCHAR(100)    -- Paylabs transaction ID
```

**Shipping Fields:**
```sql
biteship_order_id       VARCHAR(100)    -- Biteship order ID
shipping_cost           DECIMAL(10,2)   -- Original shipping cost
```

---

## 🔍 Monitoring & Logging

### Log Locations

**Paylabs Refund:**
```
[INFO] Paylabs refundTransaction request
[INFO] Paylabs refundTransaction response
[INFO] Paylabs payment refund completed
[ERROR] Paylabs payment refund failed
```

**Biteship Refund:**
```
[INFO] Biteship refund shipping cost check
[INFO] Biteship shipping refund processed
[WARNING] Biteship shipping refund failed
```

**Overall Refund:**
```
[INFO] Refund error for order #XXX
```

---

## 🎯 Status Refund

### Refund Status Values

| Status | Deskripsi | Action |
|--------|-----------|--------|
| `null` | Tidak perlu refund | - |
| `pending` | Refund sedang diproses | Admin follow up |
| `completed` | Refund berhasil | Dana kembali 1-3 hari |
| `failed` | Refund gagal | Admin proses manual |

---

## 💰 Refund Amount Calculation

```php
// Total Refund = Total Pembayaran
$refundAmount = $order->total;

// Breakdown:
// - Subtotal produk
// - Diskon produk (-)
// - Ongkir
// - Diskon ongkir (-)
// = Total yang dibayar customer
```

---

## 🚨 Error Handling

### Paylabs Refund Errors

**Error 1: Transaction Not Found**
```
Message: "Transaction not found or already refunded"
Action: Check di dashboard Paylabs
Status: refund_status = 'failed'
```

**Error 2: Insufficient Balance**
```
Message: "Insufficient balance"
Action: Top up balance Paylabs
Status: refund_status = 'pending'
```

**Error 3: Network Error**
```
Message: "Connection timeout"
Action: Retry atau manual refund
Status: refund_status = 'pending'
```

---

### Biteship Refund Errors

**Error 1: Order Already Picked**
```
Message: "Order sudah dalam proses pengiriman"
Action: Manual refund by admin
Status: requires_manual_refund = true
```

**Error 2: Order Not Found**
```
Message: "Gagal mengambil detail order"
Action: Check biteship_order_id
Status: success = false
```

---

## 👨‍💼 Admin Actions

### Untuk Refund Pending

1. **Check Paylabs Dashboard**
   - Login ke https://dashboard.paylabs.co.id
   - Menu: Transactions → Refunds
   - Cari berdasarkan order_number atau transaction_id

2. **Check Biteship Dashboard**
   - Login ke https://dashboard.biteship.com
   - Menu: Orders
   - Cari berdasarkan order_number atau biteship_order_id

3. **Manual Refund Process**
   - Transfer manual ke rekening customer
   - Update order: refund_status = 'completed'
   - Catat di notes

---

## 🔐 Security

### Validations

1. **Authorization Check**
   ```php
   if ($order->user_id !== auth()->id()) {
       abort(403);
   }
   ```

2. **Status Check**
   ```php
   if (!$order->canBeCancelled()) {
       return back()->with('error', 'Pesanan tidak dapat dibatalkan');
   }
   ```

3. **Amount Validation**
   ```php
   $refundAmount = max(0, (float) $order->total);
   ```

4. **Transaction Validation**
   ```php
   if (empty($order->payment_gateway_transaction_id)) {
       // Skip Paylabs refund
   }
   ```

---

## 📱 Customer Notifications

### Refund Success
```
Subject: Pesanan Dibatalkan - Refund Diproses
Message: 
"Pesanan #NP-20250207-XXXXX berhasil dibatalkan.
Dana sebesar Rp 150.000 akan dikembalikan dalam 1-3 hari kerja."
```

### Refund Pending
```
Subject: Pesanan Dibatalkan - Refund Sedang Diproses
Message:
"Pesanan #NP-20250207-XXXXX berhasil dibatalkan.
Pengembalian dana sedang diproses oleh admin."
```

---

## 🎓 Best Practices

### 1. Always Log Refund Activities
```php
Log::info("Refund processed", [
    'order_number' => $order->order_number,
    'amount' => $refundAmount,
    'method' => 'paylabs',
]);
```

### 2. Use Database Transactions
```php
DB::beginTransaction();
try {
    // Process refund
    // Update order
    // Restore stock
    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
}
```

### 3. Handle Partial Refunds
```php
if ($paymentRefundSuccess && !$shippingRefundSuccess) {
    // Payment refunded, shipping pending
    $order->refund_status = Order::REFUND_PENDING;
}
```

### 4. Notify All Parties
```php
// Notify customer
auth()->user()->notify(new OrderCancelledNotification($order));

// Notify admins
Notification::send($admins, new OrderCancelledNotification($order));
```

---

## 🔄 Refund Timeline

| Event | Time | Status |
|-------|------|--------|
| Customer cancel order | T+0 | refund_status = 'pending' |
| Paylabs API call | T+0 | Processing |
| Biteship cancel | T+0 | Processing |
| Refund completed | T+0 | refund_status = 'completed' |
| Dana masuk ke customer | T+1 to T+3 days | - |

---

## 📞 Support

### Jika Refund Gagal

**Customer:**
1. Hubungi admin via WhatsApp
2. Berikan order_number
3. Screenshot bukti pembayaran

**Admin:**
1. Check log: `storage/logs/laravel.log`
2. Check Paylabs dashboard
3. Check Biteship dashboard
4. Process manual refund jika perlu

---

## 🎉 Summary

✅ **Paylabs Refund:** Fully implemented dengan API integration
✅ **Biteship Refund:** Fully implemented dengan auto/manual logic
✅ **Error Handling:** Comprehensive error handling & logging
✅ **Testing:** Mock mode available untuk development
✅ **Monitoring:** Detailed logging untuk audit trail
✅ **Security:** Authorization & validation checks
✅ **Notifications:** Customer & admin notifications

**Status: PRODUCTION READY** 🚀
