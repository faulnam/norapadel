@extends('layouts.courier')

@section('title', 'Dashboard')

@section('breadcrumb')
    <a href="{{ route('courier.dashboard') }}">Dashboard</a> / Overview
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="font-weight: 600;">Selamat datang, {{ auth()->user()->name }}</h4>
        <p class="text-muted mb-0">Berikut ringkasan pengiriman Anda hari ini</p>
    </div>
    <div class="text-muted small">
        <i class="fas fa-calendar me-1"></i> {{ now()->isoFormat('dddd, D MMMM Y') }}
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
           
            <div class="stat-info">
                <h3>{{ $stats['pending'] }}</h3>
                <p>Menunggu Diambil</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            
            <div class="stat-info">
                <h3>{{ $stats['on_progress'] }}</h3>
                <p>Sedang Diantar</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
           
            <div class="stat-info">
                <h3>{{ $stats['delivered_today'] }}</h3>
                <p>Selesai Hari Ini</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
           
            <div class="stat-info">
                <h3>{{ $stats['total_completed'] }}</h3>
                <p>Total Selesai</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Active Deliveries -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Pengiriman Aktif</span>
                <a href="{{ route('courier.deliveries.index') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($activeDeliveries as $delivery)
                    <div class="delivery-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1" style="font-weight: 600;">
                                    <a href="{{ route('courier.deliveries.show', $delivery) }}" class="text-decoration-none" style="color: var(--primary);">
                                        #{{ $delivery->order_number }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i>{{ $delivery->user->name }}
                                </small>
                            </div>
                            <div>
                                @switch($delivery->status)
                                    @case(\App\Models\Order::STATUS_ASSIGNED)
                                        <span class="badge bg-info">
                                            Menunggu Diambil
                                        </span>
                                        @break
                                    @case(\App\Models\Order::STATUS_PICKED_UP)
                                        <span class="badge bg-secondary">
                                            Sudah Diambil
                                        </span>
                                        @break
                                    @case(\App\Models\Order::STATUS_ON_DELIVERY)
                                        <span class="badge bg-warning">
                                            Sedang Diantar
                                        </span>
                                        @break
                                    @case(\App\Models\Order::STATUS_DELIVERED)
                                        <span class="badge bg-success">
                                            Sudah Sampai
                                        </span>
                                        @break
                                @endswitch
                            </div>
                        </div>
                        <div class="row text-muted small mb-3">
                            <div class="col-md-6">
                                <i class="fas fa-map-marker-alt me-1" style="color: #dc2626;"></i>
                                {{ Str::limit($delivery->delivery_address, 50) }}
                            </div>
                            <div class="col-md-3">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $delivery->delivery_date->format('d M Y') }}
                            </div>
                            <div class="col-md-3">
                                <i class="fas fa-clock me-1"></i>
                                {{ $delivery->delivery_time }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span style="color: var(--primary); font-weight: 600;">
                                Rp {{ number_format($delivery->total_amount, 0, ',', '.') }}
                            </span>
                            <div>
                                @if($delivery->status === \App\Models\Order::STATUS_ASSIGNED)
                                    <form action="{{ route('courier.deliveries.pickup', $delivery) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-hand-holding me-1"></i>Ambil Barang
                                        </button>
                                    </form>
                                @elseif($delivery->status === \App\Models\Order::STATUS_PICKED_UP)
                                    <form action="{{ route('courier.deliveries.start', $delivery) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-play me-1"></i>Mulai Antar
                                        </button>
                                    </form>
                                @elseif($delivery->status === \App\Models\Order::STATUS_ON_DELIVERY)
                                    <a href="{{ route('courier.deliveries.show', $delivery) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-check me-1"></i>Selesaikan
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h5>Tidak ada pengiriman</h5>
                        <p>Tidak ada pengiriman aktif saat ini</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Completed -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">Baru Selesai</div>
            <div class="card-body p-0">
                @forelse($recentCompleted as $completed)
                    <div class="p-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1" style="font-weight: 600;">#{{ $completed->order_number }}</h6>
                                <small class="text-muted">{{ $completed->user->name }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success">Selesai</span>
                                <div class="small text-muted mt-1">
                                    {{ $completed->delivered_at ? $completed->delivered_at->diffForHumans() : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state" style="padding: 2rem 1rem;">
                        <i class="fas fa-box-open" style="font-size: 2rem;"></i>
                        <p class="mb-0 small mt-2">Belum ada pengiriman selesai</p>
                    </div>
                @endforelse
            </div>
            @if($recentCompleted->count() > 0)
                <div class="card-footer bg-transparent text-center border-top">
                    <a href="{{ route('courier.deliveries.history') }}" class="text-decoration-none small" style="color: var(--primary);">
                        Lihat Semua Riwayat <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
