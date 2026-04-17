# Sistem Checkout dengan Estimasi Tanggal - Implementasi Lengkap

## ✅ Yang Sudah Diimplementasikan

### 1. EstimationHelper (app/Helpers/EstimationHelper.php)
- ✅ Deteksi zona (same_city, same_province, same_island, different_island)
- ✅ Adjust ETD berdasarkan zona
- ✅ Konversi hari ke tanggal (format: "16 – 18 April")
- ✅ Format ETD text (1-3 jam, 6-8 jam, 2-3 hari)
- ✅ Filter layanan berdasarkan zona
- ✅ Label zona

### 2. ShippingController (Updated)
- ✅ Integrasi dengan EstimationHelper
- ✅ Filter instant/sameday untuk jarak jauh
- ✅ Adjust ETD otomatis
- ✅ Konversi ke tanggal
- ✅ Sorting by price & speed
- ✅ Label "💸 Termurah" & "⚡ Tercepat"

### 3. Response Format
```json
{
  "success": true,
  "rates": [
    {
      "courier_code": "jnt",
      "courier_name": "J&T Express",
      "courier_service_name": "EZ (Reguler)",
      "service_type": "regular",
      "price": 12000,
      "etd_original": "2-3",
      "etd_adjusted": "3–5 hari",
      "estimated_date": "16 – 18 April",
      "min_days": 3,
      "max_days": 5,
      "zone": "same_island",
      "zone_label": "Antar Provinsi (1 Pulau)",
      "is_cheapest": true,
      "is_fastest": false,
      "label": "💸 Termurah"
    }
  ],
  "zone": "same_island",
  "zone_label": "Antar Provinsi (1 Pulau)"
}
```

## 🎨 Update Frontend (checkout.blade.php)

Ganti fungsi `displayCourierOptions` dengan:

```javascript
function displayCourierOptions(rates) {
    const container = document.getElementById('courierOptions');
    container.innerHTML = '';

    if (!rates || rates.length === 0) {
        container.innerHTML = '<div class="alert alert-info">Tidak ada ekspedisi tersedia untuk lokasi ini.</div>';
        return;
    }

    // Tampilkan info zona
    const zoneInfo = document.createElement('div');
    zoneInfo.className = 'zone-info';
    zoneInfo.innerHTML = `<i class="fas fa-map-marker-alt"></i> Zona: <strong>${rates[0].zone_label || 'Dalam Kota'}</strong>`;
    container.appendChild(zoneInfo);

    // Group by courier
    const grouped = {};
    rates.forEach(rate => {
        if (!grouped[rate.courier_code]) {
            grouped[rate.courier_code] = { name: rate.courier_name, services: [] };
        }
        grouped[rate.courier_code].services.push(rate);
    });

    const courierIcons = { 
        jnt: 'fa-truck', 
        anteraja: 'fa-shipping-fast', 
        paxel: 'fa-bolt',
        gosend: 'fa-motorcycle',
        grabexpress: 'fa-car'
    };

    Object.entries(grouped).forEach(([code, courier]) => {
        const card = document.createElement('div');
        card.className = 'courier-option';
        card.dataset.courier = code;

        const servicesHtml = courier.services.map(s => {
            const badgeClass = { 
                regular: 'badge-regular', 
                express: 'badge-express', 
                sameday: 'badge-sameday', 
                instant: 'badge-instant' 
            }[s.service_type] || 'badge-regular';
            
            const badgeLabel = { 
                regular: 'Reguler', 
                express: 'Express', 
                sameday: 'Same Day', 
                instant: 'Instant' 
            }[s.service_type] || s.service_type;
            
            // Label badge
            let labelBadge = '';
            if (s.label) {
                const labelClass = s.label.includes('Termurah') ? 'bg-success' : 'bg-primary';
                labelBadge = `<span class="badge ${labelClass} ms-2" style="font-size: 10px;">${s.label}</span>`;
            }
            
            return `
            <div class="service-item" data-rate='${JSON.stringify(s)}'>
                <input type="radio" name="selected_service">
                <div class="service-left">
                    <div class="service-radio"></div>
                    <div>
                        <div class="service-name">
                            ${s.courier_service_name}
                            <span class="service-badge ${badgeClass}">${badgeLabel}</span>
                            ${labelBadge}
                        </div>
                        <div class="service-duration">
                            <i class="far fa-calendar me-1"></i><strong>Tiba ${s.estimated_date}</strong>
                        </div>
                        <div class="service-duration" style="margin-top: 2px;">
                            <i class="far fa-clock me-1"></i>Estimasi ${s.etd_adjusted}
                        </div>
                    </div>
                </div>
                <div class="service-price">${formatRupiah(s.price)}</div>
            </div>`;
        }).join('');

        card.innerHTML = `
            <div class="courier-header">
                <div class="courier-icon"><i class="fas ${courierIcons[code] || 'fa-truck'}"></i></div>
                <div class="courier-title">${courier.name}</div>
                <div class="courier-toggle">Pilih Layanan <i class="fas fa-chevron-down ms-1" style="transition:transform 0.2s"></i></div>
            </div>
            <div class="courier-services">${servicesHtml}</div>
        `;

        card.querySelector('.courier-header').addEventListener('click', () => {
            const isOpen = card.classList.contains('open');
            document.querySelectorAll('.courier-option').forEach(c => c.classList.remove('open'));
            if (!isOpen) card.classList.add('open');
        });

        card.querySelectorAll('.service-item').forEach(item => {
            item.addEventListener('click', (e) => {
                e.stopPropagation();
                document.querySelectorAll('.service-item').forEach(i => i.classList.remove('selected'));
                item.classList.add('selected');
                document.querySelectorAll('.courier-option').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                const rate = JSON.parse(item.dataset.rate);
                selectCourier(rate);
            });
        });

        container.appendChild(card);
    });
}
```

## 🧪 Testing

1. Buka checkout page
2. Pilih lokasi di map
3. Lihat estimasi tanggal muncul
4. Cek label "Termurah" dan "Tercepat"
5. Pastikan instant/sameday tidak muncul untuk jarak jauh

## 📝 Catatan

- Zona saat ini hardcoded (Surabaya, Jawa Timur)
- Untuk production, ambil dari geocoding API atau database kota/provinsi
- Estimasi tanggal menggunakan Carbon (sudah include di Laravel)

## 🔄 Next Steps

1. Implementasi geocoding untuk deteksi kota/provinsi otomatis
2. Integrasi dengan API Biteship real (bukan mock)
3. Tambah cache untuk rates (5 menit)
4. Tambah loading skeleton saat fetch rates
