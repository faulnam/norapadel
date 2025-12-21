@extends('layouts.app')

@section('title', 'Tulis Testimoni - PATAH')

@section('content')
<div class="container py-4 py-lg-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-3 mb-lg-4">
                <ol class="breadcrumb breadcrumb-mobile">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customer.orders.index') }}">Pesanan</a></li>
                    <li class="breadcrumb-item active">Testimoni</li>
                </ol>
            </nav>
            
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white card-header-mobile">
                    <h5 class="mb-0 card-title-mobile">
                        <i class="fas fa-star me-2"></i>Tulis Testimoni
                    </h5>
                </div>
                <div class="card-body p-3 p-lg-4">
                    <div class="alert alert-info py-2 alert-mobile">
                        <i class="fas fa-info-circle me-2"></i>
                        <span class="d-none d-sm-inline">Terima kasih telah berbelanja di PATAH! </span>Bagikan pengalaman Anda.
                    </div>

                    <!-- Order Info -->
                    <div class="card bg-light mb-4">
                        <div class="card-body p-3">
                            <h6 class="card-title order-info-title">Detail Pesanan</h6>
                            <table class="table table-sm table-borderless mb-0 order-info-table">
                                <tr>
                                    <td class="order-info-label">No. Pesanan</td>
                                    <td><strong>{{ $order->order_number }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="order-info-label">Tanggal</td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="order-info-label">Total</td>
                                    <td><strong class="text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                                </tr>
                            </table>
                            
                            <hr>
                            
                            <h6 class="order-info-title">Produk:</h6>
                            <ul class="list-unstyled mb-0 product-list">
                                @foreach($order->orderItems as $item)
                                <li>
                                    <i class="fas fa-check text-success me-2"></i>
                                    {{ $item->product->name ?? 'Produk tidak tersedia' }} (x{{ $item->quantity }})
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Testimonial Form -->
                    <form action="{{ route('customer.testimonials.store', $order) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="rating" class="form-label fw-bold">Rating <span class="text-danger">*</span></label>
                            <div class="rating-input">
                                <div class="btn-group btn-group-mobile" role="group">
                                    @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" class="btn-check" name="rating" id="rating{{ $i }}" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }} required>
                                    <label class="btn btn-outline-warning btn-rating" for="rating{{ $i }}">
                                        <i class="fas fa-star"></i><span class="d-none d-sm-inline"> {{ $i }}</span>
                                    </label>
                                    @endfor
                                </div>
                            </div>
                            @error('rating')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2 rating-hint">
                                1 = Sangat Buruk, 5 = Sangat Baik
                            </small>
                        </div>

                        <div class="mb-4">
                            <label for="content" class="form-label fw-bold">Testimoni Anda <span class="text-danger">*</span></label>
                            <textarea name="content" id="content" rows="4" 
                                class="form-control @error('content') is-invalid @enderror" 
                                placeholder="Ceritakan pengalaman Anda..."
                                required>{{ old('content') }}</textarea>
                            @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimal 20 karakter</small>
                        </div>

                        <div class="alert alert-warning py-2 alert-mobile">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Testimoni akan direview admin sebelum ditampilkan.
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-between gap-2">
                            <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-outline-secondary btn-action-mobile order-2 order-sm-1">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-success btn-action-mobile order-1 order-sm-2">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Testimoni
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.rating-input .btn-outline-warning:hover,
.rating-input .btn-check:checked + .btn-outline-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #fff;
}

/* Mobile Responsive */
@media (max-width: 767.98px) {
    .breadcrumb-mobile {
        font-size: 0.8rem;
    }
    .card-header-mobile {
        padding: 0.75rem 1rem;
    }
    .card-title-mobile {
        font-size: 1rem;
    }
    .alert-mobile {
        font-size: 0.85rem;
    }
    .order-info-title {
        font-size: 0.9rem;
    }
    .order-info-table {
        font-size: 0.85rem;
    }
    .order-info-label {
        width: 100px;
    }
    .product-list {
        font-size: 0.85rem;
    }
    .btn-rating {
        padding: 0.4rem 0.6rem;
    }
    .rating-hint {
        font-size: 0.75rem;
    }
    .form-label {
        font-size: 0.9rem;
    }
    .form-control {
        font-size: 0.9rem;
    }
    .btn-action-mobile {
        font-size: 0.9rem;
    }
}

@media (max-width: 575.98px) {
    .btn-rating {
        padding: 0.35rem 0.5rem;
        font-size: 0.85rem;
    }
    .order-info-label {
        width: 80px;
    }
}
</style>
@endsection
