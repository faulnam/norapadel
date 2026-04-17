# Tracking Kurir dengan Leaflet + Routing Machine

## ✅ Yang Sudah Diimplementasikan

### 1. **Leaflet Map** (Pengganti Google Maps)
- OpenStreetMap tiles (gratis, no API key needed)
- Leaflet Routing Machine untuk rute mengikuti jalan
- Smooth animations dan real-time updates

### 2. **Icon Motor yang Bagus** 🏍️
**Design:**
- Gradient biru (#3B82F6 → #2563EB)
- Border putih 3px
- Shadow effect untuk depth
- Pulse animation
- SVG motor icon yang detail
- Shadow di bawah untuk efek 3D

**Features:**
- Size: 50x50px
- Smooth animation saat bergerak
- Z-index tinggi agar selalu di atas
- Popup info saat diklik

### 3. **Icon Toko & Tujuan**
**Toko (Hijau):**
- Gradient hijau dengan icon rumah
- Size: 40x40px

**Tujuan (Merah):**
- Pin merah dengan dot putih di tengah
- Size: 40x50px (lebih tinggi)

### 4. **Routing yang Mengikuti Jalan**
- Leaflet Routing Machine
- Rute biru (#3B82F6) dengan opacity 0.8
- Weight: 5px
- Otomatis calculate jarak dan waktu
- Hide routing instructions panel

### 5. **Real-time Movement**
- Update setiap 3 detik
- Smooth animation 30 steps
- Progress percentage display
- Auto-fit bounds untuk semua markers

## 📦 Dependencies

### CDN yang Digunakan:
```html
<!-- Leaflet Core -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Leaflet Routing Machine -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
```

## 🎨 Icon Design

### Motor Icon
```javascript
const motorIcon = L.divIcon({
    html: `
        <div class="courier-marker">
            <!-- Gradient blue circle -->
            <div style="background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); 
                        border-radius: 50%; 
                        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4); 
                        border: 3px solid white;">
                <!-- SVG motorcycle icon -->
                <svg>...</svg>
            </div>
            <!-- Shadow effect -->
            <div style="background: rgba(59, 130, 246, 0.2); 
                        width: 40px; 
                        height: 8px; 
                        border-radius: 50%; 
                        filter: blur(4px);"></div>
        </div>
    `,
    iconSize: [50, 50],
    iconAnchor: [25, 25]
});
```

## 🛣️ Routing Features

### Leaflet Routing Machine
```javascript
L.Routing.control({
    waypoints: [origin, destination],
    routeWhileDragging: false,
    addWaypoints: false,
    draggableWaypoints: false,
    lineOptions: {
        styles: [{
            color: '#3B82F6',
            opacity: 0.8,
            weight: 5
        }]
    },
    createMarker: function() { return null; } // Hide default markers
}).addTo(map);
```

### Route Info Display
- Jarak: X.X km
- Waktu: XX menit
- Update otomatis saat rute berubah

## 🎯 Cara Testing

### 1. Ubah Status Order
```sql
UPDATE orders SET status = 'shipped' WHERE id = 1;
```

### 2. Buka Order Detail
```
http://127.0.0.1:8000/customer/orders/1
```

### 3. Yang Akan Terlihat
- ✅ Peta Leaflet dengan OpenStreetMap
- ✅ Icon motor biru dengan gradient dan shadow
- ✅ Icon toko hijau
- ✅ Icon pin merah untuk tujuan
- ✅ Rute biru mengikuti jalan
- ✅ Motor bergerak smooth setiap 3 detik
- ✅ Progress: "Simulasi: Kurir 45.5% menuju tujuan"
- ✅ Jarak dan waktu ditampilkan

## ⚡ Performance

### Update Interval
- **3 seconds** (lebih cepat dari sebelumnya untuk gerakan lebih smooth)

### Animation
- **30 steps** × 100ms = 3 seconds total
- Smooth interpolation antara posisi

### Auto-fit Bounds
- Padding: 50px
- Menampilkan semua markers dalam view

## 🎨 CSS Customization

### Hide Routing Instructions
```css
.leaflet-routing-container {
    display: none;
}
```

### Pulse Animation
```css
@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.05); opacity: 0.9; }
}

.courier-marker {
    animation: pulse 2s ease-in-out infinite;
}
```

## 🆚 Leaflet vs Google Maps

| Feature | Leaflet | Google Maps |
|---------|---------|-------------|
| **Cost** | ✅ FREE | ❌ Paid (after quota) |
| **API Key** | ✅ Not needed | ❌ Required |
| **Routing** | ✅ Via plugin | ✅ Built-in |
| **Customization** | ✅ Full control | ⚠️ Limited |
| **Icon Design** | ✅ HTML/CSS/SVG | ⚠️ Limited |
| **File Size** | ✅ Lightweight | ❌ Heavy |
| **Offline** | ✅ Possible | ❌ No |

## 🚀 Advantages

✅ **No API Key Required** - Gratis selamanya
✅ **Beautiful Motor Icon** - Gradient, shadow, pulse animation
✅ **Follows Roads** - Routing machine untuk rute real
✅ **Smooth Movement** - 30 steps animation
✅ **Real-time Updates** - Setiap 3 detik
✅ **Progress Tracking** - Percentage display
✅ **Lightweight** - Lebih ringan dari Google Maps
✅ **Full Customization** - HTML/CSS untuk icons

## 📝 Files Modified

1. ✅ `resources/views/customer/orders/show.blade.php`
   - Added Leaflet + Routing Machine CDN
   - Created beautiful motor icon with gradient
   - Implemented routing that follows roads
   - Added smooth animations
   - Added progress display

2. ✅ `app/Http/Controllers/Customer/OrderController.php`
   - Already has simulation logic (no changes needed)

3. ✅ `routes/web.php`
   - Already has courier-location route (no changes needed)

## 🎉 Result

Tracking kurir sekarang menggunakan:
- 🗺️ **Leaflet** (gratis, no API key)
- 🏍️ **Icon motor yang bagus** (gradient biru dengan shadow)
- 🛣️ **Rute mengikuti jalan** (Leaflet Routing Machine)
- ⚡ **Real-time smooth movement** (update setiap 3 detik)
- 📊 **Progress tracking** (percentage display)

Seperti Shopee, tapi lebih bagus! 🚀
