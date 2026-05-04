# 🔧 FIX - Error Paylabs QRIS "amount must be greater than or equal to 1000.00"

## ❌ **MASALAH**

Error saat pembayaran QRIS:
```
Gagal membuat pembayaran: amount:must be greater than or equal to 1000.00
```

---

## 🔍 **PENYEBAB**

Paylabs API memiliki **minimum amount Rp 1.000** untuk semua transaksi.

Error ini terjadi karena salah satu dari:

1. **Total order kurang dari Rp 1.000**
   - Produk terlalu murah
   - Diskon terlalu besar
   - Ongkir gratis

2. **Format amount salah**
   - Dikirim sebagai integer bukan decimal
   - Format: harus `"1000.00"` bukan `1000`

3. **Field amount salah**
   - Menggunakan `$order->total` bukan `$order->total_amount`
   - Field kosong atau null

---

## ✅ **SOLUSI YANG SUDAH DITERAPKAN**

### 1. **Validasi Minimum Amount di Controller**

**File:** `app/Http/Controllers/Customer/PaylabsPaymentController.php`

```php
public function process(Request $request, Order $order)
{
    // Get total amount - ensure it's at least 1000
    $totalAmount = (float) $order->total_amount;
    
    // Validate minimum amount
    if ($totalAmount < 1000) {
        \Log::error('Paylabs payment amount too low', [
            'order_number' => $order->order_number,
            'total_amount' => $totalAmount,
            'order_total' => $order->total,
            'order_total_pembayaran' => $order->total_pembayaran,
        ]);
        
        return back()->with('error', 'Total pembayaran minimal Rp 1.000. Total saat ini: Rp ' . number_format($totalAmount, 0, ',', '.'));
    }
    
    // Send as float (will be formatted in service)
    $result = $this->paylabs->createTransaction([
        'amount' => $totalAmount,  // ← Float, bukan integer
        ...
    ]);
}
```

### 2. **Validasi & Format di Service**

**File:** `app/Services/PaylabsService.php`

```php
protected function buildEndpointAndBody(...)
{
    // Ensure amount is at least 1000
    $rawAmount = (float) ($data['amount'] ?? 0);
    
    if ($rawAmount < 1000) {
        Log::error('Paylabs amount below minimum', [
            'raw_amount' => $rawAmount,
            'order_number' => $data['order_number'] ?? 'unknown',
        ]);
        throw new \InvalidArgumentException('Amount must be at least 1000.00');
    }
    
    // Format as decimal with 2 digits (required by Paylabs)
    $amount = number_format($rawAmount, 2, '.', '');
    // Result: "1000.00" ✅
    
    Log::info('Paylabs buildEndpointAndBody', [
        'raw_amount' => $rawAmount,
        'formatted_amount' => $amount,
    ]);
    
    // Send to Paylabs API
    return [
        '/payment/v2.1/qris/create',
        [
            'amount' => $amount,  // ← "1000.00" format
            ...
        ]
    ];
}
```

---

## 🧪 **CARA TESTING**

### Test 1: Order dengan Total < Rp 1.000

```bash
# Scenario: Produk Rp 500 + Ongkir Rp 0 = Rp 500
# Expected: Error message "Total pembayaran minimal Rp 1.000"
```

**Steps:**
1. Buat order dengan total < Rp 1.000
2. Pilih payment QRIS
3. Expected result:
   ```
   ❌ Total pembayaran minimal Rp 1.000. Total saat ini: Rp 500
   ```

### Test 2: Order dengan Total >= Rp 1.000

```bash
# Scenario: Produk Rp 50.000 + Ongkir Rp 15.000 = Rp 65.000
# Expected: Payment berhasil dibuat
```

**Steps:**
1. Buat order dengan total >= Rp 1.000
2. Pilih payment QRIS
3. Expected result:
   ```
   ✅ Redirect ke halaman waiting
   ✅ QR Code tampil
   ```

### Test 3: Check Log

```bash
# Check log untuk debug
tail -f storage/logs/laravel.log | grep -i "paylabs"
```

**Expected log:**
```
[INFO] Paylabs buildEndpointAndBody
{
    "raw_amount": 65000,
    "formatted_amount": "65000.00",
    "order_number": "NP-20250207-XXXXX"
}

[INFO] Paylabs createTransaction request
{
    "body": {
        "amount": "65000.00",  ← Format correct!
        ...
    }
}
```

---

## 📊 **DEBUGGING CHECKLIST**

Jika masih error, check:

### 1. **Check Order Total**

```sql
SELECT 
    order_number,
    total,
    total_pembayaran,
    subtotal,
    shipping_cost,
    product_discount,
    shipping_discount
FROM orders 
WHERE order_number = 'NP-20250207-XXXXX';
```

