@extends('layouts.app')

@section('title', 'Pembayaran Paylabs')

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<style>
    body { padding-top: 0 !important; padding-bottom: 0 !important; }
    #mainNavbar, .mobile-bottom-nav, .footer { display: none !important; }
    .payment-option input[type="radio"] { display: none; }
    .payment-option .option-content {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
    }
    .payment-option input[type="radio"]:checked + .option-content {
        border-color: #000;
        background: #fafafa;
    }
    .payment-option:hover .option-content { border-color: #000; }
    .payment-option .option-content i {
        font-size: 24px;
        color: #000;
        display: block;
        margin-bottom: 8px;
    }
    .payment-option .option-content span {
        font-weight: 500;
        color: #000;
    }
</style>
@endpush

@section('content')
<!-- Navbar -->
<header class="fixed left-0 top-0 z-50 w-full border-b border-black/6 bg-white/80 backdrop-blur-xl md:sticky">
    <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
        <a href="{{ route('home') }}" class="text-xl font-semibold tracking-tight text-black">NoraPadel</a>
        <nav class="hidden items-center gap-8 md:flex">
            <a href="{{ route('home') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Home</a>
            <a href="{{ route('racket') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Racket</a>
            <a href="{{ route('shoes') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Shoes</a>
            <a href="{{ route('apparel') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Accessories</a>
        </nav>
        <div class="flex items-center gap-3 text-black/80">
            <a href="{{ route('customer.orders.index') }}" class="transition duration-300 hover:text-black" title="Riwayat Pesanan">
                <i class="fas fa-history text-sm"></i>
            </a>
            <a href="{{ route('customer.profile.index') }}" class="transition duration-300 hover:text-black" title="Profile">
                <i class="fas fa-user text-sm"></i>
            </a>
            <a href="{{ route('customer.cart.index') }}" class="relative transition duration-300 hover:text-black" title="Keranjang">
                <i class="fas fa-shopping-bag text-sm"></i>
            </a>
        </div>
    </div>
</header>

<div class="min-h-screen bg-zinc-50 py-12 pt-16 md:pt-0">
    <div class="mx-auto max-w-3xl px-6">
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-black">Pilih Metode Pembayaran</h1>
            <p class="mt-2 text-sm text-zinc-500">Order: {{ $order->order_number }} • Total: {{ $order->formatted_total }}</p>
        </div>

        <form action="{{ route('customer.payment.paylabs.process', $order) }}" method="POST" class="space-y-8">
            @csrf

            @php
                $paymentMethods = config('paylabs.payment_methods');
                $vaList = $paymentMethods['va'] ?? [];
                $qrisList = $paymentMethods['qris'] ?? [];
                $ewalletList = $paymentMethods['ewallet'] ?? [];
                $retailList = $paymentMethods['retail'] ?? [];
            @endphp

            <!-- Virtual Account -->
            @if(!empty($vaList))
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-base font-semibold text-black"><i class="fas fa-university me-2"></i>Virtual Account</h3>
                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach($vaList as $value => $label)
                    <label class="payment-option">
                        <input type="radio" name="payment_channel" value="{{ $value }}" required>
                        <div class="option-content">
                            <i class="fas fa-university"></i>
                            <span>{{ $label }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- QRIS -->
            @if(!empty($qrisList))
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-base font-semibold text-black"><i class="fas fa-qrcode me-2"></i>QRIS</h3>
                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach($qrisList as $value => $label)
                    <label class="payment-option">
                        <input type="radio" name="payment_channel" value="{{ $value }}" required>
                        <div class="option-content">
                            <i class="fas fa-qrcode"></i>
                            <span>{{ $label }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- E-Wallet -->
            @if(!empty($ewalletList))
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-base font-semibold text-black"><i class="fas fa-wallet me-2"></i>E-Wallet</h3>
                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach($ewalletList as $value => $label)
                    <label class="payment-option">
                        <input type="radio" name="payment_channel" value="{{ $value }}" required>
                        <div class="option-content">
                            <i class="fas fa-wallet"></i>
                            <span>{{ $label }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Retail -->
            @if(!empty($retailList))
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-base font-semibold text-black"><i class="fas fa-store me-2"></i>Gerai Retail</h3>
                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach($retailList as $value => $label)
                    <label class="payment-option">
                        <input type="radio" name="payment_channel" value="{{ $value }}" required>
                        <div class="option-content">
                            <i class="fas fa-store"></i>
                            <span>{{ $label }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="flex gap-3">
                <a href="{{ route('customer.payment.select-gateway', $order) }}" 
                   class="flex-1 rounded-xl border border-zinc-300 bg-white py-3 text-center text-sm font-medium text-black transition hover:bg-zinc-50">
                    Kembali
                </a>
                <button type="submit" 
                        class="flex-1 rounded-xl bg-black py-3 text-center text-sm font-medium text-white transition hover:bg-black/90">
                    Lanjutkan
                </button>
            </div>
        </form>
    </div>
</div>


@endsection
