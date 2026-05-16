@extends('layouts.app')

@section('title', 'Shopping Cart - NoraPadel')

@section('content')
<div class="bg-white text-black antialiased">
    <header class="fixed left-0 top-0 z-50 w-full border-b border-black/6 bg-white/80 backdrop-blur-xl md:sticky">
        <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('storage/logo.png') }}" alt="NoraPadel" class="h-7 w-7 object-contain" loading="lazy">
                <span class="text-xl font-semibold tracking-tight text-black">NoraPadel</span>
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
                                <!-- Right: Image -->
                                <div class="relative overflow-hidden">
                                    <img src="{{ asset('storage/fiks.jpeg') }}" alt="New Arrivals" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                    <div class="absolute bottom-6 left-6 right-6">
                                        <h5 class="text-white font-bold text-2xl mb-1">New Arrivals</h5>
                                        <p class="text-white/90 text-sm font-medium">Discover the Latest</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Racket Mega Dropdown -->
                <div class="relative group" data-dropdown="racket">
                    <a href="{{ route('racket') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black flex items-center gap-1">
                        Racket
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
                                <!-- Right: Image -->
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
                                <!-- Right: Image -->
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
                                <!-- Right: Image -->
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
                        class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Contact</a>
            </nav>

            <div class="flex items-center gap-3 text-black/80" id="navIcons">
                <!-- Desktop Inline Search -->
                <div class="hidden md:flex items-center relative" id="navSearchWrapper">
                    <i class="fas fa-search absolute left-3 text-sm text-zinc-400 pointer-events-none transition-colors duration-300" id="navSearchIcon"></i>
                    <input type="text" id="navSearchInput" placeholder="Cari produk..."
                           class="bg-zinc-50 border border-zinc-200 rounded-full pl-9 pr-4 py-1.5 text-sm text-black placeholder-zinc-400 focus:outline-none focus:bg-white focus:border-zinc-300 w-40 lg:w-48 transition-all duration-300"
                           autocomplete="off">
                </div>

                <!-- Mobile Search Icon -->
                <button type="button" id="searchToggleBtn" class="transition duration-300 hover:text-black md:hidden" aria-label="Search" title="Cari Produk">
                    <i class="fas fa-search text-sm"></i>
                </button>

                <!-- Hamburger Menu with combined elements -->
                <div class="relative" id="hamburgerMenuWrapperCustom">
                    <button type="button" id="hamburgerMenuBtnCustom" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-black/15 bg-transparent text-black transition duration-300 hover:border-black/30">
                        <i class="fas fa-bars text-sm"></i>
                    </button>
                    <div id="hamburgerMenuDropdownCustom" class="absolute right-0 mt-2 w-48 z-50 hidden">
                        <div class="bg-white rounded-lg shadow-lg border border-zinc-100 overflow-hidden">
                            <!-- Login -->
                            @guest
                                <a href="{{ route('login') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                    <i class="fas fa-sign-in-alt text-zinc-500 text-sm"></i>
                                    <span class="text-sm text-zinc-700">Login</span>
                                </a>
                            @endguest
                            
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
                            
                            <!-- Cart -->
                            <a href="{{ route('customer.cart.index') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                <div class="relative">
                                    <i class="fas fa-shopping-bag text-zinc-500 text-sm"></i>
                                    @auth
                                        @if (auth()->user()->role === 'customer')
                                            @php $cartCount = auth()->user()->cartItems()->sum('quantity'); @endphp
                                            @if ($cartCount > 0)
                                                <span class="absolute -right-1.5 -top-1.5 flex h-3 w-3 items-center justify-center rounded-full bg-rose-500 text-[9px] font-bold text-white">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                                            @endif
                                        @endif
                                    @endauth
                                    @guest
                                        @php 
                                            $guestCart = session()->get('guest_cart', []);
                                            $guestCartCount = array_sum(array_column($guestCart, 'quantity'));
                                        @endphp
                                        @if($guestCartCount > 0)
                                            <span class="absolute -right-1.5 -top-1.5 flex h-3 w-3 items-center justify-center rounded-full bg-rose-500 text-[9px] font-bold text-white">{{ $guestCartCount > 9 ? '9+' : $guestCartCount }}</span>
                                        @endif
                                    @endguest
                                </div>
                                <span class="text-sm text-zinc-700">Cart</span>
                            </a>
                            
                            <!-- Wishlist -->
                            <a href="{{ route('customer.wishlist.index') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                <div class="relative">
                                    <i class="fas fa-heart text-zinc-500 text-sm"></i>
                                    @php
                                        if (auth()->check() && auth()->user()->role === 'customer') {
                                            $wishlistCount = auth()->user()->wishlistItems()->count();
                                        } else {
                                            $guestWishlist = session()->get('guest_wishlist', []);
                                            $wishlistCount = count($guestWishlist);
                                        }
                                    @endphp
                                    @if($wishlistCount > 0)
                                        <span class="absolute -right-1.5 -top-1.5 flex h-3 w-3 items-center justify-center rounded-full bg-rose-500 text-[9px] font-bold text-white">{{ $wishlistCount > 9 ? '9+' : $wishlistCount }}</span>
                                    @endif
                                </div>
                                <span class="text-sm text-zinc-700">Wishlist</span>
                            </a>
                            
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

