# Fix: Missing Route for Courier Location

## Problem
```
RouteNotFoundException: Route [customer.orders.courier-location] not defined.
```

## Solution

### Added Route in routes/web.php

**Location:** Customer routes group

**Added:**
```php
Route::get('/orders/{order}/courier-location', [CustomerOrder::class, 'getCourierLocation'])
    ->name('orders.courier-location');
```

**Full Context:**
```php
Route::prefix('customer')->name('customer.')->middleware(['auth', 'customer'])->group(function () {
    // ... other routes
    
    // Order Tracking
    Route::get('/orders/{order}/tracking', [CustomerOrder::class, 'getTracking'])
        ->name('orders.tracking');
    Route::get('/orders/{order}/courier-location', [CustomerOrder::class, 'getCourierLocation'])
        ->name('orders.courier-location');
    
    // ... other routes
});
```

## Route Details

**Name:** `customer.orders.courier-location`
**URL:** `/customer/orders/{order}/courier-location`
**Method:** GET
**Controller:** `CustomerOrder::getCourierLocation`
**Middleware:** `auth`, `customer`

## Controller Method

The method already exists in `OrderController.php`:

```php
public function getCourierLocation(Order $order)
{
    // Check if user is the order owner
    if ($order->user_id !== auth()->id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // Only allow tracking when order is being delivered
    if (!in_array($order->status, [Order::STATUS_ON_DELIVERY])) {
        return response()->json([
            'success' => false,
            'message' => 'Tracking hanya tersedia saat pesanan sedang dikirim',
        ]);
    }

    // ... rest of the method
}
```

## Usage in Frontend

**JavaScript Fetch:**
```javascript
fetch('{{ route('customer.orders.courier-location', $order) }}')
    .then(response => response.json())
    .then(data => {
        if (data.success && data.location) {
            // Update courier marker position
            updateCourierMarker(data.location);
        }
    });
```

**Called Every 5 Seconds:**
```javascript
updateInterval = setInterval(updateCourierLocation, 5000);
```

## Response Format

```json
{
    "success": true,
    "location": {
        "latitude": -6.2088,
        "longitude": 106.8456,
        "accuracy": 10,
        "speed": 40,
        "heading": 180,
        "updated_at": "2024-01-01T10:00:00Z",
        "updated_ago": "5 seconds ago"
    },
    "destination": {
        "latitude": -6.2100,
        "longitude": 106.8470,
        "address": "Jl. Customer Address"
    },
    "store": {
    "latitude": -7.278417,
    "longitude": 112.632583
    },
    "courier": {
        "name": "John Doe",
        "phone": "081234567890",
        "avatar": "https://..."
    }
}
```

## Testing

**1. Check Route Exists:**
```bash
php artisan route:list | grep courier-location
```

**Expected Output:**
```
GET|HEAD  customer/orders/{order}/courier-location ... customer.orders.courier-location
```

**2. Test in Browser:**
```
http://localhost:8000/customer/orders/1/courier-location
```

**3. Test with JavaScript:**
Open order detail page and check browser console for fetch requests.

## Files Modified

1. ✅ `routes/web.php` - Added courier-location route

## Status

✅ **FIXED** - Route has been added successfully!

The error should now be resolved. The Google Maps tracking will work properly.
