@extends('layouts.app')

@section('title', 'Paylabs Payment')

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
@include('components.luxury-navbar')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hamburgerBtn = document.getElementById('hamburgerMenuBtn');
        const hamburgerDropdown = document.getElementById('hamburgerMenuDropdown');
        if (hamburgerBtn && hamburgerDropdown) {
            hamburgerBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                hamburgerDropdown.classList.toggle('hidden');
            });
            document.addEventListener('click', function(e) {
                if (!hamburgerDropdown.contains(e.target) && e.target !== hamburgerBtn && !hamburgerBtn.contains(e.target)) {
                    hamburgerDropdown.classList.add('hidden');
                }
            });
        }
    });
</script>

<div class="min-h-screen bg-zinc-50 py-12 pt-16 md:pt-0">
    <div class="mx-auto max-w-3xl px-6">
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-black">Select Payment Method</h1>
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
                <a href="{{ route('customer.orders.show', $order) }}" 
                   class="flex-1 rounded-xl border border-zinc-300 bg-white py-3 text-center text-sm font-medium text-black transition hover:bg-zinc-50">
                    Back
                </a>
                <button type="submit" 
                        class="flex-1 rounded-xl bg-black py-3 text-center text-sm font-medium text-white transition hover:bg-black/90">
                    Continue
                </button>
            </div>
        </form>
    </div>
</div>


@endsection
