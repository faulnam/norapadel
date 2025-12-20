@extends('layouts.app')

@section('title', 'Produk - PATAH')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
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
                                <option value="pakcoy" {{ request('category') == 'pakcoy' ? 'selected' : '' }}>Pakcoy</option>
                                <option value="tahu" {{ request('category') == 'tahu' ? 'selected' : '' }}>Tahu</option>
                                <option value="mix" {{ request('category') == 'mix' ? 'selected' : '' }}>Mix</option>
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
        
        <!-- Products Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    <i class="fas fa-box me-2 text-success"></i>Produk Kami
                </h4>
                <span class="text-muted">{{ $products->total() }} produk ditemukan</span>
            </div>
            
            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 product-card">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=400' }}" 
                                 class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <span class="badge bg-success mb-2">{{ ucfirst($product->category) }}</span>
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit($product->description, 60) }}</p>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="h5 text-success mb-0">{{ $product->formatted_price }}</span>
                                    @if($product->stock > 0)
                                        <small class="text-muted">Stok: {{ $product->stock }}</small>
                                    @else
                                        <small class="text-danger">Habis</small>
                                    @endif
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <a href="{{ route('customer.products.show', $product) }}" class="btn btn-outline-success">
                                        <i class="fas fa-eye me-1"></i>Lihat Detail
                                    </a>
                                    @if($product->stock > 0)
                                        <form action="{{ route('customer.cart.add', $product) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="fas fa-cart-plus me-1"></i>Tambah ke Keranjang
                                            </button>
                                        </form>
                                    @endif
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
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
</style>
@endpush
