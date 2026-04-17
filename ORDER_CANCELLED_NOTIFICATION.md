# Notifikasi Order Cancelled

## Overview
Sistem notifikasi otomatis ketika pesanan dibatalkan, baik oleh customer maupun sistem (auto-cancel expired orders).

## Fitur Notifikasi

### 1. Database Notification
- Notifikasi tersimpan di database (table `notifications`)
- Dapat dilihat di halaman `/admin/notifications` untuk admin
- Dapat dilihat di halaman customer notifications untuk customer

### 2. Push Notification (Admin Only)
- Real-time push notification untuk admin via WebPush
- Muncul sebagai browser notification
- Hanya untuk admin, customer tidak menerima push notification

## Implementasi

### OrderCancelledNotification Class

**Location:** `app/Notifications/OrderCancelledNotification.php`

**Constructor Parameters:**
```php
public function __construct(Order $order, string $cancelReason = null, float $refundAmount = null)
```

**Notification Data:**
```php
[
    'title' => '❌ Pesanan Dibatalkan', // Admin
    'title' => 'Pesanan Dibatalkan',   // Customer
    'message' => 'Pesanan #XXX dari Customer Name telah dibatalkan. Refund: Rp XXX',
    'order_id' => 1,
    'order_number' => 'ORD-20240101-0001',
    'cancel_reason' => 'Dibatalkan oleh customer',
    'refund_amount' => 100000,
    'refund_status' => 'completed',
    'type' => 'order_cancelled',
    'url' => '/admin/orders/1' // or '/customer/orders/1'
]
```

## Trigger Notifikasi

### 1. Customer Membatalkan Order

**Location:** `OrderController::cancel()`

**Flow:**
1. Customer klik "Batalkan Pesanan"
2. Sistem proses refund (jika perlu)
3. Restore stock
4. Cancel order
5. **Send notifications:**
   - Database notification ke semua admin
   - Database notification ke customer
   - Push notification ke semua admin

**Code:**
```php
// Notify admins
$admins = User::where('role', 'admin')->get();
if ($admins->isNotEmpty()) {
    Notification::send($admins, new OrderCancelledNotification($order, $reason, $refundAmount));
}

// Notify customer
auth()->user()->notify(new OrderCancelledNotification($order, $reason, $refundAmount));

// Push notification to admins
$webPush = app(WebPushService::class);
$webPush->sendToAdmins(
    '❌ Pesanan Dibatalkan',
    "Pesanan #{$order->order_number} dari {$order->user->name} telah dibatalkan - Refund: {$order->formatted_total}",
    route('admin.orders.show', $order),
    'order_cancelled'
);
```

### 2. Auto-Cancel Expired Orders

**Location:** `CancelExpiredOrders::handle()`

**Flow:**
1. Scheduled command berjalan setiap jam
2. Query orders dengan status pending_payment > 24 jam
3. Loop setiap expired order:
   - Update status ke cancelled
   - Restore stock
   - **Send notifications:**
     - Database notification ke semua admin
     - Database notification ke customer
   - Log activity

**Code:**
```php
// Notify admins
$admins = User::where('role', 'admin')->get();
if ($admins->isNotEmpty()) {
    Notification::send($admins, new OrderCancelledNotification(
        $order, 
        'Otomatis dibatalkan: Pembayaran tidak dilakukan dalam 24 jam',
        null
    ));
}

// Notify customer
if ($order->user) {
    $order->user->notify(new OrderCancelledNotification(
        $order,
        'Otomatis dibatalkan: Pembayaran tidak dilakukan dalam 24 jam',
        null
    ));
}
```

**Note:** Auto-cancel tidak mengirim push notification untuk menghindari spam.

## Notification Message Format

### Admin Notification

**Dengan Refund:**
```
❌ Pesanan Dibatalkan
Pesanan #ORD-20240101-0001 dari John Doe telah dibatalkan. Refund: Rp 150.000
```

**Tanpa Refund (COD/Belum Bayar):**
```
❌ Pesanan Dibatalkan
Pesanan #ORD-20240101-0001 dari John Doe telah dibatalkan
```

### Customer Notification

**Dengan Refund:**
```
Pesanan Dibatalkan
Pesanan #ORD-20240101-0001 telah dibatalkan. Dana Rp 150.000 akan dikembalikan dalam 1-3 hari kerja
```

**Tanpa Refund:**
```
Pesanan Dibatalkan
Pesanan #ORD-20240101-0001 telah dibatalkan
```

## Notification Display

### Admin Dashboard
- URL: `/admin/notifications`
- Menampilkan semua notifikasi termasuk order cancelled
- Badge merah dengan emoji ❌ untuk order cancelled
- Klik notifikasi redirect ke order detail page

### Customer Dashboard
- URL: `/customer/notifications` (jika ada)
- Menampilkan notifikasi customer
- Klik notifikasi redirect ke order detail page

## Database Schema

**Table:** `notifications`

```sql
id: uuid
type: App\Notifications\OrderCancelledNotification
notifiable_type: App\Models\User
notifiable_id: user_id
data: json {
    "title": "❌ Pesanan Dibatalkan",
    "message": "...",
    "order_id": 1,
    "order_number": "ORD-20240101-0001",
    "cancel_reason": "...",
    "refund_amount": 100000,
    "refund_status": "completed",
    "type": "order_cancelled",
    "url": "/admin/orders/1"
}
read_at: timestamp (nullable)
created_at: timestamp
updated_at: timestamp
```

## Testing

### Manual Cancel Test

1. Login sebagai customer
2. Buat order dan bayar (non-COD)
3. Tunggu status menjadi "processing"
4. Klik "Batalkan Pesanan"
5. Check notifikasi di `/admin/notifications`
6. Verify:
   - Admin menerima database notification
   - Admin menerima push notification
   - Customer menerima database notification
   - Notification message sesuai (dengan refund info)

### Auto-Cancel Test

1. Buat order tapi jangan bayar
2. Ubah `created_at` order menjadi > 24 jam yang lalu:
   ```php
   $order->update(['created_at' => now()->subHours(25)]);
   ```
3. Run command: `php artisan orders:cancel-expired`
4. Check notifikasi di `/admin/notifications`
5. Verify:
   - Admin menerima database notification
   - Customer menerima database notification
   - Notification message: "Otomatis dibatalkan: Pembayaran tidak dilakukan dalam 24 jam"

## Files Modified

1. **app/Notifications/OrderCancelledNotification.php** (NEW)
   - Notification class untuk order cancelled

2. **app/Http/Controllers/Customer/OrderController.php**
   - Added: Import OrderCancelledNotification
   - Updated: cancel() method - Send notifications setelah cancel order

3. **app/Console/Commands/CancelExpiredOrders.php**
   - Added: Import OrderCancelledNotification, User, Notification
   - Updated: handle() method - Send notifications setelah auto-cancel
   - Added: Stock restoration

## Benefits

✅ **Real-time Updates** - Admin langsung tahu ada order yang dibatalkan
✅ **Customer Informed** - Customer mendapat konfirmasi pembatalan
✅ **Refund Transparency** - Notifikasi mencantumkan info refund
✅ **Audit Trail** - Semua pembatalan tercatat di database
✅ **Auto-Cancel Notification** - Customer diberi tahu jika order expired
✅ **Push Notification** - Admin dapat notifikasi browser real-time

## Future Improvements

1. Email notification untuk order cancelled
2. SMS notification untuk customer
3. Notification preferences (customer bisa pilih channel)
4. Notification grouping (batch notifications)
5. Notification sound/vibration settings
