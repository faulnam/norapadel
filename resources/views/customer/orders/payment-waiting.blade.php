@extends('layouts.app')

@section('title', 'Menunggu Pembayaran - Nora Padel')

@push('styles')
<style>
    .payment-waiting-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 2rem 0;
    }
    .waiting-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        text-align: center;
        padding: 2rem;
    }
    .payment-status-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        margin-bottom: 1rem;
    }
    .status-pending {
        background: #fef3c7;
        color: #f59e0b;
    }
    .status-success {
        background: #dcfce7;
        color: #16a34a;
    }
    .payment-amount {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }
    .payment-method-badge {
        display: inline-block;
        background: #f3f4f6;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        color: #374151;
        margin-bottom: 1.5rem;
    }
    .qr-container {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        display: inline-block;
        margin-bottom: 1rem;
    }
    .qr-container canvas {
        display: block;
    }
    .va-number-box {
        background: #f9fafb;
        border: 2px dashed #d1d5db;
        border-radius: 10px;
        padding: 1.25rem;
        margin-bottom: 1rem;
    }
    .va-number {
        font-size: 24px;
        font-weight: 700;
        font-family: 'Courier New', monospace;
        color: #1f2937;
        letter-spacing: 2px;
    }
    .btn-copy {
        background: #16a34a;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 500;
    }
    .btn-copy:hover {
        background: #15803d;
        color: white;
    }
    .expired-box {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 8px;
        padding: 12px;
        font-size: 13px;
        color: #dc2626;
        margin-bottom: 1rem;
    }
    .timer-box {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 1.5rem;
    }
    .timer {
        font-size: 20px;
        font-weight: 700;
        color: #92400e;
    }
    .instruction-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        margin-top: 1.5rem;
        text-align: left;
    }
    .instruction-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        font-weight: 600;
        color: #1f2937;
    }
    .instruction-body {
        padding: 1.5rem;
    }
    .instruction-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .instruction-list li {
        display: flex;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f3f4f6;
    }
    .instruction-list li:last-child {
        border-bottom: none;
    }
    .instruction-number {
        width: 24px;
        height: 24px;
        background: #16a34a;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        flex-shrink: 0;
    }
    .checking-status {
        font-size: 13px;
        color: #6b7280;
        margin-top: 1rem;
    }
    .checking-status i {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    @media (max-width: 767.98px) {
        .payment-waiting-page {
            padding: 1rem 0;
        }
        .waiting-card {
            padding: 1.5rem;
        }
        .payment-status-icon {
            width: 60px;
            height: 60px;
            font-size: 28px;
        }
        .payment-amount {
            font-size: 22px;
        }
        .va-number {
            font-size: 18px;
            letter-spacing: 1px;
        }
        .instruction-header {
            padding: 0.75rem 1rem;
            font-size: 14px;
        }
        .instruction-body {
            padding: 1rem;
        }
        .instruction-list li {
            font-size: 13px;
            padding: 8px 0;
        }
    }
</style>
<!-- Preload QR Code library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
@endpush

@section('content')
<div class="payment-waiting-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="waiting-card">
                    <div class="payment-status-icon status-pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    
                    <h4 class="mb-2">Menunggu Pembayaran</h4>
                    <p class="text-muted mb-3">Silakan selesaikan pembayaran Anda</p>
                    
                    <div class="payment-amount">
                        Rp {{ number_format($paymentTransaction['total_payment'] ?? $order->total_amount, 0, ',', '.') }}
                    </div>
                    
                    @php
                        $methodName = $paymentMethods[$paymentTransaction['method']]['name'] ?? strtoupper($paymentTransaction['method']);
                    @endphp
                    <div class="payment-method-badge">
                        <i class="{{ $paymentMethods[$paymentTransaction['method']]['icon'] ?? 'fas fa-credit-card' }} me-1"></i>
                        {{ $methodName }}
                    </div>

                    @if($paymentTransaction['fee'] > 0)
                    <p class="text-muted small mb-3">
                        Termasuk biaya layanan: Rp {{ number_format($paymentTransaction['fee'], 0, ',', '.') }}
                    </p>
                    @endif

                    @if($paymentTransaction['expired_at'])
                    <div class="timer-box">
                        <div class="small text-muted mb-1">Selesaikan pembayaran dalam:</div>
                        <div class="timer" id="countdown">Memuat...</div>
                        <div class="small text-muted mt-1" id="expiredTime"></div>
                    </div>
                    @endif

                    @if($paymentTransaction['method'] === 'qris')
                        <!-- QR Code Display -->
                        <div class="qr-container">
                            <div id="qrcode"></div>
                        </div>
                        <p class="text-muted small">Scan QR code dengan aplikasi e-wallet Anda</p>
                    @else
                        <!-- Virtual Account Display -->
                        <div class="va-number-box">
                            <div class="small text-muted mb-2">Nomor Virtual Account</div>
                            <div class="va-number" id="vaNumber">{{ $paymentTransaction['payment_number'] }}</div>
                        </div>
                        <button type="button" class="btn-copy" onclick="copyVA()">
                            <i class="fas fa-copy me-1"></i>Salin Nomor
                        </button>
                    @endif

                    <div class="checking-status">
                        <i class="fas fa-sync-alt"></i>
                        Memeriksa status pembayaran...
                    </div>
                    </div>
                </div>

                <!-- Payment Instructions -->
                <div class="instruction-card">
                    <div class="instruction-header">
                        <i class="fas fa-info-circle me-2"></i>Cara Pembayaran
                    </div>
                    <div class="instruction-body">
                        @if($paymentTransaction['method'] === 'qris')
                        <ol class="instruction-list">
                            <li>
                                <span class="instruction-number">1</span>
                                <span>Buka aplikasi e-wallet (GoPay, OVO, Dana, ShopeePay, dll)</span>
                            </li>
                            <li>
                                <span class="instruction-number">2</span>
                                <span>Pilih menu <strong>Scan</strong> atau <strong>Bayar</strong></span>
                            </li>
                            <li>
                                <span class="instruction-number">3</span>
                                <span>Arahkan kamera ke QR code di atas</span>
                            </li>
                            <li>
                                <span class="instruction-number">4</span>
                                <span>Periksa nominal dan konfirmasi pembayaran</span>
                            </li>
                            <li>
                                <span class="instruction-number">5</span>
                                <span>Pembayaran selesai! Halaman akan otomatis terupdate</span>
                            </li>
                        </ol>
                        @else
                        <ol class="instruction-list">
                            <li>
                                <span class="instruction-number">1</span>
                                <span>Salin nomor Virtual Account di atas</span>
                            </li>
                            <li>
                                <span class="instruction-number">2</span>
                                <span>Buka aplikasi m-banking atau internet banking Anda</span>
                            </li>
                            <li>
                                <span class="instruction-number">3</span>
                                <span>Pilih menu <strong>Transfer</strong> ke Virtual Account</span>
                            </li>
                            <li>
                                <span class="instruction-number">4</span>
                                <span>Masukkan nomor Virtual Account dan nominal transfer</span>
                            </li>
                            <li>
                                <span class="instruction-number">5</span>
                                <span>Konfirmasi dan selesaikan pembayaran</span>
                            </li>
                        </ol>
                        @endif
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Detail Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate QR Code for QRIS
    @if($paymentTransaction['method'] === 'qris')
    const qrString = @json($paymentTransaction['payment_number']);
    const qrcodeEl = document.getElementById('qrcode');
    
    if (typeof QRCode !== 'undefined' && qrcodeEl) {
        new QRCode(qrcodeEl, {
            text: qrString,
            width: 250,
            height: 250,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.L
        });
    }
    @endif

    // Countdown timer
    @if($paymentTransaction['expired_at'])
    const expiredAtStr = @json($paymentTransaction['expired_at']);
    const expiredAt = new Date(expiredAtStr);
    const expiredTimeEl = document.getElementById('expiredTime');
    
    // Show expired time
    if (expiredTimeEl) {
        const options = { 
            day: 'numeric', 
            month: 'short', 
            year: 'numeric',
            hour: '2-digit', 
            minute: '2-digit',
            hour12: false
        };
        expiredTimeEl.textContent = 'Batas waktu: ' + expiredAt.toLocaleDateString('id-ID', options);
    }
    
    function updateCountdown() {
        const now = new Date();
        const diff = expiredAt - now;
        
        if (diff <= 0) {
            document.getElementById('countdown').textContent = 'Kadaluarsa';
            document.getElementById('countdown').style.color = '#dc2626';
            return;
        }
        
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        
        document.getElementById('countdown').textContent = 
            String(hours).padStart(2, '0') + ':' + 
            String(minutes).padStart(2, '0') + ':' + 
            String(seconds).padStart(2, '0');
    }
    
    updateCountdown();
    setInterval(updateCountdown, 1000);
    @else
    // No expired_at, hide timer box
    const timerBox = document.querySelector('.timer-box');
    if (timerBox) timerBox.style.display = 'none';
    @endif

    // Check payment status every 5 seconds
    function checkPaymentStatus() {
        fetch('{{ route("customer.payment.check-status", $order) }}')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'paid') {
                    // Payment successful
                    document.querySelector('.payment-status-icon').classList.remove('status-pending');
                    document.querySelector('.payment-status-icon').classList.add('status-success');
                    document.querySelector('.payment-status-icon').innerHTML = '<i class="fas fa-check"></i>';
                    document.querySelector('.waiting-card h4').textContent = 'Pembayaran Berhasil!';
                    document.querySelector('.checking-status').innerHTML = '<i class="fas fa-check-circle text-success"></i> ' + data.message;
                    
                    // Redirect after 2 seconds
                    setTimeout(function() {
                        window.location.href = data.redirect;
                    }, 2000);
                }
            })
            .catch(error => console.error('Error checking status:', error));
    }
    
    // Check every 5 seconds
    setInterval(checkPaymentStatus, 5000);
    // Initial check after 3 seconds
    setTimeout(checkPaymentStatus, 3000);
});

