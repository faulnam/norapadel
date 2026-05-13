@extends('layouts.app')

@section('title', 'NoraPadel Racket — Precision. Power. Performance.')

@section('content')
<div class="bg-white text-black antialiased">
    <style>
        #mainNavbar, .mobile-bottom-nav {
            display: none !important;
        }
    </style>
    <header class="sticky top-0 z-50 w-full border-b border-zinc-200 bg-white" id="mainHeader">
        <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('storage/logo.png') }}" alt="NoraPadel" class="h-7 w-7 object-contain" loading="lazy">
                <span class="text-xl font-semibold tracking-tight text-black" id="logoText">NoraPadel</span>
            </a>

            <nav class="hidden items-center gap-8 md:flex" id="navLinks">
                <a href="{{ route('home') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Home</a>

                <!-- New Arrivals Mega Dropdown -->
                <div class="relative group" data-dropdown="new-arrivals">
                    <a href="{{ route('new-arrivals') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black flex items-center gap-1">
                        New Arrivals
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-50">
                        <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl border border-zinc-100 p-0 overflow-hidden aspect-video">
                            <div class="grid grid-cols-[1fr_1fr] h-full">
                                <!-- Left: Brand & Level (Centered) -->
                                <div class="flex flex-col justify-center items-center bg-zinc-50/50 p-8 space-y-6">
                                    <div class="w-full text-center">
                                        <h4 class="text-sm font-bold text-black mb-4 tracking-wide">BRAND</h4>
                                        <div class="flex flex-wrap justify-center gap-2">
                                            <a href="{{ route('new-arrivals', ['brand' => 'Bullpadel']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Bullpadel</a>
                                            <a href="{{ route('new-arrivals', ['brand' => 'Babolat']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Babolat</a>
                                            <a href="{{ route('new-arrivals', ['brand' => 'Nox']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Nox</a>
                                            <a href="{{ route('new-arrivals', ['brand' => 'Alpha']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Alpha</a>
                                            <a href="{{ route('new-arrivals', ['brand' => 'Zephyr']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Zephyr</a>
                                            <a href="{{ route('new-arrivals', ['brand' => 'Arronax']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Arronax</a>
                                        </div>
                                    </div>
                                    <div class="w-full text-center">
                                        <h4 class="text-sm font-bold text-black mb-4 tracking-wide">LEVEL</h4>
                                        <div class="flex flex-wrap justify-center gap-2">
                                            <a href="{{ route('new-arrivals', ['level' => 'beginner']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Beginner</a>
                                            <a href="{{ route('new-arrivals', ['level' => 'intermediate']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Intermediate</a>
                                            <a href="{{ route('new-arrivals', ['level' => 'pro']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Pro</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Right: Category (Centered) -->
                                <div class="flex flex-col justify-center items-center bg-zinc-50/50 p-8">
                                    <div class="w-full text-center">
                                        <h4 class="text-sm font-bold text-black mb-4 tracking-wide">CATEGORY</h4>
                                        <div class="flex flex-wrap justify-center gap-2">
                                            <a href="{{ route('racket') }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Racket</a>
                                            <a href="{{ route('shoes') }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Shoes</a>
                                            <a href="{{ route('apparel') }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Accessories</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> flex items-center gap-1
                        t
                        <svg xmlns="htp://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    
                </div>

                <!-- Racket Mega Dropdown -->
                <div class="relative group" data-dropdown="racket">
                    <a href="{{ route('racket') }}" class="border-b border-black text-sm text-black transition duration-300" data-active="true">Racket</a>
                    <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-50">
                        <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl border border-zinc-100 p-0 overflow-hidden aspect-video">
                            <div class="grid grid-cols-[1fr_1.2fr] h-full">
                                <!-- Left: Categories (Centered) -->
                                <div class="flex flex-col justify-center items-center bg-zinc-50/50 p-8 space-y-6">
                                    <div class="w-full text-center">
                                        <h4 class="text-sm font-bold text-black mb-4 tracking-wide">BRAND</h4>
                                        <div class="flex flex-wrap justify-center gap-2">
                                            <a href="{{ route('racket', ['brand' => 'Bullpadel']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Bullpadel</a>
                                            <a href="{{ route('racket', ['brand' => 'Babolat']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Babolat</a>
                                            <a href="{{ route('racket', ['brand' => 'Nox']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Nox</a>
                                            <a href="{{ route('racket', ['brand' => 'Alpha']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Alpha</a>
                                            <a href="{{ route('racket', ['brand' => 'Zephyr']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Zephyr</a>
                                            <a href="{{ route('racket', ['brand' => 'Arronax']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Arronax</a>
                                        </div>
                                    </div>
                                    <div class="w-full text-center">
                                        <h4 class="text-sm font-bold text-black mb-4 tracking-wide">LEVEL</h4>
                                        <div class="flex flex-wrap justify-center gap-2">
                                            <a href="{{ route('racket', ['level' => 'beginner']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Beginner</a>
                                            <a href="{{ route('racket', ['level' => 'intermediate']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Intermediate</a>
                                            <a href="{{ route('racket', ['level' => 'pro']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Pro</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Right: Image Preview -->
                                <div class="relative overflow-hidden">
                                    <img src="{{ asset('storage/iconracket.jpg') }}" alt="Racket Collection" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                    <div class="absolute bottom-6 left-6 right-6">
                                        <h5 class="text-white font-bold text-2xl mb-1">Premium Rackets</h5>
                                        <p class="text-white/90 text-sm font-medium">Precision & Power</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shoes Mega Dropdown -->
                <div class="relative group" data-dropdown="shoes">
                    <a href="{{ route('shoes') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black flex items-center gap-1">
                        Shoes
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-50">
                        <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl border border-zinc-100 p-0 overflow-hidden aspect-video">
                            <div class="grid grid-cols-[1fr_1.2fr] h-full">
                                <!-- Left: Categories (Centered) -->
                                <div class="flex flex-col justify-center items-center bg-zinc-50/50 p-8 space-y-6">
                                    <div class="w-full text-center">
                                        <h4 class="text-sm font-bold text-black mb-4 tracking-wide">BRAND</h4>
                                        <div class="flex flex-wrap justify-center gap-2">
                                            <a href="{{ route('shoes', ['brand' => 'Bullpadel']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Bullpadel</a>
                                            <a href="{{ route('shoes', ['brand' => 'Babolat']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Babolat</a>
                                            <a href="{{ route('shoes', ['brand' => 'Nox']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Nox</a>
                                            <a href="{{ route('shoes', ['brand' => 'Alpha']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Alpha</a>
                                            <a href="{{ route('shoes', ['brand' => 'Zephyr']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Zephyr</a>
                                            <a href="{{ route('shoes', ['brand' => 'Arronax']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Arronax</a>
                                        </div>
                                    </div>
                                    <div class="w-full text-center">
                                        <h4 class="text-sm font-bold text-black mb-4 tracking-wide">LEVEL</h4>
                                        <div class="flex flex-wrap justify-center gap-2">
                                            <a href="{{ route('shoes', ['level' => 'beginner']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Beginner</a>
                                            <a href="{{ route('shoes', ['level' => 'intermediate']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Intermediate</a>
                                            <a href="{{ route('shoes', ['level' => 'pro']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Pro</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Right: Image Preview -->
                                <div class="relative overflow-hidden">
                                    <img src="{{ asset('storage/iconsepatu.png') }}" alt="Shoes Collection" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                    <div class="absolute bottom-6 left-6 right-6">
                                        <h5 class="text-white font-bold text-2xl mb-1">Premium Shoes</h5>
                                        <p class="text-white/90 text-sm font-medium">Move Faster, Play Smarter</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Accessories Mega Dropdown -->
                <div class="relative group" data-dropdown="accessories">
                    <a href="{{ route('apparel') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black flex items-center gap-1">
                        Accessories
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-50">
                        <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl border border-zinc-100 p-0 overflow-hidden aspect-video">
                            <div class="grid grid-cols-[1fr_1.2fr] h-full">
                                <!-- Left: Categories (Centered) -->
                                <div class="flex flex-col justify-center items-center bg-zinc-50/50 p-8 space-y-6">
                                    <div class="w-full text-center">
                                        <h4 class="text-sm font-bold text-black mb-4 tracking-wide">BRAND</h4>
                                        <div class="flex flex-wrap justify-center gap-2">
                                            <a href="{{ route('apparel', ['brand' => 'Bullpadel']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Bullpadel</a>
                                            <a href="{{ route('apparel', ['brand' => 'Babolat']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Babolat</a>
                                            <a href="{{ route('apparel', ['brand' => 'Nox']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Nox</a>
                                            <a href="{{ route('apparel', ['brand' => 'Alpha']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Alpha</a>
                                            <a href="{{ route('apparel', ['brand' => 'Zephyr']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Zephyr</a>
                                            <a href="{{ route('apparel', ['brand' => 'Arronax']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Arronax</a>
                                        </div>
                                    </div>
                                    <div class="w-full text-center">
                                        <h4 class="text-sm font-bold text-black mb-4 tracking-wide">LEVEL</h4>
                                        <div class="flex flex-wrap justify-center gap-2">
                                            <a href="{{ route('apparel', ['level' => 'beginner']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Beginner</a>
                                            <a href="{{ route('apparel', ['level' => 'intermediate']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Intermediate</a>
                                            <a href="{{ route('apparel', ['level' => 'pro']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Pro</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Right: Image Preview -->
                                <div class="relative overflow-hidden">
                                    <img src="{{ asset('storage/icontas.jpg') }}" alt="Accessories Collection" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                    <div class="absolute bottom-6 left-6 right-6">
                                        <h5 class="text-white font-bold text-2xl mb-1">Premium Accessories</h5>
                                        <p class="text-white/90 text-sm font-medium">Comfort Meets Performance</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('contact') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Contact</a>
            </nav>

            <div class="flex items-center gap-3 text-black/80" id="navIcons">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 rounded-full border border-black/15 bg-transparent px-4 py-1.5 text-xs font-medium text-black transition duration-300 hover:border-black/30" aria-label="Back to Dashboard">
                            <i class="fas fa-arrow-left text-[10px]"></i>
                            <span>Dashboard</span>
                        </a>
                    @elseif(auth()->user()->role === 'customer')
                        <a href="{{ route('customer.orders.index') }}" class="transition duration-300 hover:text-black" aria-label="Riwayat Pesanan">
                            <i class="fas fa-history text-sm"></i>
                        </a>
                        <a href="{{ route('customer.profile.index') }}" class="transition duration-300 hover:text-black" aria-label="Profile">
                            <i class="fas fa-user text-sm"></i>
                        </a>
                    @endif
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1 rounded-full border border-black/15 bg-transparent px-3 py-1.5 text-xs font-medium text-black transition duration-300 hover:border-black/30" aria-label="Masuk">
                        <i class="fas fa-sign-in-alt text-[11px]"></i>
                        <span>Masuk</span>
                    </a>
                @endguest
                
                <a href="{{ route('customer.wishlist.index') }}" class="relative transition duration-300 hover:text-black" aria-label="Wishlist" title="Wishlist">
                    <i class="fas fa-heart text-sm"></i>
                    @php
                        if (auth()->check() && auth()->user()->role === 'customer') {
                            $wishlistCount = auth()->user()->wishlistItems()->count();
                        } else {
                            $guestWishlist = session()->get('guest_wishlist', []);
                            $wishlistCount = count($guestWishlist);
                        }
                    @endphp
                    @if($wishlistCount > 0)
                        <span class="pointer-events-none absolute -right-2 -top-2 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white">{{ $wishlistCount > 9 ? '9+' : $wishlistCount }}</span>
                    @endif
                </a>
                
                @auth
                    <a href="{{ route('customer.cart.index') }}" class="relative transition duration-300 hover:text-black" aria-label="Cart">
                        <i class="fas fa-shopping-bag text-sm"></i>
                        @if(auth()->user()->role === 'customer')
                            @php $cartCount = auth()->user()->cartItems()->sum('quantity'); @endphp
                            @if($cartCount > 0)
                                <span class="absolute -right-2 -top-2 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                            @endif
                        @endif
                    </a>
                @else
                    <a href="{{ route('customer.cart.index') }}" class="relative transition duration-300 hover:text-black" aria-label="Cart">
                        <i class="fas fa-shopping-bag text-sm"></i>
                        @php 
                            $guestCart = session()->get('guest_cart', []);
                            $guestCartCount = array_sum(array_column($guestCart, 'quantity'));
                        @endphp
                        @if($guestCartCount > 0)
                            <span class="absolute -right-2 -top-2 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white">{{ $guestCartCount > 9 ? '9+' : $guestCartCount }}</span>
                        @endif
                    </a>
                @endauth
                
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-black/15 bg-transparent text-black transition duration-300 hover:border-black/30 md:hidden" data-mobile-menu-toggle aria-label="Toggle navigation" aria-expanded="false">
                    <i class="fas fa-bars text-sm"></i>
                </button>
            </div>
        </div>

        <div class="hidden border-t border-black/10 bg-white px-6 py-4 md:hidden" data-mobile-menu>
            <nav class="flex flex-col gap-3 text-sm font-medium text-black/85">
                <a href="{{ route('home') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Home</a>
                <a href="{{ route('new-arrivals') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">New Arrivals</a>
                <a href="{{ route('racket') }}" class="rounded-lg bg-black/5 px-2 py-1.5 text-black">Racket</a>
                <a href="{{ route('shoes') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Shoes</a>
                <a href="{{ route('apparel') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Accessories</a>
            </nav>
        </div>
    </header>

    <main class="bg-white">
        <br>
        <!-- Main Layout: Sidebar + Grid -->
        <div class="mx-auto max-w-7xl px-6 pb-16 md:px-10 lg:px-12">
            <div class="flex flex-col gap-8 md:flex-row">
                
                <!-- Sidebar Filters -->
                <aside class="w-full flex-shrink-0 md:w-[240px]">
                    <!-- Mobile Filter Toggle -->
                    <button type="button" class="md:hidden w-full flex items-center justify-between rounded-lg border border-zinc-200 px-4 py-3 text-sm font-medium text-black" data-mobile-filter-toggle>
                        <span>Filters</span>
                        <i class="fas fa-chevron-down text-xs transition-transform" data-filter-chevron></i>
                    </button>
                    
                    <div class="mt-4 md:mt-0 space-y-6" data-filter-panel>
                        <!-- Search -->
                        <div>
                            <h3 class="mb-3 text-sm font-semibold text-black">Search</h3>
                            <input type="text" id="searchProduct" placeholder="Cari produk..." class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm outline-none focus:border-black transition">
                        </div>

                        <!-- Brand -->
                        <div class="border-t border-zinc-100 pt-6">
                            <button type="button" class="filter-toggle flex w-full items-center justify-between text-left">
                                <h3 class="text-sm font-semibold text-black">Brand</h3>
                                <i class="fas fa-chevron-down text-xs text-zinc-400 transition-transform duration-200"></i>
                            </button>
                            <div class="filter-content mt-3 flex flex-wrap gap-2">
                                <a href="{{ request()->fullUrlWithQuery(['brand' => 'Bullpadel']) }}" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black {{ $selectedBrand === 'Bullpadel' ? 'bg-black text-white border-black' : '' }}">Bullpadel</a>
                                <a href="{{ request()->fullUrlWithQuery(['brand' => 'Babolat']) }}" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black {{ $selectedBrand === 'Babolat' ? 'bg-black text-white border-black' : '' }}">Babolat</a>
                                <a href="{{ request()->fullUrlWithQuery(['brand' => 'Nox']) }}" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black {{ $selectedBrand === 'Nox' ? 'bg-black text-white border-black' : '' }}">Nox</a>
                                <a href="{{ request()->fullUrlWithQuery(['brand' => 'Alpha']) }}" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black {{ $selectedBrand === 'Alpha' ? 'bg-black text-white border-black' : '' }}">Alpha</a>
                                <a href="{{ request()->fullUrlWithQuery(['brand' => 'Zephyr']) }}" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black {{ $selectedBrand === 'Zephyr' ? 'bg-black text-white border-black' : '' }}">Zephyr</a>
                                <a href="{{ request()->fullUrlWithQuery(['brand' => 'Arronax']) }}" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black {{ $selectedBrand === 'Arronax' ? 'bg-black text-white border-black' : '' }}">Arronax</a>
                                @if($selectedBrand)
                                    <a href="{{ request()->fullUrlWithQuery(['brand' => null]) }}" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-rose-600 transition hover:border-rose-600 hover:text-rose-600">Clear</a>
                                @endif
                            </div>
                        </div>

                        <!-- Level -->
                        <div class="border-t border-zinc-100 pt-6">
                            <button type="button" class="filter-toggle flex w-full items-center justify-between text-left">
                                <h3 class="text-sm font-semibold text-black">Level</h3>
                                <i class="fas fa-chevron-down text-xs text-zinc-400 transition-transform duration-200"></i>
                            </button>
                            <div class="filter-content mt-3 flex flex-wrap gap-2">
                                <a href="{{ request()->fullUrlWithQuery(['level' => 'beginner']) }}" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black {{ $selectedLevel === 'beginner' ? 'bg-black text-white border-black' : '' }}">Beginner</a>
                                <a href="{{ request()->fullUrlWithQuery(['level' => 'intermediate']) }}" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black {{ $selectedLevel === 'intermediate' ? 'bg-black text-white border-black' : '' }}">Intermediate</a>
                                <a href="{{ request()->fullUrlWithQuery(['level' => 'pro']) }}" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black {{ $selectedLevel === 'pro' ? 'bg-black text-white border-black' : '' }}">Pro</a>
                                @if($selectedLevel)
                                    <a href="{{ request()->fullUrlWithQuery(['level' => null]) }}" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-rose-600 transition hover:border-rose-600 hover:text-rose-600">Clear</a>
                                @endif
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="border-t border-zinc-100 pt-6">
                            <button type="button" class="filter-toggle flex w-full items-center justify-between text-left">
                                <h3 class="text-sm font-semibold text-black">Price</h3>
                                <i class="fas fa-chevron-down text-xs text-zinc-400 transition-transform duration-200"></i>
                            </button>
                            <div class="filter-content mt-3 flex flex-col gap-2">
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" name="filterPrice" class="border-zinc-300 text-black focus:ring-black" value="">
                                    <span class="text-sm text-zinc-600">All Prices</span>
                                </label>
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" name="filterPrice" class="border-zinc-300 text-black focus:ring-black" value="0-500000">
                                    <span class="text-sm text-zinc-600">&lt; Rp 500.000</span>
                                </label>
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" name="filterPrice" class="border-zinc-300 text-black focus:ring-black" value="500000-1000000">
                                    <span class="text-sm text-zinc-600">Rp 500.000 - Rp 1.000.000</span>
                                </label>
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" name="filterPrice" class="border-zinc-300 text-black focus:ring-black" value="1000000-2000000">
                                    <span class="text-sm text-zinc-600">Rp 1.000.000 - Rp 2.000.000</span>
                                </label>
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" name="filterPrice" class="border-zinc-300 text-black focus:ring-black" value="2000000-5000000">
                                    <span class="text-sm text-zinc-600">Rp 2.000.000 - Rp 5.000.000</span>
                                </label>
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" name="filterPrice" class="border-zinc-300 text-black focus:ring-black" value="5000000-999999999">
                                    <span class="text-sm text-zinc-600">&gt; Rp 5.000.000</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Product Grid Area -->
                <div class="flex-1">
                    <!-- Toolbar -->
                    <div class="mb-6 flex items-center justify-between border-b border-zinc-100 pb-4">
                       
                    </div>

                    <!-- Grid -->
                    <div id="productGrid" class="grid grid-cols-2 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @forelse($products as $product)
                            @php
                                $soldCount = \App\Models\OrderItem::where('product_id', $product->id)
                                    ->whereHas('order', function($q) {
                                        $q->whereIn('status', ['completed', 'delivered']);
                                    })->sum('quantity');
                            @endphp
                            <div class="product-item group block overflow-hidden bg-white transition duration-300 hover:-translate-y-1"
                               data-name="{{ strtolower($product->name) }}"
                               data-price="{{ $product->hasActiveDiscount() ? $product->discounted_price : $product->price }}"
                               data-brand="{{ strtolower($product->brand ?? '') }}"
                               data-level="{{ $product->level ?? '' }}"
                               data-category="{{ strtolower($product->category ?? '') }}"
                               data-stock="{{ $product->stock ?? 0 }}">
                                <a href="{{ route('produk.show', $product) }}" class="block">
                                    <div class="relative aspect-square overflow-hidden">
                                        <div class="h-full w-full overflow-hidden">
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" onerror="this.onerror=null;this.src='/images/logo.png';" loading="lazy">
                                        </div>
                                        @if($product->hasActiveDiscount())
                                            <span class="absolute left-0 top-0 bg-rose-500 px-2 py-0.5 text-[10px] font-semibold text-white pointer-events-none">-{{ $product->formatted_discount_percent }}</span>
                                        @endif
                                        @if($product->category === 'arrivals')
                                            <span class="absolute left-0 {{ $product->hasActiveDiscount() ? 'top-7' : 'top-0' }} bg-blue-500 px-2 py-0.5 text-[10px] font-semibold text-white pointer-events-none">Latest</span>
                                        @endif
                                        @if($product->package_type === 'bundle')
                                            <span class="absolute left-0 {{ $product->hasActiveDiscount() && $product->category === 'arrivals' ? 'top-14' : ($product->hasActiveDiscount() || $product->category === 'arrivals' ? 'top-7' : 'top-0') }} bg-purple-500 px-2 py-0.5 text-[10px] font-semibold text-white pointer-events-none">Bundle</span>
                                        @endif
                                        @if($soldCount >= 5 || $product->package_type === 'bestseller')
                                            <span class="absolute right-0 top-0 bg-amber-500 px-2 py-0.5 text-[10px] font-semibold text-white pointer-events-none">Popular</span>
                                        @endif
                                    </div>
                                    <div class="p-3">
                                        <h3 class="line-clamp-1 text-sm font-medium text-black">{{ $product->name }}</h3>
                                        <p class="mt-1 text-xs text-zinc-600">{{ $product->category_label }}</p>
                                        @if($product->hasActiveDiscount())
                                            <p class="mt-1 text-base font-semibold text-black">{{ $product->formatted_discounted_price }}</p>
                                            <p class="text-xs text-zinc-400 line-through">{{ $product->formatted_price }}</p>
                                        @else
                                            <p class="mt-1 text-base font-semibold text-black">{{ $product->formatted_price }}</p>
                                        @endif
                                    </div>
                                </a>
                                <div class="px-3 pb-3">
                                    <div class="flex items-center gap-3">
                                        <button onclick="addToCart('{{ $product->slug }}', event)" class="border border-zinc-300 bg-transparent px-3 py-1.5 text-[11px] font-semibold text-zinc-800 transition duration-300 hover:border-zinc-500 hover:text-zinc-950">
                                            Add to cart
                                        </button>
                                        <button onclick="addToWishlist('{{ $product->slug }}', event)" class="text-zinc-400 transition duration-300 hover:text-rose-500">
                                            <i class="fas fa-heart text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 p-12 text-center">
                                <i class="fas fa-box-open text-3xl text-zinc-400"></i>
                                <p class="mt-3 font-medium text-zinc-500">Produk racket belum tersedia.</p>
                            </div>
                        @endforelse
                    </div>

                    @if($products->hasPages())
                        <div class="mt-10">
                            {{ $products->links() }}
                        </div>
                    @endif

                    <div id="noResults" class="hidden text-center py-12">
                        <i class="fas fa-search text-4xl text-zinc-300 mb-3"></i>
                        <p class="text-zinc-500">Tidak ada produk yang ditemukan</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@push('styles')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .animate-marquee {
            animation: marquee 20s linear infinite;
        }
        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .np-fade-in {
            opacity: 0;
            transform: translateY(16px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .np-fade-in.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        .filter-chip.active {
            background-color: #000;
            color: #fff;
            border-color: #000;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Add to Cart Function
        function addToCart(productId, event) {
            event.preventDefault();
            event.stopPropagation();
            
            fetch(`/customer/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Produk berhasil ditambahkan ke keranjang!');
                    location.reload();
                } else {
                    alert(data.message || 'Gagal menambahkan produk ke keranjang');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }

        function addToWishlist(productId, event) {
            event.preventDefault();
            event.stopPropagation();
            
            fetch(`/customer/wishlist/add/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Produk berhasil ditambahkan ke wishlist!');
                    location.reload();
                } else {
                    alert(data.message || 'Produk sudah ada di wishlist');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }

        (function () {
            const mobileMenuToggle = document.querySelector('[data-mobile-menu-toggle]');
            const mobileMenu = document.querySelector('[data-mobile-menu]');
            const mobileFilterToggle = document.querySelector('[data-mobile-filter-toggle]');
            const filterPanel = document.querySelector('[data-filter-panel]');
            const filterChevron = document.querySelector('[data-filter-chevron]');

            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                    mobileMenuToggle.setAttribute('aria-expanded', String(!mobileMenu.classList.contains('hidden')));
                });
            }

            if (mobileFilterToggle && filterPanel) {
                mobileFilterToggle.addEventListener('click', () => {
                    filterPanel.classList.toggle('hidden');
                    if (filterChevron) filterChevron.classList.toggle('rotate-180');
                });
            }

            // Collapsible filter sections
            document.querySelectorAll('.filter-toggle').forEach(toggle => {
                toggle.addEventListener('click', () => {
                    const content = toggle.nextElementSibling;
                    const icon = toggle.querySelector('i');
                    if (content) {
                        content.classList.toggle('hidden');
                        if (icon) icon.classList.toggle('rotate-180');
                    }
                });
            });

            // Filter chips
            document.querySelectorAll('.filter-chip').forEach(chip => {
                chip.addEventListener('click', () => {
                    chip.classList.toggle('active');
                    filterProducts();
                });
            });

            const searchInput = document.getElementById('searchProduct');
            const filterInStock = document.getElementById('filterInStock');
            const priceRadios = document.querySelectorAll('input[name="filterPrice"]');
            const productGrid = document.getElementById('productGrid');
            const noResults = document.getElementById('noResults');
            const products = Array.from(document.querySelectorAll('.product-item'));

            function getActiveFilters(type) {
                return Array.from(document.querySelectorAll(`.filter-chip.active[data-filter="${type}"]`)).map(btn => btn.dataset.value);
            }

            function filterProducts() {
                const searchTerm = searchInput?.value.toLowerCase() || '';
                const activeCategories = getActiveFilters('category');
                const activeBrands = getActiveFilters('brand');
                const activeLevels = getActiveFilters('level');
                const inStockOnly = filterInStock?.checked || false;

                let minPrice = 0;
                let maxPrice = Infinity;
                const checkedPrice = document.querySelector('input[name="filterPrice"]:checked');
                const priceRange = checkedPrice ? checkedPrice.value : '';
                if (priceRange) {
                    const [min, max] = priceRange.split('-').map(Number);
                    minPrice = min;
                    maxPrice = max;
                }

                let visibleCount = 0;

                products.forEach(product => {
                    const name = (product.dataset.name || '').toLowerCase();
                    const price = parseFloat(product.dataset.price) || 0;
                    const brand = (product.dataset.brand || '').toLowerCase();
                    const level = (product.dataset.level || '').toLowerCase();
                    const category = (product.dataset.category || '').toLowerCase();
                    const stock = parseInt(product.dataset.stock) || 0;

                    let show = true;

                    if (searchTerm && !name.includes(searchTerm)) show = false;
                    if (activeCategories.length > 0 && !activeCategories.includes(category)) show = false;
                    if (activeBrands.length > 0 && !activeBrands.includes(brand)) show = false;
                    if (activeLevels.length > 0 && !activeLevels.includes(level)) show = false;
                    if (inStockOnly && stock <= 0) show = false;
                    if (price < minPrice || price > maxPrice) show = false;

                    if (show) {
                        product.style.display = '';
                        visibleCount++;
                    } else {
                        product.style.display = 'none';
                    }
                });

                if (visibleCount === 0) {
                    productGrid.classList.add('hidden');
                    noResults.classList.remove('hidden');
                } else {
                    productGrid.classList.remove('hidden');
                    noResults.classList.add('hidden');
                }
            }

            searchInput?.addEventListener('input', filterProducts);
            filterInStock?.addEventListener('change', filterProducts);
            priceRadios.forEach(r => r.addEventListener('change', filterProducts));

            // Mega Dropdown Hover Control
            const dropdownContainers = document.querySelectorAll('[data-dropdown]');
            let activeDropdown = null;
            let hoverTimeout = null;

            dropdownContainers.forEach(container => {
                const dropdown = container.querySelector('.absolute');

                container.addEventListener('mouseenter', () => {
                    if (hoverTimeout) {
                        clearTimeout(hoverTimeout);
                        hoverTimeout = null;
                    }

                    dropdownContainers.forEach(otherContainer => {
                        if (otherContainer !== container) {
                            const otherDropdown = otherContainer.querySelector('.absolute');
                            if (otherDropdown) {
                                otherDropdown.classList.add('invisible', 'opacity-0', 'translate-y-[-10px]');
                                otherDropdown.classList.remove('visible', 'opacity-100', 'translate-y-0');
                            }
                        }
                    });

                    if (dropdown) {
                        dropdown.classList.remove('invisible', 'opacity-0', 'translate-y-[-10px]');
                        dropdown.classList.add('visible', 'opacity-100', 'translate-y-0');
                    }
                    activeDropdown = container;
                });

                container.addEventListener('mouseleave', () => {
                    hoverTimeout = setTimeout(() => {
                        if (dropdown) {
                            dropdown.classList.add('invisible', 'opacity-0', 'translate-y-[-10px]');
                            dropdown.classList.remove('visible', 'opacity-100', 'translate-y-0');
                        }
                        activeDropdown = null;
                    }, 100);
                });

                if (dropdown) {
                    dropdown.addEventListener('mouseenter', () => {
                        if (hoverTimeout) {
                            clearTimeout(hoverTimeout);
                            hoverTimeout = null;
                        }
                    });

                    dropdown.addEventListener('mouseleave', () => {
                        hoverTimeout = setTimeout(() => {
                            dropdown.classList.add('invisible', 'opacity-0', 'translate-y-[-10px]');
                            dropdown.classList.remove('visible', 'opacity-100', 'translate-y-0');
                            activeDropdown = null;
                        }, 100);
                    });
                }
            });
        })();
    </script>
@endpush
