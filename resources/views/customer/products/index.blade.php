@extends('layouts.app')

@section('title', 'Produk - PATAH')

@section('content')
<div class="container py-4 py-lg-5">
    <div class="row">
        <!-- Mobile Filter Toggle -->
        <div class="col-12 d-lg-none mb-3">
            <button class="btn btn-success w-100" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false">
                <i class="fas fa-filter me-2"></i>Filter Produk
                <i class="fas fa-chevron-down ms-2 filter-toggle-icon"></i>
            </button>
        </div>
        
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="collapse d-lg-block" id="filterCollapse">
                <div class="card filter-card">
                    <div class="card-header bg-success text-white d-none d-lg-block">
                        <i class="fas fa-filter me-2"></i>Filter Produk
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customer.products.index') }}" method="GET">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Cari Produk</label>
                                <input type="text" class="form-control" name="search" placeholder="Nama produk..." value="{{ request('search') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kategori</label>
                                <select class="form-select" name="category">
                                    <option value="">Semua Kategori</option>
                                    @foreach(\App\Models\Product::categories() as $value => $label)
                                        <option value="{{ $value }}" {{ request('category') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Urutkan</label>
                                <select class="form-select" name="sort">
                                    <option value="">Terbaru</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-search me-1"></i>Terapkan Filter
                            </button>
                            
                            @if(request()->hasAny(['search', 'category', 'sort']))
                                <a href="{{ route('customer.products.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                                    Reset Filter
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    <i class="fas fa-box me-2 text-success"></i>Produk Kami
                </h4>
                <span class="text-muted">{{ $products->total() }} produk ditemukan</span>
            </div>
            
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-3 g-3 g-lg-4">
                @forelse($products as $product)
                    <div class="col">
                        <div class="card h-100 product-card">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=400' }}" 
                                 class="card-img-top product-img" alt="{{ $product->name }}">
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <span class="badge bg-{{ $product->category == 'original' ? 'success' : 'danger' }} product-badge">{{ $product->category_label }}</span>
                                    <span class="badge bg-secondary product-badge d-none d-sm-inline-block">{{ $product->formatted_weight }}</span>
                                </div>
                                <h6 class="card-title product-title mb-1">{{ $product->name }}</h6>
                                <p class="card-text text-muted small mb-2 d-none d-md-block product-desc">{{ Str::limit($product->description, 60) }}</p>
                                
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="product-price text-success fw-bold">{{ $product->formatted_price }}</span>
                                        @if($product->stock > 0)
                                            <small class="text-muted d-none d-sm-inline">Stok: {{ $product->stock }}</small>
                                        @else
                                            <small class="text-danger fw-semibold">Habis</small>
                                        @endif
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('customer.products.show', $product) }}" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-eye me-1 d-none d-sm-inline"></i>Detail
                                        </a>
                                        @if($product->stock > 0)
                                            <form action="{{ route('customer.cart.add', $product) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-success w-100 btn-sm">
                                                    <i class="fas fa-cart-plus me-1 d-none d-sm-inline"></i><span class="d-sm-none">+</span><span class="d-none d-sm-inline">+ Keranjang</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada produk ditemukan</h5>
                            <p class="text-muted">Coba ubah filter pencarian Anda</p>
                        </div>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Product Card */
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #e9ecef;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }
    
    /* Product Image */
    .product-img {
        height: 200px;
        object-fit: cover;
    }
    
    /* Product Title */
    .product-title {
        font-size: 1rem;
        font-weight: 600;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.3;
    }
    
    /* Product Description */
    .product-desc {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Product Price */
    .product-price {
        font-size: 1.1rem;
    }
    
    /* Product Badge */
    .product-badge {
        font-size: 0.7rem;
    }
    
    /* Filter Card */
    .filter-card {
        border: 1px solid #e9ecef;
    }
    
    /* Filter Toggle Icon Animation */
    .filter-toggle-icon {
        transition: transform 0.3s;
    }
    [aria-expanded="true"] .filter-toggle-icon {
        transform: rotate(180deg);
    }
    
    /* Tablet */
    @media (min-width: 768px) and (max-width: 991.98px) {
        .product-img {
            height: 180px;
        }
    }
    
    /* Mobile */
    @media (max-width: 767.98px) {
        .product-img {
            height: 140px;
        }
        .product-title {
            font-size: 0.85rem;
        }
        .product-price {
            font-size: 0.95rem;
        }
        .product-badge {
            font-size: 0.6rem;
            padding: 0.2em 0.5em;
        }
        .product-card .card-body {
            padding: 0.75rem;
        }
        .product-card .btn-sm {
            font-size: 0.75rem;
            padding: 0.35rem 0.5rem;
        }
    }
    
    /* Small Mobile */
    @media (max-width: 575.98px) {
        .product-img {
            height: 120px;
        }
        .product-card:hover {
            transform: none;
            box-shadow: none;
        }
    }
</style>
@endpush
