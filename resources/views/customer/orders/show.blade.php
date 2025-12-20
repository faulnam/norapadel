@extends('layouts.app')

@section('title', 'Detail Pesanan - PATAH')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.orders.index') }}" class="text-decoration-none">Pesanan Saya</a></li>
            <li class="breadcrumb-item active">{{ $order->order_number }}</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-lg-8">
            <!-- Order Status -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-info-circle me-2"></i>Status Pesanan</span>
                    <span class="badge bg-light text-dark">{{ $order->status_label }}</span>
                </div>
                <div class="card-body">
                    <!-- Progress Tracker -->
                    <div class="d-flex justify-content-between mb-4">
                        <div class="text-center flex-fill">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center {{ !in_array($order->status, ['cancelled']) ? 'bg-success' : 'bg-secondary' }}" 
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-shopping-cart text-white"></i>
                            </div>
                            <p class="small mt-2 mb-0">Pesanan Dibuat</p>
                        </div>
                        <div class="text-center flex-fill">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center {{ in_array($order->status, ['paid', 'assigned', 'picked_up', 'on_delivery', 'delivered', 'completed', 'processing', 'shipped']) ? 'bg-success' : 'bg-secondary' }}" 
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-credit-card text-white"></i>
                            </div>
                            <p class="small mt-2 mb-0">Dibayar</p>
                        </div>
                        <div class="text-center flex-fill">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center {{ in_array($order->status, ['on_delivery', 'delivered', 'completed', 'shipped']) ? 'bg-success' : 'bg-secondary' }}" 
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-truck text-white"></i>
                            </div>
                            <p class="small mt-2 mb-0">Diantar</p>
                        </div>
                        <div class="text-center flex-fill">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center {{ in_array($order->status, ['delivered', 'completed']) ? 'bg-success' : 'bg-secondary' }}" 
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-check text-white"></i>
                            </div>
                            <p class="small mt-2 mb-0">Selesai</p>
                        </div>
                    </div>
                    
                    @if($order->status == 'cancelled')
                        <div class="alert alert-danger">
                            <strong>Pesanan Dibatalkan</strong>
                            @if($order->cancel_reason)
                                <p class="mb-0 mt-1">Alasan: {{ $order->cancel_reason }}</p>
                            @endif
                        </div>
                    @endif
                    
                    @if($order->tracking_number && in_array($order->status, ['shipped', 'on_delivery']))
                        <div class="alert alert-info">
                            <strong><i class="fas fa-truck me-2"></i>Informasi Pengiriman</strong>
                            <p class="mb-1 mt-2">Kurir: {{ $order->courier_name }} - {{ $order->courier_service }}</p>
                            <p class="mb-0">No. Resi: <strong>{{ $order->tracking_number }}</strong></p>
                        </div>
                    @endif

                    <!-- Courier Status Info -->
                    @if($order->courier)
                        <div class="alert alert-success">
                            <strong><i class="fas fa-motorcycle me-2"></i>Status Pengiriman</strong>
                            <div class="mt-2">
                                <p class="mb-1">Kurir: <strong>{{ $order->courier->name }}</strong></p>
                                @if($order->courier->phone)
                                    <p class="mb-1">
                                        <i class="fas fa-phone me-1"></i>{{ $order->courier->phone }}
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->courier->phone) }}" 
                                           class="btn btn-sm btn-success ms-2" target="_blank">
                                            <i class="fab fa-whatsapp"></i> Chat
                                        </a>
                                    </p>
                                @endif
                                @if($order->status === \App\Models\Order::STATUS_ON_DELIVERY)
                                    <div class="mt-2 p-2 bg-warning bg-opacity-25 rounded">
                                        <i class="fas fa-truck fa-bounce me-1"></i> 
                                        <strong>Pesanan sedang dalam perjalanan!</strong>
                                    </div>
                                @elseif($order->status === \App\Models\Order::STATUS_DELIVERED)
                                    <div class="mt-2 p-2 bg-success bg-opacity-25 rounded">
                                        <i class="fas fa-check-circle me-1"></i> 
                                        <strong>Pesanan sudah sampai. Silakan konfirmasi penerimaan.</strong>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Delivery Photos for Customer -->
                            @if($order->pickup_photo || $order->delivery_photo)
                            <hr class="my-3">
                            <strong><i class="fas fa-camera me-2"></i>Foto Dokumentasi Pengiriman</strong>
                            <div class="row mt-2 g-2">
                                @if($order->pickup_photo)
                                <div class="col-6">
                                    <div class="bg-white rounded p-2 text-center">
                                        <a href="{{ asset('storage/' . $order->pickup_photo) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $order->pickup_photo) }}" class="img-fluid rounded" style="max-height: 100px; object-fit: cover;">
                                        </a>
                                        <small class="d-block mt-1 text-muted">Foto Pengambilan</small>
                                        @if($order->picked_up_at)
                                        <small class="text-muted">{{ $order->picked_up_at->format('d/m H:i') }}</small>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                @if($order->delivery_photo)
                                <div class="col-6">
                                    <div class="bg-white rounded p-2 text-center">
                                        <a href="{{ asset('storage/' . $order->delivery_photo) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $order->delivery_photo) }}" class="img-fluid rounded" style="max-height: 100px; object-fit: cover;">
                                        </a>
                                        <small class="d-block mt-1 text-muted">Foto Selesai</small>
                                        @if($order->delivered_at)
                                        <small class="text-muted">{{ $order->delivered_at->format('d/m H:i') }}</small>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    @endif

                    <!-- Jadwal Pengiriman -->
                    @if($order->delivery_date)
                    <div class="alert alert-warning">
                        <strong><i class="fas fa-calendar-alt me-2"></i>Jadwal Pengiriman</strong>
                        <p class="mb-1 mt-2">
                            <i class="fas fa-calendar me-1"></i> Tanggal: <strong>{{ $order->formatted_delivery_date }}</strong>
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-clock me-1"></i> Jam: <strong>{{ $order->delivery_time_slot ?? '10:00 - 16:00' }} WIB</strong>
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Order Items -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <i class="fas fa-box me-2"></i>Item Pesanan
                </div>
                <div class="card-body p-0">
                    @foreach($order->items as $item)
                        <div class="d-flex align-items-center p-3 border-bottom">
                            <img src="{{ $item->product && $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/60' }}" 
                                 alt="{{ $item->product_name }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $item->product_name }}</h6>
                                <span class="text-muted">{{ $item->formatted_price }} x {{ $item->quantity }}</span>
                            </div>
                            <strong>{{ $item->formatted_subtotal }}</strong>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Shipping Address -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <i class="fas fa-map-marker-alt me-2"></i>Alamat Pengiriman
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>{{ $order->shipping_name }}</strong></p>
                    <p class="mb-1">{{ $order->shipping_phone }}</p>
                    <p class="mb-2 text-muted">{{ $order->shipping_address }}</p>
                    @if($order->delivery_distance_minutes)
                    <div class="alert alert-light mb-0 py-2">
                        <small>
                            <i class="fas fa-route text-success me-1"></i>
                            Estimasi jarak: <strong>{{ $order->delivery_distance_minutes }} menit</strong>
                        </small>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Testimonial Form -->
            @if($order->canGiveTestimonial())
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-star me-2"></i>Berikan Testimoni
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customer.testimonials.store', $order) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <div class="rating">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                                        <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                    @endfor
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Testimoni Anda</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                          name="content" rows="3" placeholder="Bagikan pengalaman belanja Anda..." required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane me-1"></i>Kirim Testimoni
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($order->testimonial)
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <i class="fas fa-star me-2"></i>Testimoni Anda
                    </div>
                    <div class="card-body">
                        <div class="mb-2">{!! $order->testimonial->stars !!}</div>
                        <p class="mb-1">{{ $order->testimonial->content }}</p>
                        @if($order->testimonial->is_approved)
                            <small class="text-success"><i class="fas fa-check me-1"></i>Ditampilkan di website</small>
                        @else
                            <small class="text-muted"><i class="fas fa-clock me-1"></i>Menunggu persetujuan</small>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        
        <div class="col-lg-4">
            <!-- Payment Info -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <i class="fas fa-credit-card me-2"></i>Pembayaran
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Status</span>
                        <span class="badge bg-{{ $order->payment_status_color }}">{{ $order->payment_status_label }}</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>{{ $order->formatted_subtotal }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkir</span>
                        <span>{{ $order->formatted_shipping_cost }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong class="text-success h5">{{ $order->formatted_total }}</strong>
                    </div>
                </div>
            </div>
            
            <!-- Upload Payment Proof -->
            @if($order->canUploadPaymentProof())
                <div class="card mb-4">
                    <div class="card-header bg-warning">
                        <i class="fas fa-upload me-2"></i>Upload Bukti Pembayaran
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info small">
                            <strong>Transfer ke:</strong><br>
                            BCA: 1234567890<br>
                            Mandiri: 0987654321<br>
                            a.n. PATAH Store
                        </div>
                        
                        <form action="{{ route('customer.orders.upload-payment', $order) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input type="file" class="form-control @error('payment_proof') is-invalid @enderror" 
                                       name="payment_proof" accept="image/*" required>
                                @error('payment_proof')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-upload me-1"></i>Upload Bukti
                            </button>
                        </form>
                    </div>
                </div>
            @endif
            
            @if($order->payment_proof)
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <i class="fas fa-image me-2"></i>Bukti Pembayaran
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                            <img src="{{ asset('storage/' . $order->payment_proof) }}" class="img-fluid rounded" style="max-height: 200px;">
                        </a>
                    </div>
                </div>
            @endif
            
            <!-- Actions -->
            <div class="d-grid gap-2">
                @if(in_array($order->status, ['shipped', 'delivered', \App\Models\Order::STATUS_DELIVERED]))
                    <form action="{{ route('customer.orders.confirm', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Konfirmasi pesanan sudah diterima?')">
                            <i class="fas fa-check me-1"></i>Konfirmasi Diterima
                        </button>
                    </form>
                @endif
                
                @if($order->canBeCancelled())
                    <form action="{{ route('customer.orders.cancel', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Yakin ingin membatalkan pesanan?')">
                            <i class="fas fa-times me-1"></i>Batalkan Pesanan
                        </button>
                    </form>
                @endif
                
                <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}
.rating input {
    display: none;
}
.rating label {
    cursor: pointer;
    font-size: 1.5rem;
    color: #ddd;
    padding: 0 5px;
}
.rating label:hover,
.rating label:hover ~ label,
.rating input:checked ~ label {
    color: #ffc107;
}
</style>
@endpush