**Expected:**
- `total_pembayaran` >= 1000
- Atau `total` >= 1000

### 2. **Check Log**

```bash
tail -100 storage/logs/laravel.log | grep -A 5 "Paylabs payment amount too low"
```

**If found:**
```
[ERROR] Paylabs payment amount too low
{
    "order_number": "NP-20250207-XXXXX",
    "total_amount": 500,  ← Problem here!
    "order_total": 500,
    "order_total_pembayaran": 500
}
```

### 3. **Check Paylabs API Response**

```bash
tail -100 storage/logs/laravel.log | grep -A 10 "Paylabs createTransaction response"
```

**If error:**
```json
{
    "errCode": "400",
    "errCodeDes": "amount:must be greater than or equal to 1000.00"
}
```

---

## 🎯 **ROOT CAUSE ANALYSIS**

### Kemungkinan Penyebab:

1. **Produk Terlalu Murah**
   - Produk < Rp 1.000
   - Solution: Set minimum price Rp 1.000

2. **Diskon Terlalu Besar**
   - Diskon 100% → Total = Rp 0
   - Solution: Limit diskon maksimal 90%

3. **Ongkir Gratis + Produk Murah**
   - Produk Rp 500 + Ongkir Rp 0 = Rp 500
   - Solution: Minimum subtotal untuk free shipping

4. **Bug di Perhitungan Total**
   - Field `total_pembayaran` tidak terisi
   - Solution: Pastikan `total_pembayaran` selalu terisi

---

## 🔧 **ADDITIONAL FIXES**

### Fix 1: Set Minimum Product Price

**File:** `app/Models/Product.php`

```php
protected static function boot()
{
    parent::boot();
    
    static::saving(function ($product) {
        // Ensure minimum price Rp 1.000
        if ($product->price < 1000) {
            throw new \Exception('Harga produk minimal Rp 1.000');
        }
    });
}
```

### Fix 2: Limit Maximum Discount

**File:** `app/Models/Product.php`

```php
public function getDiscountedPriceAttribute()
{
    if ($this->hasActiveDiscount()) {
        $discount = $this->price * ($this->discount_percent / 100);
        $discountedPrice = $this->price - $discount;
        
        // Ensure minimum price after discount
        return max(1000, $discountedPrice);
    }
    
    return $this->price;
}
```

### Fix 3: Minimum Subtotal for Free Shipping

**File:** `app/Models/ShippingDiscount.php`

```php
public function calculateDiscount($shippingCost, $subtotal)
{
    // Only apply if subtotal >= min_subtotal
    if ($subtotal < $this->min_subtotal) {
        return 0;
    }
    
    $discount = $shippingCost * ($this->discount_percent / 100);
    
    // Ensure final total >= 1000
    $finalTotal = $subtotal + $shippingCost - $discount;
    if ($finalTotal < 1000) {
        // Reduce discount to keep total >= 1000
        $discount = $subtotal + $shippingCost - 1000;
    }
    
    return max(0, min($discount, $this->max_discount ?? PHP_INT_MAX));
}
```

---

## ✅ **VERIFICATION**

### After Fix, Test:

1. ✅ Order dengan total Rp 500 → Error message
2. ✅ Order dengan total Rp 1.000 → Success
3. ✅ Order dengan total Rp 50.000 → Success
4. ✅ Log menampilkan formatted amount: "50000.00"
5. ✅ Paylabs API response success

---

## 📞 **SUPPORT**

### Jika Masih Error:

1. **Check Log:**
   ```bash
   tail -200 storage/logs/laravel.log | grep -i "paylabs"
   ```

2. **Check Database:**
   ```sql
   SELECT * FROM orders WHERE order_number = 'NP-XXXXX';
   ```

3. **Check Paylabs Dashboard:**
   - Login: https://dashboard.paylabs.co.id
   - Check transaction history
   - Check error logs

4. **Contact Paylabs Support:**
   - Email: support@paylabs.co.id
   - Provide: order_number, error message, timestamp

---

## 🎉 **SUMMARY**

### ✅ **FIX APPLIED:**

1. ✅ Validasi minimum amount Rp 1.000 di controller
2. ✅ Validasi minimum amount di service
3. ✅ Format amount sebagai decimal "1000.00"
4. ✅ Logging untuk debugging
5. ✅ Error message yang jelas untuk user

### ✅ **EXPECTED BEHAVIOR:**

- Order < Rp 1.000 → Error message
- Order >= Rp 1.000 → Payment success
- Amount format: "1000.00" (decimal string)
- Log: Clear debugging info

---

**Last Updated:** 2025-02-07
**Status:** ✅ FIXED
