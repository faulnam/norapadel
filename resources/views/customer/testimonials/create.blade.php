@extends('layouts.app')

@section('title', 'Tulis Testimoni - PATAH')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customer.orders.index') }}">Pesanan Saya</a></li>
                    <li class="breadcrumb-item active">Tulis Testimoni</li>
                </ol>
            </nav>
            
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-star me-2"></i>Tulis Testimoni
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Terima kasih telah berbelanja di PATAH! Bagikan pengalaman Anda untuk membantu pelanggan lain.
                    </div>

                    <!-- Order Info -->
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h6 class="card-title">Detail Pesanan</h6>
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td width="150">No. Pesanan</td>
                                    <td><strong>{{ $order->order_number }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pesan</td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><strong class="text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                                </tr>
                            </table>
                            
                            <hr>
                            
                            <h6>Produk yang Dipesan:</h6>
                            <ul class="list-unstyled mb-0">
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
                                <div class="btn-group" role="group">
                                    @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" class="btn-check" name="rating" id="rating{{ $i }}" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }} required>
                                    <label class="btn btn-outline-warning" for="rating{{ $i }}">
                                        <i class="fas fa-star"></i> {{ $i }}
                                    </label>
                                    @endfor
                                </div>
                            </div>
                            @error('rating')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                1 = Sangat Buruk, 2 = Buruk, 3 = Cukup, 4 = Baik, 5 = Sangat Baik
                            </small>
                        </div>

                        <div class="mb-4">
                            <label for="content" class="form-label fw-bold">Testimoni Anda <span class="text-danger">*</span></label>
                            <textarea name="content" id="content" rows="5" 
                                class="form-control @error('content') is-invalid @enderror" 
                                placeholder="Ceritakan pengalaman Anda berbelanja di PATAH. Bagaimana kualitas produk? Pelayanan? Pengiriman?"
                                required>{{ old('content') }}</textarea>
                            @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimal 20 karakter</small>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Perhatian:</strong> Testimoni Anda akan direview oleh admin sebelum ditampilkan di website.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
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
</style>
@endsection
