@extends('layouts.app')

@section('title', 'NoraPadel — Precision. Power. Performance.')

@section('content')
    <style>
        @media (max-width: 991.98px) {
            body { padding-top: 0 !important; }
        }
        html, body { overflow-x: hidden; }
    </style>
    <div class="bg-white text-black antialiased">

        <header class="fixed left-0 top-0 z-[70] w-full border-b border-transparent bg-transparent backdrop-blur-none transition-all duration-300" id="mainHeader">
            <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-3 md:px-10 lg:px-12">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('storage/logo.png') }}" alt="NoraPadel" class="h-7 w-7 object-contain" loading="lazy">
                    <span class="text-xl font-semibold tracking-tight text-white transition-colors duration-300" id="logoText">NoraPadel</span>
                </a>

                <nav class="hidden items-center gap-6 md:flex" id="navLinks">
                    <a href="{{ route('home') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">Home</a>

                    <!-- New Arrivals Mega Dropdown -->
                    <div class="relative group" data-dropdown="new-arrivals">
                        <a href="{{ route('new-arrivals') }}"
                            class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white flex items-center gap-1">
                            New Arrivals
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-[100]">
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
                        </div>
                    </div>

                    <!-- Racket Mega Dropdown -->
                    <div class="relative group" data-dropdown="racket">
                        <a href="{{ route('racket') }}"
                            class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white flex items-center gap-1">
                            Racket
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-[100]">
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
                        <a href="{{ route('shoes') }}"
                            class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white flex items-center gap-1">
                            Shoes
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-[100]">
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
                        <a href="{{ route('apparel') }}"
                            class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white flex items-center gap-1">
                            Accessories
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-[100]">
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

                    <a href="{{ route('contact') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">Contact</a>
                </nav>

                <div class="flex items-center gap-2 md:gap-3 text-white/90" id="navIcons">
                    <!-- Inline Search (all screens) -->
                    <div class="flex items-center relative" id="navSearchWrapper">
                        <i class="fas fa-search absolute left-2 md:left-3 text-xs md:text-sm text-white/60 pointer-events-none transition-colors duration-300" id="navSearchIcon"></i>
                        <input type="text" id="navSearchInput" placeholder="Cari..."
                               class="bg-white/10 border border-white/20 rounded-full pl-7 md:pl-9 pr-2 md:pr-4 py-1 md:py-1.5 text-xs md:text-sm text-white placeholder-white/60 focus:outline-none focus:bg-white/20 focus:border-white/40 w-24 md:w-40 lg:w-48 transition-all duration-300"
                               autocomplete="off">
                    </div>

                    <!-- Login (desktop only) -->
                    @guest
                        <a href="{{ route('login') }}" id="loginBtn" class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 border border-white/20 rounded-full text-xs font-semibold text-white backdrop-blur transition duration-300 hover:bg-white/20 hover:border-white/30">
                            <i class="fas fa-sign-in-alt text-sm"></i>
                            <span>Login</span>
                        </a>
                    @endauth

                    <!-- Cart (desktop only) -->
                    <a href="{{ route('customer.cart.index') }}" class="hidden md:relative transition duration-300 hover:text-white">
                        <i class="fas fa-shopping-bag text-sm"></i>
                        @auth
                            @if (auth()->user()->role === 'customer')
                                @php $cartCount = auth()->user()->cartItems()->sum('quantity'); @endphp
                                @if ($cartCount > 0)
                                    <span class="cart-badge absolute -right-1.5 -top-1.5 flex h-3 w-3 items-center justify-center rounded-full bg-rose-500 text-[9px] font-bold text-white">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                                @endif
                            @endif
                        @endauth
                        @guest
                            @php 
                                $guestCart = session()->get('guest_cart', []);
                                $guestCartCount = array_sum(array_column($guestCart, 'quantity'));
                            @endphp
                            @if($guestCartCount > 0)
                                <span class="cart-badge absolute -right-1.5 -top-1.5 flex h-3 w-3 items-center justify-center rounded-full bg-rose-500 text-[9px] font-bold text-white">{{ $guestCartCount > 9 ? '9+' : $guestCartCount }}</span>
                            @endif
                        @endguest
                    </a>

                    <!-- Wishlist (mobile only) -->
                    <a href="{{ route('customer.wishlist.index') }}" class="relative md:hidden transition duration-300 hover:text-white">
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
                            <span class="wishlist-badge absolute -right-1.5 -top-1.5 flex h-3 w-3 items-center justify-center rounded-full bg-rose-500 text-[9px] font-bold text-white">{{ $wishlistCount > 9 ? '9+' : $wishlistCount }}</span>
                        @endif
                    </a>

                    <!-- Cart (mobile only) -->
                    <a href="{{ route('customer.cart.index') }}" class="relative md:hidden transition duration-300 hover:text-white">
                        <i class="fas fa-shopping-bag text-sm"></i>
                        @auth
                            @if (auth()->user()->role === 'customer')
                                @php $cartCount = auth()->user()->cartItems()->sum('quantity'); @endphp
                                @if ($cartCount > 0)
                                    <span class="cart-badge absolute -right-1.5 -top-1.5 flex h-3 w-3 items-center justify-center rounded-full bg-rose-500 text-[9px] font-bold text-white">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                                @endif
                            @endif
                        @endauth
                        @guest
                            @php 
                                $guestCart = session()->get('guest_cart', []);
                                $guestCartCount = array_sum(array_column($guestCart, 'quantity'));
                            @endphp
                            @if($guestCartCount > 0)
                                <span class="cart-badge absolute -right-1.5 -top-1.5 flex h-3 w-3 items-center justify-center rounded-full bg-rose-500 text-[9px] font-bold text-white">{{ $guestCartCount > 9 ? '9+' : $guestCartCount }}</span>
                            @endif
                        @endguest
                    </a>

                    <!-- Login (mobile only) -->
                    @guest
                        <a href="{{ route('login') }}" class="md:hidden transition duration-300 hover:text-white">
                            <i class="fas fa-sign-in-alt text-sm"></i>
                        </a>
                    @endauth

                    <!-- Mobile Search Icon (hidden since inline search is now visible) -->
                    <button type="button" id="searchToggleBtn" class="hidden transition duration-300 hover:text-white" aria-label="Search" title="Cari Produk">
                        <i class="fas fa-search text-sm"></i>
                    </button>

                    <!-- Hamburger Menu with combined elements -->
                    <div class="relative" id="hamburgerMenuWrapper">
                        <button type="button" id="hamburgerMenuBtn" class="inline-flex h-9 w-9 items-center justify-center rounded border border-white/30 bg-white/10 text-white backdrop-blur transition duration-300 hover:bg-white/20 relative">
                            <i class="fas fa-bars text-sm"></i>
                        </button>
                        <div id="hamburgerMenuDropdown" class="absolute right-0 mt-2 w-48 z-[100] hidden">
                            <div class="bg-white rounded-lg shadow-lg border border-zinc-100 overflow-hidden">
                                <!-- Navigation (mobile only) -->
                                <div class="md:hidden">
                                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                        <i class="fas fa-home text-zinc-500 text-sm"></i>
                                        <span class="text-sm text-zinc-700">Home</span>
                                    </a>
                                    <a href="{{ route('new-arrivals') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                        <i class="fas fa-star text-zinc-500 text-sm"></i>
                                        <span class="text-sm text-zinc-700">New Arrivals</span>
                                    </a>
                                    <a href="{{ route('racket') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                        <i class="fas fa-table-tennis text-zinc-500 text-sm"></i>
                                        <span class="text-sm text-zinc-700">Racket</span>
                                    </a>
                                    <a href="{{ route('shoes') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                        <i class="fas fa-shoe-prints text-zinc-500 text-sm"></i>
                                        <span class="text-sm text-zinc-700">Shoes</span>
                                    </a>
                                    <a href="{{ route('apparel') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                        <i class="fas fa-tshirt text-zinc-500 text-sm"></i>
                                        <span class="text-sm text-zinc-700">Accessories</span>
                                    </a>
                                </div>

                                <!-- Language Switcher -->
                                <div class="border-b border-zinc-100">
                                    <div class="px-3 py-2 bg-zinc-50">
                                        <div class="flex gap-2">
                                            <a href="{{ request()->fullUrlWithQuery(['locale' => 'en']) }}" class="flex-1 px-2 py-1.5 text-xs text-zinc-700 hover:bg-white rounded transition {{ session('locale', 'en') === 'en' ? 'bg-white font-semibold' : 'bg-white/50' }}">
                                                EN
                                            </a>
                                            <a href="{{ request()->fullUrlWithQuery(['locale' => 'id']) }}" class="flex-1 px-2 py-1.5 text-xs text-zinc-700 hover:bg-white rounded transition {{ session('locale', 'en') === 'id' ? 'bg-white font-semibold' : 'bg-white/50' }}">
                                                ID
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Auth Section for logged-in users -->
                                @auth
                                    @if (auth()->user()->role === 'admin')
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-t border-zinc-100">
                                            <i class="fas fa-arrow-left text-zinc-500 text-sm"></i>
                                            <span class="text-sm text-zinc-700">Dashboard</span>
                                        </a>
                                    @elseif(auth()->user()->role === 'customer')
                                        <a href="{{ route('customer.orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-t border-zinc-100">
                                            <i class="fas fa-history text-zinc-500 text-sm"></i>
                                            <span class="text-sm text-zinc-700">Orders</span>
                                        </a>
                                        <a href="{{ route('customer.profile.index') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-t border-zinc-100">
                                            <i class="fas fa-user text-zinc-500 text-sm"></i>
                                            <span class="text-sm text-zinc-700">Profile</span>
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- ============================ -->
        <!-- Modern Search Overlay -->
        <!-- ============================ -->
        <div id="searchOverlay" class="fixed inset-0 z-[100] hidden opacity-0 transition-opacity duration-300" aria-modal="true" role="dialog">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="searchBackdrop"></div>

            <!-- Search Panel -->
            <div class="relative mx-auto mt-20 w-full max-w-3xl px-4 sm:px-6 transform transition-all duration-300 -translate-y-4" id="searchPanel">
                <div class="overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-black/5">
                    <!-- Search Input -->
                    <div class="flex items-center gap-3 border-b border-zinc-100 px-5 py-4">
                        <i class="fas fa-search text-zinc-400"></i>
                        <input
                            type="text"
                            id="searchInput"
                            placeholder="Cari produk, brand, atau kategori..."
                            class="flex-1 bg-transparent text-base text-zinc-900 placeholder-zinc-400 focus:outline-none"
                            autocomplete="off"
                            spellcheck="false"
                        >
                        <div id="searchLoading" class="hidden">
                            <svg class="h-5 w-5 animate-spin text-zinc-400" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                        </div>
                        <button type="button" id="searchCloseBtn" class="rounded-md p-1 text-zinc-400 transition hover:bg-zinc-100 hover:text-zinc-700" aria-label="Tutup">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                        <span class="hidden text-[10px] font-medium uppercase tracking-wider text-zinc-400 sm:inline-block">ESC</span>
                    </div>

                    <!-- Results Area -->
                    <div id="searchResultsArea" class="max-h-[60vh] overflow-y-auto">
                        <!-- Initial State -->
                        <div id="searchInitial" class="px-6 py-12 text-center">
                            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-zinc-100">
                                <i class="fas fa-search text-zinc-400"></i>
                            </div>
                            <p class="text-sm text-zinc-500">Mulai mengetik untuk mencari produk</p>
                            <p class="mt-1 text-xs text-zinc-400">Cari berdasarkan nama, brand, atau kategori</p>
                        </div>

                        <!-- Empty State -->
                        <div id="searchEmpty" class="hidden px-6 py-12 text-center">
                            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-zinc-100">
                                <i class="fas fa-box-open text-zinc-400"></i>
                            </div>
                            <p class="text-sm font-medium text-zinc-700">No products found</p>
                            <p class="mt-1 text-xs text-zinc-400">Coba kata kunci lain</p>
                        </div>

                        <!-- Results List -->
                        <div id="searchResults" class="hidden divide-y divide-zinc-100"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero Banner - Full behind navbar -->
        <section class="relative w-full h-[300px] overflow-hidden bg-zinc-900">
            <img src="{{ asset('storage/fiks.jpeg') }}"
                alt="Padel Tennis"
                class="absolute inset-0 h-full w-full object-cover"
                loading="eager">
            <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-black/50 to-black/80"></div>
            <div class="relative mx-auto flex h-[300px] max-w-7xl items-center justify-center px-6 md:px-10 lg:px-12 pt-16">
                <div class="max-w-2xl text-center text-white">
                    <h1 class="text-lg font-semibold tracking-tight sm:text-2xl md:text-3xl lg:text-4xl drop-shadow-lg">NoraPadel</h1>
                    <p class="mt-2 md:mt-4 text-[11px] md:text-sm text-zinc-100 leading-relaxed drop-shadow-md">Experience the ultimate in padel equipment. Premium quality rackets, shoes, and accessories for players who demand excellence.</p>
                    <div class="mt-3 md:mt-6 flex flex-wrap justify-center gap-6">
                        <a href="{{ route('shop') }}" class="inline-flex items-center gap-1 rounded-full border border-white/30 bg-white/10 px-4 py-1.5 md:px-6 md:py-2.5 text-[10px] md:text-xs font-semibold text-white backdrop-blur transition duration-300 hover:bg-white/20 hover:scale-[1.02]">Shop Now</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Marquee Bar -->
        <div class="bg-white text-white py-2 overflow-hidden transition-all duration-300" id="marqueeBar">
            <div class="marquee-container">
                <div class="marquee-content">
                    <!-- Set 1 -->
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/arronax logo.webp') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• ARRONAX •</span>
                    </span>
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/Babolat_logo.svg.png') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• BABOLAT •</span>
                    </span>
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/logobullpadel2 (1).png') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• BULLPADEL •</span>
                    </span>
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/logo_nox_1200x1200.png') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• NOX •</span>
                    </span>
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/alpha padel.png') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• ALPHA •</span>
                    </span>
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/head.jpeg') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• ZEPHYR •</span>
                    </span>

                    <!-- Set 2 -->
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/arronax logo.webp') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• ARRONAX •</span>
                    </span>
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/Babolat_logo.svg.png') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• BABOLAT •</span>
                    </span>
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/logobullpadel2 (1).png') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• BULLPADEL •</span>
                    </span>
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/logo_nox_1200x1200.png') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• NOX •</span>
                    </span>
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/alpha padel.png') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• ALPHA •</span>
                    </span>
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/head.jpeg') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• ZEPHYR •</span>
                    </span>

                    <!-- Set 3 -->
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/arronax logo.webp') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• ARRONAX •</span>
                    </span>
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/Babolat_logo.svg.png') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• BABOLAT •</span>
                    </span>
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/logobullpadel2 (1).png') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• BULLPADEL •</span>
                    </span>
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/logo_nox_1200x1200.png') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• NOX •</span>
                    </span>
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/alpha padel.png') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• ALPHA •</span>
                    </span>
                    <span class="marquee-item inline-flex items-center gap-10">
                        <img src="{{ asset('storage/head.jpeg') }}" alt="NoraPadel" class="h-14 w-14 md:h-20 md:w-20 object-contain" loading="lazy">
                        <span>• ZEPHYR •</span>
                    </span>
                </div>
            </div>
        </div>

        

        <main class="relative z-0">
            <!-- Main Layout: Sidebar + Content -->
            <div class="mx-auto max-w-7xl px-6 pb-8 md:px-10 lg:px-12 pt-6">
                <div class="flex flex-col gap-8 lg:flex-row">
                    
                    <!-- Sidebar Filters -->
                    <aside class="hidden lg:block w-[240px] flex-shrink-0">
                        <div class="space-y-6 sticky top-24">
                            <!-- Category -->
                            <div>
                                <button type="button" class="filter-toggle flex w-full items-center justify-between text-left">
                                    <h3 class="text-sm font-semibold text-black">Category</h3>
                                    <i class="fas fa-chevron-down text-xs text-zinc-400 transition-transform duration-200"></i>
                                </button>
                                <div class="filter-content mt-3 flex flex-wrap gap-2">
                                    <a href="javascript:void(0)" onclick="applyFilter('category', 'racket')" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black" data-category="racket">Racket</a>
                                    <a href="javascript:void(0)" onclick="applyFilter('category', 'shoes')" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black" data-category="shoes">Shoes</a>
                                    <a href="javascript:void(0)" onclick="applyFilter('category', 'apparel')" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black" data-category="apparel">Accessories</a>
                                    <a href="javascript:void(0)" onclick="clearFilter('category')" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-rose-600 transition hover:border-rose-600 hover:text-rose-600">Clear</a>
                                </div>
                            </div>

                            <!-- Brand -->
                            <div class="border-t border-zinc-100 pt-6">
                                <button type="button" class="filter-toggle flex w-full items-center justify-between text-left">
                                    <h3 class="text-sm font-semibold text-black">Brand</h3>
                                    <i class="fas fa-chevron-down text-xs text-zinc-400 transition-transform duration-200"></i>
                                </button>
                                <div class="filter-content mt-3 flex flex-wrap gap-2">
                                    <a href="javascript:void(0)" onclick="applyFilter('brand', 'Bullpadel')" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black" data-brand="Bullpadel">Bullpadel</a>
                                    <a href="javascript:void(0)" onclick="applyFilter('brand', 'Babolat')" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black" data-brand="Babolat">Babolat</a>
                                    <a href="javascript:void(0)" onclick="applyFilter('brand', 'Nox')" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black" data-brand="Nox">Nox</a>
                                    <a href="javascript:void(0)" onclick="applyFilter('brand', 'Alpha')" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black" data-brand="Alpha">Alpha</a>
                                    <a href="javascript:void(0)" onclick="applyFilter('brand', 'Zephyr')" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black" data-brand="Zephyr">Zephyr</a>
                                    <a href="javascript:void(0)" onclick="applyFilter('brand', 'Arronax')" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black" data-brand="Arronax">Arronax</a>
                                    <a href="javascript:void(0)" onclick="clearFilter('brand')" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-rose-600 transition hover:border-rose-600 hover:text-rose-600">Clear</a>
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
                                        <input type="radio" name="filterPrice" class="border-zinc-300 text-black focus:ring-black" value="" onchange="applyFilters()">
                                        <span class="text-sm text-zinc-600">All Prices</span>
                                    </label>
                                    <label class="flex cursor-pointer items-center gap-2">
                                        <input type="radio" name="filterPrice" class="border-zinc-300 text-black focus:ring-black" value="low" onchange="applyFilters()">
                                        <span class="text-sm text-zinc-600">Low to High</span>
                                    </label>
                                    <label class="flex cursor-pointer items-center gap-2">
                                        <input type="radio" name="filterPrice" class="border-zinc-300 text-black focus:ring-black" value="high" onchange="applyFilters()">
                                        <span class="text-sm text-zinc-600">High to Low</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Sort -->
                            <div class="border-t border-zinc-100 pt-6">
                                <button type="button" class="filter-toggle flex w-full items-center justify-between text-left">
                                    <h3 class="text-sm font-semibold text-black">Sort</h3>
                                    <i class="fas fa-chevron-down text-xs text-zinc-400 transition-transform duration-200"></i>
                                </button>
                                <div class="filter-content mt-3 flex flex-col gap-2">
                                    <label class="flex cursor-pointer items-center gap-2">
                                        <input type="radio" name="filterSort" class="border-zinc-300 text-black focus:ring-black" value="" onchange="applyFilters()">
                                        <span class="text-sm text-zinc-600">Default</span>
                                    </label>
                                    <label class="flex cursor-pointer items-center gap-2">
                                        <input type="radio" name="filterSort" class="border-zinc-300 text-black focus:ring-black" value="popular" onchange="applyFilters()">
                                        <span class="text-sm text-zinc-600">Popular</span>
                                    </label>
                                    <label class="flex cursor-pointer items-center gap-2">
                                        <input type="radio" name="filterSort" class="border-zinc-300 text-black focus:ring-black" value="latest" onchange="applyFilters()">
                                        <span class="text-sm text-zinc-600">Latest</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </aside>

                    <!-- Main Content -->
                    <div class="flex-1 min-w-0">

            <!-- Voucher Section -->
        @if($vouchers->isNotEmpty())
        <div class="relative">
            <!-- Toggle Button — floating, tidak makan ruang vertikal -->
            <div class="flex items-center gap-2 mb-1">
                <button onclick="toggleVoucherSection()" class="flex items-center gap-1.5 hover:scale-105 transition-all duration-200">
                    <div class="relative">
                        <span class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-ticket-alt text-white text-lg"></i>
                        </span>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center border border-white">{{ $vouchers->count() }}</span>
                    </div>
                    <span class="text-xs text-zinc-500">Voucher tersedia</span>
                </button>
            </div>

            <!-- Voucher Content (collapsible) -->
            <div id="voucherContent"
                 class="overflow-hidden transition-all duration-500 ease-in-out"
                 style="max-height: 0px; opacity: 0;">
                <div class="pb-2 flex flex-nowrap overflow-x-auto gap-3 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                    @foreach($vouchers as $voucher)
                    @php
                        $hasClaimed = auth()->check() && $voucher->isClaimedByUser(auth()->id());
                        $isUsed = auth()->check() && $voucher->isUsedByUser(auth()->id());
                        $isExpired = $voucher->is_expired;
                        $isQuotaFinished = $voucher->is_quota_finished;
                        $isNotStarted = $voucher->is_not_started;
                    @endphp
                    <div class="relative shrink-0 basis-[280px] bg-gradient-to-r from-white to-gray-50 rounded border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 {{ $isUsed ? 'opacity-60' : '' }}">
                        <div class="flex items-center">
                            <div class="flex-1 p-3 relative">
                                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-2 h-2 bg-white rounded-full -ml-1"></div>
                                <div class="font-bold text-gray-700 text-sm mb-0.5">
                                    @if($voucher->type === 'fixed')
                                        Diskon Rp{{ number_format($voucher->discount_value, 0, ',', '.') }}
                                    @elseif($voucher->type === 'percent')
                                        Diskon {{ $voucher->discount_value }}%
                                    @else
                                        Cashback {{ $voucher->cashback_coin }} Coin
                                    @endif
                                </div>
                                <div class="text-[10px] text-gray-500 mb-1">Min. Blj Rp{{ number_format($voucher->minimum_purchase, 0, ',', '.') }}</div>
                                <div class="w-full h-1 bg-gray-100 rounded-full overflow-hidden mb-0.5">
                                    <div class="h-full bg-gradient-to-r {{ $voucher->quota_percentage > 80 ? 'from-red-400 to-red-300' : 'from-gray-400 to-gray-300' }} rounded-full" style="width: {{ $voucher->quota_percentage }}%"></div>
                                </div>
                                <div class="text-[10px] text-gray-400">
                                    Sisa: {{ $voucher->remaining_quota }}/{{ $voucher->quota }} • Hingga: {{ $voucher->end_date->format('d.m.Y') }}
                                </div>
                            </div>
                            <div class="w-px h-10 border-l-2 border-dashed border-gray-200"></div>
                            <div class="px-2 py-3 flex items-center">
                                @if($isUsed)
                                    <button class="px-3 py-1.5 bg-rose-100 text-rose-600 font-bold text-[10px] rounded cursor-not-allowed" disabled>Digunakan</button>
                                @elseif($hasClaimed)
                                    <button class="px-3 py-1.5 bg-emerald-100 text-emerald-600 font-bold text-[10px] rounded cursor-not-allowed" disabled>Diklaim</button>
                                @elseif($isExpired || $isQuotaFinished || $isNotStarted)
                                    <button class="px-3 py-1.5 bg-gray-300 text-gray-500 font-bold text-[10px] rounded cursor-not-allowed" disabled>
                                        @if($isExpired) Expired @elseif($isQuotaFinished) Habis @else Segera @endif
                                    </button>
                                @else
                                    <button onclick="claimVoucher({{ $voucher->id }}, this)" class="claim-btn px-3 py-1.5 bg-gray-600 text-white font-bold text-[10px] rounded hover:bg-gray-700 transition-all duration-300">Klaim</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

            <!-- New Arrivals -->
            <section class="np-fade-section bg-white py-2 lg:py-3 pb-0">
                <div class="relative group">
                        <!-- Left Arrow -->
                        <button class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white/90 hover:bg-white shadow-lg rounded w-10 h-10 flex items-center justify-center transition duration-300" onclick="scrollNewArrivals('left')">
                            <i class="fas fa-chevron-left text-black text-sm"></i>
                        </button>
                        
                        <!-- Right Arrow -->
                        <button class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white/90 hover:bg-white shadow-lg rounded w-10 h-10 flex items-center justify-center transition duration-300" onclick="scrollNewArrivals('right')">
                            <i class="fas fa-chevron-right text-black text-sm"></i>
                        </button>
                        
                        <div id="newArrivalsContainer" class="flex gap-6 overflow-x-auto pb-3 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden snap-x snap-mandatory scroll-smooth">
                        @foreach($newArrivals as $product)
                            @php
                                $soldCount = \App\Models\OrderItem::where('product_id', $product->id)
                                    ->whereHas('order', function($q) {
                                        $q->whereIn('status', ['completed', 'delivered']);
                                    })->sum('quantity');
                            @endphp
                            <div class="product-card group snap-start shrink-0 basis-[40%] sm:basis-[48%] md:basis-[32%] lg:basis-[18%] overflow-hidden bg-white transition duration-300 hover:-translate-y-2" data-category="{{ strtolower($product->type) }}" data-brand="{{ strtolower($product->brand ?? '') }}">
                                <a href="{{ route('produk.show', $product) }}" class="block">
                                    <div class="relative aspect-square overflow-hidden">
                                        <div class="h-full w-full overflow-hidden">
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" onerror="this.onerror=null;this.src='/images/logo.png';" loading="lazy">
                                        </div>
                                        @if($product->hasActiveDiscount())
                                            <span class="absolute left-0 top-0 bg-rose-500 px-2 py-0.5 text-[10px] font-semibold text-white pointer-events-none">-{{ $product->formatted_discount_percent }}</span>
                                        @endif
                                        <!-- Latest Badge for New Arrivals -->
                                        <span class="absolute left-0 {{ $product->hasActiveDiscount() ? 'top-7' : 'top-0' }} bg-blue-500 px-2 py-0.5 text-[10px] font-semibold text-white pointer-events-none">Latest</span>
                                        @if($product->package_type === 'bundle')
                                            <span class="absolute left-0 {{ $product->hasActiveDiscount() ? 'top-14' : 'top-7' }} bg-purple-500 px-2 py-0.5 text-[10px] font-semibold text-white pointer-events-none">Bundle</span>
                                        @endif
                                        @if($product->isBestSeller())
                                            <span class="absolute right-0 top-0 bg-amber-500 px-2 py-0.5 text-[10px] font-semibold text-white pointer-events-none">Best Seller</span>
                                        @endif
                                    </div>
                                    <div class="p-2 md:p-4">
                                        <h3 class="line-clamp-1 text-sm font-medium text-black">{{ $product->name }}</h3>
                                        <p class="mt-1 text-xs text-zinc-600">{{ $product->category_label }}</p>
                                        <div class="mt-1 flex items-center gap-1">
                                            @php
                                                $rating = $product->average_rating;
                                            @endphp
                                            <i class="fas fa-star text-black text-[10px]"></i>
                                            <span class="text-[10px] text-zinc-600 ml-1">{{ number_format($rating, 1) }}</span>
                                            @if($product->total_reviews > 0)
                                                <span class="text-[10px] text-zinc-500">({{ $product->total_reviews }})</span>
                                            @endif
                                        </div>
                                        @if($product->hasActiveDiscount())
                                            <p class="mt-1 text-base font-semibold text-black">{{ $product->formatted_discounted_price }}</p>
                                            <p class="text-xs text-zinc-400 line-through">{{ $product->formatted_price }}</p>
                                        @else
                                            <p class="mt-1 text-base font-semibold text-black">{{ $product->formatted_price }}</p>
                                        @endif
                                    </div>
                                </a>
                                <div class="px-2 pb-2 md:px-4 md:pb-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('produk.show', $product) }}" class="border border-zinc-300 bg-transparent px-2 py-1 text-[10px] font-semibold text-zinc-800 transition duration-300 hover:border-zinc-500 hover:text-zinc-950">
                                            Detail
                                        </a>
                                        <button onclick="addToCart('{{ $product->slug }}', event)" class="border border-zinc-300 bg-transparent px-2 py-1 text-[10px] font-semibold text-zinc-800 transition duration-300 hover:border-zinc-500 hover:text-zinc-950">
                                            Add to cart
                                        </button>
                                        <button onclick="addToWishlist('{{ $product->slug }}', event)" class="text-zinc-400 transition duration-300 hover:text-rose-500">
                                            <i class="fas fa-heart text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                </div>
            </section>

            <!-- Category Icons -->
            <section class="np-fade-section bg-white py-4 pt-4">
                <div class="grid grid-cols-2 gap-4 md:grid-cols-4 md:gap-6">
                        <a href="{{ route('racket') }}" class="flex flex-col items-center justify-center p-4 md:p-6 bg-white cursor-pointer transition hover:opacity-80">
                            <div class="w-36 h-36 md:w-48 md:h-48 mb-3 md:mb-4 flex items-center justify-center">
                                <img src="{{ asset('storage/iconracket.jpg') }}" alt="Racket" class="w-full h-full object-contain">
                            </div>
                            <h3 class="text-sm md:text-base font-medium text-black">Racket</h3>
                        </a>
                        <a href="{{ route('shoes') }}" class="flex flex-col items-center justify-center p-4 md:p-6 bg-white cursor-pointer transition hover:opacity-80">
                            <div class="w-36 h-36 md:w-48 md:h-48 mb-3 md:mb-4 flex items-center justify-center">
                                <img src="{{ asset('storage/iconsepatu.png') }}" alt="Shoes" class="w-full h-full object-contain">
                            </div>
                            <h3 class="text-sm md:text-base font-medium text-black">Shoes</h3>
                        </a>
                        <a href="{{ route('apparel') }}" class="flex flex-col items-center justify-center p-4 md:p-6 bg-white cursor-pointer transition hover:opacity-80">
                            <div class="w-36 h-36 md:w-48 md:h-48 mb-3 md:mb-4 flex items-center justify-center">
                                <img src="{{ asset('storage/icontas.jpg') }}" alt="Bag" class="w-full h-full object-contain">
                            </div>
                            <h3 class="text-sm md:text-base font-medium text-black">Bags</h3>
                        </a>
                        <a href="{{ route('apparel') }}" class="flex flex-col items-center justify-center p-4 md:p-6 bg-white cursor-pointer transition hover:opacity-80">
                            <div class="w-36 h-36 md:w-48 md:h-48 mb-3 md:mb-4 flex items-center justify-center">
                                <img src="{{ asset('storage/icongrip.jpg') }}" alt="Grip" class="w-full h-full object-contain">
                            </div>
                            <h3 class="text-sm md:text-base font-medium text-black">Grips</h3>
                        </a>
                </div>
            </section>

            <!-- Shop -->
            <section class="np-fade-section bg-white py-12 lg:py-14">
                <div id="productGrid" class="grid grid-cols-2 gap-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach($shopProducts->take(12) as $product)
                            @php
                                $soldCount = \App\Models\OrderItem::where('product_id', $product->id)
                                    ->whereHas('order', function($q) {
                                        $q->whereIn('status', ['completed', 'delivered']);
                                    })->sum('quantity');
                            @endphp
                       <div class="product-item product-card group block overflow-hidden bg-white transition duration-300 hover:-translate-y-1"
                                 data-name="{{ strtolower($product->name) }}"
                                 data-price="{{ $product->hasActiveDiscount() ? $product->discounted_price : $product->price }}"
                                 data-category="{{ strtolower($product->type) }}"
                                 data-brand="{{ strtolower($product->brand ?? '') }}"
                                 data-level="{{ $product->level ?? '' }}"
                                 data-discount="{{ $product->hasActiveDiscount() ? 'yes' : 'no' }}"
                                 data-bundle="{{ $product->package_type === 'bundle' ? 'yes' : 'no' }}"
                                 data-sold="{{ $soldCount }}">
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
                                        @if($product->isBestSeller())
                                            <span class="absolute right-0 top-0 bg-amber-500 px-2 py-0.5 text-[10px] font-semibold text-white pointer-events-none">Popular</span>
                                        @endif
                                    </div>
                                    <div class="p-3">
                                        <h3 class="line-clamp-1 text-sm font-medium text-black">{{ $product->name }}</h3>
                                        <p class="mt-1 text-xs text-zinc-600">{{ $product->category_label }}</p>
                                        <div class="mt-1 flex items-center gap-1">
                                            @php
                                                $rating = $product->average_rating;
                                            @endphp
                                            <i class="fas fa-star text-black text-[10px]"></i>
                                            <span class="text-[10px] text-zinc-600 ml-1">{{ number_format($rating, 1) }}</span>
                                            @if($product->total_reviews > 0)
                                                <span class="text-[10px] text-zinc-500">({{ $product->total_reviews }})</span>
                                            @endif
                                        </div>
                                        @if($product->hasActiveDiscount())
                                            <p class="mt-1 text-base font-semibold text-black">{{ $product->formatted_discounted_price }}</p>
                                            <p class="text-xs text-zinc-400 line-through">{{ $product->formatted_price }}</p>
                                        @else
                                            <p class="mt-1 text-base font-semibold text-black">{{ $product->formatted_price }}</p>
                                        @endif
                                    </div>
                                </a>
                                <div class="px-2 pb-2 md:px-3 md:pb-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('produk.show', $product) }}" class="border border-zinc-300 bg-transparent px-2 py-1 text-[10px] font-semibold text-zinc-800 transition duration-300 hover:border-zinc-500 hover:text-zinc-950">
                                            Detail
                                        </a>
                                        <button onclick="addToCart('{{ $product->slug }}', event)" class="border border-zinc-300 bg-transparent px-2 py-1 text-[10px] font-semibold text-zinc-800 transition duration-300 hover:border-zinc-500 hover:text-zinc-950 truncate max-w-[80px] md:max-w-none">
                                            Add to cart
                                        </button>
                                        <button onclick="addToWishlist('{{ $product->slug }}', event)" class="text-zinc-400 transition duration-300 hover:text-rose-500">
                                            <i class="fas fa-heart text-xs md:text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="noResults" class="hidden text-center py-12">
                        <i class="fas fa-search text-4xl text-zinc-300 mb-3"></i>
                        <p class="text-zinc-500">Tidak ada produk yang ditemukan</p>
                    </div>
            </section>
                    </div>
                </div>
            </div>

        <!-- Testimonials Section - Full Width with Proper Margins -->
        <section id="testimonials" class="np-fade-section bg-white py-18 lg:py-22 mx-auto max-w-7xl px-4 md:px-6 lg:px-12" data-testimonial-showcase>
            @php
                $testimonialItems = $testimonials->take(3);
            @endphp

            @if ($testimonialItems->count() > 0)
                <div class="relative overflow-hidden rounded-lg bg-zinc-50/40 px-2 py-2 md:px-4 md:py-4"
                    data-testimonial-hero>
                    <div class="np-testimonial-hero-track" data-testimonial-track>
                        @foreach ($testimonialItems as $index => $testimonial)
                            <article class="np-testimonial-hero-slide">
                                <div class="relative aspect-video overflow-hidden rounded-2xl">
                                    <img src="{{ $testimonial->image_url ?? '/images/logo.png' }}"
                                        alt="Testimoni" class="h-full w-full object-cover" loading="lazy">
                                    <div
                                        class="absolute inset-0 bg-linear-to-t from-black/60 via-black/20 to-transparent">
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="absolute bottom-4 left-1/2 z-20 flex -translate-x-1/2 items-center gap-2 rounded bg-black/35 px-3 py-2 backdrop-blur"
                        data-testimonial-dots>
                        @foreach ($testimonialItems as $index => $testimonial)
                            <button type="button"
                                class="np-testimonial-dot h-2.5 w-2.5 rounded-full bg-white/45 transition duration-300"
                                data-slide-to="{{ $index }}"
                                aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-zinc-300 bg-white p-10 text-center text-zinc-500">
                    Belum ada testimoni.
                </div>
            @endif
        </section>

        </main>

        <!-- Welcome Bonus Pop-up -->
        @auth
            @if(auth()->user()->role === 'customer' && !auth()->user()->welcome_bonus_claimed && !auth()->user()->orders()->exists())
                <div id="welcomeBonusModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;">
                    <div class="relative mx-4 w-full max-w-md overflow-hidden rounded-lg bg-white shadow-2xl">
                        <button onclick="closeWelcomeBonus()" class="absolute right-4 top-4 z-10 flex h-8 w-8 items-center justify-center rounded bg-black/10 text-black transition hover:bg-black/20">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                        
                        <div class="bg-gradient-to-br from-blue-500 to-purple-600 px-8 py-12 text-center text-white">
                            <div class="mb-4">
                                <i class="fas fa-gift text-6xl"></i>
                            </div>
                            <h2 class="mb-2 text-3xl font-bold">Welcome!</h2>
                            <p class="text-lg opacity-90">Special Bonus For You</p>
                        </div>
                        
                        <div class="px-8 py-8 text-center">
                            <div class="mb-4">
                                <div class="mb-3">
                                    <div class="text-3xl font-semibold text-blue-600">🎁 First Purchase Bonus</div>
                                </div>
                                <div class="space-y-2 text-left">
                                    <div class="flex items-center gap-3 rounded-lg bg-blue-50 p-3">
                                        <i class="fas fa-coins text-2xl text-blue-600"></i>
                                        <div>
                                            <div class="font-semibold text-black">100 Free Points</div>
                                            <div class="text-xs text-zinc-600">Worth Rp 10,000 for discount</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 rounded-lg bg-purple-50 p-3">
                                        <i class="fas fa-hand-holding-heart text-2xl text-purple-600"></i>
                                        <div>
                                            <div class="font-semibold text-black">Free Grip</div>
                                            <div class="text-xs text-zinc-600">Free grip on first purchase</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="mb-6 text-xs text-zinc-500">
                                *Bonus only applies to your first purchase
                            </p>
                            
                            <form action="{{ route('customer.claim-welcome-bonus') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full rounded bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-3 text-sm font-semibold text-white transition duration-300 hover:shadow-lg">
                                    <i class="fas fa-check-circle mr-2"></i>Claim Bonus Now
                                </button>
                            </form>
                            
                            <button onclick="closeWelcomeBonus()" class="mt-3 text-sm text-zinc-500 hover:text-zinc-700">
                                Maybe Later
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </div>

    <x-search-modal />

    @guest
        <x-welcome-bonus-popup />
    @endguest
