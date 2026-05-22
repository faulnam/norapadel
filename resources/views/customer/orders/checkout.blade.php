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
<x-luxury-navbar />
<div class="checkout-page pt-16 md:pt-0">
    <div class="container">
        <div class="breadcrumb-minimal">
            <a href="{{ route('customer.cart.index') }}">Cart</a>
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
            @auth
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            @endauth
            
            <div class="row">
                <div class="col-lg-7">
                    <!-- Shipping Information -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <i class="fas fa-map-marker-alt"></i>
                            Delivery Address
                        </div>
                        <div class="checkout-card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Recipient Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('shipping_name') is-invalid @enderror"
                                           name="shipping_name" value="{{ old('shipping_name', auth()->check() ? auth()->user()->name : '') }}" @guest required @endguest>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('shipping_phone') is-invalid @enderror"
                                           name="shipping_phone" value="{{ old('shipping_phone', auth()->check() ? auth()->user()->phone : '') }}" @guest required @endguest>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Full Address <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('shipping_address') is-invalid @enderror"
                                          name="shipping_address" rows="3" @guest required @endguest placeholder="Street, House No., RT/RW, Village, District, City">{{ old('shipping_address', auth()->check() ? auth()->user()->address : '') }}</textarea>
                            </div>

                            @guest
                            <hr class="my-4">
                            <!-- Guest Information -->
                            <div class="alert alert-info mb-3" style="border-radius: 12px;">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Checkout as Guest</strong><br>
                                <small>Fill in your personal data to continue. Or <a href="{{ route('login') }}" class="alert-link">login</a> to get rewards!</small>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('guest_name') is-invalid @enderror"
                                           name="guest_name" value="{{ old('guest_name') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('guest_email') is-invalid @enderror"
                                           name="guest_email" value="{{ old('guest_email') }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('guest_phone') is-invalid @enderror"
                                           name="guest_phone" value="{{ old('guest_phone') }}" required>
                                </div>
                            </div>
                            @endguest

                            <!-- Coordinates -->
                            <hr class="my-4">
                            <div class="coord-box">
                                <div class="coord-title">
                                    <i class="fas fa-map-pin me-1"></i>Location Coordinates
                                </div>
                                <p class="text-muted small mb-3">Click on the map or use GPS to determine delivery location</p>

                                <!-- Map Search -->
                                <div class="map-search-box mb-3">
                                    <input type="text" id="searchAddress" placeholder="Search address or place..." autocomplete="off">
                                </div>

                                <!-- Leaflet Map -->
                                <div id="map-container">
                                    <div id="map"></div>
                                </div>
                                <div class="map-hint">
                                    <i class="fas fa-hand-pointer"></i>
                                    Click map to set location or drag marker
                                </div>

                                <div class="row g-3 mt-3">
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

                                <div class="mt-3">
                                    <button type="button" class="btn-calc" id="getLocation">
                                        <i class="fas fa-crosshairs me-1"></i>My Location
                                    </button>
                                </div>
                            </div>

                            <!-- Courier Selection -->
                            <hr class="my-4">
                            <div id="courierSelection" style="display: none;">
                                <label class="form-label">Select Courier <span class="text-danger">*</span></label>

                                <!-- Loading State -->
                                <div class="shipping-result" id="shippingLoading" style="display: none; background: #e0f2fe; border-color: #0ea5e9; color: #0c4a6e;">
                                    <i class="fas fa-spinner fa-spin me-1"></i>
                                    Getting shipping rates from courier...
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
                            <input type="hidden" name="courier_service_code" id="courier_service_code">
                            <input type="hidden" name="courier_service_name" id="courier_service_name">
                            <input type="hidden" name="delivery_distance_km" id="delivery_distance_km" value="{{ old('delivery_distance_km', '0') }}">
                            <input type="hidden" name="delivery_distance_minutes" id="delivery_distance_minutes" value="{{ old('delivery_distance_minutes', '0') }}">
                            <input type="hidden" name="shipping_cost" id="shipping_cost_input" value="{{ old('shipping_cost', '0') }}">

                            @php
                                $deliveryInfo = \App\Models\Order::calculateDeliveryDate();
                            @endphp
                            <input type="hidden" name="delivery_date" value="{{ $deliveryInfo['date'] }}">
                            <input type="hidden" name="delivery_time_slot" value="{{ $deliveryInfo['time_slot'] }}">

                            <hr class="my-4">
                            <div>
                                <label class="form-label">Notes (Optional)</label>
                                <textarea class="form-control" name="notes" rows="2" placeholder="Notes for seller...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-5">
                    @auth
                    @if(auth()->user()->role === 'customer')
        <!-- Welcome Bonus Info - Only for those who haven't ordered -->
                        @if(!auth()->user()->orders()->exists() && $freeGrip)
                        <div class="alert alert-success mb-3" style="border-radius: 12px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; color: white;">
                            <div class="d-flex align-items-start">
                                <div class="me-3" style="font-size: 2rem;">🎁</div>
                                <div class="flex-1">
                                    <h6 class="fw-bold mb-2" style="color: white;">Your First Purchase!</h6>
                                    <div class="small mb-2">
                                        <div class="mb-1">
                                            <i class="fas fa-check-circle me-1"></i> 
                                            <strong>{{ $freeGrip->name }}</strong> (worth Rp {{ number_format($freeGrip->price, 0, ',', '.') }}) 
                                            <span class="badge bg-white text-success ms-1" style="font-size: 9px;">FREE</span>
                                        </div>
                                        <div><i class="fas fa-coins me-1"></i> You have <strong>{{ auth()->user()->points }} points</strong> (Rp {{ number_format(auth()->user()->points * 100, 0, ',', '.') }})</div>
                                    </div>
                                    <small style="opacity: 0.9;">✨ Enjoy your member benefits!</small>
                                </div>
                            </div>
                        </div>
                        @elseif(!auth()->user()->orders()->exists() && !$freeGrip)
                        <div class="alert alert-warning mb-3" style="border-radius: 12px;">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <strong>Your First Purchase!</strong><br>
                                    <small>Grip is currently unavailable, but you can still use your {{ auth()->user()->points }} points for discount!</small>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Points Usage -->
                        @if(auth()->user()->points > 0)
                        <div class="checkout-card mb-3">
                            <div class="checkout-card-header">
                                <i class="fas fa-coins"></i>
                                Gunakan Point
                            </div>
                            <div class="checkout-card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3" style="background: #f9fafb; border-radius: 12px; padding: 0.75rem 1rem;">
                                    <div>
                                        <span class="text-muted small d-block">Total Point Anda</span>
                                        <span class="fw-bold" style="font-size: 1.125rem; color: #1d1d1f;">{{ number_format(auth()->user()->points) }} Points</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="text-muted small d-block">Nilai</span>
                                        <span class="fw-semibold" style="color: #059669; font-size: 0.9375rem;">{{ auth()->user()->formatted_points_value }}</span>
                                    </div>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="usePoints" name="use_points" value="1">
                                    <label class="form-check-label" for="usePoints" style="font-weight: 500; color: #374151;">
                                        Gunakan point untuk potongan harga
                                    </label>
                                </div>
                                <div id="pointsSlider" style="display: none;">
                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label small mb-0">Jumlah Point</label>
                                            <span class="small" style="color: #6b7280;">1 Point = Rp100</span>
                                        </div>
                                        <input type="range" class="form-range" id="pointsRange" name="points_used"
                                               min="0" max="{{ auth()->user()->points }}" value="0" step="10"
                                               style="accent-color: #0071e3;">
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center" style="background: #ecfdf5; border-radius: 8px; padding: 0.5rem 0.75rem;">
                                        <span class="small" style="color: #065f46;"><span id="pointsUsed">0</span> point digunakan</span>
                                        <span class="small fw-bold" style="color: #059669;">Potongan <span id="pointsDiscount">Rp 0</span></span>
                                    </div>
                                    <div id="pointsValidationError" class="small mt-2" style="display: none; color: #dc2626;">
                                        <i class="fas fa-exclamation-circle me-1"></i> Point tidak boleh melebihi total checkout atau saldo point.
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endif
                    @endauth

                    <!-- Shipping Discount Promo Banner -->
                    @if($shippingDiscountInfo)
                        <div class="alert alert-success mb-3" style="border-radius: 12px; font-size: 13px;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-tag me-2"></i>
                                <div>
                                    <strong>{{ $shippingDiscountInfo->name }}</strong>
                                    <div class="mt-1">
                                        Discount {{ $shippingDiscountInfo->formatted_discount }} shipping cost
                                        @if($shippingDiscountInfo->max_discount)
                                            (max. {{ $shippingDiscountInfo->formatted_max_discount }})
                                        @endif
                                        @if($shippingDiscountInfo->min_subtotal > 0)
                                            <br><small class="text-success">Min. shopping Rp {{ number_format($shippingDiscountInfo->min_subtotal, 0, ',', '.') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Voucher & Promo -->
                    @auth
                    <div class="checkout-card mb-3">
                        <div class="checkout-card-header">
                            <i class="fas fa-ticket-alt"></i>
                            Voucher & Promo
                        </div>
                        <div class="checkout-card-body">
                            <!-- Voucher Selection -->
                            <div class="mb-4">
                                <label class="form-label mb-2" style="font-weight: 500; color: #374151;">Pilih Voucher</label>
                                <select class="form-select" id="voucherSelect" onchange="selectVoucher()" style="border-radius: 0.5rem; border: 1px solid #e5e7eb; padding: 0.75rem;">
                                    <option value="">-- Pilih Voucher --</option>
                                </select>
                                <div id="voucherEmptyState" class="small mt-2" style="display: none; color: #6b7280; padding: 0.5rem 0;">
                                    <i class="fas fa-info-circle me-1"></i> Tidak ada voucher tersedia
                                </div>
                            </div>

                            <!-- Voucher Code Input -->
                            <div class="mb-4">
                                <label class="form-label mb-2" style="font-weight: 500; color: #374151;">Redeem Kode Voucher</label>
                                <div class="d-flex gap-2">
                                    <input type="text" class="form-control" id="voucherCode" placeholder="Masukkan kode voucher" style="border-radius: 0.5rem; border: 1px solid #e5e7eb; padding: 0.75rem;">
                                    <button type="button" onclick="applyVoucherCode()" class="btn-calc" style="background: #6b7280; color: white; border: none; border-radius: 0.5rem; padding: 0.75rem 1.5rem; font-weight: 500; transition: all 0.2s ease; cursor: pointer; white-space: nowrap;" onmouseover="this.style.background='#4b5563'" onmouseout="this.style.background='#6b7280'">
                                        Apply
                                    </button>
                                </div>
                            </div>

                            <!-- Voucher Applied Card -->
                            <div id="voucherAppliedCard" style="display: none; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 1px solid #86efac; border-radius: 0.75rem; padding: 1rem;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div style="font-weight: 600; color: #166534; font-size: 0.875rem; margin-bottom: 0.25rem;">
                                            <i class="fas fa-check-circle me-1"></i> Voucher Digunakan
                                        </div>
                                        <div id="voucherAppliedName" style="color: #166534; font-weight: 500; font-size: 0.875rem;"></div>
                                        <div id="voucherAppliedDiscount" style="color: #15803d; font-size: 0.8125rem; margin-top: 0.25rem;"></div>
                                    </div>
                                    <button type="button" onclick="removeVoucher()" style="background: white; color: #dc2626; border: 1px solid #fca5a5; border-radius: 0.5rem; padding: 0.375rem 0.75rem; font-size: 0.75rem; font-weight: 500; transition: all 0.2s ease; cursor: pointer;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='white'">
                                        Hapus
                                    </button>
                                </div>
                            </div>

                            <!-- Error Message -->
                            <div id="voucherError" style="display: none; background: #fef2f2; border: 1px solid #fecaca; border-radius: 0.5rem; padding: 0.75rem; margin-top: 0.5rem;">
                                <div style="color: #dc2626; font-size: 0.8125rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <span id="voucherErrorText"></span>
                                </div>
                            </div>

                            <!-- Success Message -->
                            <div id="voucherSuccess" style="display: none; background: #f0fdf4; border: 1px solid #86efac; border-radius: 0.5rem; padding: 0.75rem; margin-top: 0.5rem;">
                                <div style="color: #166534; font-size: 0.8125rem;">
                                    <i class="fas fa-check-circle me-1"></i>
                                    <span id="voucherSuccessText"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endauth
                    
                    <!-- Order Summary -->
                    <div class="checkout-card summary-sticky">
                        <div class="checkout-card-header">
                            <i class="fas fa-receipt"></i>
                            Order Summary
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
                                    <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach

                            @auth
                            @if(auth()->user()->role === 'customer' && !auth()->user()->first_purchase_completed && $freeGrip)
                                <!-- Free Grip Item -->
                                <div class="summary-item" style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); padding: 0.75rem; border-radius: 8px; margin-top: 0.5rem;">
                                    <span class="d-flex align-items-center gap-2">
                                        @if($freeGrip->image)
                                        <img src="{{ $freeGrip->image }}" 
                                             alt="{{ $freeGrip->name }}"
                                             onerror="this.onerror=null; this.src='{{ asset('images/racket.png') }}'"
                                             style="width: 32px; height: 32px; object-fit: cover; border-radius: 6px;">
                                        @else
                                        <div style="width: 32px; height: 32px; background: #10b981; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px;">
                                            <i class="fas fa-gift"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold" style="font-size: 0.875rem; color: #166534;">
                                                {{ $freeGrip->name }}
                                                <span class="badge bg-success ms-1" style="font-size: 9px; vertical-align: middle;">FREE</span>
                                            </div>
                                            <div class="text-muted" style="font-size: 0.75rem; color: #166534 !important; opacity: 0.8;">First Purchase Bonus</div>
                                        </div>
                                    </span>
                                    <span class="fw-bold" style="color: #166534; text-decoration: line-through; opacity: 0.6;">Rp {{ number_format($freeGrip->price, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            @endauth
                            
                            <div class="summary-divider"></div>

                            @php
                                $totalDiscount = $cartItems->sum('discount_amount');
                                $originalTotal = $cartItems->sum('original_subtotal');
                                $actualSubtotal = $originalTotal - $totalDiscount;
                            @endphp
                            @if($totalDiscount > 0)
                                <div class="summary-item">
                                    <span>Normal Price</span>
                                    <span class="text-decoration-line-through text-muted">Rp {{ number_format($originalTotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="summary-item text-danger">
                                    <span>Product Discount</span>
                                    <span>-Rp {{ number_format($totalDiscount, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            <div class="summary-item">
                                <span style="font-weight: 500;">Subtotal</span>
                                <span style="font-weight: 500;">Rp {{ number_format($actualSubtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="summary-item">
                                <span>Shipping</span>
                                <span id="displayShippingCost" class="text-muted">Not calculated yet</span>
                            </div>

                            <div class="summary-item text-success" id="shippingDiscountRow" style="display: none;">
                                <span>Shipping Discount</span>
                                <span id="displayShippingDiscount">-Rp 0</span>
                            </div>

                            @auth
                            <div class="summary-item" id="voucherDiscountRow" style="display: none;">
                                <span>Voucher Discount</span>
                                <span id="displayVoucherDiscount" style="color: #059669; font-weight: 600;">-Rp 0</span>
                            </div>
                            @endauth

                            @auth
                            @if(auth()->user()->role === 'customer' && auth()->user()->points > 0)
                            <div class="summary-item" id="pointsDiscountRow" style="display: none;">
                                <span>Point Discount</span>
                                <span id="displayPointsDiscount" style="color: #059669; font-weight: 600;">-Rp 0</span>
                            </div>
                            @endif
                            @endauth

                            <div class="summary-divider"></div>

                            <div class="summary-total">
                                <span>Total Payment</span>
                                <span id="displayTotal">Rp {{ number_format($actualSubtotal, 0, ',', '.') }}</span>
                            </div>

                            <div class="warning-box mt-3" id="warningShipping">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Calculate shipping first
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn-checkout w-100" id="submitBtn" disabled>
                                    <i class="fas fa-check me-2"></i>Place Order
                                </button>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('customer.cart.index') }}" class="btn btn-link w-100 text-muted text-decoration-none">
                                    <i class="fas fa-arrow-left me-1"></i>Back to Cart
                                </a>
                            </div>
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
    document.addEventListener('DOMContentLoaded', function () {
        const mobileMenuToggle = document.querySelector('[data-mobile-menu-toggle]');
        const mobileMenu = document.querySelector('[data-mobile-menu]');

        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
                mobileMenuToggle.setAttribute('aria-expanded', String(!mobileMenu.classList.contains('hidden')));
            });
        }
    });

    // Hamburger Menu Toggle
    (function() {
        const btn = document.getElementById('hamburgerMenuBtn');
        const dropdown = document.getElementById('hamburgerMenuDropdown');
        const wrapper = document.getElementById('hamburgerMenuWrapper');
        if (!btn || !dropdown || !wrapper) return;
        btn.addEventListener('click', function(e){ e.stopPropagation(); dropdown.classList.toggle('hidden'); });
        document.addEventListener('click', function(e){ if(!wrapper.contains(e.target)) dropdown.classList.add('hidden'); });
    })();
</script>
<script>
    const STORE_LAT = {{ config('branding.store_latitude', -7.278417) }};
    const STORE_LNG = {{ config('branding.store_longitude', 112.632583) }};
    // Subtotal setelah diskon produk
    const SUBTOTAL = {{ $subtotal - $productDiscount }};
    const SHIPPING_RATE_PER_KM = 1500; // Rp 1.500 per KM
    const MAX_DELIVERY_DISTANCE = 40; // Maksimal 40 KM
    
    @auth
    @if(auth()->user()->role === 'customer')
    const USER_POINTS = {{ auth()->user()->points }};
    @else
    const USER_POINTS = 0;
    @endif
    @else
    const USER_POINTS = 0;
    @endauth
    
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
    const defaultLat = {{ old('shipping_latitude') ?: config('branding.store_latitude', -7.278417) }};
    const defaultLng = {{ old('shipping_longitude') ?: config('branding.store_longitude', 112.632583) }};
    
    document.addEventListener('DOMContentLoaded', function() {
        initMap();
        recalculateOrderTotal();
        initPointsSlider();
    });

    function initPointsSlider() {
        const usePointsCheckbox = document.getElementById('usePoints');
        const pointsSlider = document.getElementById('pointsSlider');
        const pointsRange = document.getElementById('pointsRange');
        const pointsUsedSpan = document.getElementById('pointsUsed');
        const pointsDiscountSpan = document.getElementById('pointsDiscount');
        const pointsValidationError = document.getElementById('pointsValidationError');

        if (!usePointsCheckbox) return;

        // Max usable points: can't exceed subtotal (1pt = Rp100)
        const maxUsablePoints = Math.min(USER_POINTS, Math.floor(SUBTOTAL / 100));

        usePointsCheckbox.addEventListener('change', function() {
            if (this.checked) {
                pointsSlider.style.display = 'block';
                // Default to max usable points, not exceeding user's balance
                pointsRange.value = Math.min(maxUsablePoints, USER_POINTS);
                pointsRange.max = Math.min(maxUsablePoints, USER_POINTS);
                updatePointsDisplay();
            } else {
                pointsSlider.style.display = 'none';
                pointsRange.value = 0;
                updatePointsDisplay();
            }
        });

        if (pointsRange) {
            pointsRange.addEventListener('input', updatePointsDisplay);
        }

        function updatePointsDisplay() {
            let points = parseInt(pointsRange.value) || 0;
            const maxPoints = parseInt(pointsRange.max) || USER_POINTS;

            // Validate: points cannot exceed subtotal value or user balance
            if (points > maxPoints) {
                points = maxPoints;
                pointsRange.value = points;
            }
            if (points < 0) {
                points = 0;
                pointsRange.value = 0;
            }

            const discount = points * 100; // 1 point = Rp 100

            pointsUsedSpan.textContent = points;
            pointsDiscountSpan.textContent = formatRupiah(discount);

            // Show/hide validation error
            if (pointsValidationError) {
                if (points > 0 && points === maxPoints && SUBTOTAL < USER_POINTS * 100) {
                    pointsValidationError.style.display = 'block';
                    pointsValidationError.innerHTML = '<i class="fas fa-info-circle me-1"></i> Point maksimal ' + maxPoints + ' (1 point = Rp100)';
                    pointsValidationError.style.color = '#059669';
                } else {
                    pointsValidationError.style.display = 'none';
                }
            }

            // Update summary
            if (points > 0) {
                document.getElementById('pointsDiscountRow').style.display = 'flex';
                document.getElementById('displayPointsDiscount').textContent = '-' + formatRupiah(discount);
            } else {
                document.getElementById('pointsDiscountRow').style.display = 'none';
            }

            recalculateOrderTotal();
        }
    }

    function getShippingDiscount(shippingPrice) {
        let shippingDiscount = 0;
        if (SHIPPING_DISCOUNT && SUBTOTAL >= SHIPPING_DISCOUNT.minSubtotal) {
            shippingDiscount = shippingPrice * (SHIPPING_DISCOUNT.percent / 100);
            if (SHIPPING_DISCOUNT.maxDiscount && shippingDiscount > SHIPPING_DISCOUNT.maxDiscount) {
                shippingDiscount = SHIPPING_DISCOUNT.maxDiscount;
            }
        }

        return normalizeRupiahAmount(Math.max(0, Math.min(shippingPrice, shippingDiscount)));
    }

    function normalizeRupiahAmount(value) {
        return Math.max(0, Math.round(Number(value) || 0));
    }

    function recalculateOrderTotal() {
        const shippingPrice = normalizeRupiahAmount(document.getElementById('shipping_cost_input').value);
        const shippingDiscount = getShippingDiscount(shippingPrice);

        // Get points discount
        let pointsDiscount = 0;
        const pointsRange = document.getElementById('pointsRange');
        const usePointsCheckbox = document.getElementById('usePoints');
        if (pointsRange && usePointsCheckbox && usePointsCheckbox.checked) {
            const pointsUsed = parseInt(pointsRange.value) || 0;
            pointsDiscount = pointsUsed * 100; // 1 point = Rp 100
        }

        // Include voucher discount
        const finalTotal = normalizeRupiahAmount(SUBTOTAL + shippingPrice - shippingDiscount - pointsDiscount - voucherDiscount);
        document.getElementById('displayTotal').textContent = formatRupiah(finalTotal);
        
        // Update voucher discount display
        const voucherDiscountRow = document.getElementById('voucherDiscountRow');
        if (voucherDiscountRow && voucherDiscount > 0) {
            voucherDiscountRow.style.display = 'flex';
            document.getElementById('displayVoucherDiscount').textContent = '-' + formatRupiah(voucherDiscount);
        } else if (voucherDiscountRow) {
            voucherDiscountRow.style.display = 'none';
        }
    }
    
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
            marker.bindPopup('<strong>Delivery Location</strong><br>Drag to move').openPopup();
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
            marker.bindPopup('<strong>Delivery Location</strong><br>Drag to move');
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
                    document.getElementById('getLocation').innerHTML = '<i class="fas fa-crosshairs me-1"></i>My Location';
                },
                function(error) {
                    alert('Failed to get location. Make sure GPS is active and allow location access.');
                    document.getElementById('getLocation').disabled = false;
                    document.getElementById('getLocation').innerHTML = '<i class="fas fa-crosshairs me-1"></i>My Location';
                },
                { enableHighAccuracy: true }
            );
        } else {
            alert('Browser does not support Geolocation.');
        }
    });

    // Fetch shipping rates from Biteship
    async function fetchShippingRates() {
        const lat = parseFloat(document.getElementById('shipping_latitude').value);
        const lng = parseFloat(document.getElementById('shipping_longitude').value);

        if (isNaN(lat) || isNaN(lng)) {
            alert('Please select delivery location on the map first.');
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
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    destination_latitude: lat,
                    destination_longitude: lng
                })
            });

            const contentType = response.headers.get('content-type') || '';
            let data = null;
            if (contentType.includes('application/json')) {
                data = await response.json();
            } else {
                const text = await response.text();
                throw new Error(text.includes('<!DOCTYPE') || text.includes('<html')
                    ? 'Gagal mengambil data ongkir. Silakan refresh halaman lalu coba lagi.'
                    : 'Gagal mengambil data ongkir.');
            }
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
                throw new Error('No courier available for this location.');
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
            container.innerHTML = '<div class="alert alert-info">No courier available for this location.</div>';
            return;
        }

        const providerRuleNote = document.createElement('div');
        providerRuleNote.className = 'zone-info';
        providerRuleNote.innerHTML = '<i class="fas fa-info-circle"></i> Service availability (including Instant / Same Day and distance limits) follows active rules in Biteship based on service area, distance, and courier operating hours.';
        container.appendChild(providerRuleNote);

        // Display zone & weight info (if any)
        const firstRate = rates[0];
        if (firstRate.zone || firstRate.weight_kg) {
            const zoneLabel = { same_city: 'Within City', nearby: 'Neighboring City', inter_city: 'Inter City', inter_island: 'Inter Island' };
            const zoneInfo = document.createElement('div');
            zoneInfo.className = 'zone-info';
            zoneInfo.innerHTML = `<i class="fas fa-map-marker-alt"></i> Zone: <strong>${zoneLabel[firstRate.zone] || firstRate.zone || 'N/A'}</strong> &nbsp;·&nbsp; <i class="fas fa-weight-hanging"></i> Weight: <strong>${firstRate.weight_kg || 'N/A'} kg</strong>`;
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
            jne: 'fa-box',
            anteraja: 'fa-shipping-fast',
            paxel: 'fa-bolt',
            gosend: 'fa-motorcycle',
            grabexpress: 'fa-car',
            gojek: 'fa-motorcycle',
            grab: 'fa-car'
        };

        Object.entries(grouped).forEach(([code, courier]) => {
            const card = document.createElement('div');
            card.className = 'courier-option';
            card.dataset.courier = code;

            const servicesHtml = courier.services.map(s => {
                const serviceType = (s.service_type || '').toString().toLowerCase();
                const normalizedServiceType = serviceType === 'same_day' ? 'sameday' : serviceType;
                const badgeClass = { regular: 'badge-regular', express: 'badge-express', sameday: 'badge-sameday', instant: 'badge-instant' }[normalizedServiceType] || 'badge-regular';
                const badgeLabel = { regular: 'Regular', express: 'Express', sameday: 'Same Day', instant: 'Instant' }[normalizedServiceType] || (s.service_type || 'Service');
                
                // Format duration - use estimated_date if available, fallback to duration or etd
                let durationText = '';
                if (s.estimated_date) {
                    durationText = `Arrive ${s.estimated_date}`;
                    // Add label if available
                    if (s.label) {
                        durationText += ` ${s.label}`;
                    }
                } else if (s.duration) {
                    durationText = s.duration;
                } else if (s.etd) {
                    durationText = s.etd;
                } else {
                    durationText = 'Estimate not available';
                }
                
                return `
                <div class="service-item" data-rate='${JSON.stringify(s)}'>
                    <input type="radio" name="selected_service">
                    <div class="service-left">
                        <div class="service-radio"></div>
                        <div>
                            <div class="service-name">
                                ${s.courier_service_name || s.service_name || 'Service'}
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
                    <div class="courier-toggle">Select Service <i class="fas fa-chevron-down ms-1" style="transition:transform 0.2s"></i></div>
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
        const shippingPrice = normalizeRupiahAmount(rate.price);
        const selectedServiceCode = (rate.courier_service_code || rate.courier_type || '').toString().trim().toLowerCase();

        // Update hidden inputs
        document.getElementById('courier_code').value = rate.courier_code;
        document.getElementById('courier_name').value = rate.courier_name;
        document.getElementById('courier_service_code').value = selectedServiceCode;
        document.getElementById('courier_service_name').value = rate.courier_service_name;
    document.getElementById('shipping_cost_input').value = shippingPrice;
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

        const shippingDiscount = getShippingDiscount(shippingPrice);

        // Update summary
    document.getElementById('displayShippingCost').textContent = formatRupiah(shippingPrice);
        document.getElementById('displayShippingCost').classList.remove('text-muted');

        if (shippingDiscount > 0) {
            document.getElementById('shippingDiscountRow').style.display = 'flex';
            document.getElementById('displayShippingDiscount').textContent = '-' + formatRupiah(shippingDiscount);
        } else {
            document.getElementById('shippingDiscountRow').style.display = 'none';
        }

        recalculateOrderTotal();

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
        const normalized = Math.round(Number(number) || 0);
        return 'Rp ' + normalized.toLocaleString('id-ID');
    }

    // Voucher functionality
    let selectedVoucher = null;
    let voucherDiscount = 0;
    let voucherData = null;

    // Load available vouchers into dropdown
    function loadAvailableVouchers() {
        const cartTotal = SUBTOTAL;

        fetch('{{ route('customer.vouchers.checkout-available') }}?cart_total=' + cartTotal, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('voucherSelect');
            const emptyState = document.getElementById('voucherEmptyState');
            select.innerHTML = '<option value="">-- Pilih Voucher --</option>';

            if (data.success && data.data && data.data.length > 0) {
                emptyState.style.display = 'none';
                select.style.display = 'block';

                data.data.forEach(voucher => {
                    const option = document.createElement('option');
                    option.value = voucher.id;
                    option.dataset.type = voucher.type;
                    option.dataset.discountValue = voucher.discount_value;
                    option.dataset.maximumDiscount = voucher.maximum_discount || 0;
                    option.dataset.cashbackCoin = voucher.cashback_coin || 0;
                    option.dataset.minimumPurchase = voucher.minimum_purchase;

                    let discountText = '';
                    if (voucher.type === 'fixed') {
                        discountText = 'Diskon Rp' + number_format(voucher.discount_value, 0, ',', '.');
                    } else if (voucher.type === 'percent') {
                        discountText = 'Diskon ' + voucher.discount_value + '%';
                        if (voucher.maximum_discount > 0) {
                            discountText += ' Max Rp' + number_format(voucher.maximum_discount, 0, ',', '.');
                        }
                    } else {
                        discountText = 'Cashback ' + voucher.cashback_coin + ' Coin';
                    }

                    option.textContent = voucher.title + ' - ' + discountText + ' (Min. Rp' + number_format(voucher.minimum_purchase, 0, ',', '.') + ')';
                    select.appendChild(option);
                });
            } else {
                select.style.display = 'none';
                emptyState.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error loading vouchers:', error);
            const select = document.getElementById('voucherSelect');
            const emptyState = document.getElementById('voucherEmptyState');
            select.style.display = 'none';
            emptyState.style.display = 'block';
        });
    }

    // Select voucher from dropdown (validated server-side via AJAX)
    function selectVoucher() {
        const select = document.getElementById('voucherSelect');
        const voucherId = select.value;

        hideVoucherMessages();

        if (!voucherId) {
            removeVoucher();
            return;
        }

        // Server-side validation
        fetch('{{ route('customer.vouchers.validate') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                code: voucherId,
                cart_total: SUBTOTAL,
                by_id: true
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const voucher = data.data.voucher;
                const discountValue = data.data.discount_value;

                selectedVoucher = voucher.id;
                voucherDiscount = discountValue;
                voucherData = {
                    id: voucher.id,
                    title: voucher.title,
                    type: voucher.type,
                    discountValue: voucher.discount_value,
                    cashbackCoin: voucher.cashback_coin || 0
                };

                showVoucherApplied();
                recalculateOrderTotal();
            } else {
                showVoucherError(data.message || 'Voucher tidak dapat digunakan');
                select.value = '';
                removeVoucher();
            }
        })
        .catch(error => {
            console.error('Error validating voucher:', error);
            showVoucherError('Terjadi kesalahan validasi voucher. Silakan coba lagi.');
            select.value = '';
            removeVoucher();
        });
    }

    // Apply voucher by code
    function applyVoucherCode() {
        const codeInput = document.getElementById('voucherCode');
        const code = codeInput.value.trim();

        if (!code) {
            showVoucherError('Silakan masukkan kode voucher');
            return;
        }

        hideVoucherMessages();

        const cartTotal = SUBTOTAL;

        fetch('{{ route('customer.vouchers.validate') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                code: code,
                cart_total: cartTotal
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const voucher = data.data.voucher;
                const discountValue = data.data.discount_value;

                selectedVoucher = voucher.id;
                voucherDiscount = discountValue;
                voucherData = {
                    id: voucher.id,
                    title: voucher.title,
                    type: voucher.type,
                    discountValue: voucher.discount_value,
                    cashbackCoin: voucher.cashback_coin || 0
                };

                showVoucherApplied();
                showVoucherSuccess('Voucher berhasil diterapkan');
                document.getElementById('voucherCode').value = '';
                document.getElementById('voucherSelect').value = '';
                recalculateOrderTotal();
            } else {
                showVoucherError(data.message || 'Kode voucher tidak valid');
            }
        })
        .catch(error => {
            console.error('Error validating voucher:', error);
            showVoucherError('Terjadi kesalahan. Silakan coba lagi.');
        });
    }

    function showVoucherApplied() {
        if (!voucherData) return;

        const card = document.getElementById('voucherAppliedCard');
        const nameEl = document.getElementById('voucherAppliedName');
        const discountEl = document.getElementById('voucherAppliedDiscount');

        nameEl.textContent = voucherData.title;

        let discountText = '';
        if (voucherData.type === 'fixed') {
            discountText = 'Potongan Rp ' + number_format(voucherDiscount, 0, ',', '.');
        } else if (voucherData.type === 'percent') {
            discountText = 'Potongan ' + voucherData.discountValue + '% (Rp ' + number_format(voucherDiscount, 0, ',', '.') + ')';
        } else {
            discountText = 'Cashback ' + voucherData.cashbackCoin + ' Coin';
        }

        discountEl.textContent = discountText;
        card.style.display = 'block';
    }

    function showVoucherError(message) {
        document.getElementById('voucherError').style.display = 'block';
        document.getElementById('voucherErrorText').textContent = message;
    }

    function showVoucherSuccess(message) {
        document.getElementById('voucherSuccess').style.display = 'block';
        document.getElementById('voucherSuccessText').textContent = message;
        setTimeout(() => {
            document.getElementById('voucherSuccess').style.display = 'none';
        }, 3000);
    }

    function hideVoucherMessages() {
        document.getElementById('voucherError').style.display = 'none';
        document.getElementById('voucherSuccess').style.display = 'none';
    }

    function removeVoucher() {
        selectedVoucher = null;
        voucherDiscount = 0;
        voucherData = null;
        document.getElementById('voucherAppliedCard').style.display = 'none';
        document.getElementById('voucherSelect').value = '';
        document.getElementById('voucherCode').value = '';
        hideVoucherMessages();
        recalculateOrderTotal();
    }

    // Helper function for number formatting
    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    // Load vouchers when shipping is calculated
    const originalSelectCourier = window.selectCourier;
    if (originalSelectCourier) {
        window.selectCourier = function() {
            originalSelectCourier.apply(this, arguments);
            setTimeout(loadAvailableVouchers, 500);
        };
    }

    // Load vouchers on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadAvailableVouchers();
    });

    // Form validation before submit
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const courierCode = document.getElementById('courier_code').value;
        const shippingCost = document.getElementById('shipping_cost_input').value;
        
        if (!courierCode || !shippingCost || shippingCost == '0') {
            e.preventDefault();
            alert('Please select delivery location and courier first.');
            return false;
        }
        
        // Add voucher_id to form if selected
        if (selectedVoucher) {
            let voucherInput = document.getElementById('voucher_id_input');
            if (!voucherInput) {
                voucherInput = document.createElement('input');
                voucherInput.type = 'hidden';
                voucherInput.name = 'voucher_id';
                voucherInput.id = 'voucher_id_input';
                document.getElementById('checkoutForm').appendChild(voucherInput);
            }
            voucherInput.value = selectedVoucher;
        }
        
        console.log('Submitting form with:', {
            courierCode,
            courierName: document.getElementById('courier_name').value,
            courierServiceCode: document.getElementById('courier_service_code').value,
            courierService: document.getElementById('courier_service_name').value,
            shippingCost,
            lat: document.getElementById('shipping_latitude').value,
            lng: document.getElementById('shipping_longitude').value
        });
    });
</script>
@endpush
@endsection
