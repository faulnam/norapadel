@extends('layouts.courier')

@section('title', 'Detail Pengiriman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('courier.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('courier.deliveries.index') }}" class="text-decoration-none">Pengiriman</a></li>
                <li class="breadcrumb-item active">#{{ $order->order_number }}</li>
            </ol>
        </nav>
        <h4 class="mb-0">Detail Pengiriman #{{ $order->order_number }}</h4>
    </div>
    <a href="{{ route('courier.deliveries.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row">
    <!-- Order Details -->
    <div class="col-lg-8">
        <!-- Status Progress -->
        <div class="card mb-4">
            <div class="card-header py-3">
                <h5 class="mb-0"><i class="fas fa-truck text-success me-2"></i>Status Pengiriman</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between position-relative mb-4">
                    <!-- Progress Line -->
                    <div class="position-absolute" style="top: 15px; left: 30px; right: 30px; height: 3px; background: #e9ecef; z-index: 0;">
                        @php
                            $progress = match($order->status) {
                                \App\Models\Order::STATUS_ASSIGNED => '0%',
                                \App\Models\Order::STATUS_PICKED_UP => '33%',
                                \App\Models\Order::STATUS_ON_DELIVERY => '66%',
                                \App\Models\Order::STATUS_DELIVERED, \App\Models\Order::STATUS_COMPLETED => '100%',
                                default => '0%'
                            };
                        @endphp
                        <div class="bg-success h-100" style="width: {{ $progress }}; transition: width 0.5s;"></div>
                    </div>
                    
                    <!-- Step 1: Assigned -->
                    <div class="text-center position-relative" style="z-index: 1;">
                        <div class="rounded-circle {{ in_array($order->status, [\App\Models\Order::STATUS_ASSIGNED, \App\Models\Order::STATUS_PICKED_UP, \App\Models\Order::STATUS_ON_DELIVERY, \App\Models\Order::STATUS_DELIVERED, \App\Models\Order::STATUS_COMPLETED]) ? 'bg-success' : 'bg-secondary' }} text-white d-flex align-items-center justify-content-center mx-auto" style="width: 35px; height: 35px;">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="small mt-2 fw-bold">Ditugaskan</div>
                        @if($order->assigned_at)
                            <small class="text-muted">{{ $order->assigned_at->format('d/m H:i') }}</small>
                        @endif
                    </div>
                    
                    <!-- Step 2: Picked Up -->
                    <div class="text-center position-relative" style="z-index: 1;">
                        <div class="rounded-circle {{ in_array($order->status, [\App\Models\Order::STATUS_PICKED_UP, \App\Models\Order::STATUS_ON_DELIVERY, \App\Models\Order::STATUS_DELIVERED, \App\Models\Order::STATUS_COMPLETED]) ? 'bg-success' : 'bg-secondary' }} text-white d-flex align-items-center justify-content-center mx-auto" style="width: 35px; height: 35px;">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="small mt-2 fw-bold">Diambil</div>
                        @if($order->picked_up_at)
                            <small class="text-muted">{{ $order->picked_up_at->format('d/m H:i') }}</small>
                        @endif
                    </div>
                    
                    <!-- Step 3: On Delivery -->
                    <div class="text-center position-relative" style="z-index: 1;">
                        <div class="rounded-circle {{ in_array($order->status, [\App\Models\Order::STATUS_ON_DELIVERY, \App\Models\Order::STATUS_DELIVERED, \App\Models\Order::STATUS_COMPLETED]) ? 'bg-success' : 'bg-secondary' }} text-white d-flex align-items-center justify-content-center mx-auto" style="width: 35px; height: 35px;">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="small mt-2 fw-bold">Diantar</div>
                        @if($order->on_delivery_at)
                            <small class="text-muted">{{ $order->on_delivery_at->format('d/m H:i') }}</small>
                        @endif
                    </div>
                    
                    <!-- Step 4: Delivered -->
                    <div class="text-center position-relative" style="z-index: 1;">
                        <div class="rounded-circle {{ in_array($order->status, [\App\Models\Order::STATUS_DELIVERED, \App\Models\Order::STATUS_COMPLETED]) ? 'bg-success' : 'bg-secondary' }} text-white d-flex align-items-center justify-content-center mx-auto" style="width: 35px; height: 35px;">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="small mt-2 fw-bold">Sampai</div>
                        @if($order->delivered_at)
                            <small class="text-muted">{{ $order->delivered_at->format('d/m H:i') }}</small>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center mt-4 pt-3 border-top">
                    @if($order->status === \App\Models\Order::STATUS_ASSIGNED)
                        <button type="button" class="btn btn-info btn-lg px-5" data-bs-toggle="modal" data-bs-target="#pickupModal">
                            <i class="fas fa-hand-holding me-2"></i>Ambil Barang
                        </button>
                        <p class="text-muted small mt-2 mb-0">Klik tombol di atas dan foto barang setelah mengambil dari toko</p>
                    @elseif($order->status === \App\Models\Order::STATUS_PICKED_UP)
                        <form action="{{ route('courier.deliveries.start', $order) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-lg px-5">
                                <i class="fas fa-play me-2"></i>Mulai Pengiriman
                            </button>
                        </form>
                        <p class="text-muted small mt-2 mb-0">Klik tombol di atas untuk memulai pengiriman</p>
                        
                        @if($order->pickup_photo)
                        <div class="mt-3 text-start">
                            <strong class="d-block mb-2"><i class="fas fa-camera text-info me-1"></i>Foto Pengambilan:</strong>
                            <img src="{{ asset('storage/' . $order->pickup_photo) }}" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                        @endif
                    @elseif($order->status === \App\Models\Order::STATUS_ON_DELIVERY)
                        <button type="button" class="btn btn-success btn-lg px-5" data-bs-toggle="modal" data-bs-target="#deliveredModal">
                            <i class="fas fa-check me-2"></i>Pesanan Sudah Sampai
                        </button>
                        <p class="text-muted small mt-2 mb-0">Klik tombol di atas dan foto bukti pengiriman</p>
                        
                        @if($order->pickup_photo)
                        <div class="mt-3 text-start">
                            <strong class="d-block mb-2"><i class="fas fa-camera text-info me-1"></i>Foto Pengambilan:</strong>
                            <img src="{{ asset('storage/' . $order->pickup_photo) }}" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                        @endif
                    @elseif($order->status === \App\Models\Order::STATUS_DELIVERED || $order->status === \App\Models\Order::STATUS_COMPLETED)
                        <div class="alert alert-success mb-0">
                            <i class="fas fa-trophy me-2"></i>
                            Pengiriman selesai! Terima kasih.
                        </div>
                        
                        <!-- Show Photos -->
                        <div class="row mt-3 text-start">
                            @if($order->pickup_photo)
                            <div class="col-6">
                                <strong class="d-block mb-2"><i class="fas fa-box text-info me-1"></i>Foto Pengambilan:</strong>
                                <a href="{{ asset('storage/' . $order->pickup_photo) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $order->pickup_photo) }}" class="img-thumbnail" style="max-height: 120px;">
                                </a>
                                @if($order->picked_up_at)
                                <small class="d-block text-muted mt-1">{{ $order->picked_up_at->format('d/m/Y H:i') }}</small>
                                @endif
                            </div>
                            @endif
                            @if($order->delivery_photo)
                            <div class="col-6">
                                <strong class="d-block mb-2"><i class="fas fa-check-circle text-success me-1"></i>Foto Pengiriman:</strong>
                                <a href="{{ asset('storage/' . $order->delivery_photo) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $order->delivery_photo) }}" class="img-thumbnail" style="max-height: 120px;">
                                </a>
                                @if($order->delivered_at)
                                <small class="d-block text-muted mt-1">{{ $order->delivered_at->format('d/m/Y H:i') }}</small>
                                @endif
                            </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card mb-4">
            <div class="card-header py-3">
                <h5 class="mb-0"><i class="fas fa-shopping-bag text-success me-2"></i>Item Pesanan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                     class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <span>{{ $item->product->name ?? 'Produk tidak tersedia' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end">Subtotal</td>
                                <td class="text-end">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end">Ongkir</td>
                                <td class="text-end">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="fw-bold">
                                <td colspan="3" class="text-end">Total</td>
                                <td class="text-end text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        @if($order->notes)
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h5 class="mb-0"><i class="fas fa-sticky-note text-warning me-2"></i>Catatan Pesanan</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $order->notes }}</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Customer Info -->
    <div class="col-lg-4">
        <!-- Customer Details -->
        <div class="card mb-4">
            <div class="card-header py-3">
                <h5 class="mb-0"><i class="fas fa-user text-primary me-2"></i>Info Customer</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($order->user->name) }}&background=random" 
                         class="rounded-circle me-3" style="width: 50px; height: 50px;">
                    <div>
                        <h6 class="mb-0">{{ $order->user->name }}</h6>
                        <small class="text-muted">{{ $order->user->email }}</small>
                    </div>
                </div>
                @if($order->user->phone)
                    <div class="mb-2">
                        <i class="fas fa-phone text-success me-2"></i>
                        <a href="tel:{{ $order->user->phone }}" class="text-decoration-none">{{ $order->user->phone }}</a>
                    </div>
                @endif
                @if($order->user->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->user->phone) }}" 
                       class="btn btn-success btn-sm w-100 mt-2" target="_blank">
                        <i class="fab fa-whatsapp me-1"></i>Hubungi via WhatsApp
                    </a>
                @endif
            </div>
        </div>

        <!-- Delivery Info -->
        <div class="card mb-4">
            <div class="card-header py-3">
                <h5 class="mb-0"><i class="fas fa-map-marker-alt text-danger me-2"></i>Info Pengiriman</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="text-muted small mb-1">Alamat Tujuan</div>
                    <div>{{ $order->delivery_address }}</div>
                </div>
                @if($order->delivery_latitude && $order->delivery_longitude)
                    <div class="mb-3">
                        <div class="text-muted small mb-1">Koordinat</div>
                        <div class="small">{{ $order->delivery_latitude }}, {{ $order->delivery_longitude }}</div>
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $order->delivery_latitude }},{{ $order->delivery_longitude }}" 
                           class="btn btn-outline-primary btn-sm w-100 mt-2" target="_blank">
                            <i class="fas fa-directions me-1"></i>Buka di Google Maps
                        </a>
                    </div>
                @endif
                <hr>
                <div class="mb-3">
                    <div class="text-muted small mb-1">Tanggal Pengiriman</div>
                    <div class="fw-bold">
                        <i class="fas fa-calendar text-success me-1"></i>
                        {{ $order->delivery_date->isoFormat('dddd, D MMMM Y') }}
                    </div>
                </div>
                <div class="mb-3">
                    <div class="text-muted small mb-1">Waktu Pengiriman</div>
                    <div class="fw-bold">
                        <i class="fas fa-clock text-success me-1"></i>
                        {{ $order->delivery_time }}
                    </div>
                </div>
                <div>
                    <div class="text-muted small mb-1">Metode Pembayaran</div>
                    <div>
                        @if($order->payment_method === 'cod')
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-money-bill-wave me-1"></i>Bayar di Tempat (COD)
                            </span>
                        @else
                            <span class="badge bg-success">
                                <i class="fas fa-credit-card me-1"></i>Transfer Bank
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($order->delivery_notes)
            <div class="card">
                <div class="card-header py-3">
                    <h5 class="mb-0"><i class="fas fa-clipboard text-info me-2"></i>Catatan Pengiriman</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $order->delivery_notes }}</p>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal Pickup dengan Foto -->
