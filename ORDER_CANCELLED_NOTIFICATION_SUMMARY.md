# Summary: Notifikasi Order Cancelled

## Changes Made

### 1. OrderCancelledNotification.php (NEW)
**Created:** `app/Notifications/OrderCancelledNotification.php`

**Features:**
- Database notification untuk admin dan customer
- Differentiated message untuk admin vs customer
- Include refund information jika ada
- Include cancel reason
- Auto-redirect URL ke order detail page

**Data Structure:**
```php
[
    'title' => '❌ Pesanan Dibatalkan',
    'message' => 'Pesanan #XXX dari Customer telah dibatalkan. Refund: Rp XXX',
    'order_id' => 1,
    'order_number' => 'ORD-XXX',
    'cancel_reason' => 'Dibatalkan oleh customer',
    'refund_amount' => 100000,
    'refund_status' => 'completed',
    'type' => 'order_cancelled',
    'url' => '/admin/orders/1'
]
```

### 2. OrderController.php
**Updated:** `cancel()` method

**Added Notifications:**
- Database notification ke semua admin
- Database notification ke customer
- Push notification ke admin (via WebPushService)

**Code Added:**
```php
// Notify admins
$admins = User::where('role', 'admin')->get();
Notification::send($admins, new OrderCancelledNotification($order, $reason, $refundAmount));

// Notify customer
auth()->user()->notify(new OrderCancelledNotification($order, $reason, $refundAmount));

// Push notification to admins
$webPush->sendToAdmins('❌ Pesanan Dibatalkan', $message, $url, 'order_cancelled');
```

### 3. CancelExpiredOrders.php
**Updated:** `handle()` method

**Added:**
- Stock restoration untuk expired orders
- Database notification ke admin dan customer
- No push notification (avoid spam)

**Code Added:**
```php
// Restore stock
foreach ($order->items as $item) {
    if ($item->product) {
        $item->product->restoreStock($item->quantity);
    }
}

// Notify admins and customer
Notification::send($admins, new OrderCancelledNotification(...));
$order->user->notify(new OrderCancelledNotification(...));
```

## Notification Triggers

### 1. Customer Cancel Order
✅ Database notification → Admin & Customer
✅ Push notification → Admin only
✅ Include refund info (jika ada)
✅ Cancel reason: "Dibatalkan oleh customer"

### 2. Auto-Cancel Expired Orders
✅ Database notification → Admin & Customer
❌ No push notification (avoid spam)
❌ No refund (belum bayar)
✅ Cancel reason: "Otomatis dibatalkan: Pembayaran tidak dilakukan dalam 24 jam"

## Notification Messages

**Admin (dengan refund):**
```
❌ Pesanan Dibatalkan
Pesanan #ORD-20240101-0001 dari John Doe telah dibatalkan. Refund: Rp 150.000
```

**Customer (dengan refund):**
```
Pesanan Dibatalkan
Pesanan #ORD-20240101-0001 telah dibatalkan. Dana Rp 150.000 akan dikembalikan dalam 1-3 hari kerja
```

**Auto-Cancel (tanpa refund):**
```
Pesanan Dibatalkan
Pesanan #ORD-20240101-0001 telah dibatalkan
Alasan: Otomatis dibatalkan: Pembayaran tidak dilakukan dalam 24 jam
```

## Where to View

**Admin:**
- URL: `http://127.0.0.1:8000/admin/notifications`
- Badge merah dengan emoji ❌
- Klik untuk ke order detail

**Customer:**
- URL: Customer notification page (jika ada)
- Klik untuk ke order detail

## Key Features

✅ **Real-time Notification** - Admin langsung tahu ada pembatalan
✅ **Refund Transparency** - Info refund jelas di notifikasi
✅ **Stock Restoration** - Stock otomatis dikembalikan
✅ **Audit Trail** - Semua pembatalan tercatat
✅ **Push Notification** - Browser notification untuk admin
✅ **Auto-Cancel Support** - Notifikasi untuk expired orders

## Files Modified

1. `app/Notifications/OrderCancelledNotification.php` - NEW notification class
2. `app/Http/Controllers/Customer/OrderController.php` - Added notifications in cancel()
3. `app/Console/Commands/CancelExpiredOrders.php` - Added notifications and stock restoration
4. `ORDER_CANCELLED_NOTIFICATION.md` - Comprehensive documentation
5. `ORDER_CANCELLED_NOTIFICATION_SUMMARY.md` - This summary

## Testing

**Manual Test:**
1. Login customer → Buat order → Bayar → Cancel
2. Check `/admin/notifications` → Should see notification with refund info
3. Check browser notification (admin) → Should popup

**Auto-Cancel Test:**
1. Buat order → Jangan bayar
2. Update created_at > 24 jam: `$order->update(['created_at' => now()->subHours(25)]);`
3. Run: `php artisan orders:cancel-expired`
4. Check `/admin/notifications` → Should see auto-cancel notification

Done! 🎉