@endsection

@push('styles')
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        #mainNavbar,
        .mobile-bottom-nav {
            display: none !important;
        }

        html {
            scroll-behavior: smooth;
        }

        /* Marquee Animation */
        .marquee-container {
            display: flex;
            overflow: hidden;
            user-select: none;
            width: 100%;
        }

        .marquee-content {
            display: flex;
            animation: marquee 30s linear infinite;
            white-space: nowrap;
            will-change: transform;
        }

        .marquee-item {
            display: inline-block;
            padding: 0 2rem;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        @keyframes marquee {
            from {
                transform: translateX(0);
            }
            to {
                transform: translateX(-50%);
            }
        }

        .np-fade-section {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .np-fade-section.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .np-testimonial-hero-track {
            display: flex;
            gap: 0.75rem;
            transition: transform 700ms ease;
            will-change: transform;
        }

        .np-testimonial-hero-slide {
            position: relative;
            min-width: calc(100% - 2.5rem);
            overflow: hidden;
            border-radius: 1rem;
        }

        @media (min-width: 768px) {
            .np-testimonial-hero-slide {
                min-width: calc(100% - 7rem);
            }
        }

        .np-container-scroll-content h2,
        .np-container-scroll-content p,
        .np-container-scroll-content .mt-7 {
            transition: transform 120ms linear;
            will-change: transform;
        }

        .np-container-scroll-card {
            transform-style: preserve-3d;
            transform-origin: center center;
            transition: transform 120ms linear, box-shadow 120ms linear;
            will-change: transform;
        }

        .np-apparel-gradient-bg {
            background-image:
                linear-gradient(rgba(245, 245, 247, 0.7), rgba(245, 245, 247, 0.7)),
                url("{{ asset('storage/bg.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function toggleVoucherSection() {
    const content = document.getElementById('voucherContent');
    if (!content) return;

    const isOpen = content.style.maxHeight !== '0px' && content.style.maxHeight !== '';
    if (isOpen) {
        content.style.maxHeight = '0px';
        content.style.opacity = '0';
    } else {
        content.style.maxHeight = '400px';
        content.style.opacity = '1';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const content = document.getElementById('voucherContent');
    if (content) {
        content.style.maxHeight = '0px';
        content.style.opacity = '0';
    }
});

        // Animate badge function
        function animateBadge(badgeElement) {
            if (!badgeElement) return;
            
            // Add animation class
            badgeElement.classList.add('animate-bounce');
            
            // Remove animation after it completes
            setTimeout(() => {
                badgeElement.classList.remove('animate-bounce');
            }, 1000);
        }

        // Update cart badge count
        function updateCartBadge(newCount) {
            const cartBadges = document.querySelectorAll('.cart-badge');
            cartBadges.forEach(badge => {
                if (newCount > 0) {
                    badge.textContent = newCount > 9 ? '9+' : newCount;
                    badge.classList.remove('hidden');
                    animateBadge(badge);
                } else {
                    badge.classList.add('hidden');
                }
            });

            // Update hamburger button badge
            const hamburgerCartBadges = document.querySelectorAll('.hamburger-cart-badge');
            hamburgerCartBadges.forEach(badge => {
                if (newCount > 0) {
                    badge.textContent = newCount > 9 ? '9+' : newCount;
                    badge.classList.remove('hidden');
                    animateBadge(badge);
                } else {
                    badge.classList.add('hidden');
                }
            });
        }

        // Update wishlist badge count
        function updateWishlistBadge(newCount) {
            const wishlistBadges = document.querySelectorAll('.wishlist-badge');
            wishlistBadges.forEach(badge => {
                if (newCount > 0) {
                    badge.textContent = newCount > 9 ? '9+' : newCount;
                    badge.classList.remove('hidden');
                    animateBadge(badge);
                } else {
                    badge.classList.add('hidden');
                }
            });

            // Update hamburger button badge
            const hamburgerWishlistBadges = document.querySelectorAll('.hamburger-wishlist-badge');
            hamburgerWishlistBadges.forEach(badge => {
                if (newCount > 0) {
                    badge.textContent = newCount > 9 ? '9+' : newCount;
                    badge.classList.remove('hidden');
                    animateBadge(badge);
                } else {
                    badge.classList.add('hidden');
                }
            });
        }

        // Add to Cart Function
        function addToCart(productId, event) {
            event.preventDefault();
            event.stopPropagation();
            
            const button = event.target.closest('button');
            if (button) {
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            }
            
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
                    // Animate and update cart badge
                    const currentCount = parseInt(data.cart_count || 0);
                    updateCartBadge(currentCount);
                    
                    if (button) {
                        button.innerHTML = '✓ Added';
                        setTimeout(() => {
                            button.disabled = false;
                            button.innerHTML = 'Add to cart';
                        }, 1500);
                    }
                } else {
                    alert(data.message || 'Gagal menambahkan produk ke keranjang');
                    if (button) {
                        button.disabled = false;
                        button.innerHTML = 'Add to cart';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                if (button) {
                    button.disabled = false;
                    button.innerHTML = 'Add to cart';
                }
            });
        }

        // Add to Wishlist Function
        function addToWishlist(productId, event) {
            event.preventDefault();
            event.stopPropagation();
            
            const button = event.target.closest('button');
            const icon = button.querySelector('i');
            if (icon) {
                icon.classList.remove('fa-heart');
                icon.classList.add('fa-spinner', 'fa-spin');
            }
            
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
                    // Animate and update wishlist badge
                    const currentCount = parseInt(data.wishlist_count || 0);
                    updateWishlistBadge(currentCount);
                    
                    if (icon) {
                        icon.classList.remove('fa-spinner', 'fa-spin');
                        icon.classList.add('fa-heart');
                        icon.classList.add('text-rose-500');
                    }
                    if (button) {
                        button.classList.add('text-rose-500');
                    }
                } else {
                    alert(data.message || 'Gagal menambahkan produk ke wishlist');
                    if (icon) {
                        icon.classList.remove('fa-spinner', 'fa-spin');
                        icon.classList.add('fa-heart');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                if (icon) {
                    icon.classList.remove('fa-spinner', 'fa-spin');
                    icon.classList.add('fa-heart');
                }
            });
        }

        // Claim Voucher Function
        function claimVoucher(voucherId, btn) {
            if (!btn) return;
            
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            fetch('{{ route('customer.vouchers.claim') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    voucher_id: voucherId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    btn.innerHTML = '✓ Diklaim';
                    setTimeout(() => {
                        window.location.href = '{{ route('shop') }}';
                    }, 1000);
                } else {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        alert(data.message || 'Gagal mengklaim voucher');
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        }

        // Apply Filters Function (for price and sort)
        window.applyFilters = function() {
            const price = document.querySelector('input[name="filterPrice"]:checked')?.value || '';
            const sort = document.querySelector('input[name="filterSort"]:checked')?.value || '';

            // Build params from active category/brand filters
            const activeCategory = document.querySelector('.filter-chip[data-category].bg-black');
            const activeBrand = document.querySelector('.filter-chip[data-brand].bg-black');
            
            const params = new URLSearchParams();
            if (activeCategory) {
                params.append('category', activeCategory.dataset.category);
            }
            if (activeBrand) {
                params.append('brand', activeBrand.dataset.brand);
            }
            if (price) {
                params.append('price', price);
            }
            if (sort) {
                params.append('sort', sort);
            }

            console.log('Applying filters with params:', params.toString());

            // Show loading state
            const newArrivalsContainer = document.getElementById('newArrivalsContainer');
            const productGrid = document.getElementById('productGrid');
            
            if (newArrivalsContainer) {
                newArrivalsContainer.innerHTML = '<div class="flex items-center justify-center w-full py-8"><i class="fas fa-spinner fa-spin text-2xl text-gray-400"></i></div>';
            }
            if (productGrid) {
                productGrid.innerHTML = '<div class="flex items-center justify-center w-full py-8 col-span-full"><i class="fas fa-spinner fa-spin text-2xl text-gray-400"></i></div>';
            }

            // Fetch filtered products via AJAX
            fetch(`/api/new-arrivals/filter?${params.toString()}`)
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success && data.html) {
                        if (newArrivalsContainer) {
                            newArrivalsContainer.innerHTML = data.html;
                        }
                        if (productGrid) {
                            productGrid.innerHTML = data.html;
                        }
                    } else {
                        if (newArrivalsContainer) {
                            newArrivalsContainer.innerHTML = '<div class="flex items-center justify-center w-full py-8 text-gray-500">No products found</div>';
                        }
                        if (productGrid) {
                            productGrid.innerHTML = '<div class="flex items-center justify-center w-full py-8 text-gray-500 col-span-full">No products found</div>';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (newArrivalsContainer) {
                        newArrivalsContainer.innerHTML = '<div class="flex items-center justify-center w-full py-8 text-gray-500">Error loading products</div>';
                    }
                    if (productGrid) {
                        productGrid.innerHTML = '<div class="flex items-center justify-center w-full py-8 text-gray-500 col-span-full">Error loading products</div>';
                    }
                });
        };

        // Apply single filter (for sidebar chips)
        window.applyFilter = function(filterType, value) {
            console.log('Applying filter:', filterType, value);
            
            // Update chip styling
            const chips = document.querySelectorAll(`.filter-chip[data-${filterType}]`);
            chips.forEach(chip => {
                chip.classList.remove('bg-black', 'text-white', 'border-black');
                chip.classList.add('text-zinc-600', 'border-zinc-200');
            });
            
            const activeChip = document.querySelector(`.filter-chip[data-${filterType}="${value}"]`);
            if (activeChip) {
                activeChip.classList.add('bg-black', 'text-white', 'border-black');
                activeChip.classList.remove('text-zinc-600', 'border-zinc-200');
            }

            // Fetch filtered products via AJAX
            const params = new URLSearchParams();
            if (filterType === 'category') {
                params.append('category', value);
            } else if (filterType === 'brand') {
                params.append('brand', value);
            }

            console.log('Fetching:', `/api/new-arrivals/filter?${params.toString()}`);

            // Show loading state
            const newArrivalsContainer = document.getElementById('newArrivalsContainer');
            const productGrid = document.getElementById('productGrid');
            
            if (newArrivalsContainer) {
                newArrivalsContainer.innerHTML = '<div class="flex items-center justify-center w-full py-8"><i class="fas fa-spinner fa-spin text-2xl text-gray-400"></i></div>';
            }
            if (productGrid) {
                productGrid.innerHTML = '<div class="flex items-center justify-center w-full py-8 col-span-full"><i class="fas fa-spinner fa-spin text-2xl text-gray-400"></i></div>';
            }

            fetch(`/api/new-arrivals/filter?${params.toString()}`)
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success && data.html) {
                        // Update both containers with filtered products
                        if (newArrivalsContainer) {
                            newArrivalsContainer.innerHTML = data.html;
                        }
                        if (productGrid) {
                            productGrid.innerHTML = data.html;
                        }
                    } else {
                        if (newArrivalsContainer) {
                            newArrivalsContainer.innerHTML = '<div class="flex items-center justify-center w-full py-8 text-gray-500">No products found</div>';
                        }
                        if (productGrid) {
                            productGrid.innerHTML = '<div class="flex items-center justify-center w-full py-8 text-gray-500 col-span-full">No products found</div>';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (newArrivalsContainer) {
                        newArrivalsContainer.innerHTML = '<div class="flex items-center justify-center w-full py-8 text-gray-500">Error loading products</div>';
                    }
                    if (productGrid) {
                        productGrid.innerHTML = '<div class="flex items-center justify-center w-full py-8 text-gray-500 col-span-full">Error loading products</div>';
                    }
                });
        };

        // Clear filter
        window.clearFilter = function(filterType) {
            const chips = document.querySelectorAll(`.filter-chip[data-${filterType}]`);
            chips.forEach(chip => {
                chip.classList.remove('bg-black', 'text-white', 'border-black');
                chip.classList.add('text-zinc-600', 'border-zinc-200');
            });
            
            // Reload page to reset all filters
            window.location.reload();
        };

        // Filter toggle functionality
        document.querySelectorAll('.filter-toggle').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const content = this.nextElementSibling;
                const icon = this.querySelector('i');
                
                content.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });

        // Hamburger Menu Toggle
        (function() {
            const btn = document.getElementById('hamburgerMenuBtn');
            const dropdown = document.getElementById('hamburgerMenuDropdown');
            const wrapper = document.getElementById('hamburgerMenuWrapper');
            if (!btn || !dropdown || !wrapper) return;
            btn.addEventListener('click', function(e){ e.stopPropagation(); dropdown.classList.toggle('hidden'); });
            document.addEventListener('click', function(e){ if(!wrapper.contains(e.target)) dropdown.classList.add('hidden'); });
            return;
            // legacy
            
            if (!btn || !dropdown || !wrapper) return;

            const openClasses = ['opacity-100', 'visible', 'translate-y-0'];
            const closedClasses = ['opacity-0', 'invisible', 'translate-y-[-10px]'];

            function openMenu() {
                closedClasses.forEach(c => dropdown.classList.remove(c));
                openClasses.forEach(c => dropdown.classList.add(c));
            }

            function closeMenu() {
                openClasses.forEach(c => dropdown.classList.remove(c));
                closedClasses.forEach(c => dropdown.classList.add(c));
            }

            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (dropdown.classList.contains('invisible')) {
                    openMenu();
                } else {
                    closeMenu();
                }
            });

            document.addEventListener('click', function(e) {
                if (!wrapper.contains(e.target)) {
                    closeMenu();
                }
            });
        })();

        (function() {
            // Scroll New Arrivals Function
            window.scrollNewArrivals = function(direction) {
                const container = document.getElementById('newArrivalsContainer');
                if (!container) return;
                
                const scrollAmount = 400;
                if (direction === 'left') {
                    container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                } else {
                    container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                }
            };

            // Welcome Bonus Modal
            const welcomeModal = document.getElementById('welcomeBonusModal');
            if (welcomeModal) {
                const hasSeenWelcome = localStorage.getItem('hasSeenWelcomeBonus');
                if (!hasSeenWelcome) {
                    setTimeout(() => {
                        welcomeModal.style.display = 'flex';
                    }, 1000); // Show after 1 second
                }
            }

            window.closeWelcomeBonus = function() {
                const welcomeModal = document.getElementById('welcomeBonusModal');
                if (welcomeModal) {
                    welcomeModal.style.display = 'none';
                    localStorage.setItem('hasSeenWelcomeBonus', 'true');
                }
            };

            // ==========================================
            // Modern Realtime Search Overlay
            // ==========================================
            (function() {
                const overlay = document.getElementById('searchOverlay');
                const panel = document.getElementById('searchPanel');
                const toggleBtn = document.getElementById('searchToggleBtn');
                const closeBtn = document.getElementById('searchCloseBtn');
                const backdrop = document.getElementById('searchBackdrop');
                const input = document.getElementById('searchInput');
                const loading = document.getElementById('searchLoading');
                const initialState = document.getElementById('searchInitial');
                const emptyState = document.getElementById('searchEmpty');
                const resultsList = document.getElementById('searchResults');

                if (!overlay || !toggleBtn || !input) return;

                let debounceTimer;
                let currentController;

                function openOverlay() {
                    overlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                    requestAnimationFrame(() => {
                        overlay.classList.remove('opacity-0');
                        overlay.classList.add('opacity-100');
                        panel.classList.remove('-translate-y-4');
                        panel.classList.add('translate-y-0');
                        setTimeout(() => input.focus(), 50);
                    });
                }

                function closeOverlay() {
                    overlay.classList.add('opacity-0');
                    overlay.classList.remove('opacity-100');
                    panel.classList.add('-translate-y-4');
                    panel.classList.remove('translate-y-0');
                    setTimeout(() => {
                        overlay.classList.add('hidden');
                        document.body.style.overflow = '';
                        input.value = '';
                        showState('initial');
                    }, 300);
                }

                function showState(state) {
                    initialState.classList.toggle('hidden', state !== 'initial');
                    emptyState.classList.toggle('hidden', state !== 'empty');
                    resultsList.classList.toggle('hidden', state !== 'results');
                }

                function escapeHtml(s) {
                    return String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
                }

                function renderResults(products) {
                    resultsList.innerHTML = products.map(p => `
                        <a href="${escapeHtml(p.detail_url)}" class="flex items-center gap-6 px-5 py-3 transition hover:bg-zinc-50">
                            <div class="h-14 w-14 flex-shrink-0 overflow-hidden rounded-lg bg-zinc-100">
                                <img src="${escapeHtml(p.image_url)}" alt="${escapeHtml(p.name)}" class="h-full w-full object-cover" onerror="this.onerror=null;this.src='/images/logo.png';" loading="lazy">
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-zinc-900">${escapeHtml(p.name)}</p>
                                <div class="mt-0.5 flex items-center gap-2 text-xs text-zinc-500">
                                    ${p.brand ? `<span class="font-medium">${escapeHtml(p.brand)}</span>` : ''}
                                    ${p.brand && p.category_label ? '<span class="text-zinc-300">·</span>' : ''}
                                    ${p.category_label ? `<span>${escapeHtml(p.category_label)}</span>` : ''}
                                </div>
                            </div>
                            <p class="flex-shrink-0 text-sm font-semibold text-zinc-900">${escapeHtml(p.formatted_price)}</p>
                        </a>
                    `).join('');
                }

                async function performSearch(query) {
                    if (currentController) currentController.abort();
                    currentController = new AbortController();

                    loading.classList.remove('hidden');
                    try {
                        const res = await fetch(`/api/search-products?q=${encodeURIComponent(query)}`, {
                            signal: currentController.signal,
                            headers: { 'Accept': 'application/json' }
                        });
                        const data = await res.json();
                        loading.classList.add('hidden');

                        if (data.products && data.products.length > 0) {
                            renderResults(data.products);
                            showState('results');
                        } else {
                            showState('empty');
                        }
                    } catch (err) {
                        if (err.name !== 'AbortError') {
                            loading.classList.add('hidden');
                            console.error('Search error:', err);
                        }
                    }
                }

                // Input with debounce
                input.addEventListener('input', function() {
                    const q = this.value.trim();
                    clearTimeout(debounceTimer);

                    if (q.length < 2) {
                        loading.classList.add('hidden');
                        if (currentController) currentController.abort();
                        showState('initial');
                        return;
                    }

                    debounceTimer = setTimeout(() => performSearch(q), 250);
                });

                // Triggers
                toggleBtn.addEventListener('click', openOverlay);
                closeBtn.addEventListener('click', closeOverlay);
                backdrop.addEventListener('click', closeOverlay);

                // Navbar inline search input
                const navSearchInputEl = document.getElementById('navSearchInput');
                if (navSearchInputEl) {
                    navSearchInputEl.addEventListener('focus', function() {
                        openOverlay();
                        const q = this.value.trim();
                        if (q.length >= 2) {
                            input.value = q;
                            performSearch(q);
                        }
                    });
                }

                // ESC to close
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && !overlay.classList.contains('hidden')) {
                        closeOverlay();
                    }
                });
            })();

            // Clone marquee content for seamless loop
            (function() {
                const marqueeContent = document.getElementById('marqueeContent');
                if (marqueeContent) {
                    marqueeContent.innerHTML += marqueeContent.innerHTML;
                }
            })();

            // Navbar scroll effect
            const header = document.getElementById('mainHeader');
            const logoText = document.getElementById('logoText');
            const navLinks = document.getElementById('navLinks');
            const navIcons = document.getElementById('navIcons');

            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.add('bg-white/80', 'backdrop-blur-xl', 'border-black/6');
                    header.classList.remove('bg-transparent', 'backdrop-blur-none', 'border-transparent');
                    
                    logoText.classList.remove('text-white');
                    logoText.classList.add('text-black');
                    
                    navLinks.querySelectorAll('a').forEach(link => {
                        link.classList.remove('text-white/90', 'hover:border-white/30', 'hover:text-white');
                        link.classList.add('text-black/80', 'hover:border-black/30', 'hover:text-black');
                    });
                    
                    navIcons.classList.remove('text-white/90');
                    navIcons.classList.add('text-black/80');

                    const navSearchInputScroll = document.getElementById('navSearchInput');
                    const navSearchIconScroll = document.getElementById('navSearchIcon');
                    if (navSearchInputScroll) {
                        navSearchInputScroll.classList.remove('bg-white/10', 'border-white/20', 'text-white', 'placeholder-white/60', 'focus:bg-white/20', 'focus:border-white/40');
                        navSearchInputScroll.classList.add('bg-zinc-50', 'border-zinc-200', 'text-black', 'placeholder-zinc-400', 'focus:bg-white', 'focus:border-zinc-300');
                    }
                    if (navSearchIconScroll) {
                        navSearchIconScroll.classList.remove('text-white/60');
                        navSearchIconScroll.classList.add('text-zinc-400');
                    }

                    navIcons.querySelectorAll('a, button').forEach(el => {
                        if (el.classList.contains('border-white/30')) {
                            el.classList.remove('border-white/30', 'bg-white/10', 'hover:bg-white/20', 'text-white');
                            el.classList.add('border-black/15', 'bg-transparent', 'hover:border-black/30', 'text-black');
                        }
                        el.classList.remove('hover:text-white');
                        el.classList.add('hover:text-black');
                    });

                    const loginBtn = document.getElementById('loginBtn');
                    if (loginBtn) {
                        loginBtn.classList.remove('text-white');
                        loginBtn.classList.add('text-black');
                    }
                } else {
                    header.classList.remove('bg-white/80', 'backdrop-blur-xl', 'border-black/6');
                    header.classList.add('bg-transparent', 'backdrop-blur-none', 'border-transparent');
                    
                    logoText.classList.add('text-white');
                    logoText.classList.remove('text-black');
                    
                    navLinks.querySelectorAll('a').forEach(link => {
                        link.classList.add('text-white/90', 'hover:border-white/30', 'hover:text-white');
                        link.classList.remove('text-black/80', 'hover:border-black/30', 'hover:text-black');
                    });
                    
                    navIcons.classList.add('text-white/90');
                    navIcons.classList.remove('text-black/80');

                    const navSearchInputScroll = document.getElementById('navSearchInput');
                    const navSearchIconScroll = document.getElementById('navSearchIcon');
                    if (navSearchInputScroll) {
                        navSearchInputScroll.classList.add('bg-white/10', 'border-white/20', 'text-white', 'placeholder-white/60', 'focus:bg-white/20', 'focus:border-white/40');
                        navSearchInputScroll.classList.remove('bg-zinc-50', 'border-zinc-200', 'text-black', 'placeholder-zinc-400', 'focus:bg-white', 'focus:border-zinc-300');
                    }
                    if (navSearchIconScroll) {
                        navSearchIconScroll.classList.add('text-white/60');
                        navSearchIconScroll.classList.remove('text-zinc-400');
                    }

                    navIcons.querySelectorAll('a, button').forEach(el => {
                        if (el.classList.contains('border-black/15')) {
                            el.classList.add('border-white/30', 'bg-white/10', 'hover:bg-white/20', 'text-white');
                            el.classList.remove('border-black/15', 'bg-transparent', 'hover:border-black/30', 'text-black');
                        }
                        el.classList.add('hover:text-white');
                        el.classList.remove('hover:text-black');
                    });

                    const loginBtn = document.getElementById('loginBtn');
                    if (loginBtn) {
                        loginBtn.classList.add('text-white');
                        loginBtn.classList.remove('text-black');
                    }
                }
            }, { passive: true });

            const revealEls = document.querySelectorAll('.np-fade-section');
            const heroImages = document.querySelectorAll('.np-parallax-image');
            const layoutSections = document.querySelectorAll('[data-featured-toggle]');
            const testimonialShowcase = document.querySelector('[data-testimonial-showcase]');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, {
                threshold: 0.12
            });

            revealEls.forEach((el) => observer.observe(el));

            document.querySelectorAll('[data-shop-showcase]').forEach((section) => {
                const container = section.querySelector('[data-slide-container]');
                const track = section.querySelector('[data-slide-track]');
                const prevBtn = section.querySelector('[data-slide-prev]');
                const nextBtn = section.querySelector('[data-slide-next]');

                if (!container || !track || !prevBtn || !nextBtn) return;

                const getStep = () => {
                    const firstCard = track.firstElementChild;
                    if (!firstCard) return 280;
                    const style = window.getComputedStyle(track);
                    const gap = parseFloat(style.columnGap || style.gap || '16') || 16;
                    return firstCard.getBoundingClientRect().width + gap;
                };

                prevBtn.addEventListener('click', () => {
                    container.scrollBy({
                        left: -getStep(),
                        behavior: 'smooth'
                    });
                });

                nextBtn.addEventListener('click', () => {
                    container.scrollBy({
                        left: getStep(),
                        behavior: 'smooth'
                    });
                });
            });

            const applyParallax = () => {
                if (window.innerWidth < 768) {
                    heroImages.forEach((img) => {
                        img.style.transform = '';
                    });
                    return;
                }

                const scrollTop = window.scrollY || window.pageYOffset;
                heroImages.forEach((img, index) => {
                    const intensity = 0.04 + (index * 0.005);
                    img.style.transform = `translate3d(0, ${scrollTop * intensity}px, 0)`;
                });
            };

            window.addEventListener('scroll', applyParallax, {
                passive: true
            });
            applyParallax();

            const applyContainerScroll = () => {
                const containers = document.querySelectorAll('[data-scroll-container]');

                if (window.innerWidth < 768) {
                    containers.forEach((container) => {
                        const card = container.querySelector('.np-container-scroll-card');
                        const content = container.querySelector('.np-container-scroll-content');
                        const title = content?.querySelector('h2');
                        const subtitle = content?.querySelector('p');
                        const cta = content?.querySelector('.mt-7');

                        if (card) card.style.transform = '';
                        if (title) title.style.transform = '';
                        if (subtitle) subtitle.style.transform = '';
                        if (cta) cta.style.transform = '';
                    });
                    return;
                }

                containers.forEach((container) => {
                    const card = container.querySelector('.np-container-scroll-card');
                    const content = container.querySelector('.np-container-scroll-content');
                    const title = content?.querySelector('h2');
                    const subtitle = content?.querySelector('p');
                    const cta = content?.querySelector('.mt-7');

                    if (!card || !content) return;

                    const rect = container.getBoundingClientRect();
                    const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
                    const rawProgress = (viewportHeight - rect.top) / (viewportHeight + rect.height);
                    const progress = Math.max(0, Math.min(1, rawProgress));

                    // 3D rotation effect (starts at 20deg, ends at 0deg)
                    const rotateX = 20 - (20 * progress);

                    // Scale effect desktop (tetap seperti semula)
                    const startScale = 1.05;
                    const endScale = 1;
                    const scale = startScale + ((endScale - startScale) * progress);

                    // Translate Y for content (moves up as you scroll)
                    const translateY = -100 * progress;

                    // Apply transforms
                    card.style.transform =
                        `perspective(1000px) rotateX(${rotateX.toFixed(2)}deg) scale(${scale.toFixed(3)})`;

                    if (title) title.style.transform = `translate3d(0, ${translateY.toFixed(2)}px, 0)`;
                    if (subtitle) subtitle.style.transform =
                    `translate3d(0, ${translateY.toFixed(2)}px, 0)`;
                    if (cta) cta.style.transform = `translate3d(0, ${translateY.toFixed(2)}px, 0)`;
                });
            };

            window.addEventListener('scroll', applyContainerScroll, {
                passive: true
            });
            window.addEventListener('resize', applyContainerScroll);
            applyContainerScroll();

            const mobileHero = document.querySelector('[data-mobile-hero-carousel]');
            if (mobileHero) {
                // Mobile hero carousel removed - using static banner now
            }

            const layoutClasses = {
                list: ['flex', 'flex-col', 'space-y-4'],
                '2col': ['grid', 'grid-cols-2', 'gap-6'],
                '4col': ['grid', 'grid-cols-1', 'gap-6', 'sm:grid-cols-2', 'lg:grid-cols-4'],
            };

            const setLayout = (section, mode) => {
                const grid = section.querySelector('[data-grid]');
                const buttons = section.querySelectorAll('.np-layout-btn');
                if (!grid) return;

                grid.className = 'np-layout-grid mt-10';
                layoutClasses[mode].forEach((cls) => grid.classList.add(cls));

                buttons.forEach((btn) => {
                    const active = btn.dataset.mode === mode;
                    btn.classList.toggle('bg-zinc-900', active);
                    btn.classList.toggle('text-white', active);
                    btn.classList.toggle('hover:bg-zinc-900/10', !active);
                });
            };

            layoutSections.forEach((section) => {
                const buttons = section.querySelectorAll('.np-layout-btn');
                const defaultMode = window.innerWidth < 768 ? '2col' : '4col';
                setLayout(section, defaultMode);

                buttons.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const mode = btn.dataset.mode;
                        if (!mode) return;
                        if (mode === '4col' && window.innerWidth < 768) return;
                        setLayout(section, mode);
                    });
                });
            });

            if (testimonialShowcase) {
                const viewport = testimonialShowcase.querySelector('[data-testimonial-hero]');
                const track = testimonialShowcase.querySelector('[data-testimonial-track]');
                const dots = testimonialShowcase.querySelectorAll('.np-testimonial-dot');

                if (viewport && track && dots.length > 0) {
                    let currentSlide = 0;
                    const totalSlides = dots.length;
                    const slides = track.querySelectorAll('.np-testimonial-hero-slide');
                    let intervalId;

                    const getTranslateX = (slideIndex) => {
                        const slide = slides[slideIndex];
                        if (!slide) return 0;

                        const viewportWidth = viewport.clientWidth;
                        const slideWidth = slide.clientWidth;
                        const centeredOffset = slide.offsetLeft - ((viewportWidth - slideWidth) / 2);
                        const maxOffset = Math.max(track.scrollWidth - viewportWidth, 0);

                        return Math.min(Math.max(centeredOffset, 0), maxOffset);
                    };

                    const setActiveSlide = (index) => {
                        currentSlide = (index + totalSlides) % totalSlides;
                        track.style.transform = `translateX(-${getTranslateX(currentSlide)}px)`;
                        dots.forEach((dot, dotIndex) => {
                            dot.classList.toggle('bg-white', dotIndex === currentSlide);
                            dot.classList.toggle('bg-white/45', dotIndex !== currentSlide);
                        });
                    };

                    const startAutoplay = () => {
                        intervalId = window.setInterval(() => {
                            setActiveSlide(currentSlide + 1);
                        }, 3600);
                    };

                    const stopAutoplay = () => {
                        if (intervalId) {
                            window.clearInterval(intervalId);
                        }
                    };

                    dots.forEach((dot, index) => {
                        dot.addEventListener('click', () => {
                            setActiveSlide(index);
                            stopAutoplay();
                            startAutoplay();
                        });
                    });

                    setActiveSlide(0);
                    startAutoplay();

                    window.addEventListener('resize', () => setActiveSlide(currentSlide));
                }
            }


            // Brand and Level Filter (server-side via URL params)
            const filterBrand = document.getElementById('filterBrand');
            const filterLevel = document.getElementById('filterLevel');

            function updateUrlParam(key, value) {
                const url = new URL(window.location.href);
                if (value) {
                    url.searchParams.set(key, value);
                } else {
                    url.searchParams.delete(key);
                }
                window.location.href = url.toString();
            }

            if (filterBrand) {
                filterBrand.addEventListener('change', function() {
                    updateUrlParam('brand', this.value);
                });
            }

            if (filterLevel) {
                filterLevel.addEventListener('change', function() {
                    updateUrlParam('level', this.value);
                });
            }

            // Price Range Filter (client-side only)
            const filterPriceRange = document.getElementById('filterPriceRange');
            const productGrid = document.getElementById('productGrid');
            const noResults = document.getElementById('noResults');

            const filterProducts = () => {
                const priceRange = filterPriceRange ? filterPriceRange.value : '';
                const products = document.querySelectorAll('.product-item');
                let visibleCount = 0;

                let minPrice = 0;
                let maxPrice = Infinity;

                if (priceRange) {
                    const [min, max] = priceRange.split('-').map(Number);
                    minPrice = min;
                    maxPrice = max;
                }

                products.forEach(product => {
                    const price = parseInt(product.dataset.price || '0');
                    const matchPrice = price >= minPrice && price <= maxPrice;

                    if (matchPrice) {
                        product.style.display = 'block';
                        visibleCount++;
                    } else {
                        product.style.display = 'none';
                    }
                });

                if (productGrid && noResults) {
                    if (visibleCount === 0) {
                        productGrid.style.display = 'none';
                        noResults.classList.remove('hidden');
                    } else {
                        productGrid.style.display = 'grid';
                        noResults.classList.add('hidden');
                    }
                }
            };

            if (filterPriceRange) {
                filterPriceRange.addEventListener('change', filterProducts);
            }

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