@if($order->status === \App\Models\Order::STATUS_ASSIGNED)
<div class="modal fade" id="pickupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('courier.deliveries.pickup', $order) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="fas fa-camera me-2"></i>Foto Pengambilan Barang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-1"></i>
                        Ambil foto barang yang sudah siap dikirim sebagai bukti pengambilan.
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Pengambilan Barang <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="pickup_photo" id="pickupPhoto" 
                               accept="image/*" capture="environment" required>
                        <div class="form-text">Ambil foto menggunakan kamera atau pilih dari galeri</div>
                    </div>
                    
                    <!-- Preview -->
                    <div id="pickupPhotoPreview" class="text-center d-none">
                        <img id="pickupPreviewImg" src="" class="img-fluid rounded" style="max-height: 250px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-check me-1"></i>Konfirmasi Pengambilan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Modal Delivered dengan Foto -->
@if($order->status === \App\Models\Order::STATUS_ON_DELIVERY)
<div class="modal fade" id="deliveredModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('courier.deliveries.delivered', $order) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-camera me-2"></i>Foto Bukti Pengiriman</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success">
                        <i class="fas fa-info-circle me-1"></i>
                        Ambil foto barang yang sudah diterima customer sebagai bukti pengiriman.
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Bukti Pengiriman <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="delivery_photo" id="deliveryPhoto" 
                               accept="image/*" capture="environment" required>
                        <div class="form-text">Foto barang yang sudah diterima customer</div>
                    </div>
                    
                    <!-- Preview -->
                    <div id="deliveryPhotoPreview" class="text-center mb-3 d-none">
                        <img id="deliveryPreviewImg" src="" class="img-fluid rounded" style="max-height: 250px;">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Catatan Pengiriman (Opsional)</label>
                        <textarea name="delivery_notes" class="form-control" rows="2" 
                                  placeholder="Contoh: Diterima oleh ibu di depan rumah"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i>Pesanan Selesai
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
// Preview pickup photo
document.getElementById('pickupPhoto')?.addEventListener('change', function(e) {
    const preview = document.getElementById('pickupPhotoPreview');
    const img = document.getElementById('pickupPreviewImg');
    
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(this.files[0]);
    }
});

// Preview delivery photo
document.getElementById('deliveryPhoto')?.addEventListener('change', function(e) {
    const preview = document.getElementById('deliveryPhotoPreview');
    const img = document.getElementById('deliveryPreviewImg');
    
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endpush
