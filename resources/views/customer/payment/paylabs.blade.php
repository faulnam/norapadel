@extends('layouts.app')

@section('title', 'Pembayaran Paylabs')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Pilih Metode Pembayaran</h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        Order: <strong>{{ $order->order_number }}</strong><br>
                        Total: <strong>{{ $order->formatted_total }}</strong>
                    </div>

                    <form action="{{ route('customer.payment.paylabs.process', $order) }}" method="POST">
                        @csrf

                        <!-- Virtual Account -->
                        <div class="payment-method-section mb-4">
                            <h6 class="mb-3"><i class="fas fa-university me-2"></i>Virtual Account</h6>
                            <div class="row g-3">
                                @foreach(['BCA', 'BNI', 'BRI', 'Mandiri', 'Permata'] as $bank)
                                <div class="col-md-6">
                                    <label class="payment-option">
                                        <input type="radio" name="payment_channel" value="VA_{{ strtoupper($bank) }}" required>
                                        <div class="option-content">
                                            <i class="fas fa-university"></i>
                                            <span>{{ $bank }}</span>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- QRIS -->
                        <div class="payment-method-section mb-4">
                            <h6 class="mb-3"><i class="fas fa-qrcode me-2"></i>QRIS</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="payment-option">
                                        <input type="radio" name="payment_channel" value="QRIS" required>
                                        <div class="option-content">
                                            <i class="fas fa-qrcode"></i>
                                            <span>QRIS</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- E-Wallet -->
                        <div class="payment-method-section mb-4">
                            <h6 class="mb-3"><i class="fas fa-wallet me-2"></i>E-Wallet</h6>
                            <div class="row g-3">
                                @foreach(['OVO', 'DANA', 'ShopeePay', 'LinkAja', 'GoPay'] as $wallet)
                                <div class="col-md-6">
                                    <label class="payment-option">
                                        <input type="radio" name="payment_channel" value="EWALLET_{{ strtoupper($wallet) }}" required>
                                        <div class="option-content">
                                            <i class="fas fa-wallet"></i>
                                            <span>{{ $wallet }}</span>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Retail -->
                        <div class="payment-method-section mb-4">
                            <h6 class="mb-3"><i class="fas fa-store me-2"></i>Retail</h6>
                            <div class="row g-3">
                                @foreach(['Alfamart', 'Indomaret'] as $retail)
                                <div class="col-md-6">
                                    <label class="payment-option">
                                        <input type="radio" name="payment_channel" value="RETAIL_{{ strtoupper($retail) }}" required>
                                        <div class="option-content">
                                            <i class="fas fa-store"></i>
                                            <span>{{ $retail }}</span>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('customer.payment.select-gateway', $order) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-check me-2"></i>Lanjutkan Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.payment-method-section {
    border-bottom: 1px solid #e5e7eb;
    padding-bottom: 24px;
}

.payment-method-section:last-child {
    border-bottom: none;
}

.payment-option {
    display: block;
    cursor: pointer;
    margin: 0;
}

.payment-option input[type="radio"] {
    display: none;
}

.payment-option .option-content {
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 16px;
    text-align: center;
    transition: all 0.3s;
    background: white;
}

.payment-option input[type="radio"]:checked + .option-content {
    border-color: #0071e3;
    background: #f0f7ff;
}

.payment-option:hover .option-content {
    border-color: #0071e3;
}

.payment-option .option-content i {
    font-size: 24px;
    color: #0071e3;
    display: block;
    margin-bottom: 8px;
}

.payment-option .option-content span {
    font-weight: 500;
    color: #1f2937;
}
</style>
@endsection
