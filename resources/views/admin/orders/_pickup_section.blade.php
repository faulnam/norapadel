<!-- Ekspedisi & Pickup -->
@if($order->courier_code)
<div class="detail-card">
    <div class="detail-card-header">
        <h6><i class="fas fa-shipping-fast"></i> Ekspedisi & Pickup</h6>
        @if($order->waybill_id)
            <span class="status-badge success">Resi: {{ $order->waybill_id }}</span>
        @elseif($order->biteship_order_id)
            <span class="status-badge processing">Pickup Requested</span>
        @else
            <span class="status-badge pending">Belum Pickup</span>
        @endif
    </div>
    <div class="detail-card-body">
        <!-- Info Ekspedisi -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="info-row">
                    <span class="info-label">Ekspedisi</span>
                    <span class="info-value">{{ $order->courier_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Layanan</span>
                    <span class="info-value">{{ $order->courier_service_name }}</span>
                </div>
            </div>
            <div class="col-md-6">
                @if($order->waybill_id)
                <div class="info-row">
                    <span class="info-label">No. Resi</span>
                    <span class="info-value">{{ $order->waybill_id }}</span>
                </div>
                @endif
                @if($order->biteship_order_id)
                <div class="info-row">
                    <span class="info-label">Biteship ID</span>
                    <span class="info-value" style="font-size: 11px;">{{ $order->biteship_order_id }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Request Pickup Button -->
        @if(!$order->biteship_order_id && $order->payment_status === 'paid' && in_array($order->status, ['processing', 'ready_to_ship']))
        <div class="alert alert-info" style="font-size: 13px; padding: 12px; border-radius: 6px; margin-bottom: 16px;">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Langkah selanjutnya:</strong> 
            @if($order->status === 'processing')
                Pack barang pesanan terlebih dahulu, lalu ubah status ke "Siap Pickup" atau langsung klik tombol di bawah untuk request pickup ke {{ $order->courier_name }}.
            @else
                Barang sudah siap. Klik tombol di bawah untuk request pickup ke {{ $order->courier_name }}. Sistem akan mencari kurir terdekat.
            @endif
        </div>
        <button type="button" class="action-btn action-btn-primary" onclick="requestPickupWithLoading()">
            <i class="fas fa-truck-pickup"></i> Request Pickup ke {{ $order->courier_name }}
        </button>
        
        <!-- Loading Modal -->
        <div id="pickupLoadingModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; align-items: center; justify-content: center;">
            <div style="background: white; padding: 40px; border-radius: 12px; text-align: center; max-width: 400px;">
                <div class="spinner-border text-primary mb-3" role="status" style="width: 50px; height: 50px;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h5 style="color: var(--text-primary); margin-bottom: 8px;">Mencari Kurir Terdekat...</h5>
                <p style="color: var(--text-muted); font-size: 13px; margin: 0;">Mohon tunggu sebentar</p>
            </div>
        </div>
        @endif

        @if($order->status === 'ready_to_ship' && $order->courier_driver_name)
        <div class="alert alert-success" style="font-size: 13px; padding: 16px; border-radius: 8px; margin-bottom: 16px; border-left: 4px solid #10b981;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <i class="fas fa-check-circle" style="font-size: 20px; color: #10b981;"></i>
                <strong style="font-size: 14px;">Pickup Berhasil Direquest!</strong>
            </div>
            <p style="margin: 0 0 12px 0; color: var(--text-secondary);">Kurir akan datang ke toko dalam <strong>30 menit</strong>. Barang siap untuk diambil.</p>
        </div>
        
        <!-- Courier Info Card -->
        <div style="background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; padding: 16px;">
            <div style="font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Informasi Kurir</div>
            
            <div style="display: flex; gap: 16px; align-items: start;">
                <img src="{{ $order->courier_driver_photo }}" alt="{{ $order->courier_driver_name }}" 
                     style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                
                <div style="flex: 1;">
                    <div style="font-weight: 600; color: var(--text-primary); font-size: 15px; margin-bottom: 4px;">{{ $order->courier_driver_name }}</div>
                    
                    <div style="display: flex; align-items: center; gap: 4px; margin-bottom: 6px;">
                        <i class="fas fa-star" style="color: #fbbf24; font-size: 12px;"></i>
                        <span style="font-size: 13px; font-weight: 600; color: var(--text-primary);">{{ number_format($order->courier_driver_rating, 1) }}</span>
                        <span style="font-size: 12px; color: var(--text-muted);">rating</span>
                    </div>
                    
                    <div style="display: flex; gap: 16px; margin-top: 8px;">
                        <div>
                            <div style="font-size: 11px; color: var(--text-muted);">Telepon</div>
                            <div style="font-size: 13px; color: var(--text-primary); font-weight: 500;">{{ $order->courier_driver_phone }}</div>
                        </div>
                        <div>
                            <div style="font-size: 11px; color: var(--text-muted);">Kendaraan</div>
                            <div style="font-size: 13px; color: var(--text-primary); font-weight: 500;">{{ $order->courier_driver_vehicle }} - {{ $order->courier_driver_vehicle_number }}</div>
                        </div>
                    </div>
                    
                    @if($order->pickup_time)
                    <div style="margin-top: 12px; padding: 8px 12px; background: white; border-radius: 6px; border: 1px solid var(--border-color);">
                        <div style="font-size: 11px; color: var(--text-muted); margin-bottom: 2px;">Estimasi Pickup</div>
                        <div style="font-size: 13px; color: var(--text-primary); font-weight: 600;">
                            <i class="fas fa-clock me-1"></i> {{ $order->pickup_time->format('H:i') }} WIB
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @elseif($order->status === 'processing')
        <div class="alert alert-warning" style="font-size: 13px; padding: 12px; border-radius: 6px; margin-bottom: 0; border-left: 4px solid #f59e0b;">
            <i class="fas fa-box me-2"></i>
            <strong>Pesanan sedang diproses.</strong> Silakan pack barang dan ubah status ke "Siap Pickup" jika sudah siap.
        </div>
        @endif

        @if($order->status === 'shipped')
        <div class="alert alert-primary" style="font-size: 13px; padding: 12px; border-radius: 6px; margin-bottom: 0;">
            <i class="fas fa-shipping-fast me-2"></i>
            <strong>Paket sedang dikirim</strong> oleh {{ $order->courier_name }} dengan nomor resi <strong>{{ $order->waybill_id }}</strong>
        </div>
        @endif

        <!-- Manual Input Resi -->
        @if(!$order->waybill_id && $order->payment_status === 'paid' && in_array($order->status, ['processing', 'ready_to_ship']))
        <div class="mt-3">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 8px; border-top: 1px solid var(--border-color); padding-top: 16px;">
                <strong>Atau</strong> input nomor resi manual (jika pickup dilakukan di luar sistem):
            </div>
            <form action="{{ route('admin.orders.update-waybill', $order) }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control-minimal" name="waybill_id" placeholder="Masukkan nomor resi" required style="border-radius: 6px 0 0 6px;">
                    <button type="submit" class="action-btn action-btn-outline" style="border-radius: 0 6px 6px 0; width: auto; padding: 0 16px;">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
        @endif

        <!-- Tracking Button -->
        @if($order->waybill_id)
        <div class="mt-3">
            <button type="button" class="action-btn action-btn-outline" onclick="loadTracking()">
                <i class="fas fa-map-marker-alt"></i> Lihat Tracking
            </button>
        </div>

        <!-- Tracking Result -->
        <div id="trackingResult" style="display: none; margin-top: 16px;">
            <div class="section-title">Status Pengiriman</div>
            <div id="trackingContent"></div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function requestPickupWithLoading() {
    if (!confirm('Request pickup ke {{ $order->courier_name }}?')) {
        return;
    }
    
    // Show loading modal
    const modal = document.getElementById('pickupLoadingModal');
    modal.style.display = 'flex';
    
    // Submit form via fetch
    fetch('{{ route("admin.orders.request-pickup", $order) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        modal.style.display = 'none';
        if (data.success) {
            window.location.reload();
        } else {
            alert('Error: ' + (data.message || 'Gagal request pickup'));
        }
    })
    .catch(error => {
        modal.style.display = 'none';
        alert('Error: ' + error.message);
    });
}

function loadTracking() {
    const resultDiv = document.getElementById('trackingResult');
    const contentDiv = document.getElementById('trackingContent');
    
    resultDiv.style.display = 'block';
    contentDiv.innerHTML = '<div style="text-align: center; padding: 20px; color: var(--text-muted);"><i class="fas fa-spinner fa-spin me-2"></i>Memuat data tracking...</div>';
    
    fetch('{{ route("admin.orders.tracking", $order) }}')
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                contentDiv.innerHTML = '<div class="alert alert-warning" style="font-size: 13px;">Gagal memuat tracking: ' + data.message + '</div>';
                return;
            }
            
            const tracking = data.data;
            let html = '';
            
            if (tracking.history && tracking.history.length > 0) {
                tracking.history.forEach(item => {
                    html += `
                    <div class="timeline-item">
                        <div>
                            <div class="timeline-label">${item.note || item.status}</div>
                            <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">
                                ${item.service_type || ''} ${item.receiver_name ? '- Diterima: ' + item.receiver_name : ''}
                            </div>
                        </div>
                        <span class="timeline-time">${item.updated_at || item.created_at}</span>
                    </div>`;
                });
            } else {
                html = '<div style="text-align: center; padding: 20px; color: var(--text-muted);">Belum ada data tracking</div>';
            }
            
            contentDiv.innerHTML = html;
        })
        .catch(error => {
            contentDiv.innerHTML = '<div class="alert alert-danger" style="font-size: 13px;">Error: ' + error.message + '</div>';
        });
}
</script>
@endpush
@endif
