@extends('layouts.app')

@section('title', 'NoraPadel — Precision. Power. Performance.')

@section('content')
    <div class="bg-white text-black antialiased">
        <header class="fixed left-0 top-0 z-50 w-full border-b border-transparent bg-transparent backdrop-blur-none transition-all duration-300" id="mainHeader">
            <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('storage/logo.png') }}" alt="NoraPadel" class="h-7 w-7 object-contain" loading="lazy">
                    <span class="text-xl font-semibold tracking-tight text-white transition-colors duration-300" id="logoText">NoraPadel</span>
                </a>

                <nav class="hidden items-center gap-8 md:flex" id="navLinks">
                    <a href="{{ route('home') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">Home</a>
                    <a href="{{ route('new-arrivals') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">New Arrivals</a>
                    <a href="{{ route('racket') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">Racket</a>
                    <a href="{{ route('shoes') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">Shoes</a>
                    <a href="{{ route('apparel') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">Accessories</a>
                    <a href="{{ route('contact') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">Contact</a>
                </nav>

                <div class="flex items-center gap-3 text-white/90" id="navIcons">
                    @auth
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center gap-1.5 rounded-full border border-white/30 bg-white/10 px-4 py-1.5 text-xs font-medium text-white backdrop-blur transition duration-300 hover:bg-white/20"
                                aria-label="Back to Dashboard">
                                <i class="fas fa-arrow-left text-[10px]"></i>
                                <span>Dashboard</span>
                            </a>
                        @elseif(auth()->user()->role === 'customer')
                            <a href="{{ route('customer.orders.index') }}" class="transition duration-300 hover:text-white"
                                aria-label="Riwayat Pesanan" title="Riwayat Pesanan">
                                <i class="fas fa-history text-sm"></i>
                            </a>
                            <a href="{{ route('customer.profile.index') }}" class="transition duration-300 hover:text-white"
                                aria-label="Profile" title="Profile">
                                <i class="fas fa-user text-sm"></i>
                            </a>
                        @endif
                    @endauth
                    @guest
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center gap-1 rounded-full border border-white/30 bg-white/10 px-3 py-1.5 text-xs font-medium text-white backdrop-blur transition duration-300 hover:bg-white/20"
                            aria-label="Masuk">
                            <i class="fas fa-sign-in-alt text-[11px]"></i>
                            <span>Masuk</span>
                        </a>
                    @endguest
                    @auth
                        <a href="{{ route('customer.cart.index') }}" class="relative transition duration-300 hover:text-white"
                            aria-label="Cart" title="Keranjang">
                            <i class="fas fa-shopping-bag text-sm"></i>
                            @if (auth()->user()->role === 'customer')
                                @php $cartCount = auth()->user()->cartItems()->sum('quantity'); @endphp
                                @if ($cartCount > 0)
                                    <span
                                        class="absolute -right-2 -top-2 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                                @endif
                            @endif
                        </a>
                    @else
                        <a href="{{ route('customer.cart.index') }}" class="relative transition duration-300 hover:text-white" aria-label="Cart"
                            title="Keranjang">
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
                    <button type="button"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-white/30 bg-white/10 text-white backdrop-blur transition duration-300 hover:bg-white/20 md:hidden"
                        data-mobile-menu-toggle aria-label="Toggle navigation" aria-expanded="false">
                        <i class="fas fa-bars text-sm"></i>
                    </button>
                </div>
            </div>

            <div class="hidden border-t border-black/10 bg-white/95 px-6 py-4 md:hidden" data-mobile-menu>
                <nav class="flex flex-col gap-3 text-sm font-medium text-black/85">
                    <a href="{{ route('home') }}" class="rounded-lg bg-black/5 px-2 py-1.5 text-black">Home</a>
                    <a href="{{ route('new-arrivals') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">New Arrivals</a>
                    <a href="{{ route('racket') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Racket</a>
                    <a href="{{ route('shoes') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Shoes</a>
                    <a href="{{ route('apparel') }}"
                        class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Accessories</a>
                </nav>
            </div>
        </header>

        <main class="pt-16 md:pt-0">
            <section class="relative h-[600px] overflow-hidden bg-zinc-900 md:h-[700px] lg:h-[800px]">
                <div class="absolute inset-0">
                    <img src="{{ asset('storage/utama.png') }}" 
                        alt="Padel Tennis" 
                        class="h-full w-full object-cover opacity-90" 
                        loading="eager">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
                </div>
                <div class="relative mx-auto flex h-full max-w-7xl items-center px-6 md:px-10 lg:px-12">
                    <div class="max-w-2xl text-white">
                        <h1 class="text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">NoraPadel</h1>
                        <p class="mt-4 text-xl sm:text-2xl lg:text-3xl">Precision. Power. Performance.</p>
                        <p class="mt-6 text-base text-zinc-200 sm:text-lg">Experience the ultimate in padel equipment. Premium quality rackets, shoes, and accessories for players who demand excellence.</p>
                        <div class="mt-8 flex flex-wrap gap-4">
                            <a href="{{ route('new-arrivals') }}" class="inline-flex rounded-full bg-blue-600 px-8 py-3 text-sm font-semibold text-white transition duration-300 hover:bg-blue-700">Shop Now</a>
                            <a href="{{ route('produk.index') }}" class="inline-flex rounded-full border-2 border-white bg-transparent px-8 py-3 text-sm font-semibold text-white transition duration-300 hover:bg-white hover:text-black">Explore Collection</a>
                        </div>
                    </div>
                </div>
            </section>


            <!-- New Arrivals -->
            <section class="np-fade-section bg-white py-8 lg:py-10">
                <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                    <div class="mb-6">
                        <h2 class="text-3xl font-semibold tracking-tight text-black sm:text-4xl lg:text-5xl">New Arrivals</h2>
                        <p class="mt-2 text-zinc-600">Discover our latest products</p>
                    </div>
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach($newArrivals as $product)
                            @php
                                $soldCount = \App\Models\OrderItem::where('product_id', $product->id)
                                    ->whereHas('order', function($q) {
                                        $q->whereIn('status', ['completed', 'delivered']);
                                    })->sum('quantity');
                            @endphp
                            <div class="group overflow-hidden rounded-2xl border border-black/6 bg-white shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                                <a href="{{ route('produk.show', $product) }}" class="block">
                                    <div class="relative aspect-square overflow-hidden">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" onerror="this.onerror=null;this.src='/images/logo.png';" loading="lazy">
                                        @if($product->hasActiveDiscount())
                                            <span class="absolute left-3 top-3 rounded-full bg-rose-500 px-2.5 py-1 text-[11px] font-semibold text-white">-{{ $product->formatted_discount_percent }}</span>
                                        @endif
                                        @if($product->package_type === 'bundle')
                                            <span class="absolute left-3 {{ $product->hasActiveDiscount() ? 'top-12' : 'top-3' }} rounded-full bg-purple-500 px-2.5 py-1 text-[11px] font-semibold text-white">Bundle</span>
                                        @endif
                                        @if($soldCount >= 5)
                                            <span class="absolute right-3 top-3 rounded-full bg-amber-500 px-2.5 py-1 text-[11px] font-semibold text-white">Best Seller</span>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h3 class="line-clamp-1 text-lg font-semibold text-black">{{ $product->name }}</h3>
                                        <p class="mt-1 text-sm text-zinc-600">{{ $product->category_label }}</p>
                                        @if($product->hasActiveDiscount())
                                            <p class="mt-2 text-xl font-bold text-black">{{ $product->formatted_discounted_price }}</p>
                                            <p class="text-sm text-zinc-400 line-through">{{ $product->formatted_price }}</p>
                                        @else
                                            <p class="mt-2 text-xl font-bold text-black">{{ $product->formatted_price }}</p>
                                        @endif
                                    </div>
                                </a>
                                <div class="px-4 pb-4">
                                    <button onclick="addToCart({{ $product->id }}, event)" class="w-full flex items-center justify-center gap-2 rounded-full border-2 border-blue-600 bg-transparent px-4 py-2 text-sm font-medium text-blue-600 transition duration-300 hover:bg-blue-600 hover:text-white">
                                        <i class="fas fa-shopping-cart text-sm"></i>
                                        <span>Add to Cart</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>


            <!-- Why Choose NoraPadel -->
            <section class="np-fade-section bg-gradient-to-br from-zinc-800 to-zinc-900 py-12 lg:py-14">
                <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                    <div class="mb-8 text-center">
                        <h2 class="text-3xl font-semibold tracking-tight text-white sm:text-4xl lg:text-5xl">Why Choose
                            NoraPadel</h2>
                        <p class="mx-auto mt-3 max-w-2xl text-white">Experience the difference with premium quality and
                            exceptional service</p>
                    </div>
                    <div class="grid gap-6 md:grid-cols-3">
                        <div
                            class="group rounded-2xl border border-black/6 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                            <div
                                class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-black/5 text-black transition duration-300 group-hover:text-white">
                                <i class="fas fa-shipping-fast text-xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-black">Fast Delivery</h3>
                            <p class="mt-2 text-sm text-zinc-600">Get your order delivered quickly with our reliable
                                shipping partners</p>
                        </div>
                        <div
                            class="group rounded-2xl border border-black/6 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                            <div
                                class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-black/5 text-black transition duration-300 group-hover:text-white">
                                <i class="fas fa-shield-alt text-xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-black">Quality Guaranteed</h3>
                            <p class="mt-2 text-sm text-zinc-600">100% authentic products with warranty and quality
                                assurance</p>
                        </div>
                        <div
                            class="group rounded-2xl border border-black/6 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                            <div
                                class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-black/5 text-black transition duration-300  group-hover:text-white">
                                <i class="fas fa-headset text-xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-black">24/7 Support</h3>
                            <p class="mt-2 text-sm text-zinc-600">Our customer service team is always ready to help you</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Shop -->
            <section class="np-fade-section bg-zinc-50 py-12 lg:py-14">
                <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                    <!-- Search & Filter -->
                    <div class="mb-6 space-y-4">
                        <div class="flex flex-col md:flex-row gap-3">
                            <div class="flex-1">
                                <input type="text" id="searchProduct" placeholder="Cari produk..." class="w-full px-4 py-2.5 border border-zinc-300 rounded-xl text-sm focus:outline-none focus:border-blue-500 transition">
                            </div>
                            <div class="flex gap-2 flex-wrap">
                                <select id="filterDiscount" class="px-4 py-2.5 border border-zinc-300 rounded-xl text-sm focus:outline-none focus:border-blue-500 transition">
                                    <option value="">Semua Diskon</option>
                                    <option value="yes">Ada Diskon</option>
                                    <option value="no">Tanpa Diskon</option>
                                </select>
                                <select id="filterBundle" class="px-4 py-2.5 border border-zinc-300 rounded-xl text-sm focus:outline-none focus:border-blue-500 transition">
                                    <option value="">Semua Produk</option>
                                    <option value="yes">Bundling Hemat</option>
                                    <option value="no">Produk Satuan</option>
                                </select>
                                <select id="filterPopular" class="px-4 py-2.5 border border-zinc-300 rounded-xl text-sm focus:outline-none focus:border-blue-500 transition">
                                    <option value="">Semua</option>
                                    <option value="yes">Sering Dibeli</option>
                                </select>
                                <button id="filterPrice" class="px-4 py-2.5 border border-zinc-300 rounded-xl text-sm hover:bg-zinc-50 transition">
                                    <i class="fas fa-sliders-h mr-2"></i>Harga
                                </button>
                            </div>
                        </div>

                        <!-- Price Range Filter -->
                        <div id="priceRangeFilter" class="hidden bg-zinc-50 border border-zinc-200 rounded-xl p-4">
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <div>
                                    <label class="text-xs text-zinc-600 mb-1 block">Harga Min</label>
                                    <input type="number" id="minPrice" placeholder="0" class="w-full px-3 py-2 border border-zinc-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="text-xs text-zinc-600 mb-1 block">Harga Max</label>
                                    <input type="number" id="maxPrice" placeholder="999999999" class="w-full px-3 py-2 border border-zinc-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button id="applyPriceFilter" class="flex-1 bg-blue-600 text-white py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                                    Terapkan
                                </button>
                                <button id="resetPriceFilter" class="px-4 py-2 border border-zinc-300 rounded-lg text-sm hover:bg-white transition">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="productGrid" class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                        @foreach($shopProducts as $product)
                            @php
                                $soldCount = \App\Models\OrderItem::where('product_id', $product->id)
                                    ->whereHas('order', function($q) {
                                        $q->whereIn('status', ['completed', 'delivered']);
                                    })->sum('quantity');
                            @endphp
                            <div class="product-item group block overflow-hidden rounded-xl border border-black/6 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg"
                                 data-name="{{ strtolower($product->name) }}"
                                 data-price="{{ $product->hasActiveDiscount() ? $product->discounted_price : $product->price }}"
                                 data-discount="{{ $product->hasActiveDiscount() ? 'yes' : 'no' }}"
                                 data-bundle="{{ $product->package_type === 'bundle' ? 'yes' : 'no' }}"
                                 data-sold="{{ $soldCount }}">
                                <a href="{{ route('produk.show', $product) }}" class="block">
                                    <div class="relative aspect-square overflow-hidden">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" onerror="this.onerror=null;this.src='/images/logo.png';" loading="lazy">
                                        @if($product->hasActiveDiscount())
                                            <span class="absolute left-2 top-2 rounded-full bg-rose-500 px-2 py-0.5 text-[10px] font-semibold text-white">-{{ $product->formatted_discount_percent }}</span>
                                        @endif
                                        @if($product->package_type === 'bundle')
                                            <span class="absolute left-2 {{ $product->hasActiveDiscount() ? 'top-9' : 'top-2' }} rounded-full bg-purple-500 px-2 py-0.5 text-[10px] font-semibold text-white">Bundle</span>
                                        @endif
                                        @if($soldCount >= 5)
                                            <span class="absolute right-2 top-2 rounded-full bg-amber-500 px-2 py-0.5 text-[10px] font-semibold text-white">Popular</span>
                                        @endif
                                    </div>
                                    <div class="p-3">
                                        <h3 class="line-clamp-1 text-sm font-semibold text-black">{{ $product->name }}</h3>
                                        <p class="mt-1 text-xs text-zinc-600">{{ $product->category_label }}</p>
                                        @if($product->hasActiveDiscount())
                                            <p class="mt-1 text-base font-bold text-black">{{ $product->formatted_discounted_price }}</p>
                                            <p class="text-xs text-zinc-400 line-through">{{ $product->formatted_price }}</p>
                                        @else
                                            <p class="mt-1 text-base font-bold text-black">{{ $product->formatted_price }}</p>
                                        @endif
                                    </div>
                                </a>
                                <div class="px-3 pb-3">
                                    <button onclick="addToCart({{ $product->id }}, event)" class="w-full flex items-center justify-center gap-1.5 rounded-full border-2 border-blue-600 bg-transparent px-3 py-1.5 text-xs font-medium text-blue-600 transition duration-300 hover:bg-blue-600 hover:text-white">
                                        <i class="fas fa-shopping-cart text-xs"></i>
                                        <span>Add to Cart</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="noResults" class="hidden text-center py-12">
                        <i class="fas fa-search text-4xl text-zinc-300 mb-3"></i>
                        <p class="text-zinc-500">Tidak ada produk yang ditemukan</p>
                    </div>
                   
                </div>
            </section>

            <section id="testimonials" class="np-fade-section bg-white py-18 lg:py-22" data-testimonial-showcase>
                <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                    @php
                        $testimonialItems = $testimonials->take(3);
                    @endphp

                    @if ($testimonialItems->count() > 0)
                        <div class="relative overflow-hidden rounded-3xl border border-black/6 bg-zinc-50/40 px-2 py-2 shadow-[0_12px_38px_rgba(0,0,0,0.08)] md:px-4 md:py-4"
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

                            <div class="absolute bottom-4 left-1/2 z-20 flex -translate-x-1/2 items-center gap-2 rounded-full bg-black/35 px-3 py-2 backdrop-blur"
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
                        <div
                            class="rounded-2xl border border-dashed border-zinc-300 bg-white p-10 text-center text-zinc-500">
                            Belum ada testimoni.</div>
                    @endif
                </div>
            </section>



            <section class="np-fade-section bg-white py-16 lg:py-20">
                <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                    <div
                        class="rounded-3xl border border-black/5 bg-linear-to-r from-zinc-100 to-white px-8 py-14 text-center shadow-[0_8px_34px_rgba(0,0,0,0.04)] lg:px-12">
                        <h2 class="text-3xl font-semibold tracking-tight text-black sm:text-4xl lg:text-5xl">Level up your
                            game
                            with NoraPadel</h2>
                        <p class="mx-auto mt-4 max-w-2xl text-zinc-600">Designed for players who expect precision
                            craftsmanship
                            and world-class performance in every detail.</p>
                        <a href="{{ route('home') }}#products"
                            class="mt-8 inline-flex rounded-full bg-[#0071e3] px-8 py-3 text-sm font-medium text-white transition duration-300 hover:scale-[1.02] hover:bg-[#0077ED]">
                            Shop Collection
                        </a>
                    </div>
                </div>
            </section>

        </main>
    </div>
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
        // Add to Cart Function
        function addToCart(productId, event) {
            event.preventDefault();
            event.stopPropagation();
            
            console.log('Adding to cart, product ID:', productId);
            console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.content);
            
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
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Error response:', text);
                        throw new Error('HTTP error ' + response.status);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Success data:', data);
                if (data.success) {
                    alert('Produk berhasil ditambahkan ke keranjang!');
                    location.reload();
                } else {
                    alert(data.message || 'Gagal menambahkan produk ke keranjang');
                }
            })
            .catch(error => {
                console.error('Catch error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            });
        }

        (function() {
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
                    
                    navIcons.querySelectorAll('a, button').forEach(el => {
                        if (el.classList.contains('border-white/30')) {
                            el.classList.remove('border-white/30', 'bg-white/10', 'hover:bg-white/20', 'text-white');
                            el.classList.add('border-black/15', 'bg-transparent', 'hover:border-black/30', 'text-black');
                        }
                        el.classList.remove('hover:text-white');
                        el.classList.add('hover:text-black');
                    });
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
                    
                    navIcons.querySelectorAll('a, button').forEach(el => {
                        if (el.classList.contains('border-black/15')) {
                            el.classList.add('border-white/30', 'bg-white/10', 'hover:bg-white/20', 'text-white');
                            el.classList.remove('border-black/15', 'bg-transparent', 'hover:border-black/30', 'text-black');
                        }
                        el.classList.add('hover:text-white');
                        el.classList.remove('hover:text-black');
                    });
                }
            }, { passive: true });

            const revealEls = document.querySelectorAll('.np-fade-section');
            const heroImages = document.querySelectorAll('.np-parallax-image');
            const layoutSections = document.querySelectorAll('[data-featured-toggle]');
            const testimonialShowcase = document.querySelector('[data-testimonial-showcase]');
            const mobileMenuToggle = document.querySelector('[data-mobile-menu-toggle]');
            const mobileMenu = document.querySelector('[data-mobile-menu]');

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
                '2col': ['grid', 'grid-cols-2', 'gap-4'],
                '4col': ['grid', 'grid-cols-1', 'gap-4', 'sm:grid-cols-2', 'lg:grid-cols-4'],
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

            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                    mobileMenuToggle.setAttribute('aria-expanded', String(!mobileMenu.classList.contains(
                        'hidden')));
                });
            }

            // Related Products Filter & Search
            const searchInput = document.getElementById('searchProduct');
            const filterDiscount = document.getElementById('filterDiscount');
            const filterPriceBtn = document.getElementById('filterPrice');
            const priceRangeFilter = document.getElementById('priceRangeFilter');
            const applyPriceBtn = document.getElementById('applyPriceFilter');
            const resetPriceBtn = document.getElementById('resetPriceFilter');
            const minPriceInput = document.getElementById('minPrice');
            const maxPriceInput = document.getElementById('maxPrice');
            const productGrid = document.getElementById('productGrid');
            const noResults = document.getElementById('noResults');

            let minPrice = 0;
            let maxPrice = Infinity;

            if (filterPriceBtn && priceRangeFilter) {
                filterPriceBtn.addEventListener('click', () => {
                    priceRangeFilter.classList.toggle('hidden');
                });
            }

            if (applyPriceBtn) {
                applyPriceBtn.addEventListener('click', () => {
                    minPrice = parseInt(minPriceInput.value) || 0;
                    maxPrice = parseInt(maxPriceInput.value) || Infinity;
                    filterProducts();
                });
            }

            if (resetPriceBtn) {
                resetPriceBtn.addEventListener('click', () => {
                    minPriceInput.value = '';
                    maxPriceInput.value = '';
                    minPrice = 0;
                    maxPrice = Infinity;
                    filterProducts();
                });
            }

            function filterProducts() {
                const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
                const discountFilter = filterDiscount ? filterDiscount.value : '';
                const bundleFilter = document.getElementById('filterBundle') ? document.getElementById('filterBundle').value : '';
                const popularFilter = document.getElementById('filterPopular') ? document.getElementById('filterPopular').value : '';
                const products = document.querySelectorAll('.product-item');
                let visibleCount = 0;

                products.forEach(product => {
                    const name = product.dataset.name || '';
                    const price = parseInt(product.dataset.price || '0');
                    const discount = product.dataset.discount;
                    const bundle = product.dataset.bundle;
                    const sold = parseInt(product.dataset.sold || 0);

                    const matchSearch = name.includes(searchTerm);
                    const matchDiscount = !discountFilter || discount === discountFilter;
                    const matchPrice = price >= minPrice && price <= maxPrice;
                    const matchBundle = !bundleFilter || bundle === bundleFilter;
                    const matchPopular = !popularFilter || (popularFilter === 'yes' && sold > 10);

                    if (matchSearch && matchDiscount && matchPrice && matchBundle && matchPopular) {
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
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterProducts);
            }

            if (filterDiscount) {
                filterDiscount.addEventListener('change', filterProducts);
            }

            const filterBundleEl = document.getElementById('filterBundle');
            if (filterBundleEl) {
                filterBundleEl.addEventListener('change', filterProducts);
            }

            const filterPopularEl = document.getElementById('filterPopular');
            if (filterPopularEl) {
                filterPopularEl.addEventListener('change', filterProducts);
            }
        })();
    </script>
@endpush
