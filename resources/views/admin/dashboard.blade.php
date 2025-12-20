@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card bg-gradient-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1">{{ number_format($totalOrders) }}</h3>
                    <p class="mb-0 opacity-75">Total Pesanan</p>
                </div>
                <i class="fas fa-shopping-cart fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card bg-gradient-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p class="mb-0 opacity-75">Total Pendapatan</p>
                </div>
                <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card bg-gradient-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1">{{ number_format($totalProducts) }}</h3>
                    <p class="mb-0 opacity-75">Total Produk</p>
                </div>
                <i class="fas fa-box fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card bg-gradient-info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1">{{ number_format($totalCustomers) }}</h3>
                    <p class="mb-0 opacity-75">Total Customer</p>
                </div>
                <i class="fas fa-users fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<!-- Order Status & Chart -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-line me-2"></i>Pendapatan 6 Bulan Terakhir</span>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="fas fa-chart-pie me-2"></i>Status Pesanan
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-clock text-warning me-2"></i>Menunggu Pembayaran</span>
                        <span class="badge bg-warning">{{ $orderStats['pending'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-cog text-info me-2"></i>Diproses</span>
                        <span class="badge bg-info">{{ $orderStats['processing'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-truck text-primary me-2"></i>Dikirim</span>
                        <span class="badge bg-primary">{{ $orderStats['shipped'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-check-circle text-success me-2"></i>Selesai</span>
                        <span class="badge bg-success">{{ $orderStats['completed'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-times-circle text-danger me-2"></i>Dibatalkan</span>
                        <span class="badge bg-danger">{{ $orderStats['cancelled'] }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Alerts & Recent Orders -->
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bell me-2"></i>Perlu Tindakan
            </div>
            <div class="card-body">
                @if($pendingPayments > 0)
                    <a href="{{ route('admin.orders.index', ['payment_status' => 'pending_verification']) }}" class="d-block p-3 bg-warning bg-opacity-10 rounded mb-3 text-decoration-none">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-warning">
                                <i class="fas fa-credit-card me-2"></i>Pembayaran Pending
                            </span>
                            <span class="badge bg-warning">{{ $pendingPayments }}</span>
                        </div>
                    </a>
                @endif
                
                @if($pendingTestimonials > 0)
                    <a href="{{ route('admin.testimonials.index', ['status' => 'pending']) }}" class="d-block p-3 bg-info bg-opacity-10 rounded mb-3 text-decoration-none">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-info">
                                <i class="fas fa-comment me-2"></i>Testimoni Pending
                            </span>
                            <span class="badge bg-info">{{ $pendingTestimonials }}</span>
                        </div>
                    </a>
                @endif
                
                @if($pendingPayments == 0 && $pendingTestimonials == 0)
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-check-circle fa-3x mb-3"></i>
                        <p class="mb-0">Tidak ada yang perlu ditindak</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-shopping-cart me-2"></i>Pesanan Terbaru</span>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}">
                                            {{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->formatted_total }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status_color }}">
                                            {{ $order->status_label }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Belum ada pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($monthlyRevenue, 'month')) !!},
            datasets: [{
                label: 'Pendapatan',
                data: {!! json_encode(array_column($monthlyRevenue, 'revenue')) !!},
                borderColor: '#2E7D32',
                backgroundColor: 'rgba(46, 125, 50, 0.1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
