@extends('layouts.app')

@section('title', 'Detail Pesanan - PATAH')

@push('styles')
<style>
    .order-detail-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 2rem 0;
    }
    .breadcrumb-minimal {
        font-size: 13px;
        margin-bottom: 1.5rem;
    }
    .breadcrumb-minimal a {
        color: #6b7280;
        text-decoration: none;
    }
    .breadcrumb-minimal a:hover {
        color: #16a34a;
    }
    .detail-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        margin-bottom: 1.5rem;
    }
    .detail-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        font-weight: 600;
        font-size: 14px;
        color: #1f2937;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .detail-card-header i {
        color: #6b7280;
        margin-right: 8px;
    }
    .detail-card-body {
        padding: 1.5rem;
    }
    .order-number {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
    }
    .status-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-pending { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .status-paid { background: rgba(37, 99, 235, 0.1); color: #2563eb; }
    .status-processing { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
    .status-shipping { background: rgba(249, 115, 22, 0.1); color: #f97316; }
    .status-completed { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .status-cancelled { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
    
    .progress-tracker {
        display: flex;
        justify-content: space-between;
        margin: 1.5rem 0;
        position: relative;
    }
    .progress-tracker::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 10%;
        right: 10%;
        height: 2px;
        background: #e5e7eb;
    }
    .progress-step {
        text-align: center;
        position: relative;
        z-index: 1;
        flex: 1;
    }
    .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #e5e7eb;
        color: #9ca3af;
        font-size: 14px;
        margin-bottom: 8px;
    }
    .step-icon.active {
        background: #16a34a;
        color: white;
    }
    .step-label {
        font-size: 12px;
        color: #6b7280;
    }
    
    .courier-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 10px;
        padding: 1rem 1.25rem;
    }
    .courier-name {
        font-weight: 600;
        color: #166534;
    }
    .btn-wa {
        background: #25d366;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 500;
    }
    .btn-wa:hover {
        background: #128c7e;
        color: white;
    }
    
    .item-row {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f3f4f6;
    }
    .item-row:last-child { border-bottom: none; }
    .item-img {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        margin-right: 1rem;
    }
    .item-name {
        font-weight: 500;
        color: #1f2937;
        font-size: 14px;
    }
    .item-qty {
        color: #6b7280;
        font-size: 13px;
    }
    .item-price {
        font-weight: 600;
        color: #1f2937;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        font-size: 14px;
        color: #4b5563;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        font-weight: 700;
        font-size: 18px;
        color: #1f2937;
        border-top: 1px solid #e5e7eb;
        margin-top: 8px;
    }
    
    .address-label {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 4px;
    }
    .address-value {
        font-weight: 500;
        color: #1f2937;
    }
    
    .photo-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    .photo-item { text-align: center; }
    .photo-item img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }
    .photo-label {
        font-size: 12px;
        color: #374151;
        margin-top: 8px;
        background: #f9fafb;
        padding: 8px;
        border-radius: 6px;
    }
    .photo-label strong {
        display: block;
        font-size: 13px;
        color: #1f2937;
        margin-bottom: 4px;
    }
    .photo-datetime {
        font-size: 11px;
        color: #6b7280;
        margin-top: 2px;
    }
    .photo-datetime i {
        width: 14px;
        color: #9ca3af;
    }
    
    .upload-box {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 10px;
        padding: 1.25rem;
    }
    .bank-info {
        background: #f9fafb;
        border-radius: 8px;
        padding: 1rem;
        font-size: 13px;
        margin-bottom: 1rem;
    }
    .bank-row {
        display: flex;
        justify-content: space-between;
        padding: 4px 0;
    }
    
    .btn-action {
        border-radius: 8px;
        padding: 10px 16px;
        font-size: 14px;
        font-weight: 500;
    }
    .btn-primary-custom {
        background: #16a34a;
        color: white;
        border: none;
    }
    .btn-primary-custom:hover {
        background: #15803d;
        color: white;
    }
    .btn-outline-custom {
        background: white;
        color: #374151;
        border: 1px solid #d1d5db;
    }
    .btn-outline-custom:hover {
        background: #f3f4f6;
    }
    
    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    .rating input { display: none; }
    .rating label {
        cursor: pointer;
        font-size: 1.25rem;
        color: #e5e7eb;
        padding: 0 3px;
    }
    .rating label:hover,
    .rating label:hover ~ label,
    .rating input:checked ~ label {
        color: #f59e0b;
    }
    
    .schedule-box {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 1px solid #fcd34d;
        border-radius: 10px;
        padding: 1rem 1.25rem;
    }
    
    /* Mobile Responsive */
    @media (max-width: 991.98px) {
        .order-detail-page {
            padding: 1rem 0;
        }
    }
    
    @media (max-width: 767.98px) {
        .order-detail-page {
            padding: 0.75rem 0;
        }
        .detail-card {
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .detail-card-header {
            padding: 0.75rem 1rem;
            font-size: 13px;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .detail-card-body {
            padding: 1rem;
        }
        .order-number {
            font-size: 15px;
        }
        .breadcrumb-minimal {
            font-size: 12px;
            margin-bottom: 1rem;
        }
        
        /* Progress Tracker Mobile */
        .progress-tracker {
            margin: 1rem 0;
        }
        .progress-tracker::before {
            top: 15px;
            left: 5%;
            right: 5%;
        }
        .step-icon {
            width: 30px;
            height: 30px;
            font-size: 11px;
        }
        .step-label {
            font-size: 10px;
        }
        
        /* Items Mobile */
        .item-row {
            padding: 0.75rem 0;
        }
        .item-img {
            width: 40px;
            height: 40px;
            margin-right: 0.75rem;
        }
        .item-name {
            font-size: 13px;
        }
        .item-qty {
            font-size: 11px;
        }
        .item-price {
            font-size: 13px;
        }
        
        /* Summary Mobile */
        .summary-row {
            font-size: 13px;
        }
        .summary-total {
            font-size: 15px;
        }
        
        /* Photo Grid Mobile */
        .photo-grid {
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }
        .photo-item img {
            height: 100px;
        }
        .photo-label {
            font-size: 11px;
            padding: 6px;
        }
        .photo-label strong {
            font-size: 12px;
        }
        .photo-datetime {
            font-size: 10px;
        }
        
        /* Courier Box Mobile */
        .courier-box {
            padding: 0.75rem 1rem;
        }
        .courier-name {
            font-size: 14px;
        }
        
        /* Address Mobile */
        .address-label {
            font-size: 11px;
        }
        .address-value {
            font-size: 13px;
        }
        
        /* Bank Info Mobile */
        .bank-info {
            font-size: 12px;
            padding: 0.75rem;
        }
        
        /* Upload Box Mobile */
        .upload-box {
            padding: 1rem;
        }
        
        /* Buttons Mobile */
        .btn-action {
            padding: 8px 12px;
            font-size: 13px;
        }
    }
    
    @media (max-width: 575.98px) {
        .progress-tracker::before {
            left: 3%;
            right: 3%;
        }
        .step-icon {
            width: 26px;
            height: 26px;
            font-size: 10px;
        }
        .step-label {
            font-size: 9px;
        }
        .item-img {
            width: 35px;
            height: 35px;
        }
        .photo-grid {
            gap: 0.5rem;
        }
        .photo-item img {
            height: 80px;
        }
    }
</style>
@endpush

@section('content')
<div class="order-detail-page">
    <div class="container">
        <div class="breadcrumb-minimal">
            <a href="{{ route('customer.orders.index') }}">Pesanan Saya</a>
            <span class="mx-2 text-muted">/</span>
            <span class="text-dark">{{ $order->order_number }}</span>
        </div>
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Order Status -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <span><i class="fas fa-receipt"></i>Detail Pesanan</span>
                        @php
                            $statusClass = match($order->status) {
                                'pending_payment' => 'status-pending',
                                'paid', 'assigned', 'picked_up' => 'status-paid',
                                'processing' => 'status-processing',
                                'on_delivery', 'shipped' => 'status-shipping',
                                'delivered', 'completed' => 'status-completed',
                                'cancelled' => 'status-cancelled',
                                default => 'status-pending'
                            };
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $order->status_label }}</span>
                    </div>
                    <div class="detail-card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <div class="order-number">{{ $order->order_number }}</div>
                                <div class="text-muted" style="font-size: 13px;">{{ $order->created_at->format('d F Y, H:i') }}</div>
                            </div>
                            @if(in_array($order->status, ['paid', 'assigned', 'picked_up', 'on_delivery', 'delivered', 'completed']))
                                <a href="{{ route('customer.orders.receipt', $order) }}" class="btn btn-sm btn-outline-success" target="_blank">
                                    <i class="fas fa-file-pdf me-1"></i>Lihat Resi
                                </a>
                            @endif
                        </div>

                        <!-- Progress Tracker -->
                        <div class="progress-tracker">
                            <div class="progress-step">
                                <div class="step-icon {{ !in_array($order->status, ['cancelled']) ? 'active' : '' }}">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="step-label">Dibuat</div>
                            </div>
                            <div class="progress-step">
                                <div class="step-icon {{ in_array($order->status, ['paid', 'assigned', 'picked_up', 'on_delivery', 'delivered', 'completed', 'processing', 'shipped']) ? 'active' : '' }}">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div class="step-label">Dibayar</div>
                            </div>
                            <div class="progress-step">
                                <div class="step-icon {{ in_array($order->status, ['on_delivery', 'delivered', 'completed', 'shipped']) ? 'active' : '' }}">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div class="step-label">Diantar</div>
                            </div>
                            <div class="progress-step">
                                <div class="step-icon {{ in_array($order->status, ['delivered', 'completed']) ? 'active' : '' }}">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="step-label">Selesai</div>
                            </div>
                        </div>
                        
                        @if($order->status == 'cancelled')
                            <div class="alert alert-danger py-2 mb-0" style="font-size: 13px;">
                                <strong>Pesanan Dibatalkan</strong>
                                @if($order->cancel_reason)
                                    <p class="mb-0 mt-1">{{ $order->cancel_reason }}</p>
                                @endif
                            </div>
                        @endif

                        <!-- Courier Info -->
                        @if($order->courier)
                            <div class="courier-box mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $order->courier->avatar_url }}" alt="{{ $order->courier->name }}" 
                                             class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover;">
                                        <div>
                                            <div style="font-size: 12px; color: #166534;">Kurir</div>
                                            <div class="courier-name">{{ $order->courier->name }}</div>
                                            @if($order->courier->phone)
                                                <div style="font-size: 13px; color: #166534;">{{ $order->courier->phone }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    @if($order->courier->phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->courier->phone) }}" class="btn-wa" target="_blank">
                                            <i class="fab fa-whatsapp me-1"></i>Chat
                                        </a>
                                    @endif
                                </div>
                                @if($order->status === \App\Models\Order::STATUS_ON_DELIVERY)
                                    <div class="mt-2 pt-2 border-top" style="border-color: #bbf7d0 !important;">
                                        <button type="button" class="btn btn-success btn-sm w-100" id="btnOpenTracking">
                                            <i class="fas fa-map-marker-alt me-1"></i> Lacak Posisi Kurir
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Delivery Photos -->
                        @if($order->pickup_photo || $order->delivery_photo)
                            <div class="mt-3 pt-3 border-top">
                                <div style="font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 12px;">
                                    <i class="fas fa-camera me-1"></i>Foto Dokumentasi
                                </div>
                                <div class="photo-grid">
                                    @if($order->pickup_photo)
                                    <div class="photo-item">
                                        <a href="{{ asset('storage/' . $order->pickup_photo) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $order->pickup_photo) }}" alt="Foto Pengambilan">
                                        </a>
                                        <div class="photo-label">
                                            <strong>Barang Diambil</strong>
                                            @if($order->picked_up_at)
                                            <div class="photo-datetime">
                                                <i class="fas fa-calendar me-1"></i>{{ $order->picked_up_at->format('d M Y') }}
                                            </div>
                                            <div class="photo-datetime">
                                                <i class="fas fa-clock me-1"></i>{{ $order->picked_up_at->format('H:i') }} WIB
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                    @if($order->delivery_photo)
                                    <div class="photo-item">
                                        <a href="{{ asset('storage/' . $order->delivery_photo) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $order->delivery_photo) }}" alt="Foto Selesai">
                                        </a>
                                        <div class="photo-label">
                                            <strong>Pesanan Diterima</strong>
                                            @if($order->delivered_at)
                                            <div class="photo-datetime">
                                                <i class="fas fa-calendar me-1"></i>{{ $order->delivered_at->format('d M Y') }}
                                            </div>
                                            <div class="photo-datetime">
                                                <i class="fas fa-clock me-1"></i>{{ $order->delivered_at->format('H:i') }} WIB
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Jadwal Pengiriman -->
                @if($order->delivery_date)
                <div class="detail-card">
                    <div class="detail-card-body p-0">
                        <div class="schedule-box" style="border-radius: 12px;">
                            <div style="font-size: 13px; font-weight: 600; color: #92400e; margin-bottom: 8px;">
                                <i class="fas fa-calendar-alt me-1"></i>Jadwal Pengiriman
                            </div>
                            <div style="font-size: 14px; color: #78350f;">
                                <strong>{{ $order->formatted_delivery_date }}</strong> • {{ $order->delivery_time_slot ?? '10:00 - 16:00' }} WIB
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Order Items -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <span><i class="fas fa-box"></i>Item Pesanan</span>
                        <span style="font-size: 13px; color: #6b7280;">{{ $order->items->count() }} item</span>
                    </div>
                    <div class="detail-card-body">
                        @foreach($order->items as $item)
                            <div class="item-row">
                                <img src="{{ $item->product && $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/50' }}" alt="{{ $item->product_name }}" class="item-img">
                                <div class="flex-grow-1">
                                    <div class="item-name">{{ $item->product_name }}</div>
                                    <div class="item-qty">{{ $item->formatted_price }} × {{ $item->quantity }}</div>
                                </div>
                                <div class="item-price">{{ $item->formatted_subtotal }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Shipping Address -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <span><i class="fas fa-map-marker-alt"></i>Alamat Pengiriman</span>
                    </div>
                    <div class="detail-card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="address-label">Penerima</div>
                                <div class="address-value">{{ $order->shipping_name }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="address-label">Telepon</div>
                                <div class="address-value">{{ $order->shipping_phone }}</div>
                            </div>
                        </div>
                        <div class="address-label">Alamat</div>
                        <div class="address-value">{{ $order->shipping_address }}</div>
                        @if($order->delivery_distance_minutes)
                            <div class="mt-2" style="font-size: 12px; color: #6b7280;">
                                <i class="fas fa-route me-1"></i>Estimasi jarak: {{ $order->delivery_distance_minutes }} menit
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Testimonial -->
                @if($order->canGiveTestimonial())
                    <div class="detail-card">
                        <div class="detail-card-header">
                            <span><i class="fas fa-star"></i>Berikan Testimoni</span>
                        </div>
                        <div class="detail-card-body">
                            <form action="{{ route('customer.testimonials.store', $order) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" style="font-size: 13px; font-weight: 500;">Rating</label>
                                    <div class="rating">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                                            <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                        @endfor
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" style="font-size: 13px; font-weight: 500;">Testimoni</label>
                                    <textarea class="form-control" name="content" rows="3" placeholder="Bagikan pengalaman belanja Anda..." style="font-size: 14px;" required>{{ old('content') }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-action btn-primary-custom">
                                    <i class="fas fa-paper-plane me-1"></i>Kirim Testimoni
                                </button>
                            </form>
                        </div>
                    </div>
                @elseif($order->testimonial)
                    <div class="detail-card">
                        <div class="detail-card-header">
                            <span><i class="fas fa-star"></i>Testimoni Anda</span>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#editTestimonial">
                                <i class="fas fa-edit me-1"></i>Edit
                            </button>
                        </div>
                        <div class="detail-card-body">
                            <!-- Display existing testimonial -->
                            <div id="showTestimonial">
                                <div class="mb-2">{!! $order->testimonial->stars !!}</div>
                                <p class="mb-2" style="font-size: 14px;">{{ $order->testimonial->content }}</p>
                                @if($order->testimonial->is_approved)
                                    <small style="color: #16a34a;"><i class="fas fa-check me-1"></i>Ditampilkan di website</small>
                                @else
                                    <small class="text-muted"><i class="fas fa-clock me-1"></i>Menunggu persetujuan</small>
                                @endif
                            </div>
                            
                            <!-- Edit form (collapsed) -->
                            <div class="collapse mt-3" id="editTestimonial">
                                <hr class="my-3">
                                <form action="{{ route('customer.testimonials.update', $order->testimonial) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label" style="font-size: 13px; font-weight: 500;">Rating</label>
                                        <div class="rating">
                                            @for($i = 5; $i >= 1; $i--)
                                                <input type="radio" name="rating" value="{{ $i }}" id="editStar{{ $i }}" {{ $order->testimonial->rating == $i ? 'checked' : '' }}>
                                                <label for="editStar{{ $i }}"><i class="fas fa-star"></i></label>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" style="font-size: 13px; font-weight: 500;">Testimoni</label>
                                        <textarea class="form-control" name="content" rows="3" style="font-size: 14px;" required>{{ $order->testimonial->content }}</textarea>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-action btn-primary-custom">
                                            <i class="fas fa-save me-1"></i>Simpan Perubahan
                                        </button>
                                        <button type="button" class="btn btn-action btn-outline-custom" data-bs-toggle="collapse" data-bs-target="#editTestimonial">
                                            Batal
                                        </button>
                                    </div>
                                    <div class="alert alert-warning mt-3 py-2" style="font-size: 12px;">
                                        <i class="fas fa-info-circle me-1"></i>Testimoni yang diedit akan membutuhkan persetujuan admin ulang.
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="col-lg-4">
                <!-- Payment Summary -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <span><i class="fas fa-credit-card"></i>Pembayaran</span>
                        @php
                            $paymentClass = match($order->payment_status) {
                                'paid', 'verified' => 'status-completed',
                                'pending_verification' => 'status-processing',
                                default => 'status-pending'
                            };
                        @endphp
                        <span class="status-badge {{ $paymentClass }}">{{ $order->payment_status_label }}</span>
                    </div>
                    <div class="detail-card-body">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>{{ $order->formatted_subtotal }}</span>
                        </div>
                        @if($order->product_discount > 0)
                            <div class="summary-row text-danger">
                                <span>Diskon Produk</span>
                                <span>-{{ $order->formatted_product_discount }}</span>
                            </div>
                        @endif
                        <div class="summary-row">
                            <span>Ongkos Kirim</span>
                            <span>{{ $order->formatted_shipping_cost }}</span>
                        </div>
                        @if($order->shipping_discount > 0)
                            <div class="summary-row text-danger">
                                <span>Diskon Ongkir</span>
                                <span>-{{ $order->formatted_shipping_discount }}</span>
                            </div>
                        @endif
                        <div class="summary-total">
                            <span>Total</span>
                            <span>{{ $order->formatted_total }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Upload Payment Proof -->
                @if($order->canUploadPaymentProof())
                    <div class="detail-card">
                        <div class="detail-card-body p-0">
                            <!-- Payment Gateway Option -->
                            <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 1px solid #bbf7d0; border-radius: 12px; padding: 1.25rem;">
                                <div style="font-size: 14px; font-weight: 600; color: #166534; margin-bottom: 8px;">
                                    <i class="fas fa-bolt me-1"></i>Bayar Online
                                </div>
                                <p style="font-size: 13px; color: #166534; margin-bottom: 12px;">
                                    Bayar langsung via QRIS atau Virtual Account
                                </p>
                                <a href="{{ route('customer.payment.show', $order) }}" class="btn btn-success w-100">
                                    <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if($order->payment_proof)
                    <div class="detail-card">
                        <div class="detail-card-header">
                            <span><i class="fas fa-image"></i>Bukti Pembayaran</span>
                        </div>
                        <div class="detail-card-body text-center">
                            <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                                <img src="{{ asset('storage/' . $order->payment_proof) }}" class="img-fluid rounded" style="max-height: 180px;">
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
                            <button type="submit" class="btn btn-action btn-primary-custom w-100" onclick="return confirm('Konfirmasi pesanan sudah diterima?')">
                                <i class="fas fa-check me-1"></i>Konfirmasi Diterima
                            </button>
                        </form>
                    @endif
                    
                    @if($order->canBeCancelled())
                        <form action="{{ route('customer.orders.cancel', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-action btn-outline-custom w-100 text-danger" onclick="return confirm('Yakin ingin membatalkan pesanan?')">
                                <i class="fas fa-times me-1"></i>Batalkan Pesanan
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('customer.orders.index') }}" class="btn btn-action btn-outline-custom">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tracking Popup -->
@if($order->status === \App\Models\Order::STATUS_ON_DELIVERY && $order->courier)
<div id="trackingPopup" class="tracking-popup" style="display: none;">
    <div class="tracking-popup-content">
        <!-- Header -->
        <div class="tracking-popup-header">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-motorcycle"></i>
                <span class="fw-bold">Lacak Kurir</span>
            </div>
            <button type="button" class="tracking-popup-close" id="btnCloseTracking">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Map -->
        <div id="trackingMap"></div>
        
        <!-- Info -->
        <div class="tracking-popup-info">
            <div class="tracking-stats">
                <div class="tracking-stat">
                    <i class="fas fa-route"></i>
                    <span id="distanceText">-- km</span>
                </div>
                <div class="tracking-stat">
                    <i class="fas fa-clock"></i>
                    <span id="etaText">-- mnt</span>
                </div>
            </div>
            <div class="tracking-courier">
                <img src="{{ $order->courier->avatar_url }}" alt="{{ $order->courier->name }}">
                <div class="tracking-courier-info">
                    <div class="fw-semibold">{{ $order->courier->name }}</div>
                    <small id="lastUpdateText">Memuat...</small>
                </div>
                @if($order->courier->phone)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->courier->phone) }}" class="tracking-wa-btn" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@if($order->status === \App\Models\Order::STATUS_ON_DELIVERY && $order->courier)
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* Tracking Popup Styles */
    .tracking-popup {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1050;
        animation: slideUp 0.3s ease;
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .tracking-popup-content {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        overflow: hidden;
        width: 340px;
    }
    .tracking-popup-header {
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
        color: white;
        padding: 12px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .tracking-popup-close {
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .tracking-popup-close:hover {
        background: rgba(255,255,255,0.3);
    }
    #trackingMap {
        height: 200px;
        width: 100%;
    }
    .tracking-popup-info {
        padding: 12px;
        background: #f9fafb;
    }
    .tracking-stats {
        display: flex;
        justify-content: center;
        gap: 24px;
        margin-bottom: 12px;
    }
    .tracking-stat {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #16a34a;
    }
    .tracking-stat i {
        color: #9ca3af;
        font-size: 12px;
    }
    .tracking-courier {
        display: flex;
        align-items: center;
        gap: 10px;
        background: white;
        padding: 10px 12px;
        border-radius: 10px;
    }
    .tracking-courier img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #16a34a;
    }
    .tracking-courier-info {
        flex: 1;
        font-size: 13px;
    }
    .tracking-courier-info small {
        color: #6b7280;
        font-size: 11px;
    }
    .tracking-wa-btn {
        width: 36px;
        height: 36px;
        background: #25d366;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s;
    }
    .tracking-wa-btn:hover {
        background: #128c7e;
        color: white;
        transform: scale(1.1);
    }
    
    /* Map Markers */
    .leaflet-control-attribution {
        font-size: 8px !important;
    }
    .courier-marker, .destination-marker {
        background: none;
        border: none;
    }
    .courier-marker-inner {
        background: #16a34a;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        box-shadow: 0 3px 12px rgba(22, 163, 74, 0.4);
        border: 2px solid white;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.4); }
        70% { box-shadow: 0 0 0 12px rgba(22, 163, 74, 0); }
        100% { box-shadow: 0 0 0 0 rgba(22, 163, 74, 0); }
    }
    .destination-marker-inner {
        background: #dc2626;
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50% 50% 50% 0;
        transform: rotate(-45deg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        box-shadow: 0 3px 10px rgba(220, 38, 38, 0.3);
    }
    .destination-marker-inner i {
        transform: rotate(45deg);
    }
    
    /* Mobile */
    @media (max-width: 575.98px) {
        .tracking-popup {
            bottom: 70px;
            right: 10px;
            left: 10px;
        }
        .tracking-popup-content {
            width: 100%;
        }
        #trackingMap {
            height: 180px;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let trackingMap = null;
let courierMarker = null;
let destinationMarker = null;
let routeLine = null;
let trackingInterval = null;
let isPopupOpen = false;

const ORDER_ID = {{ $order->id }};
const DESTINATION = {
    lat: {{ $order->shipping_latitude ?? -7.4674 }},
    lng: {{ $order->shipping_longitude ?? 112.5274 }}
};

// Open tracking popup
document.getElementById('btnOpenTracking').addEventListener('click', function() {
    document.getElementById('trackingPopup').style.display = 'block';
    isPopupOpen = true;
    
    setTimeout(() => {
        if (!trackingMap) {
            initTrackingMap();
        } else {
            trackingMap.invalidateSize();
        }
        startTracking();
    }, 100);
});

// Close tracking popup
document.getElementById('btnCloseTracking').addEventListener('click', function() {
    document.getElementById('trackingPopup').style.display = 'none';
    isPopupOpen = false;
    stopTracking();
});

function initTrackingMap() {
    trackingMap = L.map('trackingMap', {
        zoomControl: false
    }).setView([DESTINATION.lat, DESTINATION.lng], 15);
    
    // Add zoom control to bottom right
    L.control.zoom({ position: 'bottomright' }).addTo(trackingMap);
    
    // Use cleaner map tiles
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OSM',
        maxZoom: 19
    }).addTo(trackingMap);
    
    // Destination marker (customer location)
    const destIcon = L.divIcon({
        html: '<div class="destination-marker-inner"><i class="fas fa-home"></i></div>',
        className: 'destination-marker',
        iconSize: [28, 28],
        iconAnchor: [14, 28]
    });
    destinationMarker = L.marker([DESTINATION.lat, DESTINATION.lng], { icon: destIcon }).addTo(trackingMap);
}

