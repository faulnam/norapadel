@extends('layouts.app')

@section('title', 'Waiting for Payment')

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<style>
    body { padding-top: 0 !important; padding-bottom: 0 !important; }
    #mainNavbar, .mobile-bottom-nav, .footer { display: none !important; }
</style>
@endpush

@section('content')
<!-- Navbar -->
<header class="fixed left-0 top-0 z-50 w-full border-b border-black/6 bg-white/80 backdrop-blur-xl md:sticky">
    <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ asset('storage/logo.png') }}" alt="NoraPadel" class="h-7 w-7 object-contain" loading="lazy">
            <span class="text-xl font-semibold tracking-tight text-black">NoraPadel</span>
        </a>
         <nav class="hidden items-center gap-8 md:flex" id="navLinks">
                    <a href="{{ route('home') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">Home</a>
                    <a href="{{ route('new-arrivals') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">New Arrivals</a>
                    <a href="{{ route('racket') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">Racket</a>
                    <a href="{{ route('shoes') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">Shoes</a>
                    <a href="{{ route('apparel') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">Accessories</a>
                    <a href="{{ route('contact') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">Contact</a>
                </nav>
        <div class="flex items-center gap-3 text-black/80">
            <a href="{{ route('customer.orders.index') }}" class="transition duration-300 hover:text-black" title="Order History">
                <i class="fas fa-history text-sm"></i>
            </a>
            <a href="{{ route('customer.profile.index') }}" class="transition duration-300 hover:text-black" title="Profile">
                <i class="fas fa-user text-sm"></i>
            </a>
            <a href="{{ route('customer.cart.index') }}" class="relative transition duration-300 hover:text-black" title="Cart">
                <i class="fas fa-shopping-bag text-sm"></i>
            </a>
        </div>
    </div>
</header>

