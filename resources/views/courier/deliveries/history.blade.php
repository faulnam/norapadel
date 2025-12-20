@extends('layouts.courier')

@section('title', 'Riwayat Pengiriman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Riwayat Pengiriman</h4>
        <p class="text-muted mb-0">Daftar pengiriman yang sudah Anda selesaikan</p>
    </div>
</div>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card bg-success text-white">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-white bg-opacity-25 p-3 me-3">
                    <i class="fas fa-check-double fa-2x"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $totalDelivered }}</h3>
                    <small class="opacity-75">Total Pengiriman Selesai</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-primary text-white">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-white bg-opacity-25 p-3 me-3">
                    <i class="fas fa-wallet fa-2x"></i>
                </div>
                <div>
                    <h3 class="mb-0">Rp {{ number_format($totalEarnings ?? 0, 0, ',', '.') }}</h3>
                    <small class="opacity-75">Total Nilai Ongkir</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('courier.deliveries.history') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label small text-muted">Dari Tanggal</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label small text-muted">Sampai Tanggal</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-success me-2">
                    <i class="fas fa-search me-1"></i>Cari
                </button>
                <a href="{{ route('courier.deliveries.history') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- History List -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Customer</th>
                        <th>Alamat</th>
                        <th>Tanggal Antar</th>
                        <th>Foto</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deliveries as $delivery)
                        <tr>
                            <td>
                                <span class="fw-bold">#{{ $delivery->order_number }}</span>
                                @if($delivery->status === \App\Models\Order::STATUS_COMPLETED)
                                    <br><span class="badge bg-success">Selesai</span>
                                @else
                                    <br><span class="badge bg-info">Sudah Diantar</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($delivery->user->name) }}&background=random&size=32" 
                                         class="rounded-circle me-2" alt="">
                                    {{ $delivery->user->name }}
                                </div>
                            </td>
                            <td>
                                <span title="{{ $delivery->delivery_address }}">
                                    {{ Str::limit($delivery->delivery_address, 30) }}
                                </span>
                            </td>
                            <td>
                                @if($delivery->delivered_at)
                                    {{ $delivery->delivered_at->format('d M Y H:i') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    @if($delivery->pickup_photo)
                                        <a href="{{ asset('storage/' . $delivery->pickup_photo) }}" target="_blank" title="Foto Pengambilan">
                                            <img src="{{ asset('storage/' . $delivery->pickup_photo) }}" class="rounded" style="width: 35px; height: 35px; object-fit: cover;">
                                        </a>
                                    @endif
                                    @if($delivery->delivery_photo)
                                        <a href="{{ asset('storage/' . $delivery->delivery_photo) }}" target="_blank" title="Foto Pengiriman">
                                            <img src="{{ asset('storage/' . $delivery->delivery_photo) }}" class="rounded" style="width: 35px; height: 35px; object-fit: cover;">
                                        </a>
                                    @endif
                                    @if(!$delivery->pickup_photo && !$delivery->delivery_photo)
                                        <span class="text-muted small">-</span>
                                    @endif
                                </div>
                            </td>
                            <td>Rp {{ number_format($delivery->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('courier.deliveries.show', $delivery) }}" 
                                   class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Belum ada riwayat pengiriman</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
@if($deliveries->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $deliveries->withQueryString()->links() }}
    </div>
@endif
@endsection
