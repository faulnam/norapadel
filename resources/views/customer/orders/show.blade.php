@extends('layouts.app')

@section('title', 'Detail Pesanan')

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
        <!-- Breadcrumb -->
        <div class="mb-6 text-sm text-zinc-500">
            <a href="{{ route('customer.orders.index') }}" class="hover:text-black">Pesanan</a>
            <span class="mx-2">/</span>
            <span class="text-black">{{ $order->order_number }}</span>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Status Card -->
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-black">{{ $order->order_number }}</h2>
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
                    <p class="text-sm text-zinc-500">{{ $order->created_at->format('d F Y, H:i') }}</p>
                </div>

                <!-- Items -->
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-base font-semibold text-black">Item Pesanan</h3>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-4">
                            <img src="{{ $item->product && $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/60' }}" 
                                 class="h-16 w-16 rounded-lg object-cover" alt="{{ $item->product_name }}">
                            <div class="flex-1">
                                <p class="font-medium text-black">{{ $item->product_name }}</p>
                                <p class="text-sm text-zinc-500">{{ $item->formatted_price }} × {{ $item->quantity }}</p>
                            </div>
                            <p class="font-semibold text-black">{{ $item->formatted_subtotal }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-base font-semibold text-black">Alamat Pengiriman</h3>
                    <div class="space-y-2 text-sm">
                        <p class="font-medium text-black">{{ $order->shipping_name }}</p>
                        <p class="text-zinc-600">{{ $order->shipping_phone }}</p>
                        <p class="text-zinc-600">{{ $order->shipping_address }}</p>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Payment Summary -->
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-base font-semibold text-black">Ringkasan Pembayaran</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-zinc-600">Subtotal</span>
                            <span class="text-black">{{ $order->formatted_subtotal }}</span>
                        </div>
                        @if($order->product_discount > 0)
                        <div class="flex justify-between text-emerald-600">
                            <span>Diskon Produk</span>
                            <span>-{{ $order->formatted_product_discount }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-zinc-600">Ongkir</span>
                            <span class="text-black">{{ $order->formatted_shipping_cost }}</span>
                        </div>
                        @if($order->shipping_discount > 0)
                        <div class="flex justify-between text-emerald-600">
                            <span>Diskon Ongkir</span>
                            <span>-{{ $order->formatted_shipping_discount }}</span>
                        </div>
                        @endif
                        <div class="border-t border-zinc-200 pt-2 mt-2 flex justify-between font-semibold text-base">
                            <span class="text-black">Total</span>
                            <span class="text-black">{{ $order->formatted_total }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                @if($order->canUploadPaymentProof())
                <a href="{{ route('customer.payment.select-gateway', $order) }}" 
                   class="block w-full rounded-xl bg-black py-3 text-center text-sm font-medium text-white transition hover:bg-black/90">
                    Bayar Sekarang
                </a>
                @endif

                <a href="{{ route('customer.orders.index') }}" 
                   class="block w-full rounded-xl border border-zinc-300 bg-white py-3 text-center text-sm font-medium text-black transition hover:bg-zinc-50">
                    Kembali
                </a>
            </div>
        </div>
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