<div class="min-h-screen bg-zinc-50 py-12 pt-16 md:pt-0">
    <div class="mx-auto max-w-2xl px-6">
        <div class="rounded-2xl bg-white p-8 shadow-sm text-center">
            <div class="mb-6 flex h-20 w-20 mx-auto items-center justify-center rounded-full bg-amber-100">
                <i class="fas fa-clock text-3xl text-amber-600"></i>
            </div>
            <h1 class="text-2xl font-semibold text-black mb-2">Waiting for Payment</h1>
            <p class="text-zinc-600 mb-6">Please complete your payment</p>

            <div class="mb-6 rounded-xl bg-amber-50 border border-amber-200 p-4">
                <p class="text-sm text-amber-800">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Complete payment before <strong id="expiry-time">{{ $expiryTime }}</strong>
                </p>
            </div>

            <div class="mb-6 rounded-xl bg-blue-50 border border-blue-200 p-3">
                <p class="text-xs text-blue-800 flex items-center justify-center gap-2">
                    <i class="fas fa-info-circle"></i>
                    <span>Payment status will be automatically checked every 10 seconds</span>
                    <span id="auto-check-indicator" class="inline-block w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                </p>
            </div>


            <!-- Payment Instructions -->
            <div class="text-left mb-6">
                @if(str_starts_with($paymentChannel, 'VA_'))
                    <h3 class="text-base font-semibold text-black mb-4"><i class="fas fa-university me-2"></i>Virtual Account</h3>
                    <div class="rounded-xl bg-zinc-50 p-4 mb-4">
                        <label class="text-xs text-zinc-500 mb-2 block">Virtual Account Number</label>
                        <div class="flex items-center gap-2">
                            <span id="va-number" class="flex-1 text-lg font-mono font-semibold text-black">{{ $paymentData['va_number_display'] ?? ($paymentData['va_number'] ?? '-') }}</span>
                            <button onclick="copyText('va-number')" class="rounded-lg bg-black px-4 py-2 text-sm text-white hover:bg-black/90">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-sm text-zinc-600 space-y-2">
                        <p class="font-medium text-black">Payment Instructions:</p>
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Open mobile banking app or ATM</li>
                            <li>Select Transfer / Pay menu</li>
                            <li>Enter the Virtual Account number above</li>
                            <li>Enter amount: <strong>{{ $order->formatted_total }}</strong></li>
                            <li>Confirm payment</li>
                        </ol>
                    </div>
                @elseif($paymentChannel === 'QRIS')
                    <h3 class="text-base font-semibold text-black mb-4"><i class="fas fa-qrcode me-2"></i>QRIS</h3>
                    <div class="flex justify-center mb-4">
                        <div class="rounded-xl border-2 border-zinc-200 p-4 bg-white">
                            @php
                                $qrImage = $paymentData['qr_url_display'] ?? ($paymentData['qr_url'] ?? '');
                            @endphp

                            @if(!empty($qrImage))
                                <img src="{{ $qrImage }}" alt="QR Code" class="w-64 h-64">
                            @else
                                <div class="w-64 h-64 flex items-center justify-center text-sm text-zinc-500 text-center px-4">
                                    QRIS not yet available from provider.<br>Please click the check status button or recreate payment.
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="text-sm text-zinc-600 space-y-2">
                        <p class="font-medium text-black">Payment Instructions:</p>
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Open e-wallet app or mobile banking</li>
                            <li>Select Scan QR menu</li>
                            <li>Scan the QR Code above</li>
                            <li>Confirm payment</li>
                        </ol>
                    </div>
                @elseif(str_starts_with($paymentChannel, 'EWALLET_'))
                    <h3 class="text-base font-semibold text-black mb-4"><i class="fas fa-wallet me-2"></i>E-Wallet</h3>
                    <a href="{{ $paymentData['deeplink_url_display'] ?? ($paymentData['deeplink_url'] ?? '#') }}" target="_blank"
                       class="block w-full rounded-xl bg-black py-4 text-center text-white font-medium hover:bg-black/90 mb-4">
                        <i class="fas fa-external-link-alt me-2"></i>Open App
                    </a>
                    <div class="text-sm text-zinc-600 space-y-2">
                        <p class="font-medium text-black">Payment Instructions:</p>
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Click the "Open App" button above</li>
                            <li>E-wallet app will open automatically</li>
                            <li>Confirm payment in the app</li>
                        </ol>
                    </div>
                @elseif(str_starts_with($paymentChannel, 'RETAIL_'))
                    <h3 class="text-base font-semibold text-black mb-4"><i class="fas fa-store me-2"></i>Retail</h3>
                    <div class="rounded-xl bg-zinc-50 p-4 mb-4">
                        <label class="text-xs text-zinc-500 mb-2 block">Payment Code</label>
                        <div class="flex items-center gap-2">
                            <span id="payment-code" class="flex-1 text-lg font-mono font-semibold text-black">{{ $paymentData['payment_code_display'] ?? ($paymentData['payment_code'] ?? '-') }}</span>
                            <button onclick="copyText('payment-code')" class="rounded-lg bg-black px-4 py-2 text-sm text-white hover:bg-black/90">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-sm text-zinc-600 space-y-2">
                        <p class="font-medium text-black">Payment Instructions:</p>
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Visit the nearest {{ str_replace('RETAIL_', '', $paymentChannel) }}</li>
                            <li>Provide the payment code above to the cashier</li>
                            <li>Pay amount: <strong>{{ $order->formatted_total }}</strong></li>
                            <li>Save the payment receipt</li>
                        </ol>
                    </div>
                @endif
            </div>

            <div class="flex gap-3">
                <a href="{{ route('customer.orders.show', $order) }}" 
                   class="flex-1 rounded-xl border border-zinc-300 bg-white py-3 text-center text-sm font-medium text-black hover:bg-zinc-50">
                    View Order
                </a>
                <button onclick="checkPaymentStatus()" 
                        class="flex-1 rounded-xl bg-black py-3 text-center text-sm font-medium text-white hover:bg-black/90">
                    <i class="fas fa-sync me-2"></i>Check Status
                </button>
            </div>

            @if($canSimulate ?? false)
                <form action="{{ route('customer.payment.paylabs.simulate', $order) }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit"
                            class="w-full rounded-xl bg-emerald-600 py-3 text-center text-sm font-medium text-white hover:bg-emerald-700">
                        <i class="fas fa-flask me-2"></i>Simulate Successful Payment
                    </button>
                </form>
            @endif

        </div>
    </div>
