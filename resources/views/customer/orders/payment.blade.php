@extends('layouts.app')

@section('title', 'Pembayaran - PATAH')

@push('styles')
<style>
    .payment-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 2rem 0;
    }
    .payment-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        margin-bottom: 1.5rem;
    }
    .payment-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        font-weight: 600;
        color: #1f2937;
    }
    .payment-card-body {
        padding: 1.5rem;
    }
    .order-summary {
        background: #f9fafb;
        border-radius: 8px;
        padding: 1rem;
    }
    .order-number {
        font-size: 14px;
        color: #6b7280;
    }
    .order-total {
        font-size: 24px;
        font-weight: 700;
        color: #16a34a;
    }
    .payment-method-card {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 0.75rem;
    }
    .payment-method-card:hover {
        border-color: #16a34a;
        background: #f0fdf4;
    }
    .payment-method-card.selected {
        border-color: #16a34a;
        background: #f0fdf4;
    }
    .payment-method-card input[type="radio"] {
        display: none;
    }
    .payment-method-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
        border-radius: 8px;
        font-size: 18px;
        color: #6b7280;
    }
    .payment-method-card.selected .payment-method-icon {
        background: #dcfce7;
        color: #16a34a;
    }
    .payment-method-name {
        font-weight: 600;
        color: #1f2937;
    }
    .payment-method-desc {
        font-size: 13px;
        color: #6b7280;
    }
    .btn-pay {
        background: #16a34a;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 14px;
        font-weight: 600;
        font-size: 15px;
        width: 100%;
    }
    .btn-pay:hover:not(:disabled) {
        background: #15803d;
        color: white;
    }
    .btn-pay:disabled {
        background: #9ca3af;
        cursor: not-allowed;
    }
    .redirect-option {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 1px solid #fcd34d;
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1rem;
    }
    
    @media (max-width: 767.98px) {
        .payment-page {
            padding: 1rem 0;
        }
        .payment-card {
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .payment-card-header {
            padding: 0.75rem 1rem;
            font-size: 14px;
        }
        .payment-card-body {
            padding: 1rem;
        }
        .order-total {
            font-size: 20px;
        }
        .payment-method-card {
            padding: 0.75rem;
        }
        .payment-method-icon {
            width: 35px;
            height: 35px;
            font-size: 16px;
        }
        .payment-method-name {
            font-size: 14px;
        }
        .payment-method-desc {
            font-size: 12px;
        }
    }
</style>
@endpush

@section('content')
<div class="payment-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb" style="font-size: 13px;">
                        <li class="breadcrumb-item"><a href="{{ route('customer.orders.index') }}" class="text-decoration-none">Pesanan</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('customer.orders.show', $order) }}" class="text-decoration-none">{{ $order->order_number }}</a></li>
                        <li class="breadcrumb-item active">Pembayaran</li>
                    </ol>
                </nav>

                <!-- Order Summary -->
                <div class="payment-card">
                    <div class="payment-card-header">
                        <i class="fas fa-receipt me-2"></i>Ringkasan Pesanan
                    </div>
                    <div class="payment-card-body">
                        <div class="order-summary">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="order-number">No. Pesanan</span>
                                <strong>{{ $order->order_number }}</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="order-number">Subtotal ({{ $order->items->count() }} item)</span>
                                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="order-number">Ongkir</span>
                                <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Total Pembayaran</span>
                                <span class="order-total">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <form action="{{ route('customer.payment.process', $order) }}" method="POST" id="paymentForm">
                    @csrf
                    
                    <div class="payment-card">
                        <div class="payment-card-header">
                            <i class="fas fa-credit-card me-2"></i>Pilih Metode Pembayaran
                        </div>
                        <div class="payment-card-body">
                            <!-- QRIS -->
                            <label class="payment-method-card d-flex align-items-center gap-3">
                                <input type="radio" name="payment_method" value="qris" required>
                                <div class="payment-method-icon">
                                    <i class="fas fa-qrcode"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="payment-method-name">QRIS</div>
                                    <div class="payment-method-desc">Scan QR dengan aplikasi e-wallet (GoPay, OVO, Dana, dll)</div>
                                </div>
                                <i class="fas fa-check-circle text-success d-none check-icon"></i>
                            </label>

                            <!-- Virtual Account Options -->
                            @foreach(['bni_va' => 'BNI', 'bri_va' => 'BRI', 'cimb_niaga_va' => 'CIMB Niaga', 'permata_va' => 'Permata', 'maybank_va' => 'Maybank'] as $method => $name)
                            <label class="payment-method-card d-flex align-items-center gap-3">
                                <input type="radio" name="payment_method" value="{{ $method }}" required>
                                <div class="payment-method-icon">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="payment-method-name">{{ $name }} Virtual Account</div>
                                    <div class="payment-method-desc">Transfer ke nomor Virtual Account {{ $name }}</div>
                                </div>
                                <i class="fas fa-check-circle text-success d-none check-icon"></i>
                            </label>
                            @endforeach

                            <!-- Redirect Option -->
                            <div class="redirect-option">
                                <label class="d-flex align-items-start gap-3">
                                    <input type="radio" name="payment_method" value="redirect" class="mt-1">
                                    <div>
                                        <div class="fw-bold" style="color: #92400e;">
                                            <i class="fas fa-external-link-alt me-1"></i>Pilih di halaman Pakasir
                                        </div>
                                        <div style="font-size: 13px; color: #78350f;">
                                            Anda akan diarahkan ke halaman Pakasir untuk memilih metode pembayaran
                                        </div>
                                    </div>
                                </label>
                            </div>

                            @error('payment_method')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn-pay" id="payButton">
                        <i class="fas fa-lock me-2"></i>Bayar Sekarang
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('customer.orders.show', $order) }}" class="text-muted text-decoration-none">
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
    const cards = document.querySelectorAll('.payment-method-card');
    const radios = document.querySelectorAll('input[name="payment_method"]');
    
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove selected class from all
            cards.forEach(card => {
                card.classList.remove('selected');
                const checkIcon = card.querySelector('.check-icon');
                if (checkIcon) checkIcon.classList.add('d-none');
            });
            
            // Add selected class to current
            const card = this.closest('.payment-method-card');
            if (card) {
                card.classList.add('selected');
                const checkIcon = card.querySelector('.check-icon');
                if (checkIcon) checkIcon.classList.remove('d-none');
            }
        });
    });

    // Form submit loading
    document.getElementById('paymentForm').addEventListener('submit', function() {
        const btn = document.getElementById('payButton');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
    });
});
</script>
@endpush