function copyVA() {
    const vaNumber = document.getElementById('vaNumber').textContent;
    navigator.clipboard.writeText(vaNumber).then(function() {
        // Show toast or feedback
        const btn = event.target.closest('.btn-copy');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check me-1"></i>Tersalin!';
        btn.classList.remove('btn-copy');
        btn.classList.add('btn-success');
        
        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-copy');
        }, 2000);
    });
}

function simulatePayment() {
    const btn = document.getElementById('simulatePaymentBtn');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...';
    
    fetch('{{ route("customer.payment.simulate", $order) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success' || data.status === 'already_paid') {
            // Payment successful
            document.querySelector('.payment-status-icon').classList.remove('status-pending');
            document.querySelector('.payment-status-icon').classList.add('status-success');
            document.querySelector('.payment-status-icon').innerHTML = '<i class="fas fa-check"></i>';
            document.querySelector('.waiting-card h4').textContent = 'Pembayaran Berhasil!';
            document.querySelector('.checking-status').innerHTML = '<i class="fas fa-check-circle text-success"></i> ' + data.message;
            
            btn.innerHTML = '<i class="fas fa-check me-1"></i>Berhasil!';
            btn.classList.remove('btn-warning');
            btn.classList.add('btn-success');
            
            // Redirect after 2 seconds
            setTimeout(function() {
                window.location.href = data.redirect;
            }, 2000);
        } else {
            btn.disabled = false;
            btn.innerHTML = originalText;
            alert(data.message || 'Gagal simulasi pembayaran');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        btn.disabled = false;
        btn.innerHTML = originalText;
        alert('Terjadi kesalahan. Coba lagi.');
    });
}
</script>
@endpush
