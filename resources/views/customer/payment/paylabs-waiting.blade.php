@extends('layouts.app')

@section('title', 'Menunggu Pembayaran')

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
    <div class="mx-auto max-w-2xl px-6">
        <div class="rounded-2xl bg-white p-8 shadow-sm text-center">
            <div class="mb-6 flex h-20 w-20 mx-auto items-center justify-center rounded-full bg-amber-100">
                <i class="fas fa-clock text-3xl text-amber-600"></i>
            </div>
            <h1 class="text-2xl font-semibold text-black mb-2">Menunggu Pembayaran</h1>
            <p class="text-zinc-600 mb-6">Silakan selesaikan pembayaran Anda</p>

            <div class="mb-6 rounded-xl bg-amber-50 border border-amber-200 p-4">
                <p class="text-sm text-amber-800">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Selesaikan pembayaran sebelum <strong id="expiry-time">{{ $expiryTime }}</strong>
                </p>
            </div>


            <!-- Payment Instructions -->
            <div class="text-left mb-6">
                @if(str_starts_with($paymentChannel, 'VA_'))
                    <h3 class="text-base font-semibold text-black mb-4"><i class="fas fa-university me-2"></i>Virtual Account</h3>
                    <div class="rounded-xl bg-zinc-50 p-4 mb-4">
                        <label class="text-xs text-zinc-500 mb-2 block">Nomor Virtual Account</label>
                        <div class="flex items-center gap-2">
                            <span id="va-number" class="flex-1 text-lg font-mono font-semibold text-black">{{ $paymentData['va_number_display'] ?? ($paymentData['va_number'] ?? '-') }}</span>
                            <button onclick="copyText('va-number')" class="rounded-lg bg-black px-4 py-2 text-sm text-white hover:bg-black/90">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-sm text-zinc-600 space-y-2">
                        <p class="font-medium text-black">Cara Pembayaran:</p>
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Buka aplikasi mobile banking atau ATM</li>
                            <li>Pilih menu Transfer / Bayar</li>
                            <li>Masukkan nomor Virtual Account di atas</li>
                            <li>Masukkan nominal: <strong>{{ $order->formatted_total }}</strong></li>
                            <li>Konfirmasi pembayaran</li>
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
                                    QRIS belum tersedia dari provider.<br>Silakan klik tombol cek status atau ulangi pembuatan pembayaran.
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="text-sm text-zinc-600 space-y-2">
                        <p class="font-medium text-black">Cara Pembayaran:</p>
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Buka aplikasi e-wallet atau mobile banking</li>
                            <li>Pilih menu Scan QR</li>
                            <li>Scan QR Code di atas</li>
                            <li>Konfirmasi pembayaran</li>
                        </ol>
                    </div>
                @elseif(str_starts_with($paymentChannel, 'EWALLET_'))
                    <h3 class="text-base font-semibold text-black mb-4"><i class="fas fa-wallet me-2"></i>E-Wallet</h3>
                    <a href="{{ $paymentData['deeplink_url_display'] ?? ($paymentData['deeplink_url'] ?? '#') }}" target="_blank"
                       class="block w-full rounded-xl bg-black py-4 text-center text-white font-medium hover:bg-black/90 mb-4">
                        <i class="fas fa-external-link-alt me-2"></i>Buka Aplikasi
                    </a>
                    <div class="text-sm text-zinc-600 space-y-2">
                        <p class="font-medium text-black">Cara Pembayaran:</p>
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Klik tombol "Buka Aplikasi" di atas</li>
                            <li>Aplikasi e-wallet akan terbuka otomatis</li>
                            <li>Konfirmasi pembayaran di aplikasi</li>
                        </ol>
                    </div>
                @elseif(str_starts_with($paymentChannel, 'RETAIL_'))
                    <h3 class="text-base font-semibold text-black mb-4"><i class="fas fa-store me-2"></i>Retail</h3>
                    <div class="rounded-xl bg-zinc-50 p-4 mb-4">
                        <label class="text-xs text-zinc-500 mb-2 block">Kode Pembayaran</label>
                        <div class="flex items-center gap-2">
                            <span id="payment-code" class="flex-1 text-lg font-mono font-semibold text-black">{{ $paymentData['payment_code_display'] ?? ($paymentData['payment_code'] ?? '-') }}</span>
                            <button onclick="copyText('payment-code')" class="rounded-lg bg-black px-4 py-2 text-sm text-white hover:bg-black/90">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-sm text-zinc-600 space-y-2">
                        <p class="font-medium text-black">Cara Pembayaran:</p>
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Kunjungi {{ str_replace('RETAIL_', '', $paymentChannel) }} terdekat</li>
                            <li>Berikan kode pembayaran di atas ke kasir</li>
                            <li>Bayar sejumlah: <strong>{{ $order->formatted_total }}</strong></li>
                            <li>Simpan struk pembayaran</li>
                        </ol>
                    </div>
                @endif
            </div>

            <div class="flex gap-3">
                <a href="{{ route('customer.orders.show', $order) }}" 
                   class="flex-1 rounded-xl border border-zinc-300 bg-white py-3 text-center text-sm font-medium text-black hover:bg-zinc-50">
                    Lihat Pesanan
                </a>
                <button onclick="checkPaymentStatus()" 
                        class="flex-1 rounded-xl bg-black py-3 text-center text-sm font-medium text-white hover:bg-black/90">
                    <i class="fas fa-sync me-2"></i>Cek Status
                </button>
            </div>

            @if($canSimulate ?? false)
                <form action="{{ route('customer.payment.paylabs.simulate', $order) }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit"
                            class="w-full rounded-xl bg-emerald-600 py-3 text-center text-sm font-medium text-white hover:bg-emerald-700">
                        <i class="fas fa-flask me-2"></i>Simulasi Pembayaran Berhasil
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
        alert('Berhasil disalin!');
    });
}

