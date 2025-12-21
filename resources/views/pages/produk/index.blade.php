@extends('layouts.app')

@section('title', 'Produk - PATAH')

@section('content')
<!-- Hero -->
<section class="page-hero">
    <div class="container">
        <span class="section-badge">Produk Kami</span>
        <h1 class="page-title">Pilihan Kerupuk <span class="text-primary">Sehat</span></h1>
        <p class="page-subtitle">Temukan varian kerupuk PATAH favoritmu</p>
    </div>
</section>

<!-- Products -->
<section class="py-5">
    <div class="container">
        <!-- Filter -->
        <div class="filter-bar mb-4">
            <form action="{{ route('produk.index') }}" method="GET" class="d-flex flex-wrap gap-3">
                <div class="filter-item">
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach(\App\Models\Product::categories() as $value => $label)
                            <option value="{{ $value }}" {{ request('category') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-item">
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="">Urutkan</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                    </select>
                </div>
                @if(request()->hasAny(['category', 'sort']))
                    <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </form>
        </div>
        
        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=400' }}" 
                                 alt="{{ $product->name }}">
                            <div class="product-badges">
                                <span class="badge badge-{{ $product->category == 'original' ? 'primary' : 'accent' }}">
                                    {{ $product->category_label }}
                                </span>
                            </div>
                        </div>
                        <div class="product-body">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="product-title mb-0">{{ $product->name }}</h6>
                            </div>
                            <span class="product-weight d-inline-block mb-2">{{ $product->formatted_weight }}</span>
                            <p class="product-desc text-gray small d-none d-md-block">{{ Str::limit($product->description, 50) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="product-price">{{ $product->formatted_price }}</span>
                                @if($product->stock > 0)
                                    <a href="{{ route('produk.show', $product) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye d-md-none"></i>
                                        <span class="d-none d-md-inline">Detail</span>
                                    </a>
                                @else
                                    <span class="badge bg-secondary">Habis</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-4x text-gray mb-3"></i>
                        <h5>Produk Tidak Ditemukan</h5>
                        <p class="text-gray">Coba ubah filter atau kembali lain waktu</p>
                    </div>
                </div>
            @endforelse
        </div>
        
        @if($products->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Mau Pesan Sekarang?</h2>
            <p>Daftar untuk mulai berbelanja dan nikmati berbagai promo menarik!</p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-accent btn-lg">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </a>
            @else
                <a href="{{ route('customer.products.index') }}" class="btn btn-accent btn-lg">
                    <i class="fas fa-shopping-cart me-2"></i>Belanja Sekarang
                </a>
            @endguest
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .page-hero {
        background: var(--white);
        padding: 4rem 0;
        text-align: center;
    }
    
    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .page-subtitle {
        color: var(--gray);
        font-size: 1.125rem;
    }
    
    .filter-bar {
        background: var(--white);
        padding: 1rem;
        border-radius: var(--radius);
        border: 1px solid var(--gray-light);
    }
    
    .filter-item select {
        min-width: 150px;
    }
    
    .product-card {
        background: var(--white);
        border-radius: var(--radius);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--gray-light);
        height: 100%;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    
    .product-image {
        position: relative;
        height: 180px;
        overflow: hidden;
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }
    
    .product-card:hover .product-image img {
        transform: scale(1.05);
    }
    
    .product-badges {
        position: absolute;
        top: 0.75rem;
        left: 0.75rem;
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
        font-size: 1rem;
        font-weight: 800;
        color: var(--primary);
    }
    
    .cta-section {
        background: var(--primary);
        padding: 4rem 0;
    }
    
    .cta-content {
        text-align: center;
        color: white;
    }
    
    .cta-content h2 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .cta-content p {
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }
    
    @media (max-width: 767.98px) {
        .page-title {
            font-size: 1.75rem;
        }
        
        .product-image {
            height: 140px;
        }
    }
</style>
@endpush