</div>



<script>
function copyText(elementId) {
    const text = document.getElementById(elementId).textContent;
    navigator.clipboard.writeText(text).then(() => {
        alert('Successfully copied!');
    });
}

let isChecking = false;
let checkInterval = null;

function checkPaymentStatus(isAutoCheck = false) {
    if (isChecking) return;
    
    isChecking = true;
    const button = document.querySelector('button[onclick*="checkPaymentStatus"]');
    const originalText = button ? button.innerHTML : '';
    
    if (button && !isAutoCheck) {
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Checking...';
    }
    
    fetch('{{ route('customer.payment.paylabs.check-status', $order) }}')
        .then(response => response.json())
        .then(data => {
            console.log('Payment status check:', data);
            
            if (data.paid || data.status === 'paid' || data.status === 'success' || data.status === '02') {
                // Stop auto-check
                if (checkInterval) {
                    clearInterval(checkInterval);
                }
                
                // Show success message
                document.querySelector('.rounded-2xl.bg-white').innerHTML = `
                    <div class="text-center py-12">
                        <div class="mb-6 flex h-20 w-20 mx-auto items-center justify-center rounded-full bg-emerald-100">
                            <i class="fas fa-check text-3xl text-emerald-600"></i>
                        </div>
                        <h1 class="text-2xl font-semibold text-black mb-2">Payment Successful!</h1>
                        <p class="text-zinc-600 mb-6">Thank you, your payment has been received</p>
                        <div class="animate-spin h-8 w-8 border-4 border-zinc-200 border-t-emerald-600 rounded-full mx-auto mb-3"></div>
                        <p class="text-sm text-zinc-600">Redirecting to order page...</p>
                    </div>
                `;
                
                // Redirect after 2 seconds
                setTimeout(() => {
                    window.location.href = '{{ route('customer.orders.show', $order) }}';
                }, 2000);
            } else {
                if (!isAutoCheck) {
                    alert('Payment not yet received. Please try again or wait a moment.');
                }
                
                if (button) {
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
                isChecking = false;
            }
        })
        .catch(error => {
            console.error('Error checking payment status:', error);
            
            if (!isAutoCheck) {
                alert('Failed to check status. Please try again.');
            }
            
            if (button) {
                button.disabled = false;
                button.innerHTML = originalText;
            }
            isChecking = false;
        });
}

// Auto-check payment status every 10 seconds
checkInterval = setInterval(() => {
    checkPaymentStatus(true);
}, 10000);

// Check immediately on page load
setTimeout(() => {
    checkPaymentStatus(true);
}, 2000);

// Countdown timer
const expiryTime = new Date('{{ $expiryTime }}').getTime();
const countdownInterval = setInterval(() => {
    const now = new Date().getTime();
    const distance = expiryTime - now;

    if (distance < 0) {
        clearInterval(countdownInterval);
        if (checkInterval) {
            clearInterval(checkInterval);
        }
        document.querySelector('.bg-amber-50').innerHTML = '<p class="text-sm text-red-600"><i class="fas fa-times-circle me-2"></i><strong>Payment expired</strong></p>';
    }
}, 1000);

// Check when page becomes visible again (user switches back to tab)
document.addEventListener('visibilitychange', () => {
    if (!document.hidden) {
        checkPaymentStatus(true);
    }
});
</script>
@endsection
