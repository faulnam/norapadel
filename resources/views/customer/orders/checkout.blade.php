@extends('layouts.app')

@section('title', 'Checkout - NoraPadel')

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    .checkout-page {
        background: #f5f5f7;
        min-height: 100vh;
        padding: 3rem 0;
    }
    .checkout-card {
        background: white;
        border-radius: 18px;
        border: 1px solid rgba(0,0,0,0.06);
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
    }
    .checkout-card-header {
        padding: 1.25rem 1.75rem;
        border-bottom: 1px solid rgba(0,0,0,0.06);
        font-weight: 600;
        font-size: 0.9375rem;
        color: #1d1d1f;
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }
    .checkout-card-header i {
        color: #86868b;
        font-size: 14px;
    }
    .checkout-card-body {
        padding: 1.75rem;
    }
    .form-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #1d1d1f;
        margin-bottom: 0.5rem;
    }
    .form-control, .form-select, textarea.form-control {
        border: 1px solid rgba(0,0,0,0.12);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.9375rem;
        transition: all 0.2s;
    }
    .form-control:focus, .form-select:focus, textarea.form-control:focus {
        border-color: #0071e3;
        box-shadow: 0 0 0 4px rgba(0, 113, 227, 0.1);
        outline: none;
    }
    .coord-box {
        background: #f5f5f7;
        border: 1px solid rgba(0,0,0,0.06);
        border-radius: 16px;
        padding: 1.5rem;
    }
    .coord-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1d1d1f;
        margin-bottom: 0.75rem;
    }
    .btn-checkout {
        background: #0071e3;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0.875rem;
        font-weight: 600;
        font-size: 0.9375rem;
        width: 100%;
        transition: all 0.2s;
    }
    .btn-checkout:hover:not(:disabled) {
        background: #0077ed;
        transform: scale(1.01);
        color: white;
    }
    .btn-checkout:disabled {
        background: #86868b;
        cursor: not-allowed;
    }
    .btn-calc {
        background: white;
        border: 1px solid rgba(0,0,0,0.12);
        color: #1d1d1f;
        border-radius: 10px;
        padding: 0.625rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-calc:hover {
        background: #f5f5f7;
        border-color: rgba(0,0,0,0.2);
    }
    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        font-size: 0.9375rem;
        color: #1d1d1f;
    }
    .summary-divider {
        border-top: 1px solid rgba(0,0,0,0.06);
        margin: 0.75rem 0;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        font-size: 1.125rem;
        font-weight: 700;
        color: #1d1d1f;
    }
    .warning-box {
        background: #fef3c7;
        border: 1px solid #fbbf24;
        color: #92400e;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        font-size: 0.875rem;
        text-align: center;
    }
    .shipping-result {
        background: #dcfce7;
        border: 1px solid #86efac;
        color: #166534;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        font-size: 0.875rem;
        margin-top: 1rem;
    }

    .map-hint {
        font-size: 0.75rem;
        color: #86868b;
        margin-top: 0.5rem;
        text-align: center;
    }
    .breadcrumb-minimal {
        font-size: 0.875rem;
        margin-bottom: 2rem;
        color: #86868b;
    }
    .breadcrumb-minimal a {
        color: #86868b;
        text-decoration: none;
        transition: color 0.2s;
    }
    .breadcrumb-minimal a:hover {
        color: #0071e3;
    }
    #map-container {
        margin-top: 1rem;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.06);
    }
    #map {
        height: 320px;
        width: 100%;
        z-index: 1;
    }
    .map-search-box input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid rgba(0,0,0,0.12);
        border-radius: 12px;
        font-size: 0.875rem;
    }
    .map-search-box input:focus {
        outline: none;
        border-color: #0071e3;
        box-shadow: 0 0 0 4px rgba(0, 113, 227, 0.1);
    }
    
    /* Mobile Responsive */
    @media (max-width: 991.98px) {
        .checkout-page {
            padding: 1rem 0;
        }
        .summary-sticky {
            position: relative;
            top: 0;
        }
    }
    
    @media (max-width: 767.98px) {
        .checkout-page {
            padding: 0.75rem 0;
        }
        .checkout-card {
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .checkout-card-header {
            padding: 0.75rem 1rem;
            font-size: 14px;
        }
        .checkout-card-body {
            padding: 1rem;
        }
        .breadcrumb-minimal {
            font-size: 12px;
            margin-bottom: 1rem;
        }
        .form-label {
            font-size: 12px;
        }
        .form-control {
            padding: 8px 12px;
            font-size: 13px;
        }
        .coord-box {
            padding: 1rem;
        }
        .coord-title {
            font-size: 12px;
        }
        .schedule-box {
            padding: 0.75rem 1rem;
        }
        .schedule-title {
            font-size: 12px;
        }
        .payment-info {
            padding: 1rem;
        }
        .bank-item {
            font-size: 12px;
            padding: 6px 0;
        }
        .summary-item {
            font-size: 13px;
        }
        .summary-total {
            font-size: 16px;
        }
        .btn-checkout {
            padding: 12px;
            font-size: 14px;
        }
        .btn-calc {
            padding: 6px 12px;
            font-size: 12px;
        }
        #map {
            height: 220px;
        }
        .map-search-box input {
            padding: 8px 12px;
            font-size: 12px;
        }
        .map-hint {
            font-size: 11px;
        }
        .warning-box {
            font-size: 12px;
            padding: 8px 12px;
        }
        .shipping-result {
            font-size: 12px;
            padding: 8px 12px;
        }
    }
    
    @media (max-width: 575.98px) {
        #map {
            height: 180px;
        }
    }
