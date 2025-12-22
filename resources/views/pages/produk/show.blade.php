@extends('layouts.app')

@section('title', $product->name . ' - PATAH')

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
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=600' }}" 
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
                            <span class="price">{{ $product->formatted_discounted_price }}</span>
                            <span class="text-decoration-line-through text-muted">{{ $product->formatted_price }}</span>
                            <span class="badge bg-danger">Hemat {{ $product->formatted_savings_amount }}</span>
                        @else
                            <span class="price">{{ $product->formatted_price }}</span>
                        @endif
                        @if($product->stock > 0)
                            <span class="stock text-success"><i class="fas fa-check-circle me-1"></i>Stok tersedia</span>
                        @else
                            <span class="stock text-danger"><i class="fas fa-times-circle me-1"></i>Stok habis</span>
                        @endif
                    </div>
                    
                    <div class="product-description mb-4">
                        <h6>Deskripsi</h6>
                        <p class="text-gray">{{ $product->description }}</p>
                    </div>
                    
                    <div class="product-features mb-4">
                        <h6>Keunggulan Produk</h6>
                        <div class="features-grid">
                            <div class="feature-item">
                                
                                <span>Tanpa Pengawet</span>
                            </div>
                            <div class="feature-item">
                                
                                <span>Tanpa MSG</span>
                            </div>
                            <div class="feature-item">
                                
                                <span>Bahan Alami</span>
                            </div>
                            <div class="feature-item">
                                
                                <span>Halal</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="product-actions">
                        @auth
                            @if($product->stock > 0)
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
                                <button class="btn btn-secondary btn-lg w-100" disabled>
                                    <i class="fas fa-times me-2"></i>Stok Habis
                                </button>
                            @endif
                        @else
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
                            <img src="{{ $related->image ? asset('storage/' . $related->image) : 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=400' }}" 
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
                                <a href="{{ route('produk.show', $related) }}" class="btn btn-sm btn-outline-primary">Detail</a>
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
<style>
    .product-gallery img {
        width: 100%;
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
        height: 150px;
        overflow: hidden;
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
            height: 120px;
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
            height: 100px;
        }
        
        .product-title {
            font-size: 0.75rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function decreaseQty() {
        const input = document.getElementById('quantity');
        if (input.value > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
    
    function increaseQty() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.getAttribute('max'));
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }
</script>
@endpush
