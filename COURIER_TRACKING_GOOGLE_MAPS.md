# Real-time Courier Tracking dengan Google Maps

## Overview
Sistem tracking kurir real-time menggunakan Google Maps API dengan icon motor, rute yang mengikuti jalan, dan update posisi otomatis setiap 5 detik.

## Fitur Utama

### 1. Icon Motor untuk Kurir
- Custom SVG icon berbentuk motor dengan warna biru
- Animasi smooth saat berpindah posisi
- Pulse effect untuk menunjukkan status aktif
- Info window dengan detail kurir (nama, kendaraan, plat nomor)

### 2. Rute Mengikuti Jalan
- Menggunakan Google Maps Directions API
- Rute otomatis mengikuti jalan yang sebenarnya
- Polyline berwarna biru dengan opacity 0.8
- Menampilkan jarak dan estimasi waktu tempuh

### 3. Real-time Updates
- Update posisi kurir setiap 5 detik
- Smooth animation saat marker berpindah
- Auto-adjust map bounds untuk menampilkan semua marker
- Live tracking indicator dengan dot animasi

### 4. Multiple Markers
- **Motor Icon (Biru)**: Posisi kurir saat ini
- **Red Marker**: Alamat tujuan customer
- **Green Marker**: Lokasi toko
- Semua marker memiliki info window dengan detail lengkap

## Implementasi Teknis

### Google Maps API Setup

**1. Get API Key:**
- Buka [Google Cloud Console](https://console.cloud.google.com/)
- Create new project atau pilih existing project
- Enable APIs:
  - Maps JavaScript API
  - Directions API
  - Geometry API
- Create credentials → API Key
- (Optional) Restrict API key untuk keamanan

**2. Add to .env:**
```env
GOOGLE_MAPS_API_KEY=your_google_maps_api_key_here
```

**3. Config services.php:**
```php
'google_maps' => [
    'api_key' => env('GOOGLE_MAPS_API_KEY'),
],
```

### Frontend Implementation

**Load Google Maps API:**
```html
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=geometry"></script>
```

**Map Container:**
```html
<div id="courierMap" style="height: 450px; border-radius: 1rem;"></div>
```

### JavaScript Functions

#### 1. initMap()
Initialize Google Maps dengan:
- Center pada alamat tujuan
- Zoom level 14
- Custom map styles (hide POI labels)
- Create markers untuk toko, tujuan, dan kurir
- Setup Directions Service & Renderer

#### 2. updateCourierLocation()
Fetch posisi kurir dari backend:
```javascript
fetch('/customer/orders/{order}/courier-location')
    .then(response => response.json())
    .then(data => {
        // Update courier marker position
        // Calculate route
        // Adjust map bounds
    });
```

**Update Interval:** 5 detik (5000ms)

#### 3. calculateRoute()
Calculate rute dari posisi kurir ke tujuan:
```javascript
directionsService.route({
    origin: courierPosition,
    destination: customerAddress,
    travelMode: google.maps.TravelMode.DRIVING,
    optimizeWaypoints: true
}, callback);
```

**Output:**
- Polyline rute di peta
- Jarak tempuh (km)
- Estimasi waktu (menit)

#### 4. animateMarker()
Smooth animation saat marker berpindah:
- 50 steps animation
- 100ms delay per step
- Linear interpolation untuk lat/lng

### Motor Icon SVG

Custom SVG icon dengan:
- Size: 48x48 pixels
- Background: Blue circle (#3B82F6)
- Icon: White motorcycle symbol
- Shadow effect untuk depth
- Anchor point di center (24, 24)

```javascript
const motorIconSVG = `
<svg width="48" height="48" viewBox="0 0 48 48">
    <circle cx="24" cy="24" r="20" fill="#3B82F6"/>
    <circle cx="24" cy="24" r="18" fill="#2563EB"/>
    <path d="..." fill="white"/> <!-- Motor shape -->
    <circle cx="24" cy="24" r="4" fill="white"/>
</svg>
`;
```

### Backend API Endpoint

**Route:**
```php
Route::get('/customer/orders/{order}/courier-location', [OrderController::class, 'getCourierLocation'])
    ->name('customer.orders.courier-location');
```

**Response:**
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
        "latitude": -7.4674,
        "longitude": 112.5274
    },
    "courier": {
        "name": "John Doe",
        "phone": "081234567890",
        "avatar": "https://..."
    }
}
```

## UI Components

### Map Container
```html
<div class="rounded-2xl bg-white p-6 shadow-sm">
    <div class="flex items-center justify-between mb-4">
        <h3>Lacak Posisi Kurir</h3>
        <div class="flex items-center gap-2 text-xs text-emerald-600">
            <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
            <span>Live Tracking</span>
        </div>
    </div>
    <div id="courierMap"></div>
</div>
```

### Legend
```html
<div class="grid grid-cols-2 gap-3 text-xs">
    <div class="flex items-center gap-2 bg-blue-50 rounded-lg p-2">
        <i class="fas fa-motorcycle text-blue-600"></i>
        <span>Posisi Kurir</span>
    </div>
    <div class="flex items-center gap-2 bg-red-50 rounded-lg p-2">
        <i class="fas fa-map-marker-alt text-red-600"></i>
        <span>Tujuan Anda</span>
    </div>
    <div class="flex items-center gap-2 bg-emerald-50 rounded-lg p-2">
        <i class="fas fa-store text-emerald-600"></i>
        <span>Toko</span>
    </div>
    <div class="flex items-center gap-2 bg-purple-50 rounded-lg p-2">
        <i class="fas fa-route text-purple-600"></i>
        <span id="distanceInfo">Menghitung...</span>
    </div>
