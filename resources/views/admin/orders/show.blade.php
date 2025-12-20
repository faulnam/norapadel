@extends('layouts.admin')

@section('page-title', 'Detail Pesanan')

@section('content')
<div class="row">
    <!-- Order Info -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-info-circle me-2"></i>Informasi Pesanan</span>
                <span class="badge bg-{{ $order->status_color }} fs-6">{{ $order->status_label }}</span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>No. Pesanan:</strong><br>
                        <span class="text-primary">{{ $order->order_number }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Pesanan:</strong><br>
                        {{ $order->created_at->format('d F Y, H:i') }}
                    </div>
                </div>
                
                <hr>
                
                <h6><i class="fas fa-user me-2"></i>Data Customer</h6>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Nama:</strong><br>{{ $order->user->name }}
                    </div>
                    <div class="col-md-4">
                        <strong>Email:</strong><br>{{ $order->user->email }}
                    </div>
                    <div class="col-md-4">
                        <strong>Telepon:</strong><br>{{ $order->user->phone }}
                    </div>
                </div>
                
                <hr>
                
                <h6><i class="fas fa-map-marker-alt me-2"></i>Alamat Pengiriman</h6>
                <p class="mb-1"><strong>{{ $order->shipping_name }}</strong> ({{ $order->shipping_phone }})</p>
                <p class="text-muted mb-2">{{ $order->shipping_address }}</p>
                
                @if($order->delivery_distance_minutes)
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-route me-1"></i>Estimasi Jarak: 
                            <strong class="text-dark">{{ $order->delivery_distance_minutes }} menit</strong>
                        </small>
                    </div>
                    @if($order->shipping_latitude && $order->shipping_longitude)
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-map-pin me-1"></i>Koordinat: 
                            <strong class="text-dark">{{ $order->shipping_latitude }}, {{ $order->shipping_longitude }}</strong>
                        </small>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Jadwal Pengiriman -->
                @if($order->delivery_date)
                <div class="alert alert-warning mt-3 mb-0">
                    <strong><i class="fas fa-calendar-alt me-2"></i>Jadwal Pengiriman</strong>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <i class="fas fa-calendar me-1"></i> Tanggal: <strong>{{ $order->formatted_delivery_date }}</strong>
                        </div>
                        <div class="col-md-6">
                            <i class="fas fa-clock me-1"></i> Jam: <strong>{{ $order->delivery_time_slot ?? '10:00 - 16:00' }} WIB</strong>
                        </div>
                    </div>
                </div>
                @endif
                
                @if($order->notes)
                    <div class="alert alert-info mt-3">
                        <strong>Catatan:</strong> {{ $order->notes }}
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Order Items -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-box me-2"></i>Item Pesanan
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
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
                                    <strong>{{ $item->product_name }}</strong>
                                </td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">{{ $item->formatted_price }}</td>
                                <td class="text-end">{{ $item->formatted_subtotal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                            <td class="text-end">{{ $order->formatted_subtotal }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end">
                                <strong>Ongkir:</strong>
                                @if($order->delivery_distance_minutes)
                                <small class="text-muted">({{ $order->delivery_distance_minutes }} menit)</small>
                                @endif
                            </td>
                            <td class="text-end">{{ $order->formatted_shipping_cost }}</td>
                        </tr>
                        <tr class="table-success">
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td class="text-end"><strong>{{ $order->formatted_total }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Tugaskan Kurir - di area content utama -->
        @if($order->canAssignCourier())
        <div class="card mb-4 border-primary">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-motorcycle me-2"></i>Tugaskan Kurir
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.assign-courier', $order) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Pilih Kurir yang Tersedia</label>
                        <select class="form-select form-select-lg" name="courier_id" required>
                            <option value="">-- Pilih Kurir --</option>
                            @foreach($couriers as $courier)
                                <option value="{{ $courier->id }}">
                                    {{ $courier->name }} - {{ $courier->phone }}
                                    ({{ $courier->activeDeliveries()->count() }} tugas aktif)
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Pilih kurir untuk mengantarkan pesanan ini</div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-paper-plane me-2"></i>Tugaskan Kurir Sekarang
                    </button>
                </form>
            </div>
        </div>
        @endif

        <!-- Kurir Info (if already assigned) -->
        @if($order->courier)
        <div class="card mb-4 border-success">
            <div class="card-header bg-success text-white">
                <i class="fas fa-motorcycle me-2"></i>Kurir Ditugaskan
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($order->courier->name) }}&background=28a745&color=fff&size=60" 
                         class="rounded-circle me-3" alt="Courier">
                    <div>
                        <h5 class="mb-1">{{ $order->courier->name }}</h5>
                        <p class="mb-0 text-muted">
                            <i class="fas fa-phone me-1"></i>{{ $order->courier->phone ?? '-' }}
                        </p>
                    </div>
                </div>
                
                <hr>
                
                <div class="small">
                    @if($order->assigned_at)
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-clipboard-list text-primary me-2"></i>Ditugaskan</span>
                            <span>{{ $order->assigned_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                    @if($order->picked_up_at)
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-box text-info me-2"></i>Barang Diambil</span>
                            <span>{{ $order->picked_up_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                    @if($order->on_delivery_at)
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-truck text-warning me-2"></i>Mulai Antar</span>
                            <span>{{ $order->on_delivery_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                    @if($order->delivered_at)
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-check-circle text-success me-2"></i>Sampai Tujuan</span>
                            <span>{{ $order->delivered_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                </div>
                
                @if($order->delivery_notes)
                    <div class="alert alert-light mt-3 mb-0">
                        <strong><i class="fas fa-sticky-note me-1"></i>Catatan Kurir:</strong><br>
                        {{ $order->delivery_notes }}
                    </div>
                @endif
                
                <!-- Delivery Photos -->
                @if($order->pickup_photo || $order->delivery_photo)
                <hr>
                <h6 class="mb-3"><i class="fas fa-camera me-2"></i>Foto Dokumentasi</h6>
                <div class="row g-2">
                    @if($order->pickup_photo)
                    <div class="col-6">
                        <div class="card">
                            <a href="{{ asset('storage/' . $order->pickup_photo) }}" target="_blank">
                                <img src="{{ asset('storage/' . $order->pickup_photo) }}" class="card-img-top" style="height: 120px; object-fit: cover;">
                            </a>
                            <div class="card-body p-2 text-center">
                                <small class="text-muted">Foto Pengambilan</small>
                                @if($order->picked_up_at)
                                <br><small class="text-muted">{{ $order->picked_up_at->format('d/m H:i') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($order->delivery_photo)
                    <div class="col-6">
                        <div class="card">
                            <a href="{{ asset('storage/' . $order->delivery_photo) }}" target="_blank">
                                <img src="{{ asset('storage/' . $order->delivery_photo) }}" class="card-img-top" style="height: 120px; object-fit: cover;">
                            </a>
                            <div class="card-body p-2 text-center">
                                <small class="text-muted">Foto Pengiriman</small>
                                @if($order->delivered_at)
                                <br><small class="text-muted">{{ $order->delivered_at->format('d/m H:i') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
    
    <!-- Actions Sidebar -->
    <div class="col-lg-4">
        <!-- Payment Status -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-credit-card me-2"></i>Status Pembayaran
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Status:</span>
                    <span class="badge bg-{{ $order->payment_status_color }} fs-6">{{ $order->payment_status_label }}</span>
                </div>
                
                @if($order->payment_proof)
                    <div class="mb-3">
                        <strong>Bukti Pembayaran:</strong>
                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="d-block mt-2">
                            <img src="{{ asset('storage/' . $order->payment_proof) }}" class="img-fluid rounded" style="max-height: 200px;">
                        </a>
                    </div>
                    
                    @if($order->payment_status === 'pending_verification')
                        <div class="d-grid gap-2">
                            <form action="{{ route('admin.orders.verify-payment', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check me-1"></i>Verifikasi Pembayaran
                                </button>
                            </form>
                            <form action="{{ route('admin.orders.reject-payment', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-danger w-100" 
                                        onclick="return confirm('Tolak bukti pembayaran ini?')">
                                    <i class="fas fa-times me-1"></i>Tolak Pembayaran
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <p class="text-muted mb-0">Belum ada bukti pembayaran</p>
                @endif

                @if($order->payment_verified_at)
                    <small class="text-success">
                        <i class="fas fa-check-circle me-1"></i>
                        Diverifikasi: {{ $order->payment_verified_at->format('d/m/Y H:i') }}
                    </small>
                @endif
            </div>
        </div>
        
        <!-- Update Status -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-sync me-2"></i>Update Status
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" id="statusForm">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label class="form-label">Status Pesanan</label>
                        <select class="form-select" name="status" id="statusSelect" onchange="toggleCancelReason()">
                            <option value="pending_payment" {{ $order->status == 'pending_payment' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                            <option value="assigned" {{ $order->status == 'assigned' ? 'selected' : '' }}>Ditugaskan ke Kurir</option>
                            <option value="picked_up" {{ $order->status == 'picked_up' ? 'selected' : '' }}>Barang Diambil</option>
                            <option value="on_delivery" {{ $order->status == 'on_delivery' ? 'selected' : '' }}>Sedang Diantar</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Sudah Sampai</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="cancelReasonDiv" style="display: none;">
                        <label class="form-label">Alasan Pembatalan</label>
                        <textarea class="form-control" name="cancel_reason" rows="3">{{ $order->cancel_reason }}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-1"></i>Update Status
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Print Receipt -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-print me-2"></i>Cetak Resi
            </div>
            <div class="card-body">
                <a href="{{ route('admin.orders.receipt', $order) }}" class="btn btn-outline-primary w-100 mb-2" target="_blank">
                    <i class="fas fa-eye me-1"></i>Lihat Resi
                </a>
                <a href="{{ route('admin.orders.print-receipt', $order) }}" class="btn btn-primary w-100">
                    <i class="fas fa-download me-1"></i>Download PDF
                </a>
            </div>
        </div>
        
        <!-- Back Button -->
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary w-100">
            <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar Pesanan
        </a>
    </div>
</div>

@push('scripts')
<script>
function toggleCancelReason() {
    const status = document.getElementById('statusSelect').value;
    const cancelDiv = document.getElementById('cancelReasonDiv');
    
    if (status === 'cancelled') {
        cancelDiv.style.display = 'block';
    } else {
        cancelDiv.style.display = 'none';
    }
}

// Initialize on page load
toggleCancelReason();
</script>
@endpush
@endsection