function checkPaymentStatus() {
    const button = event.target;
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengecek...';
    
    fetch('{{ route('customer.payment.paylabs.check-status', $order) }}')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'paid' || data.paid) {
                // Show success message
                document.querySelector('.rounded-2xl.bg-white').innerHTML = `
                    <div class="text-center py-12">
                        <div class="mb-6 flex h-20 w-20 mx-auto items-center justify-center rounded-full bg-emerald-100">
                            <i class="fas fa-check text-3xl text-emerald-600"></i>
                        </div>
                        <h1 class="text-2xl font-semibold text-black mb-2">Pembayaran Berhasil!</h1>
                        <p class="text-zinc-600 mb-6">Terima kasih, pembayaran Anda telah diterima</p>
                        <div class="animate-spin h-8 w-8 border-4 border-zinc-200 border-t-emerald-600 rounded-full mx-auto mb-3"></div>
                        <p class="text-sm text-zinc-600">Mengalihkan ke halaman pesanan...</p>
                    </div>
                `;
                
                // Redirect after 2 seconds
                setTimeout(() => {
                    window.location.href = '{{ route('customer.orders.show', $order) }}';
                }, 2000);
            } else {
                alert('Pembayaran belum diterima. Silakan coba lagi.');
                button.disabled = false;
                button.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengecek status. Silakan coba lagi.');
            button.disabled = false;
            button.innerHTML = originalText;
        });
}

// Countdown timer
const expiryTime = new Date('{{ $expiryTime }}').getTime();
const countdownInterval = setInterval(() => {
    const now = new Date().getTime();
    const distance = expiryTime - now;

    if (distance < 0) {
        clearInterval(countdownInterval);
        document.querySelector('.bg-amber-50').innerHTML = '<p class="text-sm text-red-600"><i class="fas fa-times-circle me-2"></i><strong>Pembayaran expired</strong></p>';
    }
}, 1000);
</script>
@endsection
