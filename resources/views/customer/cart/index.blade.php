@extends('layouts.app')

@section('title', 'Keranjang Belanja - NoraPadel')

@section('content')
<div class="bg-white text-black antialiased">
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
                <a href="{{ route('customer.profile.index') }}" class="transition duration-300 hover:text-black" aria-label="Profile">
                    <i class="fas fa-user text-sm"></i>
                </a>
                <a href="{{ route('customer.cart.index') }}" class="transition duration-300 hover:text-black" aria-label="Cart">
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
                <a href="{{ route('racket') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Racket</a>
                <a href="{{ route('shoes') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Shoes</a>
                <a href="{{ route('apparel') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Accessories</a>
            </nav>
        </div>
    </header>

<div class="mx-auto w-full max-w-7xl px-6 py-8 pt-16 md:px-10 md:py-12 md:pt-0 lg:px-12 lg:py-16">
    <h3 class="mb-6 text-3xl font-semibold tracking-tight text-black sm:text-4xl">
        <i class="fas fa-shopping-cart mr-3 text-black"></i>Keranjang Belanja
    </h3>
    
    @if($cartItems->count() > 0)
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="mb-4 overflow-hidden rounded-2xl border border-black/6 bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-black/6 bg-zinc-50 px-6 py-4">
                        <span class="text-sm font-medium text-black">{{ $cartItems->count() }} Item</span>
                        <form action="{{ route('customer.cart.clear') }}" method="POST" 
                              onsubmit="return confirm('Kosongkan keranjang?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-full border border-rose-600 bg-white px-4 py-1.5 text-xs font-medium text-rose-600 transition hover:bg-rose-50">
                                <i class="fas fa-trash mr-1"></i>Kosongkan
                            </button>
                        </form>
                    </div>
                    <div>
                        @foreach($cartItems as $item)
                            <div class="border-b border-black/6 p-6 last:border-0">
                                <div class="flex flex-col gap-4 sm:flex-row">
                                    <div class="relative mx-auto shrink-0 sm:mx-0">
                                        <img src="{{ $item->variant && $item->variant->image ? asset('storage/' . $item->variant->image) : ($item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/80') }}" 
                                             alt="{{ $item->product->name }}" class="h-20 w-20 rounded-xl object-cover">
                                        @if($item->product->hasActiveDiscount())
                                            <span class="absolute left-0 top-0 rounded-br-lg rounded-tl-lg bg-rose-500 px-1.5 py-0.5 text-[10px] font-semibold text-white">-{{ $item->product->formatted_discount_percent }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="flex flex-1 flex-col">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h6 class="text-base font-semibold text-black">{{ $item->product->name }}</h6>
                                                @if($item->variant)
                                                    <p class="mt-0.5 text-xs text-zinc-500">
                                                        <i class="fas fa-tag mr-1"></i>Varian: <span class="font-medium">{{ $item->variant->name }}</span>
                                                    </p>
                                                @endif
                                                @if($item->variant)
                                                    <p class="mt-1 text-sm font-medium text-emerald-600">{{ $item->variant->formatted_final_price }}</p>
                                                @elseif($item->product->hasActiveDiscount())
                                                    <p class="mt-1 text-sm font-medium text-emerald-600">{{ $item->product->formatted_discounted_price }}</p>
                                                    <p class="text-xs text-zinc-400 line-through">{{ $item->product->formatted_price }}</p>
                                                @else
                                                    <p class="mt-1 text-sm font-medium text-emerald-600">{{ $item->product->formatted_price }}</p>
                                                @endif
                                            </div>
                                            <form action="{{ route('customer.cart.remove', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 transition hover:text-rose-700">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                        
                                        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                            <form action="{{ route('customer.cart.update', $item) }}" method="POST" class="inline-flex">
                                                @csrf
                                                @method('PATCH')
                                                <div class="flex items-center gap-2">
                                                    <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="flex h-8 w-8 items-center justify-center rounded-lg border border-black/10 text-black transition hover:bg-black/5" 
                                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                                    <input type="text" class="h-8 w-12 rounded-lg border border-black/10 text-center text-sm" value="{{ $item->quantity }}" readonly>
                                                    @php
                                                        $maxStock = $item->variant ? $item->variant->stock : $item->product->stock;
                                                    @endphp
                                                    <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="flex h-8 w-8 items-center justify-center rounded-lg border border-black/10 text-black transition hover:bg-black/5"
                                                            {{ $item->quantity >= $maxStock ? 'disabled' : '' }}>+</button>
                                                </div>
                                            </form>
                                            
                                            <strong class="text-base font-semibold text-black">{{ $item->formatted_subtotal }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <a href="{{ route('home') }}#products" class="inline-flex items-center gap-2 rounded-full border border-black/10 bg-white px-6 py-2.5 text-sm font-medium text-black transition hover:bg-black hover:text-white">
                    <i class="fas fa-arrow-left"></i>Lanjut Belanja
                </a>
            </div>
            
            <div class="lg:col-span-1">
                <div class="overflow-hidden rounded-2xl border border-black/6 bg-white shadow-sm">
                    <div class="border-b border-black/6 bg-black px-6 py-4">
                        <h4 class="text-lg font-semibold text-white"><i class="fas fa-receipt mr-2"></i>Ringkasan</h4>
                    </div>
                    <div class="px-6 py-6">
                        <div class="flex justify-between border-b border-black/6 pb-3 text-sm">
                            <span class="text-zinc-600">Total Item</span>
                            <span class="font-medium text-black">{{ $cartItems->sum('quantity') }} pcs</span>
                        </div>
                        @php
                            $totalDiscount = $cartItems->sum('discount_amount');
                            $originalTotal = $cartItems->sum('original_subtotal');
                        @endphp
                        @if($totalDiscount > 0)
                            <div class="flex justify-between border-b border-black/6 py-3 text-sm">
                                <span class="text-zinc-600">Harga Normal</span>
                                <span class="text-zinc-400 line-through">Rp {{ number_format($originalTotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between border-b border-black/6 py-3 text-sm text-rose-600">
                                <span>Diskon Produk</span>
                                <span>-Rp {{ number_format($totalDiscount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between py-3 text-sm">
                            <span class="text-zinc-600">Subtotal</span>
                            <span class="font-medium text-black">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="mb-6 flex justify-between border-t border-black/6 pt-4">
                            <strong class="text-lg text-black">Total</strong>
                            <strong class="text-lg text-emerald-600">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                        </div>
                        
                        <a href="{{ route('customer.checkout') }}" class="block w-full rounded-full bg-black px-6 py-3 text-center text-sm font-medium text-white transition hover:bg-black/90">
                            <i class="fas fa-credit-card mr-2"></i>Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="py-20 text-center">
            <i class="fas fa-shopping-cart mb-6 text-6xl text-zinc-300"></i>
            <h4 class="mb-2 text-2xl font-semibold text-black">Keranjang Belanja Kosong</h4>
            <p class="mb-6 text-zinc-600">Ayo mulai berbelanja perlengkapan NoraPadel!</p>
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
