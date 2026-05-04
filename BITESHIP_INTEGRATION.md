# Integrasi API Biteship - Sistem Perhitungan Ongkir Real-Time

## Overview
Sistem perhitungan ongkir dan estimasi pengiriman menggunakan API Biteship dengan grouping dan labeling seperti Tokopedia/Shopee.

---

## 1. Konfigurasi

### File: `.env`
```env
BITESHIP_API_KEY=biteship_test.your_api_key_here
BITESHIP_SANDBOX=true
BITESHIP_BASE_URL=https://api.biteship.com/v1
```

### File: `config/biteship.php`
```php
return [
    'api_key' => env('BITESHIP_API_KEY'),
    'sandbox' => env('BITESHIP_SANDBOX', true),
    'base_url' => env('BITESHIP_BASE_URL', 'https://api.biteship.com/v1'),
    
    'origin' => [
        'postal_code' => '60119',
    'latitude' => -7.278417,
    'longitude' => 112.632583,
    ],
];
```

---

## 2. Service Layer

### File: `app/Services/BiteshipService.php`

Method utama: `getRatesFromAPI()`

**Request ke Biteship:**
```php
POST https://api.biteship.com/v1/rates/couriers

Headers:
- authorization: {API_KEY}
- content-type: application/json

Body:
{
    "origin_postal_code": "60119",
    "destination_postal_code": "61219",
    "couriers": "jne,jnt,anteraja,gojek,grab,paxel",
    "items": [
        {
            "name": "Raket Padel",
            "value": 500000,
            "weight": 800,
            "quantity": 1
        }
    ]
}
```

**Response Processing:**
```php
// Raw response dari Biteship
{
    "pricing": [
        {
            "courier_code": "jnt",
            "courier_name": "J&T Express",
            "courier_service_name": "EZ (Reguler)",
            "duration": "2-3",
            "price": 12000
        },
        {
            "courier_code": "gosend",
            "courier_name": "GoSend",
            "courier_service_name": "Instant",
            "duration": "1-2 hours",
            "price": 25000
        }
    ]
}

// Setelah diproses oleh formatRates()
{
    "instant": [
        {
            "courier_code": "gosend",
            "courier_name": "GoSend",
            "courier_service_name": "Instant",
            "service_type": "instant",
            "price": 25000,
            "duration": "1-3 jam",
            "duration_minutes": 180,
            "is_cheapest": false,
            "is_fastest": true
        }
    ],
    "sameday": [
        {
            "courier_code": "paxel",
            "courier_name": "Paxel",
            "courier_service_name": "Same Day",
            "service_type": "sameday",
            "price": 18000,
            "duration": "6-8 jam (hari yang sama)",
            "duration_minutes": 480,
            "is_cheapest": false,
            "is_fastest": false
        }
    ],
    "regular": [
        {
            "courier_code": "jnt",
            "courier_name": "J&T Express",
            "courier_service_name": "EZ (Reguler)",
            "service_type": "regular",
            "price": 12000,
            "duration": "2-3 hari",
            "duration_minutes": 3600,
            "is_cheapest": true,
            "is_fastest": false
        }
    ]
}
```

---

## 3. Controller

### File: `app/Http/Controllers/Customer/ShippingController.php`

**Endpoint:** `POST /customer/shipping/rates`

**Request:**
```json
{
    "destination_postal_code": "61219",
    "destination_latitude": -7.278417,
    "destination_longitude": 112.632583
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "instant": [...],
        "sameday": [...],
        "regular": [...]
    }
}
```

---

## 4. Frontend Implementation

### File: `resources/views/customer/orders/checkout.blade.php`

