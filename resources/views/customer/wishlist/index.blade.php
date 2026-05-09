@extends('layouts.app')

@section('title', 'Wishlist - NoraPadel')

@section('content')
<div class="bg-white text-black antialiased">
    <header class="fixed left-0 top-0 z-50 w-full border-b border-black/6 bg-white/80 backdrop-blur-xl md:sticky">
        <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('storage/logo.png') }}" alt="NoraPadel" class="h-7 w-7 object-contain" loading="lazy">
                <span class="text-xl font-semibold tracking-tight text-black">NoraPadel</span>
            </a>

            <nav class="hidden items-center gap-8 md:flex">
                <a href="{{ route('home') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Home</a>
                <a href="{{ route('new-arrivals') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">New Arrivals</a>
                <a href="{{ route('racket') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Racket</a>
                <a href="{{ route('shoes') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Shoes</a>
                <a href="{{ route('apparel') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Accessories</a>
                <a href="{{ route('contact') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Contact</a>
            </nav>

            <div class="flex items-center gap-3 text-black/80">
                @auth
                    <a href="{{ route('customer.orders.index') }}" class="transition duration-300 hover:text-black" title="Riwayat Pesanan">
                        <i class="fas fa-history text-sm"></i>
                    </a>
                    <a href="{{ route('customer.profile.index') }}" class="transition duration-300 hover:text-black" aria-label="Profile">
                        <i class="fas fa-user text-sm"></i>
                    </a>
                @endauth
                
                <a href="{{ route('customer.wishlist.index') }}" class="relative transition duration-300 hover:text-black" aria-label="Wishlist" title="Wishlist">
                    <i class="fas fa-heart text-sm"></i>
                </a>
                
                <a href="{{ route('customer.cart.index') }}" class="relative transition duration-300 hover:text-black" aria-label="Cart" title="Keranjang">
                    <i class="fas fa-shopping-bag text-sm"></i>
                </a>
                
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-black/15 text-black transition duration-300 hover:border-black/35 md:hidden" data-mobile-menu-toggle aria-label="Toggle navigation" aria-expanded="false">
                    <i class="fas fa-bars text-sm"></i>
                </button>
            </div>
        </div>

        <div class="hidden border-t border-black/10 bg-white/95 px-6 py-4 md:hidden" data-mobile-menu>
            <nav class="flex flex-col gap-3 text-sm font-medium text-black/85">
                <a href="{{ route('home') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Home</a>
                <a href="{{ route('new-arrivals') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">New Arrivals</a>
                <a href="{{ route('racket') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Racket</a>
                <a href="{{ route('shoes') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Shoes</a>
                <a href="{{ route('apparel') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Accessories</a>
            </nav>
        </div>
    </header>

    <div class="mx-auto w-full max-w-7xl px-6 py-8 pt-16 md:px-10 md:py-12 md:pt-0 lg:px-12 lg:py-16">
        <h3 class="mb-6 text-3xl font-semibold tracking-tight text-black sm:text-4xl">
            <i class="fas fa-heart mr-3 text-rose-500"></i>Wishlist Saya
        </h3>
        
        @if($wishlistItems->count() > 0)
            <div class="mb-4 flex items-center justify-between">
                <span class="text-sm text-zinc-600">{{ $wishlistItems->count() }} Produk</span>
                <form action="{{ route('customer.wishlist.clear') }}" method="POST" 
                      onsubmit="return confirm('Kosongkan wishlist?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-full border border-rose-600 bg-white px-4 py-1.5 text-xs font-medium text-rose-600 transition hover:bg-rose-50">
                        <i class="fas fa-trash mr-1"></i>Kosongkan Wishlist
                    </button>
                </form>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach($wishlistItems as $item)
                    <div class="group overflow-hidden rounded-2xl border border-black/6 bg-white shadow-sm transition duration-300 hover:shadow-lg">
                        <a href="{{ route('produk.show', $item->product) }}" class="block">
                            <div class="relative aspect-square overflow-hidden bg-zinc-100">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                @if($item->product->hasActiveDiscount())
                                    <span class="absolute left-3 top-3 rounded-full bg-rose-500 px-2.5 py-1 text-[11px] font-semibold text-white">-{{ $item->product->formatted_discount_percent }}</span>
                                @endif
                                @if($item->product->package_type === 'bundle')
                                    <span class="absolute left-3 {{ $item->product->hasActiveDiscount() ? 'top-12' : 'top-3' }} rounded-full bg-purple-500 px-2.5 py-1 text-[11px] font-semibold text-white">Bundle</span>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="line-clamp-2 text-sm font-semibold text-black">{{ $item->product->name }}</h3>
                                <p class="mt-1 text-xs text-zinc-600">{{ $item->product->category_label }}</p>
                                @if($item->product->hasActiveDiscount())
                                    <p class="mt-2 text-base font-bold text-black">{{ $item->product->formatted_discounted_price }}</p>
                                    <p class="text-xs text-zinc-400 line-through">{{ $item->product->formatted_price }}</p>
                                @else
                                    <p class="mt-2 text-base font-bold text-black">{{ $item->product->formatted_price }}</p>
                                @endif
                            </div>
                        </a>
                        <div class="flex gap-2 px-4 pb-4">
                            <form action="{{ route('customer.cart.add', $item->product) }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full rounded-full bg-blue-600 px-3 py-2 text-xs font-medium text-white transition duration-300 hover:bg-blue-700">
                                    <i class="fas fa-shopping-cart mr-1"></i>Tambah ke Keranjang
                                </button>
                            </form>
                            <form action="{{ route('customer.wishlist.remove', $item->product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-full bg-rose-600 px-3 py-2 text-xs font-medium text-white transition duration-300 hover:bg-rose-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-20 text-center">
                <i class="fas fa-heart mb-6 text-6xl text-zinc-300"></i>
                <h4 class="mb-2 text-2xl font-semibold text-black">Wishlist Kosong</h4>
                <p class="mb-6 text-zinc-600">Belum ada produk favorit? Ayo mulai tambahkan!</p>
                <a href="{{ route('home') }}#products" class="inline-flex items-center gap-2 rounded-full bg-black px-8 py-3 text-sm font-medium text-white transition hover:bg-black/90">
                    <i class="fas fa-shopping-bag"></i>Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<style>
    #mainNavbar,
    .mobile-bottom-nav {
        display: none !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mobileMenuToggle = document.querySelector('[data-mobile-menu-toggle]');
        const mobileMenu = document.querySelector('[data-mobile-menu]');

        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
                mobileMenuToggle.setAttribute('aria-expanded', String(!mobileMenu.classList.contains('hidden')));
            });
        }
    });
</script>
@endpush
