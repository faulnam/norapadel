# 🛒 Guest Checkout - Belanja Tanpa Login

## 📋 Overview

Fitur guest checkout memungkinkan customer untuk membeli produk dan menyelesaikan pembayaran **tanpa perlu registrasi atau login**. Sistem akan otomatis membuat akun guest untuk tracking pesanan.

## ✨ Fitur Utama

### 1. **Shopping Cart untuk Guest**
- ✅ Tambah produk ke keranjang tanpa login
- ✅ Cart disimpan di session browser
- ✅ Update quantity & hapus item
- ✅ Cart counter real-time

### 2. **Checkout Tanpa Login**
- ✅ Form checkout dengan data guest (nama, email, phone)
- ✅ Pilih alamat pengiriman dengan Google Maps
- ✅ Hitung ongkir via Biteship
- ✅ Pilih metode pengiriman
- ✅ Otomatis buat akun guest

### 3. **Payment Gateway**
- ✅ Pilih metode pembayaran (Paylabs/COD)
- ✅ Proses pembayaran tanpa login
- ✅ Redirect ke payment gateway
- ✅ Webhook handling untuk update status

### 4. **Order Tracking untuk Guest**
- ✅ Link tracking disimpan di session
- ✅ Akses detail pesanan via link
- ✅ Tracking pengiriman real-time
- ✅ Update status otomatis

## 🔧 Implementasi Teknis

### Database Changes

**Migration: `2026_05_10_000001_add_is_guest_to_users_table.php`**
```php
Schema::table('users', function (Blueprint $table) {
    $table->boolean('is_guest')->default(false)->after('is_active');
});
```

### Model Updates

**User Model (`app/Models/User.php`)**
```php
protected $fillable = [
    // ... existing fields
    'is_guest',
];

protected function casts(): array
{
    return [
        // ... existing casts
        'is_guest' => 'boolean',
    ];
}
```

### Routes

**Guest-accessible routes (tanpa middleware auth):**
```php
// Cart
Route::post('/customer/cart/add/{product}', [CartController::class, 'add']);
Route::get('/customer/cart', [CartController::class, 'index']);
Route::patch('/customer/cart/{cart}', [CartController::class, 'update']);
Route::delete('/customer/cart/{cart}', [CartController::class, 'remove']);

// Checkout
Route::get('/customer/checkout', [CustomerOrder::class, 'checkout']);
Route::post('/customer/checkout', [CustomerOrder::class, 'processCheckout']);
Route::post('/customer/shipping/rates', [ShippingController::class, 'getRates']);

// Payment
Route::get('/customer/payment/{order}/select-gateway', [PaymentController::class, 'selectGateway']);
Route::get('/customer/payment/{order}', [PaymentController::class, 'show']);
Route::post('/customer/payment/{order}/process', [PaymentController::class, 'process']);
Route::get('/customer/payment/{order}/waiting', [PaymentController::class, 'waiting']);
Route::get('/customer/payment/{order}/check-status', [PaymentController::class, 'checkStatus']);

// Guest Order Tracking
Route::get('/customer/orders/{order}/track', [CustomerOrder::class, 'guestTrackOrder']);
Route::get('/customer/orders/{order}/guest-tracking', [CustomerOrder::class, 'guestGetTracking']);
```

### Controller Logic

**CartController - Session Cart untuk Guest:**
```php
public function add(Request $request, Product $product)
{
    if (auth()->check()) {
        // Save to database
        Cart::create([...]);
    } else {
        // Save to session
        $guestCart = session()->get('guest_cart', []);
        $guestCart[$key] = [
            'product_id' => $product->id,
            'variant_id' => $variantId,
            'quantity' => $quantity,
        ];
        session()->put('guest_cart', $guestCart);
    }
}
```

**OrderController - Create Guest User:**
```php
public function processCheckout(Request $request)
{
    if (!auth()->check()) {
        // Create or find guest user
        $guestUser = User::where('email', $validated['guest_email'])->first();
        
        if (!$guestUser) {
            $guestUser = User::create([
                'name' => $validated['guest_name'],
                'email' => $validated['guest_email'],
                'phone' => $validated['guest_phone'],
                'password' => bcrypt(Str::random(16)),
                'role' => 'customer',
                'is_active' => true,
                'is_guest' => true, // Mark as guest
            ]);
        }
        
        $userId = $guestUser->id;
        
        // Store in session for tracking
        session()->put('guest_user_id', $userId);
        
        // Store order ID for guest access
        $guestOrders = session()->get('guest_orders', []);
        $guestOrders[] = $order->id;
        session()->put('guest_orders', $guestOrders);
    }
}
```