</div>
```

### Loading State
```html
<div id="mapLoader" class="absolute inset-0 flex items-center justify-center bg-zinc-100 rounded-xl z-10">
    <div class="text-center">
        <i class="fas fa-spinner fa-spin text-3xl text-zinc-400 mb-2"></i>
        <p class="text-sm text-zinc-600">Memuat peta...</p>
    </div>
</div>
```

## Info Windows

### Courier Info Window
```javascript
const courierInfoWindow = new google.maps.InfoWindow({
    content: `
        <div style="padding: 10px;">
            <div style="font-weight: 600;">🏍️ ${courierName}</div>
            <div style="font-size: 12px; color: #666;">${courierService}</div>
            <div style="font-size: 11px; color: #888;">${vehicle} - ${plateNumber}</div>
            <div style="font-size: 10px; color: #10B981; margin-top: 4px;">● Sedang menuju lokasi Anda</div>
        </div>
    `
});
```

### Destination Info Window
```javascript
const destinationInfoWindow = new google.maps.InfoWindow({
    content: `
        <div style="padding: 8px; max-width: 250px;">
            <div style="font-weight: 600;">📍 Alamat Tujuan</div>
            <div style="font-size: 12px; color: #666;">${customerName}</div>
            <div style="font-size: 11px; color: #888;">${address}</div>
        </div>
    `
});
```

### Store Info Window
```javascript
const storeInfoWindow = new google.maps.InfoWindow({
    content: `
        <div style="padding: 8px;">
            <div style="font-weight: 600;">🏪 Toko</div>
            <div style="font-size: 12px; color: #666;">${storeName}</div>
        </div>
    `
});
```

## Performance Optimization

### 1. Update Interval
- Default: 5 seconds (5000ms)
- Adjustable berdasarkan kebutuhan
- Cleanup interval on page unload

### 2. Smooth Animation
- 50 steps untuk smooth transition
- 100ms delay per step
- Total animation time: 5 seconds

### 3. Map Bounds
- Auto-adjust untuk menampilkan semua marker
- Max zoom: 16 (untuk better view)
- Padding: 50px dari edge

### 4. API Optimization
- Cache directions result
- Only recalculate when position changes significantly
- Use geometry library untuk distance calculation

## Security

### 1. API Key Restriction
**Application restrictions:**
- HTTP referrers (websites)
- Add your domain: `yourdomain.com/*`

**API restrictions:**
- Restrict key to specific APIs:
  - Maps JavaScript API
  - Directions API
  - Geometry API

### 2. Backend Validation
- Check user authorization
- Validate order ownership
- Only show tracking for active deliveries

## Error Handling

### 1. Location Not Available
```javascript
if (!data.success) {
    console.log('Courier location not available:', data.message);
    // Show message to user
}
```

### 2. Directions API Error
```javascript
if (status !== google.maps.DirectionsStatus.OK) {
    console.error('Directions request failed:', status);
    // Fallback to straight line
}
```

### 3. Network Error
```javascript
fetch(url)
    .catch(error => {
        console.error('Error fetching courier location:', error);
        // Retry or show error message
    });
```

## Testing

### 1. Development Mode
- Use mock courier location
- Simulate movement dengan random offset
- Test animation dan route calculation

### 2. Production Mode
- Real GPS data dari courier app
- Update setiap 5 detik
- Monitor API usage dan costs

## Cost Estimation

**Google Maps API Pricing:**
- Maps JavaScript API: $7 per 1,000 loads
- Directions API: $5 per 1,000 requests
- Free tier: $200 credit per month

**Example:**
- 100 active deliveries per day
- 5 second updates = 720 updates per hour
- 1 hour average delivery time
- Total: 72,000 requests per day
- Cost: ~$360 per day

**Optimization:**
- Increase update interval to 10-15 seconds
- Only track during active delivery
- Cache directions result

## Browser Compatibility

✅ Chrome 90+
✅ Firefox 88+
✅ Safari 14+
✅ Edge 90+
✅ Mobile browsers (iOS Safari, Chrome Mobile)

## Future Improvements

1. **ETA Calculation** - Real-time ETA based on traffic
2. **Traffic Layer** - Show traffic conditions on map
3. **Multiple Waypoints** - Support multiple delivery stops
4. **Offline Mode** - Cache last known position
5. **Push Notifications** - Notify when courier is nearby
6. **Street View** - Show street view of destination
7. **Route History** - Show courier's path history
8. **Speed Indicator** - Show courier's current speed
9. **Geofencing** - Alert when courier enters delivery zone
10. **Dark Mode** - Dark theme for map

## Troubleshooting

### Map Not Loading
- Check API key validity
- Verify API is enabled in Google Cloud Console
- Check browser console for errors
- Verify domain is whitelisted

### Marker Not Moving
- Check backend API response
- Verify location data format
- Check update interval is running
- Verify courier has active location

### Route Not Showing
- Check Directions API is enabled
- Verify origin and destination coordinates
- Check API quota limits
- Verify network connectivity

## Files Modified

1. **resources/views/customer/orders/show.blade.php**
   - Replaced Leaflet with Google Maps
   - Added motor icon SVG
   - Implemented real-time tracking
   - Added route calculation
   - Added smooth animations

2. **config/services.php**
   - Added google_maps configuration

3. **COURIER_TRACKING_GOOGLE_MAPS.md**
   - This documentation file

## Environment Variables

Add to `.env`:
```env
GOOGLE_MAPS_API_KEY=your_api_key_here
```

## Dependencies

- Google Maps JavaScript API
- Google Maps Directions API
- Google Maps Geometry Library
- Font Awesome (for icons)
- Tailwind CSS (for styling)

Done! 🚀
