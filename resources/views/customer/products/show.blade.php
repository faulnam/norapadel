@extends('layouts.app')

@section('title', $product->name . ' - PATAH')

@section('content')
<div class="container py-4 py-lg-5">
    <nav aria-label="breadcrumb" class="mb-3 mb-lg-4">
        <ol class="breadcrumb breadcrumb-mobile">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.products.index') }}" class="text-decoration-none">Produk</a></li>
            <li class="breadcrumb-item active text-truncate" style="max-width: 150px;">{{ $product->name }}</li>
        </ol>
    </nav>
    
    <div class="row">
        <!-- Product Image -->
        <div class="col-lg-5 mb-4">
            <div class="card product-image-card">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=600' }}" 
                     class="card-img-top product-main-img" alt="{{ $product->name }}">
            </div>
        </div>
        
        <!-- Product Details -->
        <div class="col-lg-7">
            <div class="mb-2">
                <span class="badge bg-{{ $product->category == 'original' ? 'success' : 'danger' }} me-1 product-badge">{{ $product->category_label }}</span>
                <span class="badge bg-secondary product-badge">{{ $product->formatted_weight }}</span>
            </div>
            <h2 class="mb-3 product-title">{{ $product->name }}</h2>
            
            <div class="mb-3 mb-lg-4">
                <span class="product-price text-success">{{ $product->formatted_price }}</span>
            </div>
            
            <div class="mb-3 mb-lg-4">
                @if($product->stock > 10)
                    <span class="badge bg-success stock-badge"><i class="fas fa-check me-1"></i>Stok Tersedia ({{ $product->stock }})</span>
                @elseif($product->stock > 0)
                    <span class="badge bg-warning stock-badge"><i class="fas fa-exclamation-triangle me-1"></i>Stok Terbatas ({{ $product->stock }})</span>
                @else
                    <span class="badge bg-danger stock-badge"><i class="fas fa-times me-1"></i>Stok Habis</span>
                @endif
            </div>
            
            <div class="mb-3 mb-lg-4">
                <h6 class="fw-bold desc-title">Deskripsi Produk</h6>
                <p class="text-muted desc-text">{{ $product->description }}</p>
            </div>
            
            <div class="mb-3 mb-lg-4">
                <h6 class="fw-bold desc-title">Keunggulan:</h6>
                <ul class="list-unstyled keunggulan-list">
                    <li><i class="fas fa-check-circle text-success me-2"></i>Tanpa Pengawet</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i>Tanpa MSG</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i>100% Bahan Alami</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i>Renyah & Gurih</li>
                </ul>
            </div>
            
            @if($product->stock > 0)
                <form action="{{ route('customer.cart.add', $product) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="row g-2 g-lg-3 align-items-end">
                        <div class="col-5 col-sm-auto">
                            <label class="form-label small">Jumlah</label>
                            <div class="input-group qty-input-group">
                                <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty()">-</button>
                                <input type="number" class="form-control text-center" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}">
                                <button type="button" class="btn btn-outline-secondary" onclick="increaseQty()">+</button>
                            </div>
                        </div>
                        <div class="col-7 col-sm-auto">
                            <button type="submit" class="btn btn-success add-cart-btn w-100">
                                <i class="fas fa-cart-plus me-1 me-sm-2"></i><span class="d-none d-sm-inline">Tambah ke </span>Keranjang
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div class="alert alert-danger py-2">
                    <i class="fas fa-exclamation-circle me-2"></i>Maaf, produk ini sedang tidak tersedia.
                </div>
            @endif
            
            <hr>
            
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('customer.cart.index') }}" class="btn btn-outline-success btn-action-mobile">
                    <i class="fas fa-shopping-cart me-1"></i>Keranjang
                </a>
                <a href="{{ route('customer.products.index') }}" class="btn btn-outline-secondary btn-action-mobile">
                    <i class="fas fa-arrow-left me-1"></i>Belanja
                </a>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <hr class="my-4 my-lg-5">
        <h4 class="mb-4 related-title"><i class="fas fa-box me-2 text-success"></i>Produk Terkait</h4>
        <div class="row g-3 g-lg-4">
            @foreach($relatedProducts as $related)
                <div class="col-6 col-md-6 col-lg-3">
                    <div class="card h-100 product-card">
                        <img src="{{ $related->image ? asset('storage/' . $related->image) : 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=400' }}" 
                             class="card-img-top related-product-img" alt="{{ $related->name }}">
                        <div class="card-body p-2 p-lg-3">
                            <h6 class="card-title related-product-title">{{ $related->name }}</h6>
                            <p class="text-success fw-bold related-product-price mb-2">{{ $related->formatted_price }}</p>
                            <a href="{{ route('customer.products.show', $related) }}" class="btn btn-outline-success btn-sm w-100">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
const maxStock = {{ $product->stock }};

function decreaseQty() {
    const input = document.getElementById('quantity');
    if (input.value > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function increaseQty() {
    const input = document.getElementById('quantity');
    if (input.value < maxStock) {
        input.value = parseInt(input.value) + 1;
    }
}
</script>
@endpush

@push('styles')
<style>
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .product-main-img {
        max-height: 400px;
        object-fit: cover;
    }
    .product-price {
        font-size: 1.75rem;
        font-weight: 700;
    }
    .qty-input-group {
        width: 130px;
    }
    .add-cart-btn {
        padding: 0.5rem 1.5rem;
    }
    .related-product-img {
        height: 150px;
        object-fit: cover;
    }
    
    /* Mobile Responsive */
    @media (max-width: 991.98px) {
        .product-main-img {
            max-height: 350px;
        }
    }
    
    @media (max-width: 767.98px) {
        .breadcrumb-mobile {
            font-size: 0.8rem;
        }
        .product-main-img {
            max-height: 280px;
        }
        .product-title {
            font-size: 1.4rem;
        }
        .product-badge {
            font-size: 0.7rem;
        }
        .product-price {
            font-size: 1.4rem;
        }
        .stock-badge {
            font-size: 0.75rem;
        }
        .desc-title {
            font-size: 0.9rem;
        }
        .desc-text {
            font-size: 0.85rem;
        }
        .keunggulan-list {
            font-size: 0.85rem;
        }
        .keunggulan-list li {
            margin-bottom: 0.25rem;
        }
        .qty-input-group {
            width: 110px;
        }
        .qty-input-group .btn {
            padding: 0.25rem 0.5rem;
        }
        .qty-input-group input {
            padding: 0.25rem;
        }
        .add-cart-btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        .btn-action-mobile {
            font-size: 0.85rem;
            padding: 0.4rem 0.75rem;
        }
        .related-title {
            font-size: 1.1rem;
        }
        .related-product-img {
            height: 120px;
        }
        .related-product-title {
            font-size: 0.85rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .related-product-price {
            font-size: 0.9rem;
        }
        .product-card:hover {
            transform: none;
            box-shadow: none;
        }
    }
    
    @media (max-width: 575.98px) {
        .product-main-img {
            max-height: 220px;
        }
        .product-title {
            font-size: 1.2rem;
        }
        .product-price {
            font-size: 1.25rem;
        }
        .related-product-img {
            height: 100px;
        }
        .related-product-title {
            font-size: 0.8rem;
        }
        .related-product-price {
            font-size: 0.85rem;
        }
    }
</style>
@endpush
