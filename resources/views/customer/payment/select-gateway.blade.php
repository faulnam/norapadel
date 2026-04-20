@extends('layouts.app')

@section('title', 'Pilih Metode Pembayaran')

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
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-semibold text-black">Pilih Metode Pembayaran</h1>
            <p class="mt-2 text-sm text-zinc-500">Order: {{ $order->order_number }} • Total: {{ $order->formatted_total }}</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <!-- Paylabs -->
            <a href="{{ route('customer.payment.paylabs.show', $order) }}" 
               class="group relative overflow-hidden rounded-2xl border-2 border-zinc-200 bg-white p-6 transition hover:border-black hover:shadow-lg">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-black/5">
                    <i class="fas fa-credit-card text-2xl text-black"></i>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-black">Paylabs</h3>
                <p class="text-sm text-zinc-600">Virtual Account, QRIS, E-Wallet</p>
                <span class="mt-3 inline-block rounded-full bg-black px-3 py-1 text-xs font-medium text-white">Recommended</span>
            </a>

            <!-- COD -->
            <button type="button" onclick="showCODModal()" 
               class="group relative overflow-hidden rounded-2xl border-2 border-zinc-200 bg-white p-6 transition hover:border-black hover:shadow-lg text-left w-full">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-black/5">
                    <i class="fas fa-hand-holding-usd text-2xl text-black"></i>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-black">COD</h3>
                <p class="text-sm text-zinc-600">Bayar di Tempat</p>
            </button>
        </div>
    </div>
</div>

<!-- COD Confirmation Modal -->
<div id="codModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" onclick="closeCODModal(event)">
    <div class="relative mx-4 w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl" onclick="event.stopPropagation()">
        <!-- Icon -->
        <div class="mb-6 flex justify-center">
            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-amber-100">
                <i class="fas fa-hand-holding-usd text-3xl text-amber-600"></i>
            </div>
        </div>
        
        <!-- Title -->
        <h2 class="mb-4 text-center text-2xl font-bold text-black">Pembayaran COD</h2>
        
        <!-- Content -->
        <div class="mb-6 space-y-3 text-center">
            <p class="text-sm text-zinc-600">Anda memilih metode pembayaran <strong class="text-black">Cash on Delivery (COD)</strong></p>
            
            <div class="rounded-xl bg-amber-50 p-4 text-left">
                <h3 class="mb-2 flex items-center gap-2 text-sm font-semibold text-amber-900">
                    <i class="fas fa-info-circle"></i>
                    Informasi Penting:
                </h3>
                <ul class="space-y-2 text-xs text-amber-800">
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-0.5 flex-shrink-0"></i>
                        <span>Pembayaran dilakukan saat barang diterima</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-0.5 flex-shrink-0"></i>
                        <span>Siapkan uang pas sebesar <strong>{{ $order->formatted_total }}</strong></span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-0.5 flex-shrink-0"></i>
                        <span>Pesanan akan segera diproses setelah konfirmasi</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-0.5 flex-shrink-0"></i>
                        <span>Kurir akan menghubungi Anda sebelum pengiriman</span>
                    </li>
                </ul>
            </div>
            
            <div class="rounded-xl bg-zinc-100 p-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-zinc-600">Total Pembayaran:</span>
                    <span class="text-xl font-bold text-black">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>
        
        <!-- Buttons -->
        <div class="flex gap-3">
            <button type="button" onclick="closeCODModal()" 
                    class="flex-1 rounded-xl border-2 border-zinc-300 bg-white px-6 py-3 text-sm font-semibold text-black transition hover:bg-zinc-50">
                Batal
            </button>
            <form action="{{ route('customer.payment.cod', $order) }}" method="GET" class="flex-1">
                <button type="submit" 
                        class="w-full rounded-xl bg-black px-6 py-3 text-sm font-semibold text-white transition hover:bg-black/90">
                    Konfirmasi COD
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function showCODModal() {
    document.getElementById('codModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCODModal(event) {
    if (!event || event.target.id === 'codModal') {
        document.getElementById('codModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// Close modal with ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeCODModal();
    }
});
</script>

<!-- Footer -->
<footer class="border-t border-black/10 bg-white py-10 text-sm text-zinc-500">
    <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
        <div class="text-center">
            <p>© {{ now()->year }} NoraPadel. All rights reserved.</p>
        </div>
    </div>
</footer>
@endsection