<div class="mx-auto w-full max-w-7xl px-6 py-8 pt-16 md:px-10 md:py-12 md:pt-0 lg:px-12 lg:py-16">
    <h3 class="mb-6 text-3xl font-semibold tracking-tight text-black sm:text-4xl">
        <i class="fas fa-shopping-cart mr-3 text-black"></i>Shopping Cart
    </h3>
    
    @if($cartItems->count() > 0)
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="mb-4 overflow-hidden rounded-2xl border border-black/6 bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-black/6 bg-zinc-50 px-6 py-4">
                        <span class="text-sm font-medium text-black">{{ $cartItems->count() }} Item</span>
                        <form action="{{ route('customer.cart.clear') }}" method="POST" 
                              onsubmit="return confirm('Clear cart?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-full border border-rose-600 bg-white px-4 py-1.5 text-xs font-medium text-rose-600 transition hover:bg-rose-50">
                                <i class="fas fa-trash mr-1"></i>Clear Cart
                            </button>
                        </form>
                    </div>
                    <div>
                        @foreach($cartItems as $item)
                            <div class="border-b border-black/6 p-6 last:border-0">
                                <div class="flex flex-col gap-4 sm:flex-row">
                                    <div class="relative mx-auto shrink-0 sm:mx-0">
                                <img src="{{ $item->variant ? $item->variant->image_url : ($item->product ? $item->product->image_url : 'https://via.placeholder.com/80') }}" 
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
                                            <form action="{{ auth()->check() ? route('customer.cart.remove', $item->id ?? $item->id) : route('customer.cart.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 transition hover:text-rose-700">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                        
                                        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                            <form action="{{ auth()->check() ? route('customer.cart.update', $item->id ?? $item->id) : route('customer.cart.update', $item->id) }}" method="POST" class="inline-flex">
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
                                            
                                            <strong class="text-base font-semibold text-black">{{ is_object($item) && method_exists($item, 'getAttribute') ? $item->formatted_subtotal : 'Rp ' . number_format($item->subtotal, 0, ',', '.') }}</strong>
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
                        <h4 class="text-lg font-semibold text-white"><i class="fas fa-receipt mr-2"></i>Summary</h4>
                    </div>
                    <div class="px-6 py-6">
                        <div class="flex justify-between border-b border-black/6 pb-3 text-sm">
                            <span class="text-zinc-600">Total Items</span>
                            <span class="font-medium text-black">{{ $cartItems->sum('quantity') }} pcs</span>
                        </div>
                        @php
                            $totalDiscount = 0;
                            $originalTotal = 0;
                            foreach($cartItems as $item) {
                                if(is_object($item) && method_exists($item, 'getAttribute')) {
                                    $totalDiscount += $item->discount_amount ?? 0;
                                    $originalTotal += $item->original_subtotal ?? $item->subtotal;
                                } else {
                                    // Guest cart - calculate discount
                                    $product = $item->product;
                                    $qty = $item->quantity;
                                    if($product->hasActiveDiscount()) {
                                        $originalTotal += $product->price * $qty;
                                        $totalDiscount += ($product->price - $product->discounted_price) * $qty;
                                    } else {
                                        $originalTotal += $product->price * $qty;
                                    }
                                }
                            }
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
                        
                        @if(auth()->check())
                            <a href="{{ route('customer.checkout') }}" class="block w-full rounded-full bg-black px-6 py-3 text-center text-sm font-medium text-white transition hover:bg-black/90">
                                <i class="fas fa-credit-card mr-2"></i>Checkout
                            </a>
                        @else
                            <a href="{{ route('customer.checkout') }}" class="block w-full rounded-full bg-black px-6 py-3 text-center text-sm font-medium text-white transition hover:bg-black/90">
                                <i class="fas fa-credit-card mr-2"></i>Checkout as Guest
                            </a>
                            <a href="{{ route('login') }}" class="block w-full mt-2 rounded-full border-2 border-black bg-transparent px-6 py-3 text-center text-sm font-medium text-black transition hover:bg-black hover:text-white">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login for Rewards
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="py-20 text-center">
            <i class="fas fa-shopping-cart mb-6 text-6xl text-zinc-300"></i>
            <h4 class="mb-2 text-2xl font-semibold text-black">Shopping Cart is Empty</h4>
            <p class="mb-6 text-zinc-600">Let's start shopping for NoraPadel equipment!</p>
            <a href="{{ route('home') }}#products" class="inline-flex items-center gap-2 rounded-full bg-black px-8 py-3 text-sm font-medium text-white transition hover:bg-black/90">
                <i class="fas fa-shopping-bag"></i>Start Shopping
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

    // Hamburger Menu Toggle
    (function() {
        const btn = document.getElementById('hamburgerMenuBtnCustom');
        const dropdown = document.getElementById('hamburgerMenuDropdownCustom');
        const wrapper = document.getElementById('hamburgerMenuWrapperCustom');
        if (!btn || !dropdown || !wrapper) return;
        btn.addEventListener('click', function(e){ e.stopPropagation(); dropdown.classList.toggle('hidden'); });
        document.addEventListener('click', function(e){ if(!wrapper.contains(e.target)) dropdown.classList.add('hidden'); });
    })();

    // Mega Dropdown Hover Control
    (function() {
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

    // Modern Search Overlay
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
                initialState.classList.remove('hidden');
                emptyState.classList.add('hidden');
                resultsList.classList.add('hidden');
            }, 300);
        }

        function escapeHtml(s) {
            return String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
        }

        function renderResults(products) {
            resultsList.innerHTML = products.map(p => `
                <a href="${escapeHtml(p.detail_url)}" class="flex items-center gap-4 px-5 py-3 transition hover:bg-zinc-50">
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
                    initialState.classList.add('hidden');
                    emptyState.classList.add('hidden');
                    resultsList.classList.remove('hidden');
                } else {
                    initialState.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                    resultsList.classList.add('hidden');
                }
            } catch (err) {
                if (err.name !== 'AbortError') {
                    loading.classList.add('hidden');
                    console.error('Search error:', err);
                }
            }
        }

        input.addEventListener('input', function() {
            const q = this.value.trim();
            clearTimeout(debounceTimer);
            if (q.length < 2) {
                loading.classList.add('hidden');
                if (currentController) currentController.abort();
                initialState.classList.remove('hidden');
                emptyState.classList.add('hidden');
                resultsList.classList.add('hidden');
                return;
            }
            debounceTimer = setTimeout(() => performSearch(q), 250);
        });

        toggleBtn.addEventListener('click', openOverlay);
        closeBtn.addEventListener('click', closeOverlay);
        backdrop.addEventListener('click', closeOverlay);

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

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !overlay.classList.contains('hidden')) {
                closeOverlay();
            }
        });
    })();
</script>
@endpush
