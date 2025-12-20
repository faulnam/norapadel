@extends('layouts.app')

@section('title', 'Pesanan Saya - PATAH')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">
        <i class="fas fa-shopping-bag me-2 text-success"></i>Pesanan Saya
    </h3>
    
    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('customer.orders.index') }}" method="GET" class="row g-3">
                <div class="col-md-10">
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="pending_payment" {{ request('status') == 'pending_payment' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Orders List -->
    @forelse($orders as $order)
        <div class="card mb-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $order->order_number }}</strong>
                    <span class="text-muted ms-2">{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
                <span class="badge bg-{{ $order->status_color }}">{{ $order->status_label }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        @foreach($order->items->take(2) as $item)
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3">
                                    <strong>{{ $item->product_name }}</strong> x{{ $item->quantity }}
                                </div>
                                <span class="text-muted">{{ $item->formatted_subtotal }}</span>
                            </div>
                        @endforeach
                        @if($order->items->count() > 2)
                            <small class="text-muted">+{{ $order->items->count() - 2 }} item lainnya</small>
                        @endif
                    </div>
                    <div class="col-md-4 text-end">
                        <p class="mb-1 text-muted">Total Pembayaran</p>
                        <h5 class="text-success mb-3">{{ $order->formatted_total }}</h5>
                        <span class="badge bg-{{ $order->payment_status_color }} mb-2">{{ $order->payment_status_label }}</span>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    @if($order->courier)
                        <small class="text-success me-3">
                            <i class="fas fa-motorcycle me-1"></i>Kurir: {{ $order->courier->name }}
                        </small>
                    @endif
                    @if($order->delivery_date)
                        <small class="text-warning">
                            <i class="fas fa-calendar-alt me-1"></i>Pengiriman: {{ $order->delivery_date->format('d M Y') }} ({{ $order->delivery_time_slot ?? '10:00-16:00' }})
                        </small>
                    @elseif($order->tracking_number)
                        <small class="text-muted">
                            <i class="fas fa-truck me-1"></i>Resi: {{ $order->tracking_number }}
                        </small>
                    @endif
                    @if($order->delivery_photo && in_array($order->status, [\App\Models\Order::STATUS_DELIVERED, \App\Models\Order::STATUS_COMPLETED]))
                        <small class="text-info ms-2">
                            <i class="fas fa-camera me-1"></i>Foto tersedia
                        </small>
                    @endif
                </div>
                <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-eye me-1"></i>Lihat Detail
                </a>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="fas fa-shopping-bag fa-4x text-muted mb-4"></i>
            <h4 class="text-muted">Belum Ada Pesanan</h4>
            <p class="text-muted mb-4">Ayo mulai berbelanja kerupuk sehat PATAH!</p>
            <a href="{{ route('customer.products.index') }}" class="btn btn-success btn-lg">
                <i class="fas fa-shopping-cart me-2"></i>Mulai Belanja
            </a>
        </div>
    @endforelse
    
    {{ $orders->links() }}
</div>
@endsection
