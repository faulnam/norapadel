@extends('layouts.courier')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Dashboard Kurir</h4>
        <p class="text-muted mb-0">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>
    <div class="text-muted">
        <i class="fas fa-calendar me-1"></i> {{ now()->isoFormat('dddd, D MMMM Y') }}
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card bg-info">
            <div class="icon"><i class="fas fa-clock"></i></div>
            <h3 class="mb-1">{{ $stats['pending'] }}</h3>
            <p class="mb-0 opacity-75">Menunggu Diambil</p>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card bg-warning">
            <div class="icon"><i class="fas fa-truck"></i></div>
            <h3 class="mb-1">{{ $stats['on_progress'] }}</h3>
            <p class="mb-0">Sedang Diantar</p>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card bg-success">
            <div class="icon"><i class="fas fa-check-circle"></i></div>
            <h3 class="mb-1">{{ $stats['delivered_today'] }}</h3>
            <p class="mb-0 opacity-75">Selesai Hari Ini</p>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card bg-primary">
            <div class="icon"><i class="fas fa-trophy"></i></div>
            <h3 class="mb-1">{{ $stats['total_completed'] }}</h3>
            <p class="mb-0 opacity-75">Total Selesai</p>
        </div>
    </div>
</div>

<div class="row">
    <!-- Active Deliveries -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0"><i class="fas fa-truck text-success me-2"></i>Pengiriman Aktif</h5>
                <a href="{{ route('courier.deliveries.index') }}" class="btn btn-sm btn-outline-success">
                    Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($activeDeliveries as $delivery)
                    <div class="delivery-card p-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1">
                                    <a href="{{ route('courier.deliveries.show', $delivery) }}" class="text-decoration-none text-dark">
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
                                        <span class="badge bg-info status-badge">
                                            <i class="fas fa-clock me-1"></i>Menunggu Diambil
                                        </span>
                                        @break
                                    @case(\App\Models\Order::STATUS_PICKED_UP)
                                        <span class="badge bg-secondary status-badge">
                                            <i class="fas fa-box me-1"></i>Sudah Diambil
                                        </span>
                                        @break
                                    @case(\App\Models\Order::STATUS_ON_DELIVERY)
                                        <span class="badge bg-warning status-badge">
                                            <i class="fas fa-truck me-1"></i>Sedang Diantar
                                        </span>
                                        @break
                                    @case(\App\Models\Order::STATUS_DELIVERED)
                                        <span class="badge bg-success status-badge">
                                            <i class="fas fa-check me-1"></i>Sudah Sampai
                                        </span>
                                        @break
                                @endswitch
                            </div>
                        </div>
                        <div class="row text-muted small mb-3">
                            <div class="col-md-6">
                                <i class="fas fa-map-marker-alt me-1 text-danger"></i>
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
                            <span class="text-success fw-bold">
                                Rp {{ number_format($delivery->total_amount, 0, ',', '.') }}
                            </span>
                            <div>
                                @if($delivery->status === \App\Models\Order::STATUS_ASSIGNED)
                                    <form action="{{ route('courier.deliveries.pickup', $delivery) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-info">
                                            <i class="fas fa-hand-holding me-1"></i>Ambil Barang
                                        </button>
                                    </form>
                                @elseif($delivery->status === \App\Models\Order::STATUS_PICKED_UP)
                                    <form action="{{ route('courier.deliveries.start', $delivery) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">
                                            <i class="fas fa-play me-1"></i>Mulai Antar
                                        </button>
                                    </form>
                                @elseif($delivery->status === \App\Models\Order::STATUS_ON_DELIVERY)
                                    <a href="{{ route('courier.deliveries.show', $delivery) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-check me-1"></i>Selesaikan
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p class="mb-0">Tidak ada pengiriman aktif saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Completed -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header py-3">
                <h5 class="mb-0"><i class="fas fa-history text-primary me-2"></i>Baru Selesai</h5>
            </div>
            <div class="card-body p-0">
                @forelse($recentCompleted as $completed)
                    <div class="p-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">#{{ $completed->order_number }}</h6>
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
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-box-open fa-2x mb-2"></i>
                        <p class="mb-0 small">Belum ada pengiriman selesai</p>
                    </div>
                @endforelse
            </div>
            @if($recentCompleted->count() > 0)
                <div class="card-footer text-center">
                    <a href="{{ route('courier.deliveries.history') }}" class="text-success text-decoration-none small">
                        Lihat Semua Riwayat <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
