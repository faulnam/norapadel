@extends('layouts.app')

@section('title', 'Checkout - PATAH')

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    .checkout-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 2rem 0;
    }
    .checkout-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        margin-bottom: 1.5rem;
    }
    .checkout-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        font-weight: 600;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .checkout-card-header i {
        color: #6b7280;
        font-size: 14px;
    }
    .checkout-card-body {
        padding: 1.5rem;
    }
    .form-label {
        font-size: 13px;
        font-weight: 500;
        color: #374151;
        margin-bottom: 6px;
    }
    .form-control {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 14px;
    }
    .form-control:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    }
    .coord-box {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 1.25rem;
    }
    .coord-title {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.75rem;
    }
    .schedule-box {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border: 1px solid #bbf7d0;
        border-radius: 10px;
        padding: 1rem 1.25rem;
    }
    .schedule-title {
        font-size: 13px;
        font-weight: 600;
        color: #166534;
        margin-bottom: 0.5rem;
    }
    .payment-info {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 1.25rem;
    }
    .bank-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px dashed #e5e7eb;
        font-size: 13px;
    }
    .bank-item:last-child {
        border-bottom: none;
    }
    .summary-sticky {
        position: sticky;
        top: 100px;
    }
    .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        font-size: 14px;
        color: #4b5563;
    }
    .summary-divider {
        border-top: 1px solid #e5e7eb;
        margin: 12px 0;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        font-weight: 700;
        font-size: 18px;
        color: #1f2937;
    }
    .btn-checkout {
        background: #16a34a;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 14px;
        font-weight: 600;
        font-size: 15px;
        width: 100%;
        transition: all 0.2s;
    }
    .btn-checkout:hover:not(:disabled) {
        background: #15803d;
        color: white;
    }
    .btn-checkout:disabled {
        background: #9ca3af;
        cursor: not-allowed;
    }
    .btn-calc {
        background: white;
        border: 1px solid #d1d5db;
        color: #374151;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-calc:hover {
        background: #f3f4f6;
        border-color: #9ca3af;
    }
    .shipping-result {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 13px;
        color: #166534;
        margin-top: 1rem;
    }
    .warning-box {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 13px;
        color: #92400e;
    }
    /* Leaflet Map Styles */
    #map-container {
        margin-top: 1rem;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }
    #map {
        height: 280px;
        width: 100%;
        z-index: 1;
    }
    .map-search-box {
        margin-bottom: 0.75rem;
    }
    .map-search-box input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 13px;
    }
    .map-search-box input:focus {
        outline: none;
        border-color: #16a34a;
    }
    .map-hint {
        font-size: 12px;
        color: #6b7280;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .leaflet-container {
        font-family: inherit;
    }
    .breadcrumb-minimal {
        font-size: 13px;
        margin-bottom: 1.5rem;
    }
    .breadcrumb-minimal a {
        color: #6b7280;
        text-decoration: none;
    }
    .breadcrumb-minimal a:hover {
        color: #16a34a;
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
                                
                                <!-- Area Layanan Warning -->
                                <div class="alert alert-info py-2 mb-3" style="font-size: 13px; border-radius: 10px;">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    <strong>Area Layanan:</strong> Sidoarjo, Mojokerto & Surabaya (maks. 40 km dari Tarik)
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
                                                Maaf, lokasi Anda (<span id="outOfRangeDistance">0</span> km) melebihi batas area layanan kami (maks. 40 km dari Tarik, Sidoarjo).
                                                Kami hanya melayani pengiriman di area <strong>Sidoarjo, Mojokerto, dan Surabaya</strong>.
                                            </p>
                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="https://shopee.co.id/kerupukpatah" target="_blank" class="btn btn-sm btn-outline-danger">
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

                            <!-- Info Pengiriman Pre-Order -->
                            @php
                                $deliveryInfo = \App\Models\Order::calculateDeliveryDate();
                                // Estimasi: 5 hari proses + 1 hari kirim
                                $estimasiProses = now()->addDays(5);
                                $estimasiSampai = now()->addDays(6);
                            @endphp
                            <div class="schedule-box mb-3" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-color: #f59e0b;">
                                <div class="schedule-title" style="color: #92400e;">
                                    <i class="fas fa-box me-1"></i>Sistem Pre-Order
                                </div>
                                <div class="small mb-2" style="color: #92400e;">
                                    <i class="fas fa-clock me-1"></i>
                                    <strong>Estimasi Proses:</strong> 5 hari kerja setelah pembayaran
                                </div>
                                <div class="small mb-2" style="color: #92400e;">
                                    <i class="fas fa-truck me-1"></i>
                                    <strong>Estimasi Pengiriman:</strong> 1 hari setelah proses selesai
                                </div>
                                <div class="small" style="color: #78350f; background: rgba(255,255,255,0.5); padding: 8px; border-radius: 8px; margin-top: 8px;">
                                    <i class="fas fa-calendar-check me-1"></i>
                                    <strong>Perkiraan Sampai:</strong> {{ $estimasiSampai->translatedFormat('l, d F Y') }}
                                </div>
                            </div>
                            
                            <div class="alert alert-light py-2 mb-3" style="font-size: 12px; border-radius: 10px; border: 1px solid #e5e7eb;">
                                <i class="fas fa-bell me-1 text-success"></i>
                                Pantau status pesanan di halaman <strong>Pesanan Saya</strong>. Anda akan mendapat notifikasi saat ada update.
                            </div>
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
    // Koordinat Toko PATAH (Kec. Tarik, Sidoarjo)
    const STORE_LAT = {{ config('branding.store_latitude', -7.4674) }};
    const STORE_LNG = {{ config('branding.store_longitude', 112.5274) }};
    // Subtotal setelah diskon produk
    const SUBTOTAL = {{ $subtotal - $productDiscount }};
    const SHIPPING_RATE_PER_KM = 1500; // Rp 1.500 per KM
    const MAX_DELIVERY_DISTANCE = 40; // Maksimal 40 KM (Sidoarjo, Mojokerto, Surabaya)
    
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
        storeMarker.bindPopup('<strong>Toko PATAH</strong><br>Lokasi pengambilan barang').openPopup();
        
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
