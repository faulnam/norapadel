@extends('layouts.courier')

@section('title', 'Tugas Pengiriman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Tugas Pengiriman</h4>
        <p class="text-muted mb-0">Daftar pengiriman yang ditugaskan kepada Anda</p>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('courier.deliveries.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label small text-muted">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status Aktif</option>
                    <option value="{{ \App\Models\Order::STATUS_ASSIGNED }}" {{ request('status') == \App\Models\Order::STATUS_ASSIGNED ? 'selected' : '' }}>Menunggu Diambil</option>
                    <option value="{{ \App\Models\Order::STATUS_PICKED_UP }}" {{ request('status') == \App\Models\Order::STATUS_PICKED_UP ? 'selected' : '' }}>Sudah Diambil</option>
                    <option value="{{ \App\Models\Order::STATUS_ON_DELIVERY }}" {{ request('status') == \App\Models\Order::STATUS_ON_DELIVERY ? 'selected' : '' }}>Sedang Diantar</option>
                    <option value="{{ \App\Models\Order::STATUS_DELIVERED }}" {{ request('status') == \App\Models\Order::STATUS_DELIVERED ? 'selected' : '' }}>Sudah Sampai</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small text-muted">Tanggal Pengiriman</label>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-success me-2">
                    <i class="fas fa-filter me-1"></i>Filter
                </button>
                <a href="{{ route('courier.deliveries.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Delivery List -->
<div class="card">
    <div class="card-body p-0">
        @forelse($deliveries as $delivery)
            <div class="delivery-card p-4 border-bottom">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                @switch($delivery->status)
                                    @case(\App\Models\Order::STATUS_ASSIGNED)
                                        <div class="bg-info text-white rounded-circle p-3">
                                            <i class="fas fa-clock fa-lg"></i>
                                        </div>
                                        @break
                                    @case(\App\Models\Order::STATUS_PICKED_UP)
                                        <div class="bg-secondary text-white rounded-circle p-3">
                                            <i class="fas fa-box fa-lg"></i>
                                        </div>
                                        @break
                                    @case(\App\Models\Order::STATUS_ON_DELIVERY)
                                        <div class="bg-warning text-dark rounded-circle p-3">
                                            <i class="fas fa-truck fa-lg"></i>
                                        </div>
                                        @break
                                    @case(\App\Models\Order::STATUS_DELIVERED)
                                        <div class="bg-success text-white rounded-circle p-3">
                                            <i class="fas fa-check fa-lg"></i>
                                        </div>
                                        @break
                                @endswitch
                            </div>
                            <div>
                                <h5 class="mb-1">
                                    <a href="{{ route('courier.deliveries.show', $delivery) }}" class="text-decoration-none text-dark">
                                        #{{ $delivery->order_number }}
                                    </a>
                                    @switch($delivery->status)
                                        @case(\App\Models\Order::STATUS_ASSIGNED)
                                            <span class="badge bg-info ms-2">Menunggu Diambil</span>
                                            @break
                                        @case(\App\Models\Order::STATUS_PICKED_UP)
                                            <span class="badge bg-secondary ms-2">Sudah Diambil</span>
                                            @break
                                        @case(\App\Models\Order::STATUS_ON_DELIVERY)
                                            <span class="badge bg-warning ms-2">Sedang Diantar</span>
                                            @break
                                        @case(\App\Models\Order::STATUS_DELIVERED)
                                            <span class="badge bg-success ms-2">Sudah Sampai</span>
                                            @break
                                    @endswitch
                                </h5>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-user me-1"></i>{{ $delivery->user->name }}
                                    <span class="mx-2">|</span>
                                    <i class="fas fa-phone me-1"></i>{{ $delivery->user->phone ?? '-' }}
                                </p>
                                <p class="mb-0 small">
                                    <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                    {{ $delivery->delivery_address }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 mt-3 mt-lg-0">
                        <div class="text-muted small mb-1">Jadwal Pengiriman</div>
                        <div class="fw-bold">
                            <i class="fas fa-calendar me-1 text-success"></i>
                            {{ $delivery->delivery_date->format('d M Y') }}
                        </div>
                        <div>
                            <i class="fas fa-clock me-1 text-success"></i>
                            {{ $delivery->delivery_time }}
                        </div>
                        <div class="mt-2 text-success fw-bold">
                            Rp {{ number_format($delivery->total_amount, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-lg-3 mt-3 mt-lg-0 text-lg-end">
                        <a href="{{ route('courier.deliveries.show', $delivery) }}" class="btn btn-outline-success mb-2 w-100">
                            <i class="fas fa-eye me-1"></i>Detail
                        </a>
                        @if($delivery->status === \App\Models\Order::STATUS_ASSIGNED)
                            <form action="{{ route('courier.deliveries.pickup', $delivery) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-info w-100">
                                    <i class="fas fa-hand-holding me-1"></i>Ambil Barang
                                </button>
                            </form>
                        @elseif($delivery->status === \App\Models\Order::STATUS_PICKED_UP)
                            <form action="{{ route('courier.deliveries.start', $delivery) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-play me-1"></i>Mulai Antar
                                </button>
                            </form>
                        @elseif($delivery->status === \App\Models\Order::STATUS_ON_DELIVERY)
                            <a href="{{ route('courier.deliveries.show', $delivery) }}" class="btn btn-success w-100">
                                <i class="fas fa-check me-1"></i>Selesaikan
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada pengiriman</h5>
                <p class="text-muted">Belum ada pengiriman yang ditugaskan kepada Anda.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Pagination -->
@if($deliveries->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $deliveries->withQueryString()->links() }}
    </div>
@endif
@endsection
