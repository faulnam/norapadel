@extends('layouts.app')

@section('title', 'Keranjang Belanja - Nora Padel')

@section('content')
<div class="container py-4 py-md-5">
    <h3 class="mb-4 h4 h3-md">
        <i class="fas fa-shopping-cart me-2 text-success"></i>Keranjang Belanja
    </h3>
    
    @if($cartItems->count() > 0)
        <div class="row">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="card mb-3">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-2 py-md-3">
                        <span class="small">{{ $cartItems->count() }} Item</span>
                        <form action="{{ route('customer.cart.clear') }}" method="POST" 
                              onsubmit="return confirm('Kosongkan keranjang?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash me-1"></i><span class="d-none d-sm-inline">Kosongkan</span>
                            </button>
                        </form>
                    </div>
                    <div class="card-body p-0">
                        @foreach($cartItems as $item)
                            <div class="cart-item p-3 border-bottom">
                                <div class="d-flex">
                                    <div class="position-relative me-3">
                                        <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/80' }}" 
                                             alt="{{ $item->product->name }}" class="cart-item-img rounded">
                                        @if($item->product->hasActiveDiscount())
                                            <span class="position-absolute top-0 start-0 badge bg-danger" style="font-size: 10px;">-{{ $item->product->formatted_discount_percent }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1 cart-item-name">{{ $item->product->name }}</h6>
                                                @if($item->product->hasActiveDiscount())
                                                    <p class="text-success mb-0 small">{{ $item->product->formatted_discounted_price }}</p>
                                                    <small class="text-decoration-line-through text-muted">{{ $item->product->formatted_price }}</small>
                                                @else
                                                    <p class="text-success mb-1 small">{{ $item->product->formatted_price }}</p>
                                                @endif
                                            </div>
                                            <form action="{{ route('customer.cart.remove', $item) }}" method="POST" class="d-md-none">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <form action="{{ route('customer.cart.update', $item) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <div class="input-group input-group-sm cart-qty-input">
                                                    <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="btn btn-outline-secondary" 
                                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                                    <input type="text" class="form-control text-center" value="{{ $item->quantity }}" readonly>
                                                    <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="btn btn-outline-secondary"
                                                            {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>+</button>
                                                </div>
                                            </form>
                                            
                                            <strong class="text-success">{{ $item->formatted_subtotal }}</strong>
                                        </div>
                                    </div>
                                    
                                    <!-- Desktop delete button -->
                                    <form action="{{ route('customer.cart.remove', $item) }}" method="POST" class="ms-3 d-none d-md-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <a href="{{ route('customer.products.index') }}" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Lanjut Belanja
                </a>
            </div>
            
            <div class="col-lg-4">
                <div class="card cart-summary">
                    <div class="card-header bg-success text-white py-2 py-md-3">
                        <i class="fas fa-receipt me-2"></i>Ringkasan
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2 small">
                            <span>Total Item</span>
                            <span>{{ $cartItems->sum('quantity') }} pcs</span>
                        </div>
                        @php
                            $totalDiscount = $cartItems->sum('discount_amount');
                            $originalTotal = $cartItems->sum('original_subtotal');
                        @endphp
                        @if($totalDiscount > 0)
                            <div class="d-flex justify-content-between mb-2 small">
                                <span>Harga Normal</span>
                                <span class="text-decoration-line-through text-muted">Rp {{ number_format($originalTotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 small text-danger">
                                <span>Diskon Produk</span>
                                <span>-Rp {{ number_format($totalDiscount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between mb-3 small">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total</strong>
                            <strong class="text-success">Rp {{ number_format($total, 0, ',', '.') }}</strong>
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
            <p class="text-muted mb-4">Ayo mulai berbelanja perlengkapan Nora Padel!</p>
            <a href="{{ route('customer.products.index') }}" class="btn btn-success btn-lg">
                <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .cart-item-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
    }
    
    .cart-item-name {
        font-size: 0.9375rem;
    }
    
    .cart-qty-input {
        width: 100px;
    }
    
    @media (max-width: 767.98px) {
        .cart-item-img {
            width: 60px;
            height: 60px;
        }
        
        .cart-item-name {
            font-size: 0.875rem;
        }
        
        .cart-qty-input {
            width: 90px;
        }
        
        .cart-qty-input .btn {
            padding: 0.25rem 0.5rem;
        }
        
        .cart-qty-input .form-control {
            padding: 0.25rem;
        }
        
        .cart-summary {
            position: sticky;
            bottom: 0;
            margin: 0 -12px;
            border-radius: 12px 12px 0 0;
            box-shadow: 0 -4px 12px rgba(0,0,0,0.1);
        }
    }
    
    @media (max-width: 575.98px) {
        .cart-item-img {
            width: 50px;
            height: 50px;
        }
        
        .cart-item-name {
            font-size: 0.8125rem;
        }
        
        .cart-qty-input {
            width: 80px;
        }
    }
</style>
@endpush