**HTML Structure:**
```html
<!-- Instant Couriers -->
<div class="courier-group">
    <h4>⚡ Instant (1-3 jam)</h4>
    <div class="courier-list">
        <label class="courier-option">
            <input type="radio" name="courier" value="gosend|instant|25000">
            <div class="courier-info">
                <img src="/img/gosend.png" alt="GoSend">
                <div>
                    <strong>GoSend Instant</strong>
                    <span class="badge fastest">Tercepat</span>
                    <p>1-3 jam</p>
                </div>
            </div>
            <div class="courier-price">Rp 25.000</div>
        </label>
    </div>
</div>

<!-- Same Day Couriers -->
<div class="courier-group">
    <h4>📦 Same Day (Hari Ini)</h4>
    <div class="courier-list">
        <label class="courier-option">
            <input type="radio" name="courier" value="paxel|sameday|18000">
            <div class="courier-info">
                <img src="/img/paxel.png" alt="Paxel">
                <div>
                    <strong>Paxel Same Day</strong>
                    <p>6-8 jam (hari yang sama)</p>
                </div>
            </div>
            <div class="courier-price">Rp 18.000</div>
        </label>
    </div>
</div>

<!-- Regular Couriers -->
<div class="courier-group">
    <h4>🚚 Reguler (2-4 hari)</h4>
    <div class="courier-list">
        <label class="courier-option">
            <input type="radio" name="courier" value="jnt|regular|12000">
            <div class="courier-info">
                <img src="/img/jnt.png" alt="J&T">
                <div>
                    <strong>J&T Express - EZ</strong>
                    <span class="badge cheapest">Termurah</span>
                    <p>2-3 hari</p>
                </div>
            </div>
            <div class="courier-price">Rp 12.000</div>
        </label>
    </div>
</div>
```

**JavaScript:**
```javascript
// Fetch shipping rates
async function loadShippingRates() {
    const response = await fetch('/customer/shipping/rates', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            destination_postal_code: document.getElementById('postal_code').value,
            destination_latitude: latitude,
            destination_longitude: longitude
        })
    });
    
    const result = await response.json();
    
    if (result.success) {
        renderCouriers(result.data);
    }
}

function renderCouriers(data) {
    const container = document.getElementById('courier-options');
    container.innerHTML = '';
    
    // Render Instant
    if (data.instant.length > 0) {
        container.innerHTML += renderGroup('⚡ Instant (1-3 jam)', data.instant);
    }
    
    // Render Same Day
    if (data.sameday.length > 0) {
        container.innerHTML += renderGroup('📦 Same Day (Hari Ini)', data.sameday);
    }
    
    // Render Regular
    if (data.regular.length > 0) {
        container.innerHTML += renderGroup('🚚 Reguler (2-4 hari)', data.regular);
    }
}

function renderGroup(title, couriers) {
    let html = `<div class="courier-group"><h4>${title}</h4><div class="courier-list">`;
    
    couriers.forEach(courier => {
        const badges = [];
        if (courier.is_cheapest) badges.push('<span class="badge cheapest">Termurah</span>');
        if (courier.is_fastest) badges.push('<span class="badge fastest">Tercepat</span>');
        
        html += `
            <label class="courier-option">
                <input type="radio" name="courier" 
                       value="${courier.courier_code}|${courier.service_type}|${courier.price}"
                       data-courier-code="${courier.courier_code}"
                       data-courier-name="${courier.courier_name}"
                       data-service-name="${courier.courier_service_name}"
                       data-price="${courier.price}">
                <div class="courier-info">
                    <img src="/img/couriers/${courier.courier_code}.png" alt="${courier.courier_name}">
                    <div>
                        <strong>${courier.courier_name} - ${courier.courier_service_name}</strong>
                        ${badges.join(' ')}
                        <p>${courier.duration}</p>
                    </div>
                </div>
                <div class="courier-price">Rp ${formatPrice(courier.price)}</div>
            </label>
        `;
    });
    
    html += '</div></div>';
    return html;
}

function formatPrice(price) {
    return new Intl.NumberFormat('id-ID').format(price);
}
```

---

## 5. Logic Mapping

### Kategori Layanan:
```php
private function determineCategory(string $courierCode, string $serviceName): string
{
    // Instant: GoSend, GrabExpress
    if (in_array(strtolower($courierCode), ['gojek', 'gosend', 'grab', 'grabexpress'])) {
        if (stripos($serviceName, 'same day') !== false) {
            return 'sameday';
        }
        return 'instant';
    }
    
    // Same Day: Service name contains "same day"
    if (stripos($serviceName, 'same day') !== false) {
        return 'sameday';
    }
    
    // Default: Regular
    return 'regular';
}
```

### Format Estimasi:
```php
private function formatETD(string $duration, string $category): string
{
    if ($category === 'instant') {
        return '1-3 jam';
    }
    
    if ($category === 'sameday') {
        return '6-8 jam (hari yang sama)';
    }
    
    // Parse "2-3" atau "1-2 days"
    if (preg_match('/(\d+)-(\d+)/', $duration, $matches)) {
        return $matches[1] . '-' . $matches[2] . ' hari';
    }
    
    return $duration ?: '2-3 hari';
}
```

---

## 6. Sorting & Labeling

### Sorting:
```php
usort($rates, function($a, $b) {
    // Sort by price first, then by duration
    if ($a['price'] === $b['price']) {
        return $a['duration_minutes'] <=> $b['duration_minutes'];
    }
    return $a['price'] <=> $b['price'];
});
```

### Labeling:
```php
$cheapest = min(array_column($allRates, 'price'));
$fastest = min(array_column($allRates, 'duration_minutes'));

foreach ($rates as $index => $rate) {
    $rates[$index]['is_cheapest'] = ($rate['price'] === $cheapest);
    $rates[$index]['is_fastest'] = ($rate['duration_minutes'] === $fastest);
}
```

---

## 7. Error Handling

```php
try {
    $result = $this->biteship->getRatesFromAPI($params);
    
    if (!$result['success']) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal mengambil data ongkir. Silakan coba lagi.'
        ], 400);
    }
    
    return response()->json($result);
    
} catch (\Exception $e) {
    Log::error('Shipping rates error: ' . $e->getMessage());
    
    return response()->json([
        'success' => false,
        'message' => 'Terjadi kesalahan sistem. Silakan hubungi admin.'
    ], 500);
}
```

---

## 8. Testing

### Test dengan Postman:
```bash
POST http://127.0.0.1:8000/customer/shipping/rates
Content-Type: application/json

{
    "destination_postal_code": "61219"
}
```

### Expected Response:
```json
{
    "success": true,
    "data": {
        "instant": [
            {
                "courier_code": "gosend",
                "courier_name": "GoSend",
                "courier_service_name": "Instant",
                "service_type": "instant",
                "price": 25000,
                "duration": "1-3 jam",
                "duration_minutes": 180,
                "is_cheapest": false,
                "is_fastest": true
            }
        ],
        "sameday": [...],
        "regular": [...]
    }
}
```

---

## 9. Production Checklist

- [ ] Set `BITESHIP_SANDBOX=false` di `.env`
- [ ] Gunakan API key production dari Biteship
- [ ] Test dengan kode pos real
- [ ] Validasi semua kurir tersedia
- [ ] Monitor error logs
- [ ] Setup webhook untuk tracking updates
- [ ] Backup plan jika API down (fallback ke mock)

---

## 10. Fitur Tambahan

### Auto-select termurah:
```javascript
// Auto-select cheapest option on load
const cheapestOption = document.querySelector('input[name="courier"][data-is-cheapest="true"]');
if (cheapestOption) {
    cheapestOption.checked = true;
    updateShippingCost(cheapestOption.dataset.price);
}
```

### Loading state:
```javascript
function showLoading() {
    document.getElementById('courier-options').innerHTML = `
        <div class="loading-state">
            <i class="fas fa-spinner fa-spin"></i>
            <p>Mencari kurir terbaik untuk Anda...</p>
        </div>
    `;
}
```

### Empty state:
```javascript
function showEmptyState() {
    document.getElementById('courier-options').innerHTML = `
        <div class="empty-state">
            <i class="fas fa-exclamation-circle"></i>
            <p>Tidak ada kurir tersedia untuk alamat ini</p>
            <small>Silakan coba alamat lain atau hubungi customer service</small>
        </div>
    `;
}
```

---

## Support

Untuk pertanyaan atau issue, hubungi:
- Email: support@norapadel.id
- WhatsApp: +62 812 7788 9900
