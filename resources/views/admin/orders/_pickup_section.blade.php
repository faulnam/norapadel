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
        @if(!$order->biteship_order_id && $order->payment_status === 'paid')
        <div class="alert alert-info" style="font-size: 13px; padding: 12px; border-radius: 6px; margin-bottom: 16px;">
            <i class="fas fa-info-circle me-2"></i>
            Klik tombol di bawah untuk request pickup ke ekspedisi. Kurir akan datang ke toko untuk mengambil paket.
        </div>
        <form action="{{ route('admin.orders.request-pickup', $order) }}" method="POST" onsubmit="return confirm('Request pickup ke {{ $order->courier_name }}?')">
            @csrf
            <button type="submit" class="action-btn action-btn-primary">
                <i class="fas fa-truck-pickup"></i> Request Pickup
            </button>
        </form>
        @endif

        <!-- Manual Input Resi -->
        @if(!$order->waybill_id && $order->payment_status === 'paid')
        <div class="mt-3">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 8px;">
                Atau input nomor resi manual (jika pickup dilakukan di luar sistem):
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
