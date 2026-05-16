@extends('layouts.app')

@section('title', 'Contact - NoraPadel')

@section('content')
    <style>
        #mainNavbar {
            display: none !important;
        }
    </style>

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
                    <a href="{{ route('contact') }}"
                        class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Contact</a>
                </nav>

                <div class="flex items-center gap-3 text-black/80" id="navIcons">
                    <!-- Hamburger Menu with combined elements -->
                    <div class="relative" id="hamburgerMenuWrapper">
                        <button type="button" id="hamburgerMenuBtn" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-black/15 bg-transparent text-black transition duration-300 hover:border-black/30">
                            <i class="fas fa-bars text-sm"></i>
                        </button>
                        <div id="hamburgerMenuDropdown" class="absolute right-0 mt-2 w-48 z-50 hidden">
                            <div class="bg-white rounded-lg shadow-lg border border-zinc-100 overflow-hidden">
                                <!-- Login -->
                                @guest
                                    <a href="{{ route('login') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                        <i class="fas fa-sign-in-alt text-zinc-500 text-sm"></i>
                                        <span class="text-sm text-zinc-700">Login</span>
                                    </a>
                                @endauth
                                
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
                    
                    <button type="button"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-black/15 text-black transition duration-300 hover:border-black/35 md:hidden"
                        data-mobile-menu-toggle aria-label="Toggle navigation" aria-expanded="false">
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

    <main class="pt-16 md:pt-0">
    <section class="bg-[#f8fafc] pt-8 pb-14 lg:pt-10 lg:pb-16">
            <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                <div class="mx-auto max-w-3xl text-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500">Support</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-black sm:text-4xl">Contact NoraPadel</h1>
                    <p class="mt-4 text-zinc-600">Send your questions. We will respond as soon as possible during business hours.</p>
                </div>

                <div class="mx-auto mt-12 grid max-w-5xl gap-8 lg:grid-cols-[1fr_1.35fr]">
                    <div class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-black">Contact Information</h2>
                        <ul class="mt-5 space-y-3 text-sm text-zinc-600">
                            <li><span class="font-medium text-black">WhatsApp:</span> {{ config('branding.phone', '08511735858') }}</li>
                            <li><span class="font-medium text-black">Email:</span> support@norapadel.com</li>
                            <li><span class="font-medium text-black">Address:</span> {{ config('branding.address', 'Citraland, Surabaya, East Java, Indonesia') }}</li>
                        </ul>
                    </div>

                    <form method="POST" action="{{ route('contact.submit') }}" class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
                        @csrf
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <label for="name" class="mb-2 block text-sm font-medium text-zinc-700">Name</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" required class="w-full rounded-xl border border-zinc-300 px-4 py-2.5 text-sm outline-none transition focus:border-black" />
                                @error('name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="sm:col-span-1">
                                <label for="email" class="mb-2 block text-sm font-medium text-zinc-700">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-zinc-300 px-4 py-2.5 text-sm outline-none transition focus:border-black" />
                                @error('email')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="subject" class="mb-2 block text-sm font-medium text-zinc-700">Subject</label>
                                <input id="subject" name="subject" type="text" value="{{ old('subject') }}" required class="w-full rounded-xl border border-zinc-300 px-4 py-2.5 text-sm outline-none transition focus:border-black" />
                                @error('subject')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="message" class="mb-2 block text-sm font-medium text-zinc-700">Message</label>
                                <textarea id="message" name="message" rows="5" required class="w-full rounded-xl border border-zinc-300 px-4 py-2.5 text-sm outline-none transition focus:border-black">{{ old('message') }}</textarea>
                                @error('message')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <button type="submit" class="mt-6 inline-flex rounded-full bg-black px-5 py-2.5 text-sm font-medium text-white transition hover:bg-zinc-800">Send Message</button>
                    </form>
                </div>
            </div>
        </section>
        </main>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            const mobileMenuToggle = document.querySelector('[data-mobile-menu-toggle]');
            const mobileMenu = document.querySelector('[data-mobile-menu]');

            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                    mobileMenuToggle.setAttribute('aria-expanded', String(!mobileMenu.classList.contains('hidden')));
                });
            }
        })();

        // Hamburger Menu Toggle - independent IIFE
        (function() {
            const btn = document.getElementById('hamburgerMenuBtn');
            const dropdown = document.getElementById('hamburgerMenuDropdown');
            const wrapper = document.getElementById('hamburgerMenuWrapper');
            if (!btn || !dropdown || !wrapper) return;
            btn.addEventListener('click', function(e){ e.stopPropagation(); dropdown.classList.toggle('hidden'); });
            document.addEventListener('click', function(e){ if(!wrapper.contains(e.target)) dropdown.classList.add('hidden'); });
        })();
    </script>
@endpush
