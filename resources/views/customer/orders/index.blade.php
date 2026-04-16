@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<style>
    body { padding-top: 0 !important; padding-bottom: 0 !important; }
    #mainNavbar, .mobile-bottom-nav, .footer { display: none !important; }
</style>
@endpush

@section('content')
<!-- Navbar -->
<header class="sticky top-0 z-50 border-b border-black/6 bg-white/80 backdrop-blur-xl">
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

<div class="min-h-screen bg-zinc-50 py-8">
    <div class="mx-auto max-w-7xl px-6 md:px-10 lg:px-12">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-black">Riwayat Pesanan</h1>
        </div>

        <!-- Filter -->
        <div class="mb-6 rounded-2xl bg-white p-4 shadow-sm">
            <form action="{{ route('customer.orders.index') }}" method="GET" class="flex gap-3">
                <select name="status" class="flex-1 rounded-xl border border-zinc-300 px-4 py-2 text-sm focus:border-black focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="pending_payment" {{ request('status') == 'pending_payment' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Dibayar</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <button type="submit" class="rounded-xl bg-black px-6 py-2 text-sm font-medium text-white hover:bg-black/90">
                    Filter
                </button>
            </form>
        </div>

        <!-- Orders List -->
        <div class="space-y-4">
            @forelse($orders as $order)
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-black">{{ $order->order_number }}</h3>
                        <p class="text-sm text-zinc-500">{{ $order->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    @php
                        $statusColors = [
                            'pending_payment' => 'bg-amber-100 text-amber-800',
                            'paid' => 'bg-blue-100 text-blue-800',
                            'completed' => 'bg-emerald-100 text-emerald-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ];
                        $statusColor = $statusColors[$order->status] ?? 'bg-zinc-100 text-zinc-800';
                    @endphp
                    <span class="rounded-full px-3 py-1 text-xs font-medium {{ $statusColor }}">{{ $order->status_label }}</span>
                </div>

                <div class="mb-4 space-y-2">
                    @foreach($order->items->take(2) as $item)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-zinc-700">{{ $item->product_name }} <span class="text-zinc-400">×{{ $item->quantity }}</span></span>
                        <span class="font-medium text-black">{{ $item->formatted_subtotal }}</span>
                    </div>
                    @endforeach
                    @if($order->items->count() > 2)
                    <p class="text-xs text-zinc-500">+{{ $order->items->count() - 2 }} item lainnya</p>
                    @endif
                </div>

                <div class="flex items-center justify-between border-t border-zinc-100 pt-4">
                    <div>
                        <p class="text-xs text-zinc-500">Total Pembayaran</p>
                        <p class="text-lg font-semibold text-black">{{ $order->formatted_total }}</p>
                    </div>
                    <a href="{{ route('customer.orders.show', $order) }}" 
                       class="rounded-xl border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-black hover:bg-zinc-50">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="py-16 text-center">
                <div class="mb-4 flex h-20 w-20 mx-auto items-center justify-center rounded-full bg-zinc-100">
                    <i class="fas fa-shopping-bag text-3xl text-zinc-400"></i>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-black">Belum Ada Pesanan</h3>
                <p class="mb-6 text-sm text-zinc-600">Ayo mulai berbelanja perlengkapan padel!</p>
                <a href="{{ route('produk.index') }}" 
                   class="inline-block rounded-xl bg-black px-6 py-3 text-sm font-medium text-white hover:bg-black/90">
                    Mulai Belanja
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Footer -->
<footer class="border-t border-black/10 bg-white py-10 text-sm text-zinc-500">
    <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
        <div class="text-center">
            <p>© {{ now()->year }} NoraPadel. All rights reserved.</p>
        </div>
    </div>
</footer>
@endsection
