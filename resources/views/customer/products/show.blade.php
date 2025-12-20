@extends('layouts.app')

@section('title', $product->name . ' - PATAH')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.products.index') }}" class="text-decoration-none">Produk</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>
    
    <div class="row">
        <!-- Product Image -->
        <div class="col-lg-5 mb-4">
            <div class="card">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=600' }}" 
                     class="card-img-top" alt="{{ $product->name }}" style="max-height: 400px; object-fit: cover;">
            </div>
        </div>
        
        <!-- Product Details -->
        <div class="col-lg-7">
            <span class="badge bg-success mb-2">{{ ucfirst($product->category) }}</span>
            <h2 class="mb-3">{{ $product->name }}</h2>
            
            <div class="mb-4">
                <span class="h2 text-success">{{ $product->formatted_price }}</span>
            </div>
            
            <div class="mb-4">
                @if($product->stock > 10)
                    <span class="badge bg-success"><i class="fas fa-check me-1"></i>Stok Tersedia ({{ $product->stock }})</span>
                @elseif($product->stock > 0)
                    <span class="badge bg-warning"><i class="fas fa-exclamation-triangle me-1"></i>Stok Terbatas ({{ $product->stock }})</span>
                @else
                    <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Stok Habis</span>
                @endif
            </div>
            
            <div class="mb-4">
                <h6 class="fw-bold">Deskripsi Produk</h6>
                <p class="text-muted">{{ $product->description }}</p>
            </div>
            
            <div class="mb-4">
                <h6 class="fw-bold">Keunggulan:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check-circle text-success me-2"></i>Tanpa Pengawet</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i>Tanpa MSG</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i>100% Bahan Alami</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i>Renyah & Gurih</li>
                </ul>
            </div>
            
            @if($product->stock > 0)
                <form action="{{ route('customer.cart.add', $product) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-auto">
                            <label class="form-label">Jumlah</label>
                            <div class="input-group" style="width: 150px;">
                                <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty()">-</button>
                                <input type="number" class="form-control text-center" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}">
                                <button type="button" class="btn btn-outline-secondary" onclick="increaseQty()">+</button>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>Maaf, produk ini sedang tidak tersedia.
                </div>
            @endif
            
            <hr>
            
            <div class="d-flex gap-3">
                <a href="{{ route('customer.cart.index') }}" class="btn btn-outline-success">
                    <i class="fas fa-shopping-cart me-1"></i>Lihat Keranjang
                </a>
                <a href="{{ route('customer.products.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Lanjut Belanja
                </a>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <hr class="my-5">
        <h4 class="mb-4"><i class="fas fa-box me-2 text-success"></i>Produk Terkait</h4>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 product-card">
                        <img src="{{ $related->image ? asset('storage/' . $related->image) : 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=400' }}" 
                             class="card-img-top" alt="{{ $related->name }}" style="height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h6 class="card-title">{{ $related->name }}</h6>
                            <p class="text-success fw-bold">{{ $related->formatted_price }}</p>
                            <a href="{{ route('customer.products.show', $related) }}" class="btn btn-outline-success btn-sm w-100">
                                Lihat Detail
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
</style>
@endpush