function startTracking() {
    fetchLocation();
    trackingInterval = setInterval(fetchLocation, 5000);
}

function stopTracking() {
    if (trackingInterval) {
        clearInterval(trackingInterval);
        trackingInterval = null;
    }
}

function fetchLocation() {
    if (!isPopupOpen) return;
    
    fetch('{{ route("customer.orders.tracking", $order) }}')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.location) {
                updateCourierPosition(data.location);
                document.getElementById('lastUpdateText').textContent = 'Aktif • ' + data.location.updated_ago;
            } else {
                document.getElementById('lastUpdateText').textContent = data.message || 'Menunggu lokasi...';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('lastUpdateText').textContent = 'Gagal memuat';
        });
}

function updateCourierPosition(location) {
    const lat = parseFloat(location.latitude);
    const lng = parseFloat(location.longitude);
    
    // Create courier marker icon
    const courierIcon = L.divIcon({
        html: '<div class="courier-marker-inner"><i class="fas fa-motorcycle"></i></div>',
        className: 'courier-marker',
        iconSize: [32, 32],
        iconAnchor: [16, 16]
    });
    
    if (courierMarker) {
        courierMarker.setLatLng([lat, lng]);
    } else {
        courierMarker = L.marker([lat, lng], { icon: courierIcon }).addTo(trackingMap);
    }
    
    // Get route from OSRM
    getRoute(lat, lng);
}