**Guest Order Tracking:**
```php
public function guestTrackOrder(Order $order)
{
    $guestOrders = session()->get('guest_orders', []);
    
    if (!in_array($order->id, $guestOrders)) {
        abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
    }
    
    return view('customer.orders.guest-track', compact('order'));
}
```

## 🎯 User Flow

### 1. Browse & Add to Cart (Guest)
```
Customer → Browse Products → Add to Cart (no login required)
→ Cart stored in session
```

### 2. Checkout Process
```
Guest Cart → Checkout Page
→ Fill guest info (name, email, phone)
→ Fill shipping address
→ Calculate shipping cost
→ Review order
→ Submit checkout
→ Auto-create guest user
→ Create order
→ Store order ID in session
```

### 3. Payment
```
Order Created → Select Payment Gateway
→ Choose Paylabs/COD
→ Process payment
→ Redirect to payment page
→ Complete payment
→ Webhook updates order status
```

### 4. Order Tracking
```
Payment Success → Get tracking link
→ Access via session (no login)
→ View order details
→ Track shipping status
→ Real-time updates
```

## 🔐 Security

### Session-based Access Control
- Guest orders disimpan di session: `guest_orders` array
- Hanya order yang ada di session yang bisa diakses
- Session expired = akses hilang (encourage login)

### Guest User Management
- Email unik untuk setiap guest
- Password random (tidak bisa login)
- Flag `is_guest = true`
- Bisa di-convert ke regular user nanti

### Data Protection
- Guest tidak bisa akses dashboard customer
- Hanya bisa tracking via link langsung
- No access to other guest orders

## 📧 Email Notifications

Guest akan menerima email untuk:
- ✅ Order confirmation
- ✅ Payment instructions
- ✅ Shipping updates
- ✅ Delivery confirmation

Email berisi link tracking yang bisa diakses tanpa login.

## 🔄 Convert Guest to Regular User

Guest bisa upgrade ke regular account dengan:
1. Klik "Daftar" dari email tracking
2. Verifikasi email yang sama
3. Set password baru
4. Flag `is_guest` diubah ke `false`
5. Semua order history tetap tersimpan

## 📱 Frontend Integration

### Cart Counter (untuk guest)
```javascript
// Update cart count via AJAX
fetch('/customer/cart/count')
    .then(res => res.json())
    .then(data => {
        document.getElementById('cart-count').textContent = data.count;
    });
```

### Add to Cart (guest-friendly)
```javascript
// No login check required
fetch('/customer/cart/add/' + productId, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify({
        quantity: 1,
        variant_id: variantId
    })
});
```

## 🧪 Testing

### Test Guest Checkout Flow
```bash
# 1. Clear session
php artisan cache:clear

# 2. Browse as guest
# 3. Add products to cart
# 4. Proceed to checkout
# 5. Fill guest info
# 6. Complete payment
# 7. Track order via link
```

### Test Session Persistence
```bash
# Cart should persist across page reloads
# Order tracking should work until session expires
```

## 🚀 Migration

Jalankan migration:
```bash
php artisan migrate
```

## ⚠️ Important Notes

1. **Session Expiry**: Guest cart & order access hilang setelah session expired (default 2 hours)
2. **Email Required**: Guest harus provide email untuk order confirmation
3. **No Dashboard**: Guest tidak bisa akses customer dashboard
4. **Encourage Registration**: Tampilkan benefit registrasi di checkout page
5. **Welcome Bonus**: Guest tidak dapat welcome bonus (hanya registered users)

## 🎨 UI/UX Recommendations

### Checkout Page
- Tampilkan "Checkout as Guest" option yang jelas
- Highlight benefit registrasi (points, free grip, etc)
- Simple form untuk guest info
- Auto-fill dari session jika ada

### After Order
- Tampilkan tracking link yang jelas
- Email tracking link ke guest
- Encourage registration dengan benefit
- Show "Create Account" button

### Cart Page
- Show cart untuk guest & logged-in user
- Merge cart after login
- Clear indication of guest status

## 📊 Analytics

Track guest checkout metrics:
- Guest checkout conversion rate
- Guest to registered user conversion
- Average order value (guest vs registered)
- Payment method preference (guest)

## 🔮 Future Enhancements

- [ ] Guest order tracking via email + order number (no session)
- [ ] SMS notifications untuk guest
- [ ] Social login untuk quick checkout
- [ ] One-click checkout untuk returning guest
- [ ] Guest wishlist (session-based)

---

**Status**: ✅ Fully Implemented & Ready to Use

**Last Updated**: 10 Mei 2026
