@extends('layouts.app')

@section('title', 'Checkout - NoraPadel')

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    /* Override app.blade styles */
    body {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }
    .navbar-brand-icon {
        display: none !important;
    }
    .mobile-bottom-nav {
        display: none !important;
    }
    /* Hide app.blade navbar */
    #mainNavbar {
        display: none !important;
    }
    /* Hide app.blade footer */
    .footer {
        display: none !important;
    }
    /* Ensure no large logo appears */
    img[height="40"], img[height="36"], img[height="32"], img[height="28"] {
        max-width: 120px !important;
        height: auto !important;
    }
    .brand-logo {
        max-width: 120px !important;
        height: auto !important;
    }
    body {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }
    .navbar-brand-icon {
        display: none !important;
    }
    .mobile-bottom-nav {
        display: none !important;
    }
    .checkout-page {
        background: #f5f5f7;
        min-height: 100vh;
        padding: 1.5rem 0;
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
    .courier-option {
        border: 2px solid rgba(0,0,0,0.1);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
        background: white;
    }
    .courier-option:hover {
        border-color: #0071e3;
        background: #f0f9ff;
    }
    .courier-option.selected {
        border-color: #0071e3;
        background: #f0f9ff;
        box-shadow: 0 0 0 3px rgba(0, 113, 227, 0.1);
    }
    .courier-header {
        display: flex;
        align-items: center;
        gap: 0.875rem;
    }
    .courier-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: #f5f5f7;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
        color: #0071e3;
        flex-shrink: 0;
    }
    .courier-title {
        font-weight: 600;
        font-size: 0.9375rem;
        color: #1d1d1f;
        flex: 1;
    }
    .courier-toggle {
        font-size: 0.75rem;
        color: #0071e3;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    .courier-services {
        margin-top: 0.875rem;
        padding-top: 0.875rem;
        border-top: 1px solid rgba(0,0,0,0.06);
        display: none;
    }
    .courier-option.open .courier-services {
        display: block;
    }
    .courier-option.open .courier-toggle i {
        transform: rotate(180deg);
    }
    .service-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.625rem 0.75rem;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.15s;
        margin-bottom: 0.375rem;
    }
    .service-item:last-child { margin-bottom: 0; }
    .service-item:hover { background: rgba(0,113,227,0.06); }
    .service-item.selected { background: rgba(0,113,227,0.1); }
    .service-item input[type=radio] { display: none; }
    .service-left {
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }
    .service-radio {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 2px solid rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.15s;
    }
    .service-item.selected .service-radio {
        border-color: #0071e3;
        background: #0071e3;
    }
    .service-item.selected .service-radio::after {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: white;
    }
    .service-name {
        font-size: 0.875rem;
        font-weight: 500;
        color: #1d1d1f;
    }
    .service-duration {
        font-size: 0.75rem;
        color: #86868b;
        margin-top: 1px;
    }
    .service-price {
        font-weight: 700;
        font-size: 0.9375rem;
        color: #1d1d1f;
    }
    .service-badge {
        display: inline-block;
        font-size: 0.625rem;
        font-weight: 600;
        padding: 0.125rem 0.4rem;
        border-radius: 4px;
        text-transform: uppercase;
        margin-left: 0.375rem;
        vertical-align: middle;
    }
    .badge-regular  { background: #e5e7eb; color: #374151; }
    .badge-express  { background: #dbeafe; color: #1d4ed8; }
    .badge-sameday  { background: #fef3c7; color: #92400e; }
    .badge-instant  { background: #fee2e2; color: #991b1b; }
    .zone-info {
        font-size: 0.75rem;
        color: #86868b;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .map-hint {
        font-size: 0.75rem;
        color: #86868b;
        margin-top: 0.5rem;
        text-align: center;
    }
    .breadcrumb-minimal {
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
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
<!-- Navbar Checkout -->
<header class="sticky top-0 z-50 border-b border-black/6 bg-white/80 backdrop-blur-xl">
    <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
        <a href="{{ route('home') }}" class="text-xl font-semibold tracking-tight text-black">NoraPadel</a>

        <nav class="hidden items-center gap-8 md:flex">
            <a href="{{ route('home') }}"
                class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Home</a>
            <a href="{{ route('racket') }}"
                class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Racket</a>
            <a href="{{ route('shoes') }}"
                class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Shoes</a>
            <a href="{{ route('apparel') }}"
                class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Accessories</a>
        </nav>

        <div class="flex items-center gap-3 text-black/80">
            @auth
                @if(auth()->user()->role === 'customer')
                    <a href="{{ route('customer.orders.index') }}" class="transition duration-300 hover:text-black" aria-label="History">
                        <i class="fas fa-history text-sm"></i>
                    </a>
                    <a href="{{ route('customer.profile.index') }}" class="transition duration-300 hover:text-black" aria-label="Profile">
                        <i class="fas fa-user text-sm"></i>
                    </a>
                @endif
            @endauth
            @auth
                <a href="{{ route('customer.cart.index') }}" class="relative transition duration-300 hover:text-black"
                    aria-label="Cart">
                    <i class="fas fa-shopping-bag text-sm"></i>
                    @if(auth()->user()->role === 'customer')
                        @php $cartCount = auth()->user()->cartItems()->sum('quantity'); @endphp
                        @if($cartCount > 0)
                            <span class="absolute -right-2 -top-2 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                        @endif
                    @endif
                </a>
            @endauth
        </div>
    </div>
</header>

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
                                </div>
                            </div>

                            <!-- Courier Selection -->
                            <div id="courierSelection" style="display: none;">
                                <label class="form-label">Pilih Ekspedisi <span class="text-danger">*</span></label>
                                
                                <!-- Loading State -->
                                <div class="shipping-result" id="shippingLoading" style="display: none; background: #e0f2fe; border-color: #0ea5e9; color: #0c4a6e;">
                                    <i class="fas fa-spinner fa-spin me-1"></i>
                                    Mengambil data ongkir dari ekspedisi...
                                </div>

                                <!-- Error State -->
                                <div class="alert alert-warning py-3" id="shippingError" style="display: none; border-radius: 12px;">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <span id="shippingErrorText"></span>
                                </div>

                                <!-- Courier Options -->
                                <div id="courierOptions"></div>
                            </div>

                            <input type="hidden" name="courier_code" id="courier_code">
                            <input type="hidden" name="courier_name" id="courier_name">
                            <input type="hidden" name="courier_service_name" id="courier_service_name">
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

<!-- Footer -->
<footer class="border-t border-black/10 bg-white py-10 text-sm text-zinc-500">
    <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
        <div class="hidden grid-cols-2 gap-8 md:grid md:grid-cols-4">
            <div>
                <h3 class="mb-3 text-xs font-semibold uppercase tracking-wide text-black">Shop</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('produk.index') }}" class="hover:underline">Racket</a></li>
                    <li><a href="{{ route('produk.index') }}" class="hover:underline">Shoes</a></li>
                    <li><a href="{{ route('produk.index') }}" class="hover:underline">Accessories</a></li>
                    <li><a href="{{ route('produk.index') }}" class="hover:underline">Shop</a></li>
                </ul>
            </div>
            <div>
                <h3 class="mb-3 text-xs font-semibold uppercase tracking-wide text-black">Support</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('tentang') }}" class="hover:underline">Help Center</a></li>
                    <li><a href="{{ route('tentang') }}" class="hover:underline">Shipping</a></li>
                    <li><a href="{{ route('tentang') }}" class="hover:underline">Returns</a></li>
                    <li><a href="{{ route('tentang') }}" class="hover:underline">Contact</a></li>
                </ul>
            </div>
            <div>
                <h3 class="mb-3 text-xs font-semibold uppercase tracking-wide text-black">Account</h3>
                <ul class="space-y-2">
                    @auth
                        <li><a href="{{ route('customer.profile.index') }}" class="hover:underline">Dashboard</a></li>
                        <li><a href="{{ route('customer.orders.index') }}" class="hover:underline">Orders</a></li>
                        <li><a href="{{ route('customer.notifications.index') }}" class="hover:underline">Notifications</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:underline">Sign In</a></li>
                        <li><a href="{{ route('register') }}" class="hover:underline">Create Account</a></li>
                    @endauth
                </ul>
            </div>
            <div>
                <h3 class="mb-3 text-xs font-semibold uppercase tracking-wide text-black">About NoraPadel</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('tentang') }}" class="hover:underline">Our Story</a></li>
                    <li><a href="{{ route('galeri') }}" class="hover:underline">Gallery</a></li>
                    <li><a href="{{ route('testimoni') }}" class="hover:underline">Testimonials</a></li>
                    <li><a href="{{ route('tentang') }}" class="hover:underline">Careers</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Mobile Footer -->
        <div class="md:hidden">
            <div class="text-center">
                <h3 class="mb-4 text-lg font-semibold text-black">NoraPadel</h3>
                <div class="flex flex-wrap justify-center gap-x-4 gap-y-2 text-xs">
                    <a href="{{ route('produk.index') }}" class="hover:underline">Shop</a>
                    <a href="{{ route('tentang') }}" class="hover:underline">Support</a>
                    <a href="{{ route('customer.profile.index') }}" class="hover:underline">Account</a>
                    <a href="{{ route('galeri') }}" class="hover:underline">Gallery</a>
                </div>
            </div>
        </div>
    </div>
    <div class="mx-auto mt-8 w-full max-w-7xl border-t border-black/10 px-6 pt-5 text-xs text-zinc-400 md:px-10 lg:px-12">
        © {{ now()->year }} NoraPadel. All rights reserved.
    </div>