</style>
@endpush

@section('content')
<div class="checkout-page">
    <div class="container">
        <div class="breadcrumb-minimal">
            <a href="{{ route('customer.cart.index') }}">Keranjang</a>
            <span class="mx-2 text-muted">/</span>
            <span class="text-dark">Checkout</span>
        </div>

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        <form action="{{ route('customer.checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            
            <div class="row">
                <div class="col-lg-7">
                    <!-- Shipping Information -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <i class="fas fa-map-marker-alt"></i>
                            Alamat Pengiriman
                        </div>
                        <div class="checkout-card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Penerima <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('shipping_name') is-invalid @enderror" 
                                           name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('shipping_phone') is-invalid @enderror" 
                                           name="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                          name="shipping_address" rows="3" required placeholder="Jalan, No. Rumah, RT/RW, Kelurahan, Kecamatan, Kota">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                            </div>

                            <!-- Koordinat -->
                            <div class="coord-box mb-3">
                                <div class="coord-title">
                                    <i class="fas fa-map-pin me-1"></i>Koordinat Lokasi
                                </div>
                                <p class="text-muted small mb-3">Klik pada peta atau gunakan GPS untuk menentukan lokasi pengiriman</p>
                                
                                <!-- Map Search -->
                                <div class="map-search-box">
                                    <input type="text" id="searchAddress" placeholder="Cari alamat atau tempat..." autocomplete="off">
                                </div>
                                
                                <!-- Leaflet Map -->
                                <div id="map-container">
                                    <div id="map"></div>
                                </div>
                                <div class="map-hint">
                                    <i class="fas fa-hand-pointer"></i>
                                    Klik peta untuk menentukan lokasi atau geser marker
                                </div>
                                
                                <div class="row mb-3 mt-3">
                                    <div class="col-6">
                                        <label class="form-label">Latitude</label>
                                        <input type="text" class="form-control" name="shipping_latitude" id="shipping_latitude"
                                               value="{{ old('shipping_latitude') }}" placeholder="-7.250445" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Longitude</label>
                                        <input type="text" class="form-control" name="shipping_longitude" id="shipping_longitude"
                                               value="{{ old('shipping_longitude') }}" placeholder="112.768845" readonly>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 flex-wrap">
                                    <button type="button" class="btn-calc" id="getLocation">
                                        <i class="fas fa-crosshairs me-1"></i>Lokasi Saya
                                    </button>
                                    <button type="button" class="btn-calc" id="calculateShipping">
                                        <i class="fas fa-calculator me-1"></i>Hitung Ongkir
                                    </button>
                                </div>

                                <div class="shipping-result" id="shippingInfo" style="display: none;">
                                    <i class="fas fa-truck me-1"></i>
                                    Jarak: <strong id="distanceText">-</strong> • 
                                    Ongkir: <strong id="shippingCostText">-</strong>
                                </div>
                                
                                <!-- Out of Range Warning -->
                                <div class="alert alert-danger py-3 mt-3" id="outOfRangeWarning" style="display: none; border-radius: 12px;">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-exclamation-triangle me-2 mt-1" style="font-size: 18px;"></i>
                                        <div>
                                            <strong>Lokasi Di Luar Jangkauan</strong>
                                            <p class="mb-2 mt-1" style="font-size: 13px;">
                                                Maaf, lokasi Anda (<span id="outOfRangeDistance">0</span> km) melebihi batas area layanan kami (maksimal 40 km).
                                            </p>
                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="https://shopee.co.id/norapadel" target="_blank" class="btn btn-sm btn-outline-danger">
                                                    <i class="fab fa-shopee me-1"></i>Beli di Shopee
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="delivery_distance_km" id="delivery_distance_km" value="{{ old('delivery_distance_km', '0') }}">
                            <input type="hidden" name="delivery_distance_minutes" id="delivery_distance_minutes" value="{{ old('delivery_distance_minutes', '0') }}">
                            <input type="hidden" name="shipping_cost" id="shipping_cost_input" value="{{ old('shipping_cost', '0') }}">

                            @php
                                $deliveryInfo = \App\Models\Order::calculateDeliveryDate();
                            @endphp
                            <input type="hidden" name="delivery_date" value="{{ $deliveryInfo['date'] }}">
                            <input type="hidden" name="delivery_time_slot" value="{{ $deliveryInfo['time_slot'] }}">
                            
                            <div class="mb-0">
                                <label class="form-label">Catatan (Opsional)</label>
                                <textarea class="form-control" name="notes" rows="2" placeholder="Catatan untuk penjual...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-5">
                    <!-- Shipping Discount Promo Banner -->
                    @if($shippingDiscountInfo)
                        <div class="alert alert-success mb-3" style="border-radius: 12px; font-size: 13px;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-tag me-2"></i>
                                <div>
                                    <strong>{{ $shippingDiscountInfo->name }}</strong>
                                    <div class="mt-1">
                                        Diskon {{ $shippingDiscountInfo->formatted_discount }} ongkir
                                        @if($shippingDiscountInfo->max_discount)
                                            (maks. {{ $shippingDiscountInfo->formatted_max_discount }})
                                        @endif
                                        @if($shippingDiscountInfo->min_subtotal > 0)
                                            <br><small class="text-success">Min. belanja Rp {{ number_format($shippingDiscountInfo->min_subtotal, 0, ',', '.') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Order Summary -->
                    <div class="checkout-card summary-sticky">
                        <div class="checkout-card-header">
                            <i class="fas fa-receipt"></i>
                            Ringkasan Pesanan
                        </div>
                        <div class="checkout-card-body">
                            @foreach($cartItems as $item)
                                <div class="summary-item">
                                    <span>
                                        {{ $item->product->name }} <span class="text-muted">x{{ $item->quantity }}</span>
                                        @if($item->product->hasActiveDiscount())
                                            <span class="badge bg-danger ms-1" style="font-size: 10px;">-{{ $item->product->formatted_discount_percent }}</span>
                                        @endif
                                    </span>
                                    <span>{{ $item->formatted_subtotal }}</span>
                                </div>
                            @endforeach
                            
                            <div class="summary-divider"></div>
                            
                            @php
                                $totalDiscount = $cartItems->sum('discount_amount');
                                $originalTotal = $cartItems->sum('original_subtotal');
                                $actualSubtotal = $originalTotal - $totalDiscount;
                            @endphp
                            @if($totalDiscount > 0)
                                <div class="summary-item">
                                    <span>Harga Normal</span>
                                    <span class="text-decoration-line-through text-muted">Rp {{ number_format($originalTotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="summary-item text-danger">
                                    <span>Diskon Produk</span>
                                    <span>-Rp {{ number_format($totalDiscount, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            <div class="summary-item">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($actualSubtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="summary-item">
                                <span>Ongkos Kirim</span>
                                <span id="displayShippingCost" class="text-muted">Belum dihitung</span>
                            </div>
                            
                            <div class="summary-item text-success" id="shippingDiscountRow" style="display: none;">
                                <span>Diskon Ongkir</span>
                                <span id="displayShippingDiscount">-Rp 0</span>
                            </div>
                            
                            <div class="summary-divider"></div>
                            
                            <div class="summary-total">
                                <span>Total</span>
                                <span id="displayTotal">Rp {{ number_format($actualSubtotal, 0, ',', '.') }}</span>
                            </div>

                            <div class="warning-box mb-3" id="warningShipping">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Hitung ongkir terlebih dahulu
                            </div>
                            
                            <button type="submit" class="btn-checkout" id="submitBtn" disabled>
                                <i class="fas fa-check me-2"></i>Buat Pesanan
                            </button>
                            <a href="{{ route('customer.cart.index') }}" class="btn btn-link w-100 mt-2 text-muted text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i>Kembali ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    const STORE_LAT = {{ config('branding.store_latitude', -7.4674) }};
    const STORE_LNG = {{ config('branding.store_longitude', 112.5274) }};
    // Subtotal setelah diskon produk
    const SUBTOTAL = {{ $subtotal - $productDiscount }};
    const SHIPPING_RATE_PER_KM = 1500; // Rp 1.500 per KM
    const MAX_DELIVERY_DISTANCE = 40; // Maksimal 40 KM
    
    // Shipping Discount Info
    @if($shippingDiscountInfo)
    const SHIPPING_DISCOUNT = {
        percent: {{ $shippingDiscountInfo->discount_percent }},
        maxDiscount: {{ $shippingDiscountInfo->max_discount ?? 'null' }},
        minSubtotal: {{ $shippingDiscountInfo->min_subtotal ?? 0 }},
        name: "{{ $shippingDiscountInfo->name }}"
    };
    @else
    const SHIPPING_DISCOUNT = null;
    @endif
    
    // Initialize map
    let map;
    let marker;
    let storeMarker;
    
    // Default center (Sidoarjo)
    const defaultLat = {{ old('shipping_latitude') ?: config('branding.store_latitude', -7.4674) }};
    const defaultLng = {{ old('shipping_longitude') ?: config('branding.store_longitude', 112.5274) }};
    
    document.addEventListener('DOMContentLoaded', function() {
        initMap();
    });
    
    function initMap() {
        // Create map
        map = L.map('map').setView([defaultLat, defaultLng], 14);
        
        // Add tile layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 19
        }).addTo(map);
        
        // Store marker (green icon)
        const storeIcon = L.divIcon({
            html: '<div style="background: #16a34a; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; box-shadow: 0 2px 6px rgba(0,0,0,0.3);"><i class="fas fa-store"></i></div>',
            className: 'store-marker',
            iconSize: [32, 32],
            iconAnchor: [16, 32]
        });
        
        storeMarker = L.marker([STORE_LAT, STORE_LNG], { icon: storeIcon }).addTo(map);
    storeMarker.bindPopup('<strong>Nora Padel Store</strong><br>Lokasi pengambilan barang').openPopup();
        
        // Delivery marker (red/draggable)
        const deliveryIcon = L.divIcon({
            html: '<div style="background: #dc2626; color: white; width: 36px; height: 36px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); display: flex; align-items: center; justify-content: center; font-size: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.3);"><i class="fas fa-map-marker-alt" style="transform: rotate(45deg);"></i></div>',
            className: 'delivery-marker',
            iconSize: [36, 36],
            iconAnchor: [18, 36]
        });
        
        // Check if we have old values
        const oldLat = document.getElementById('shipping_latitude').value;
        const oldLng = document.getElementById('shipping_longitude').value;
        
        if (oldLat && oldLng) {
            marker = L.marker([parseFloat(oldLat), parseFloat(oldLng)], { 
                icon: deliveryIcon,
                draggable: true 
            }).addTo(map);
            marker.bindPopup('<strong>Lokasi Pengiriman</strong><br>Geser untuk memindahkan').openPopup();
            map.setView([parseFloat(oldLat), parseFloat(oldLng)], 15);
            
            // Setup drag event
            marker.on('dragend', onMarkerDrag);
        }
        
        // Click event on map
        map.on('click', function(e) {
            setDeliveryLocation(e.latlng.lat, e.latlng.lng);
        });
        
        // Search functionality
        const searchInput = document.getElementById('searchAddress');
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                searchAddress(this.value);
            }, 500);
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchAddress(this.value);
            }
        });
    }
    
    function setDeliveryLocation(lat, lng) {
        const deliveryIcon = L.divIcon({
            html: '<div style="background: #dc2626; color: white; width: 36px; height: 36px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); display: flex; align-items: center; justify-content: center; font-size: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.3);"><i class="fas fa-map-marker-alt" style="transform: rotate(45deg);"></i></div>',
            className: 'delivery-marker',
            iconSize: [36, 36],
            iconAnchor: [18, 36]
        });
        
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], { 
                icon: deliveryIcon,
                draggable: true 
            }).addTo(map);
            marker.bindPopup('<strong>Lokasi Pengiriman</strong><br>Geser untuk memindahkan');
            marker.on('dragend', onMarkerDrag);
        }
        
        // Update form inputs
        document.getElementById('shipping_latitude').value = lat.toFixed(8);
        document.getElementById('shipping_longitude').value = lng.toFixed(8);
        
        // Auto calculate shipping
        calculateShipping();
    }
    
    function onMarkerDrag(e) {
        const latlng = e.target.getLatLng();
        document.getElementById('shipping_latitude').value = latlng.lat.toFixed(8);
        document.getElementById('shipping_longitude').value = latlng.lng.toFixed(8);
        calculateShipping();
    }
    
    function searchAddress(query) {
        if (!query || query.length < 3) return;
        
        // Use Nominatim for geocoding (free OpenStreetMap service)
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&limit=1`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    const result = data[0];
                    const lat = parseFloat(result.lat);
                    const lng = parseFloat(result.lon);
                    
                    map.setView([lat, lng], 16);
                    setDeliveryLocation(lat, lng);
                }
            })
            .catch(err => console.error('Search error:', err));
    }

    // Get user's current location
    document.getElementById('getLocation').addEventListener('click', function() {
        if (navigator.geolocation) {
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Mengambil lokasi...';
            
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    // Update map
                    map.setView([lat, lng], 16);
                    setDeliveryLocation(lat, lng);
                    
                    document.getElementById('getLocation').disabled = false;
                    document.getElementById('getLocation').innerHTML = '<i class="fas fa-crosshairs me-1"></i>Lokasi Saya';
                },
                function(error) {
                    alert('Gagal mengambil lokasi. Pastikan GPS aktif dan izinkan akses lokasi.');
                    document.getElementById('getLocation').disabled = false;
                    document.getElementById('getLocation').innerHTML = '<i class="fas fa-crosshairs me-1"></i>Lokasi Saya';
                },
                { enableHighAccuracy: true }
            );
        } else {
            alert('Browser tidak mendukung Geolocation.');
        }
    });

    // Calculate shipping
    document.getElementById('calculateShipping').addEventListener('click', calculateShipping);

    function calculateShipping() {
        const lat = parseFloat(document.getElementById('shipping_latitude').value);
        const lng = parseFloat(document.getElementById('shipping_longitude').value);

        if (isNaN(lat) || isNaN(lng)) {
            alert('Pilih lokasi pengiriman di peta terlebih dahulu.');
            return;
        }

        // Calculate distance using Haversine formula
        const distance = haversineDistance(STORE_LAT, STORE_LNG, lat, lng);
        
        // Round up to nearest km (minimum 1 km)
        const distanceKm = Math.max(1, Math.ceil(distance));

        // Check if distance exceeds maximum delivery range
        if (distanceKm > MAX_DELIVERY_DISTANCE) {
            // Show out of range warning
            document.getElementById('outOfRangeDistance').textContent = distanceKm;
            document.getElementById('outOfRangeWarning').style.display = 'block';
            document.getElementById('shippingInfo').style.display = 'none';
            
            // Disable submit button
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('warningShipping').style.display = 'block';
            document.getElementById('warningShipping').innerHTML = '<i class="fas fa-times-circle me-1"></i>Lokasi di luar jangkauan pengiriman';
            
            // Reset shipping display
            document.getElementById('displayShippingCost').textContent = '-';
            document.getElementById('displayShippingCost').classList.add('text-muted');
            document.getElementById('shippingDiscountRow').style.display = 'none';
            
            console.log('Out of range:', { distanceKm, maxDistance: MAX_DELIVERY_DISTANCE });
            return;
        }

        // Hide out of range warning if within range
        document.getElementById('outOfRangeWarning').style.display = 'none';

        // Calculate shipping cost (1 KM = Rp 1.500)
        const shippingCost = distanceKm * SHIPPING_RATE_PER_KM;
        
        // Calculate shipping discount
        let shippingDiscount = 0;
        if (SHIPPING_DISCOUNT && SUBTOTAL >= SHIPPING_DISCOUNT.minSubtotal) {
            shippingDiscount = shippingCost * (SHIPPING_DISCOUNT.percent / 100);
            
            // Apply max discount cap
            if (SHIPPING_DISCOUNT.maxDiscount && shippingDiscount > SHIPPING_DISCOUNT.maxDiscount) {
                shippingDiscount = SHIPPING_DISCOUNT.maxDiscount;
            }
        }

        // Calculate final total
        const finalTotal = SUBTOTAL + shippingCost - shippingDiscount;

        // Update UI
        document.getElementById('distanceText').textContent = distanceKm + ' km';
        document.getElementById('shippingCostText').textContent = formatRupiah(shippingCost);
        document.getElementById('shippingInfo').style.display = 'block';

        document.getElementById('displayShippingCost').textContent = formatRupiah(shippingCost);
        document.getElementById('displayShippingCost').classList.remove('text-muted');
        
        // Show shipping discount if applicable
        if (shippingDiscount > 0) {
            document.getElementById('shippingDiscountRow').style.display = 'flex';
            document.getElementById('displayShippingDiscount').textContent = '-' + formatRupiah(shippingDiscount);
        } else {
            document.getElementById('shippingDiscountRow').style.display = 'none';
        }
        
        document.getElementById('displayTotal').textContent = formatRupiah(finalTotal);

        // Set hidden inputs
        document.getElementById('delivery_distance_km').value = distanceKm;
        document.getElementById('delivery_distance_minutes').value = Math.ceil((distance / 30) * 60); // For backward compatibility
        document.getElementById('shipping_cost_input').value = shippingCost;

        // Enable submit button
        document.getElementById('submitBtn').disabled = false;
        document.getElementById('warningShipping').style.display = 'none';
        
        console.log('Shipping calculated:', { distanceKm, shippingCost, shippingDiscount, finalTotal, distance: distance.toFixed(2) + ' km' });
    }

    function haversineDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Earth's radius in km
        const dLat = toRad(lat2 - lat1);
        const dLon = toRad(lon2 - lon1);
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                  Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    function toRad(deg) {
        return deg * (Math.PI / 180);
    }

    function formatRupiah(number) {
        return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Form validation before submit
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const distanceKm = document.getElementById('delivery_distance_km').value;
        const shippingCost = document.getElementById('shipping_cost_input').value;
        
        if (!distanceKm || distanceKm == '0' || !shippingCost || shippingCost == '0') {
            e.preventDefault();
            alert('Silakan pilih lokasi pengiriman di peta dan hitung ongkos kirim terlebih dahulu.');
            return false;
        }
        
        console.log('Submitting form with:', {
            distanceKm,
            shippingCost,
            lat: document.getElementById('shipping_latitude').value,
            lng: document.getElementById('shipping_longitude').value
        });
    });
</script>
@endpush
@endsection
