@extends('layouts.app')

@section('title', 'Keranjang Belanja - PATAH')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">
        <i class="fas fa-shopping-cart me-2 text-success"></i>Keranjang Belanja
    </h3>
    
    @if($cartItems->count() > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <span>{{ $cartItems->count() }} Item</span>
                        <form action="{{ route('customer.cart.clear') }}" method="POST" 
                              onsubmit="return confirm('Kosongkan keranjang?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash me-1"></i>Kosongkan
                            </button>
                        </form>
                    </div>
                    <div class="card-body p-0">
                        @foreach($cartItems as $item)
                            <div class="d-flex align-items-center p-3 border-bottom">
                                <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/80' }}" 
                                     alt="{{ $item->product->name }}" class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $item->product->name }}</h6>
                                    <p class="text-success mb-1">{{ $item->product->formatted_price }}</p>
                                    <small class="text-muted">Stok: {{ $item->product->stock }}</small>
                                </div>
                                
                                <div class="d-flex align-items-center me-4">
                                    <form action="{{ route('customer.cart.update', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <div class="input-group" style="width: 130px;">
                                            <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="btn btn-outline-secondary btn-sm" 
                                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                            <input type="text" class="form-control form-control-sm text-center" value="{{ $item->quantity }}" readonly>
                                            <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="btn btn-outline-secondary btn-sm"
                                                    {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>+</button>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="text-end me-4" style="min-width: 120px;">
                                    <strong>{{ $item->formatted_subtotal }}</strong>
                                </div>
                                
                                <form action="{{ route('customer.cart.remove', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <a href="{{ route('customer.products.index') }}" class="btn btn-outline-success">
                    <i class="fas fa-arrow-left me-1"></i>Lanjut Belanja
                </a>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-receipt me-2"></i>Ringkasan Belanja
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Item</span>
                            <span>{{ $cartItems->sum('quantity') }} pcs</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total</strong>
                            <strong class="text-success h5">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                        </div>
                        
                        <a href="{{ route('customer.checkout') }}" class="btn btn-success w-100">
                            <i class="fas fa-credit-card me-1"></i>Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
            <h4 class="text-muted">Keranjang Belanja Kosong</h4>
            <p class="text-muted mb-4">Ayo mulai berbelanja kerupuk sehat PATAH!</p>
            <a href="{{ route('customer.products.index') }}" class="btn btn-success btn-lg">
                <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection
