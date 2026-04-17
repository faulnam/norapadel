# Debug Shipping Rates

## Test API Endpoint

Buka browser console (F12) dan jalankan:

```javascript
fetch('/customer/shipping/rates', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
        destination_latitude: -7.2575,
        destination_longitude: 112.7521
    })
})
.then(r => r.json())
.then(data => console.log('Response:', data))
.catch(err => console.error('Error:', err));
```

## Expected Response Format

```json
{
    "success": true,
    "rates": [
        {
            "courier_code": "jnt",
            "courier_name": "J&T Express",
            "courier_service_name": "EZ (Reguler)",
            "service_type": "regular",
            "duration": "2-4 hari",
            "duration_minutes": 2880,
            "price": 12000,
            "weight_kg": 1,
            "distance_km": 15.5,
            "zone": "same_city"
        }
    ]
}
```

## Common Issues

### 1. Empty rates array
**Cause:** Cart is empty or no items
**Solution:** Add items to cart first

### 2. "Tidak ada ekspedisi tersedia"
**Cause:** Response format mismatch
**Solution:** Check console.log output

### 3. API returns error
**Cause:** Invalid coordinates or missing data
**Solution:** Ensure lat/lng are valid numbers

## Manual Test

1. Login sebagai customer
2. Add product to cart
3. Go to checkout
4. Click on map to set location
5. Check browser console for logs
6. Should see courier options appear

## Debug Steps

1. Check if cart has items:
```sql
SELECT * FROM carts WHERE user_id = YOUR_USER_ID;
```

2. Check if products have weight:
```sql
SELECT id, name, weight FROM products;
```

3. Test shipping service directly:
```php
$biteship = app(\App\Services\BiteshipService::class);
$result = $biteship->getRates([
    'destination_latitude' => -7.2575,
    'destination_longitude' => 112.7521,
    'items' => [
        [
            'name' => 'Test Product',
            'value' => 100000,
            'weight' => 500,
            'quantity' => 1
        ]
    ]
]);
dd($result);
```
