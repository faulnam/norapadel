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
                                    <div>
                                        <div style="font-size: 12px; color: #166534;">Kurir</div>
                                        <div class="courier-name">{{ $order->courier->name }}</div>
                                        @if($order->courier->phone)
                                            <div style="font-size: 13px; color: #166534;">{{ $order->courier->phone }}</div>
                                        @endif
                                    </div>
                                    @if($order->courier->phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->courier->phone) }}" class="btn-wa" target="_blank">
                                            <i class="fab fa-whatsapp me-1"></i>Chat
                                        </a>
                                    @endif
                                </div>
                                @if($order->status === \App\Models\Order::STATUS_ON_DELIVERY)
                                    <div class="mt-2 pt-2 border-top" style="border-color: #bbf7d0 !important; font-size: 13px; color: #166534;">
                                        <i class="fas fa-truck me-1"></i> Pesanan sedang dalam perjalanan
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
                        </div>
                        <div class="detail-card-body">
                            <div class="mb-2">{!! $order->testimonial->stars !!}</div>
                            <p class="mb-2" style="font-size: 14px;">{{ $order->testimonial->content }}</p>
                            @if($order->testimonial->is_approved)
                                <small style="color: #16a34a;"><i class="fas fa-check me-1"></i>Ditampilkan di website</small>
                            @else
                                <small class="text-muted"><i class="fas fa-clock me-1"></i>Menunggu persetujuan</small>
                            @endif
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
                        <div class="summary-row">
                            <span>Ongkos Kirim</span>
                            <span>{{ $order->formatted_shipping_cost }}</span>
                        </div>
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
                            <div class="upload-box" style="border-radius: 12px;">
                                <div style="font-size: 14px; font-weight: 600; color: #92400e; margin-bottom: 12px;">
                                    <i class="fas fa-upload me-1"></i>Upload Bukti Pembayaran
                                </div>
                                <div class="bank-info">
                                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 8px;">Transfer ke:</div>
                                    <div class="bank-row">
                                        <span>BCA</span>
                                        <strong>1234567890</strong>
                                    </div>
                                    <div class="bank-row">
                                        <span>Mandiri</span>
                                        <strong>0987654321</strong>
                                    </div>
                                    <div style="font-size: 12px; color: #6b7280; margin-top: 8px;">a.n. PATAH Store</div>
                                </div>
                                
                                <form action="{{ route('customer.orders.upload-payment', $order) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" class="form-control mb-2" name="payment_proof" accept="image/*" required style="font-size: 13px;">
                                    <button type="submit" class="btn btn-action btn-primary-custom w-100">
                                        <i class="fas fa-upload me-1"></i>Upload
                                    </button>
                                </form>
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
@endsection