function getRoute(courierLat, courierLng) {
    const osrmUrl = `https://router.project-osrm.org/route/v1/driving/${courierLng},${courierLat};${DESTINATION.lng},${DESTINATION.lat}?overview=full&geometries=geojson`;
    
    fetch(osrmUrl)
        .then(response => response.json())
        .then(data => {
            if (data.code === 'Ok' && data.routes && data.routes.length > 0) {
                const route = data.routes[0];
                const coords = route.geometry.coordinates.map(c => [c[1], c[0]]);
                
                if (routeLine) {
                    trackingMap.removeLayer(routeLine);
                }
                
                routeLine = L.polyline(coords, {
                    color: '#16a34a',
                    weight: 4,
                    opacity: 0.8,
                    lineCap: 'round',
                    lineJoin: 'round'
                }).addTo(trackingMap);
                
                const distanceKm = (route.distance / 1000).toFixed(1);
                const durationMin = Math.round(route.duration / 60);
                
                document.getElementById('distanceText').textContent = distanceKm + ' km';
                document.getElementById('etaText').textContent = durationMin + ' mnt';
                
                const bounds = L.latLngBounds(coords);
                trackingMap.fitBounds(bounds, { padding: [30, 30] });
            } else {
                drawStraightLine(courierLat, courierLng);
            }
        })
        .catch(error => {
            drawStraightLine(courierLat, courierLng);
        });
}

function drawStraightLine(courierLat, courierLng) {
    if (routeLine) {
        trackingMap.removeLayer(routeLine);
    }
    
    routeLine = L.polyline([
        [courierLat, courierLng],
        [DESTINATION.lat, DESTINATION.lng]
    ], {
        color: '#16a34a',
        weight: 3,
        opacity: 0.6,
        dashArray: '6, 6'
    }).addTo(trackingMap);
    
    const distance = calculateDistance(courierLat, courierLng, DESTINATION.lat, DESTINATION.lng);
    document.getElementById('distanceText').textContent = distance.toFixed(1) + ' km';
    document.getElementById('etaText').textContent = '~' + Math.round(distance * 3) + ' mnt';
    
    const bounds = L.latLngBounds([
        [courierLat, courierLng],
        [DESTINATION.lat, DESTINATION.lng]
    ]);
    trackingMap.fitBounds(bounds, { padding: [30, 30] });
}

function calculateDistance(lat1, lng1, lat2, lng2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLng = (lng2 - lng1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLng/2) * Math.sin(dLng/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}
</script>
@endpush
@endif
