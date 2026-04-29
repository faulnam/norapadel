@extends('layouts.app')

@section('title', $product->name . ' - Nora Padel')

@section('content')
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('produk.index') }}" class="text-decoration-none">Produk</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>
        
        <div class="row g-5">
            <div class="col-lg-5">
                <div class="product-gallery">
                <img id="mainProductImage"
                     src="{{ $product->image_url }}" 
                     alt="{{ $product->name }}" class="img-fluid rounded-3">
                </div>
            </div>
            
            <div class="col-lg-7">
                <div class="product-info">
                    <div class="d-flex gap-2 mb-3">
                        <span class="badge badge-{{ $product->category == 'original' ? 'primary' : 'accent' }}">
                            {{ $product->category_label }}
                        </span>
                        <span class="badge" style="background: var(--gray-light); color: var(--gray);">
                            {{ $product->formatted_weight }}
                        </span>
                        @if($product->hasActiveDiscount())
                            <span class="badge bg-danger">-{{ $product->formatted_discount_percent }}</span>
                        @endif
                    </div>
                    
                    <h1 class="product-name">{{ $product->name }}</h1>
                    
                    <div class="product-price-box mb-4">
                        @if($product->hasActiveDiscount())
                            <span class="price" id="displayPrice">{{ $product->formatted_discounted_price }}</span>
                            <span class="text-decoration-line-through text-muted">{{ $product->formatted_price }}</span>
                            <span class="badge bg-danger">Hemat {{ $product->formatted_savings_amount }}</span>
                        @else
                            <span class="price" id="displayPrice">{{ $product->formatted_price }}</span>
                        @endif
                        <span class="stock" id="stockBadge">
                        @if($product->stock > 0)
                            <span class="text-success"><i class="fas fa-check-circle me-1"></i>Stok tersedia</span>
                        @else
                            <span class="text-danger"><i class="fas fa-times-circle me-1"></i>Stok habis</span>
                        @endif
                        </span>
                    </div>
                    
                    <div class="product-description mb-4">
                        <h6>Deskripsi</h6>
                        <p class="text-gray">{{ $product->description }}</p>
                    </div>
                    
                    {{-- Varian Section (Di atas tombol beli) --}}
                    @if($product->has_variants && $product->activeVariants->count() > 0)
                        <div class="mb-4 p-3 border rounded" style="background: #f8f9fa;" id="variantSection">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="mb-0 fw-bold">Pilih Varian <span class="text-danger">*</span></h6>
                                <span id="variantSelectedLabel" class="badge bg-success" style="display:none;">
                                    <i class="fas fa-check me-1"></i>Dipilih
                                </span>
                            </div>
                            
                            {{-- Grid Varian dengan Gambar --}}
                            <div class="row g-2 mb-3">
                                @foreach($product->activeVariants as $variant)
                                <div class="col-4 col-sm-3 col-md-2">
                                    <button type="button"
                                        class="variant-card-btn w-100 p-2 border rounded position-relative bg-white"
                                        data-variant-id="{{ $variant->id }}"
                                        data-variant-name="{{ $variant->name }}"
                                        data-variant-stock="{{ $variant->stock }}"
                                        data-variant-price="{{ $variant->formatted_final_price }}"
                                        data-variant-image="{{ $variant->image_url }}"
                                        onclick="selectVariant(this)"
                                        {{ $variant->stock <= 0 ? 'disabled' : '' }}
                                        style="border: 2px solid #dee2e6; transition: all 0.2s; cursor: pointer; {{ $variant->stock <= 0 ? 'opacity: 0.5; cursor: not-allowed;' : '' }}">
                                        
                                        {{-- Checkmark Badge --}}
                                        <div class="variant-check position-absolute" style="top: 4px; right: 4px; display: none;">
                                            <span class="badge bg-dark rounded-circle d-flex align-items-center justify-center" style="width: 20px; height: 20px; padding: 0;">
                                                <i class="fas fa-check" style="font-size: 10px;"></i>
                                            </span>
                                        </div>
                                        
                                        {{-- Gambar Varian --}}
                                        <div class="variant-image mb-2" style="aspect-ratio: 1; overflow: hidden; border-radius: 6px; background: #f8f9fa;">
                                            <img src="{{ $variant->image_url }}" 
                                                 alt="{{ $variant->name }}"
                                                 class="w-100 h-100"
                                                 style="object-fit: cover;"
                                                 onerror="this.src='{{ $product->image_url }}'">
                                        </div>
                                        
                                        {{-- Nama Varian --}}
                                        <div class="text-center" style="font-size: 0.75rem; font-weight: 600; color: #212529;">
                                            {{ $variant->name }}
                                        </div>
                                        
                                        {{-- Stock Badge --}}
                                        @if($variant->stock <= 0)
                                            <div class="text-center mt-1">
                                                <small class="badge bg-danger" style="font-size: 0.65rem;">Habis</small>
                                            </div>
                                        @elseif($variant->stock <= 5)
                                            <div class="text-center mt-1">
                                                <small class="badge bg-warning text-dark" style="font-size: 0.65rem;">{{ $variant->stock }}</small>
                                            </div>
                                        @endif
                                        
                                        {{-- Price Adjustment --}}
                                        @if($variant->price_adjustment != 0)
                                            <div class="text-center mt-1">
                                                <small class="badge {{ $variant->price_adjustment > 0 ? 'bg-primary' : 'bg-success' }}" style="font-size: 0.65rem;">
                                                    {{ $variant->price_adjustment > 0 ? '+' : '' }}{{ number_format(abs($variant->price_adjustment), 0) }}
                                                </small>
                                            </div>
                                        @endif
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            
                            {{-- Hint Message --}}
                            <div id="variantHint" class="alert alert-danger py-2 px-3 mb-0" style="font-size: 0.875rem;">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                <span>Pilih varian terlebih dahulu</span>
                            </div>
                        </div>
                    @endif
                    
                    <div class="product-features mb-4">
                        <h6>Keunggulan Produk</h6>
                        <div class="features-grid">
                            <div class="feature-item">
                                
                                <span>Material Premium</span>
                            </div>
                            <div class="feature-item">
                                
                                <span>Durabilitas Tinggi</span>
                            </div>
                            <div class="feature-item">
                                
                                <span>Nyaman Digunakan</span>
                            </div>
                            <div class="feature-item">
                                
                                <span>Cocok Semua Level</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="product-actions">
                        @auth
                            @if($product->has_variants && $product->activeVariants->count() > 0)
                                {{-- Form dengan Varian (Varian selector sudah di atas) --}}
                                <form action="{{ route('customer.cart.add', $product) }}" method="POST" id="addToCartForm">
                                    @csrf
                                    <input type="hidden" name="variant_id" id="selectedVariantId" required>
                                    
                                    <div class="d-flex gap-3">
                                        <div class="quantity-selector">
                                            <button type="button" class="qty-btn" onclick="decreaseQty()" disabled id="qtyMinus">-</button>
                                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="1" disabled>
                                            <button type="button" class="qty-btn" onclick="increaseQty()" disabled id="qtyPlus">+</button>
                                        </div>
                                        <button type="submit" class="btn btn-accent btn-lg flex-grow-1" id="addCartBtn" disabled>
                                            <i class="fas fa-shopping-cart me-2"></i>Tambah ke Keranjang
                                        </button>
                                    </div>
                                </form>
                            
                            @elseif($product->stock > 0)
                                {{-- Produk tanpa varian --}}
                                <form action="{{ route('customer.cart.add', $product) }}" method="POST" class="d-flex gap-3">
                                    @csrf
                                    <div class="quantity-selector">
                                        <button type="button" class="qty-btn" onclick="decreaseQty()">-</button>
                                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}">
                                        <button type="button" class="qty-btn" onclick="increaseQty()">+</button>
                                    </div>
                                    <button type="submit" class="btn btn-accent btn-lg flex-grow-1">
                                        <i class="fas fa-shopping-cart me-2"></i>Tambah ke Keranjang
                                    </button>
                                </form>
                            
                            @else
                                {{-- Stok Habis --}}
                                <button class="btn btn-secondary btn-lg w-100" disabled>
                                    <i class="fas fa-times me-2"></i>Stok Habis
                                </button>
                            @endif
                        @else
                            {{-- Not Logged In --}}
                            <a href="{{ route('login') }}" class="btn btn-accent btn-lg w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>Masuk untuk Membeli
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<section class="py-5 bg-gray-light">
    <div class="container">
        <h4 class="section-title mb-4">Produk Lainnya</h4>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
                <div class="col-6 col-md-3">
                    <div class="product-card">
                        <div class="product-image">
                       <img src="{{ $related->image ? asset('storage/' . $related->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80' }}" 
                                 alt="{{ $related->name }}">
                            @if($related->hasActiveDiscount())
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-danger">-{{ $related->formatted_discount_percent }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="product-body">
                            <h6 class="product-title mb-1">{{ $related->name }}</h6>
                            <span class="product-weight d-inline-block mb-2">{{ $related->formatted_weight }}</span>
                            <div class="d-flex justify-content-between align-items-center">
                                @if($related->hasActiveDiscount())
                                    <div>
                                        <span class="product-price">{{ $related->formatted_discounted_price }}</span>
                                        <small class="text-decoration-line-through text-muted d-block">{{ $related->formatted_price }}</small>
                                    </div>
                                @else
                                    <span class="product-price">{{ $related->formatted_price }}</span>
                                @endif
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-primary"
                                    data-product-trigger
                                    data-product-id="{{ $related->id }}"
                                    data-product-name="{{ e($related->name) }}"
                                    data-product-category="{{ e($related->category_label) }}"
                                    data-product-description="{{ e(\Illuminate\Support\Str::limit(strip_tags($related->description ?? ''), 180)) }}"
                                    data-product-image="{{ $related->image ? asset('storage/' . $related->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80' }}"
                                    data-product-price="{{ $related->hasActiveDiscount() ? $related->formatted_discounted_price : $related->formatted_price }}"
                                    data-product-old-price="{{ $related->hasActiveDiscount() ? $related->formatted_price : '' }}"
                                >Detail</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<style>
    .product-gallery {
        position: relative;
        /* Rasio 4:5 seperti Instagram */
        aspect-ratio: 4 / 5;
        overflow: hidden;
        border-radius: 1rem;
        background: var(--gray-light);
    }
    
    .product-gallery img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 1px solid var(--gray-light);
    }
    
    .product-name {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }
    
    .product-price-box {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    
    .product-price-box .price {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--primary);
    }
    
    .product-price-box .stock {
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .feature-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem;
        background: var(--gray-light);
        border-radius: var(--radius-sm);
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .quantity-selector {
        display: flex;
        align-items: center;
        border: 1px solid var(--gray-light);
        border-radius: var(--radius-sm);
        overflow: hidden;
    }
    
    .qty-btn {
        width: 40px;
        height: 48px;
        border: none;
        background: var(--gray-light);
        font-size: 1.25rem;
        cursor: pointer;
        transition: var(--transition);
    }
    
    .qty-btn:hover {
        background: var(--primary-light);
        color: var(--primary);
    }
    
    .quantity-selector input {
        width: 50px;
        height: 48px;
        border: none;
        text-align: center;
        font-weight: 600;
        font-size: 1rem;
    }
    
    .product-card {
        background: var(--white);
        border-radius: var(--radius);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--gray-light);
    }
    
    .product-card:hover {
        box-shadow: var(--shadow);
    }
    
    .product-image {
        /* Rasio 4:5 seperti Instagram */
        aspect-ratio: 4 / 5;
        overflow: hidden;
        background: var(--gray-light);
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-body {
        padding: 1rem;
    }
    
    .product-title {
        font-weight: 700;
        font-size: 0.9rem;
    }
    
    .product-weight {
        background: var(--gray-light);
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--gray);
    }
    
    .product-price {
        font-weight: 700;
        color: var(--primary);
    }
    
    /* Responsive for product detail */
    @media (max-width: 991.98px) {
        .product-gallery {
            margin-bottom: 1.5rem;
        }
        
        .product-name {
            font-size: 1.625rem;
        }
        
        .product-price-box .price {
            font-size: 1.5rem;
        }
    }
    
    @media (max-width: 767.98px) {
        section.py-5 {
            padding: 1.5rem 0 !important;
        }
        
        .breadcrumb {
            font-size: 0.8125rem;
            margin-bottom: 1rem !important;
        }
        
        .product-gallery img {
            border-radius: 12px;
        }
        
        .product-name {
            font-size: 1.375rem;
            margin-bottom: 0.75rem;
        }
        
        .product-price-box {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .product-price-box .price {
            font-size: 1.375rem;
        }
        
        .product-price-box .stock {
            font-size: 0.8125rem;
        }
        
        .product-description h6,
        .product-features h6 {
            font-size: 0.9375rem;
        }
        
        .product-description p {
            font-size: 0.875rem;
        }
        
        .features-grid {
            grid-template-columns: 1fr 1fr;
            gap: 0.625rem;
        }
        
        .feature-item {
            padding: 0.5rem;
            font-size: 0.75rem;
        }
        
        .feature-item i {
            font-size: 0.875rem;
        }
        
        .product-actions form {
            flex-direction: column;
        }
        
        .quantity-selector {
            width: 100%;
            justify-content: center;
        }
        
        .quantity-selector input {
            flex: 1;
            max-width: 100px;
        }
        
        .product-actions .btn-lg {
            padding: 0.75rem 1rem;
            font-size: 0.9375rem;
        }
        
        /* Related products */
        .section-title {
            font-size: 1.25rem;
        }
        
        .product-image {
            /* Rasio 4:5 tetap untuk mobile */
            aspect-ratio: 4 / 5;
        }
        
        .product-body {
            padding: 0.75rem;
        }
        
        .product-title {
            font-size: 0.8125rem;
        }
        
        .product-weight {
            font-size: 0.625rem;
        }
        
        .product-price {
            font-size: 0.8125rem;
        }
        
        .product-card .btn-sm {
            font-size: 0.6875rem;
            padding: 0.25rem 0.5rem;
        }
    }
    
    @media (max-width: 575.98px) {
        .product-name {
            font-size: 1.25rem;
        }
        
        .product-price-box .price {
            font-size: 1.25rem;
        }
        
        .features-grid {
            gap: 0.5rem;
        }
        
        .feature-item {
            padding: 0.375rem;
            font-size: 0.6875rem;
            gap: 0.375rem;
        }
        
        .product-image {
            /* Rasio 4:5 tetap untuk small mobile */
            aspect-ratio: 4 / 5;
        }
        
        .product-title {
            font-size: 0.75rem;
        }
    }

    .variant-btn {
        min-width: 70px;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    .variant-btn.btn-primary {
        box-shadow: 0 0 0 3px rgba(var(--bs-primary-rgb), 0.25);
    }
    .variant-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    #mainProductImage {
        transition: opacity 0.25s ease;
    }
    .qty-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endpush

@push('scripts')
<script>
    function decreaseQty() {
        const input = document.getElementById('quantity');
        if (input.value > 1) input.value = parseInt(input.value) - 1;
    }
    
    function increaseQty() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.getAttribute('max'));
        if (parseInt(input.value) < max) input.value = parseInt(input.value) + 1;
    }

    function selectVariant(btn) {
        // Remove active state from all variants
        document.querySelectorAll('.variant-card-btn').forEach(card => {
            card.style.borderColor = '#dee2e6';
            card.style.backgroundColor = '#ffffff';
            card.style.transform = 'scale(1)';
            const check = card.querySelector('.variant-check');
            if (check) check.style.display = 'none';
        });

        // Add active state to selected variant
        btn.style.borderColor = '#000000';
        btn.style.backgroundColor = '#f8f9fa';
        btn.style.transform = 'scale(1.05)';
        const check = btn.querySelector('.variant-check');
        if (check) check.style.display = 'block';

        const stock = parseInt(btn.dataset.variantStock);
        const image = btn.dataset.variantImage;
        const price = btn.dataset.variantPrice;
        const name = btn.dataset.variantName;

        // Update main image with smooth fade effect
        const img = document.getElementById('mainProductImage');
        if (img) {
            img.style.transition = 'opacity 0.3s ease';
            img.style.opacity = '0';
            setTimeout(() => { 
                img.src = image; 
                img.style.opacity = '1'; 
            }, 300);
        }

        // Update price
        const priceEl = document.getElementById('displayPrice');
        if (priceEl) {
            priceEl.style.transition = 'color 0.3s ease';
            priceEl.style.color = '#28a745';
            priceEl.textContent = price;
            setTimeout(() => { priceEl.style.color = ''; }, 500);
        }

        // Update stock badge
        const stockBadge = document.getElementById('stockBadge');
        if (stockBadge) {
            if (stock > 0) {
                stockBadge.innerHTML = `<span class="text-success"><i class="fas fa-check-circle me-1"></i>Stok tersedia (${stock})</span>`;
            } else {
                stockBadge.innerHTML = `<span class="text-danger"><i class="fas fa-times-circle me-1"></i>Stok habis</span>`;
            }
        }

        // Update quantity input
        const qtyInput = document.getElementById('quantity');
        if (qtyInput) {
            qtyInput.max = stock;
            qtyInput.value = Math.min(parseInt(qtyInput.value) || 1, stock || 1);
            qtyInput.disabled = stock <= 0;
        }

        // Enable/disable quantity buttons
        const qtyMinus = document.getElementById('qtyMinus');
        const qtyPlus = document.getElementById('qtyPlus');
        if (qtyMinus) qtyMinus.disabled = stock <= 0;
        if (qtyPlus) qtyPlus.disabled = stock <= 0;

        // Update hidden variant id
        const variantInput = document.getElementById('selectedVariantId');
        if (variantInput) variantInput.value = btn.dataset.variantId;

        // Enable/disable add to cart button
        const addBtn = document.getElementById('addCartBtn');
        if (addBtn) addBtn.disabled = stock <= 0;

        // Update hint message with animation
        const hint = document.getElementById('variantHint');
        const selectedLabel = document.getElementById('variantSelectedLabel');
        
        if (hint) {
            hint.style.transition = 'all 0.3s ease';
            if (stock > 0) {
                hint.className = 'alert alert-success py-2 px-3 mb-0';
                hint.style.fontSize = '0.875rem';
                hint.innerHTML = `<i class="fas fa-check-circle me-1"></i><span>Varian dipilih: <strong>${name}</strong></span>`;
                if (selectedLabel) selectedLabel.style.display = 'inline-block';
            } else {
                hint.className = 'alert alert-danger py-2 px-3 mb-0';
                hint.style.fontSize = '0.875rem';
                hint.innerHTML = `<i class="fas fa-times-circle me-1"></i><span>Varian <strong>${name}</strong> stok habis</span>`;
                if (selectedLabel) selectedLabel.style.display = 'none';
            }
        }
    }

    // Add hover effect to variant cards
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.variant-card-btn').forEach(btn => {
            if (!btn.disabled) {
                btn.addEventListener('mouseenter', function() {
                    if (this.style.borderColor !== 'rgb(0, 0, 0)') {
                        this.style.borderColor = '#6c757d';
                        this.style.transform = 'scale(1.02)';
                    }
                });
                btn.addEventListener('mouseleave', function() {
                    if (this.style.borderColor !== 'rgb(0, 0, 0)') {
                        this.style.borderColor = '#dee2e6';
                        this.style.transform = 'scale(1)';
                    }
                });
            }
        });
    });
</script>
@endpush