</footer>

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
        
        // Auto fetch shipping rates
        fetchShippingRates();
    }
    
    function onMarkerDrag(e) {
        const latlng = e.target.getLatLng();
        document.getElementById('shipping_latitude').value = latlng.lat.toFixed(8);
        document.getElementById('shipping_longitude').value = latlng.lng.toFixed(8);
        fetchShippingRates();
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

    // Fetch shipping rates from Biteship
    async function fetchShippingRates() {
        const lat = parseFloat(document.getElementById('shipping_latitude').value);
        const lng = parseFloat(document.getElementById('shipping_longitude').value);

        if (isNaN(lat) || isNaN(lng)) {
            alert('Pilih lokasi pengiriman di peta terlebih dahulu.');
            return;
        }

        // Show courier selection section
        document.getElementById('courierSelection').style.display = 'block';
        document.getElementById('shippingLoading').style.display = 'block';
        document.getElementById('shippingError').style.display = 'none';
        document.getElementById('courierOptions').innerHTML = '';

        try {
            const response = await fetch('{{ route("customer.shipping.rates") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    destination_latitude: lat,
                    destination_longitude: lng
                })
            });

            const data = await response.json();
            document.getElementById('shippingLoading').style.display = 'none';
            
            console.log('API Response:', data);

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Gagal mengambil data ongkir');
            }

            // Check if data is grouped or flat array
            let rates = [];
            if (data.rates && Array.isArray(data.rates)) {
                rates = data.rates;
            } else if (data.data && typeof data.data === 'object') {
                // If grouped (instant, sameday, regular)
                if (data.data.instant || data.data.sameday || data.data.regular) {
                    rates = [
                        ...(data.data.instant || []),
                        ...(data.data.sameday || []),
                        ...(data.data.regular || [])
                    ];
                } else if (data.data.pricing && Array.isArray(data.data.pricing)) {
                    rates = data.data.pricing;
                } else {
                    rates = Object.values(data.data).flat();
                }
            }
            
            console.log('Processed rates:', rates);

            if (!rates || rates.length === 0) {
                throw new Error('Tidak ada ekspedisi tersedia untuk lokasi ini.');
            }

            displayCourierOptions(rates);

        } catch (error) {
            document.getElementById('shippingLoading').style.display = 'none';
            document.getElementById('shippingError').style.display = 'block';
            document.getElementById('shippingErrorText').textContent = error.message;
            console.error('Fetch rates error:', error);
        }
    }

    function displayCourierOptions(rates) {
        const container = document.getElementById('courierOptions');
        container.innerHTML = '';

        if (!rates || rates.length === 0) {
            container.innerHTML = '<div class="alert alert-info">Tidak ada ekspedisi tersedia untuk lokasi ini.</div>';
            return;
        }

        // Tampilkan info zona & berat (jika ada)
        const firstRate = rates[0];
        if (firstRate.zone || firstRate.weight_kg) {
            const zoneLabel = { same_city: 'Dalam Kota', nearby: 'Kota Tetangga', inter_city: 'Antar Kota', inter_island: 'Antar Pulau' };
            const zoneInfo = document.createElement('div');
            zoneInfo.className = 'zone-info';
            zoneInfo.innerHTML = `<i class="fas fa-map-marker-alt"></i> Zona: <strong>${zoneLabel[firstRate.zone] || firstRate.zone || 'N/A'}</strong> &nbsp;·&nbsp; <i class="fas fa-weight-hanging"></i> Berat: <strong>${firstRate.weight_kg || 'N/A'} kg</strong>`;
            container.appendChild(zoneInfo);
        }

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
                const badgeClass = { regular: 'badge-regular', express: 'badge-express', sameday: 'badge-sameday', instant: 'badge-instant' }[s.service_type] || 'badge-regular';
                const badgeLabel = { regular: 'Reguler', express: 'Express', sameday: 'Same Day', instant: 'Instant' }[s.service_type] || s.service_type;
                
                // Format duration - gunakan estimated_date jika ada, fallback ke duration atau etd
                let durationText = '';
                if (s.estimated_date) {
                    durationText = `Tiba ${s.estimated_date}`;
                    // Tambahkan label jika ada
                    if (s.label) {
                        durationText += ` ${s.label}`;
                    }
                } else if (s.duration) {
                    durationText = s.duration;
                } else if (s.etd) {
                    durationText = s.etd;
                } else {
                    durationText = 'Estimasi tidak tersedia';
                }
                
                return `
                <div class="service-item" data-rate='${JSON.stringify(s)}'>
                    <input type="radio" name="selected_service">
                    <div class="service-left">
                        <div class="service-radio"></div>
                        <div>
                            <div class="service-name">
                                ${s.courier_service_name || s.service_name || 'Layanan'}
                                <span class="service-badge ${badgeClass}">${badgeLabel}</span>
                            </div>
                            <div class="service-duration"><i class="far fa-clock me-1"></i>${durationText}</div>
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

            // Toggle dropdown
            card.querySelector('.courier-header').addEventListener('click', () => {
                const isOpen = card.classList.contains('open');
                document.querySelectorAll('.courier-option').forEach(c => c.classList.remove('open'));
                if (!isOpen) card.classList.add('open');
            });

            // Select service
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

    function selectCourier(rate) {
        // Update hidden inputs
        document.getElementById('courier_code').value = rate.courier_code;
        document.getElementById('courier_name').value = rate.courier_name;
        document.getElementById('courier_service_name').value = rate.courier_service_name;
        document.getElementById('shipping_cost_input').value = rate.price;
        document.getElementById('delivery_distance_km').value = rate.distance_km || 0;
        document.getElementById('delivery_distance_minutes').value = rate.duration_minutes || 60;

        // Add hidden input for estimated_delivery_date
        let estimatedDateInput = document.getElementById('estimated_delivery_date_input');
        if (!estimatedDateInput) {
            estimatedDateInput = document.createElement('input');
            estimatedDateInput.type = 'hidden';
            estimatedDateInput.name = 'estimated_delivery_date';
            estimatedDateInput.id = 'estimated_delivery_date_input';
            document.getElementById('checkoutForm').appendChild(estimatedDateInput);
        }
        estimatedDateInput.value = rate.estimated_date || rate.duration || '2-3 hari'; // Default 60 menit jika tidak ada

        // Calculate shipping discount
        let shippingDiscount = 0;
        if (SHIPPING_DISCOUNT && SUBTOTAL >= SHIPPING_DISCOUNT.minSubtotal) {
            shippingDiscount = rate.price * (SHIPPING_DISCOUNT.percent / 100);
            if (SHIPPING_DISCOUNT.maxDiscount && shippingDiscount > SHIPPING_DISCOUNT.maxDiscount) {
                shippingDiscount = SHIPPING_DISCOUNT.maxDiscount;
            }
        }

        // Update summary
        document.getElementById('displayShippingCost').textContent = formatRupiah(rate.price);
        document.getElementById('displayShippingCost').classList.remove('text-muted');

        if (shippingDiscount > 0) {
            document.getElementById('shippingDiscountRow').style.display = 'flex';
            document.getElementById('displayShippingDiscount').textContent = '-' + formatRupiah(shippingDiscount);
        } else {
            document.getElementById('shippingDiscountRow').style.display = 'none';
        }

        const finalTotal = SUBTOTAL + rate.price - shippingDiscount;
        document.getElementById('displayTotal').textContent = formatRupiah(finalTotal);

        // Enable submit button
        document.getElementById('submitBtn').disabled = false;
        document.getElementById('warningShipping').style.display = 'none';
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
        const courierCode = document.getElementById('courier_code').value;
        const shippingCost = document.getElementById('shipping_cost_input').value;
        
        if (!courierCode || !shippingCost || shippingCost == '0') {
            e.preventDefault();
            alert('Silakan pilih lokasi pengiriman dan ekspedisi terlebih dahulu.');
            return false;
        }
        
        console.log('Submitting form with:', {
            courierCode,
            courierName: document.getElementById('courier_name').value,
            courierService: document.getElementById('courier_service_name').value,
            shippingCost,
            lat: document.getElementById('shipping_latitude').value,
            lng: document.getElementById('shipping_longitude').value
        });
    });
</script>
@endpush
@endsection
