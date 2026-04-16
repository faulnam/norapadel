@extends('layouts.app')

@section('title', 'Pilih Metode Pembayaran')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Pilih Metode Pembayaran</h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Order: <strong>{{ $order->order_number }}</strong><br>
                        Total: <strong>{{ $order->formatted_total }}</strong>
                    </div>

                    <div class="row g-3">
                        <!-- Paylabs -->
                        <div class="col-md-6">
                            <a href="{{ route('customer.payment.paylabs.show', $order) }}" class="text-decoration-none">
                                <div class="payment-gateway-card">
                                    <div class="gateway-icon">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <h6>Paylabs</h6>
                                    <p class="text-muted small mb-0">Virtual Account, QRIS, E-Wallet</p>
                                    <div class="badge bg-success mt-2">Recommended</div>
                                </div>
                            </a>
                        </div>

                        <!-- Pakasir -->
                        <div class="col-md-6">
                            <a href="{{ route('customer.payment.show', $order) }}" class="text-decoration-none">
                                <div class="payment-gateway-card">
                                    <div class="gateway-icon">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <h6>Pakasir</h6>
                                    <p class="text-muted small mb-0">Transfer Manual</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.payment-gateway-card {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    transition: all 0.3s;
    background: white;
    height: 100%;
}

.payment-gateway-card:hover {
    border-color: #0071e3;
    box-shadow: 0 4px 12px rgba(0, 113, 227, 0.1);
    transform: translateY(-2px);
}

.gateway-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    font-size: 24px;
    color: #0071e3;
}

.payment-gateway-card h6 {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 8px;
}
</style>
@endsection
