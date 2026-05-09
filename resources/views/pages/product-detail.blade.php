@extends('layouts.app')

@section('title', $product->name . ' - NoraPadel')

@section('content')
<div class="bg-white text-black antialiased">
    <!-- Navbar sama seperti home_luxury -->
    <header class="fixed left-0 top-0 z-50 w-full border-b border-black/6 bg-white/80 backdrop-blur-xl md:sticky">
        <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('storage/logo.png') }}" alt="NoraPadel" class="h-7 w-7 object-contain" loading="lazy">
                <span class="text-xl font-semibold tracking-tight text-black">NoraPadel</span>
            </a>

            <nav class="hidden items-center gap-8 md:flex">
                <a href="{{ route('home') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Home</a>
                <a href="{{ route('racket') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Racket</a>
                <a href="{{ route('shoes') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Shoes</a>
                <a href="{{ route('apparel') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Accessories</a>
                <a href="{{ route('contact') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Contact</a>
            </nav>

            <div class="flex items-center gap-3 text-black/80">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 rounded-full border border-black/15 bg-black px-4 py-1.5 text-xs font-medium text-white transition duration-300 hover:bg-black/90" aria-label="Back to Dashboard">
                            <i class="fas fa-arrow-left text-[10px]"></i>
                            <span>Dashboard</span>
                        </a>
                    @elseif(auth()->user()->role === 'customer')
                        <a href="{{ route('customer.orders.index') }}" class="transition duration-300 hover:text-black" aria-label="Riwayat Pesanan" title="Riwayat Pesanan">
                            <i class="fas fa-history text-sm"></i>
                        </a>
                        <a href="{{ route('customer.profile.index') }}" class="transition duration-300 hover:text-black" aria-label="Profile" title="Profile">
                            <i class="fas fa-user text-sm"></i>
                        </a>
                    @endif
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1 rounded-full border border-black/15 px-3 py-1.5 text-xs font-medium text-black/80 transition duration-300 hover:border-black/30 hover:text-black" aria-label="Masuk">
                        <i class="fas fa-sign-in-alt text-[11px]"></i>
                        <span>Masuk</span>
                    </a>
                @endguest
                @auth
                    <a href="{{ route('customer.cart.index') }}" class="relative transition duration-300 hover:text-black" aria-label="Cart" title="Keranjang">
                        <i class="fas fa-shopping-bag text-sm"></i>
                        @if(auth()->user()->role === 'customer')
                            @php $cartCount = auth()->user()->cartItems()->sum('quantity'); @endphp
                            @if($cartCount > 0)
                                <span class="absolute -right-2 -top-2 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                            @endif
                        @endif
                    </a>
                @else
                    <a href="{{ route('login') }}" class="transition duration-300 hover:text-black" aria-label="Cart" title="Keranjang">
                        <i class="fas fa-shopping-bag text-sm"></i>
                    </a>
                @endauth
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

    <main class="pt-16 md:pt-0">
        <div class="bg-white min-h-screen py-8">
            <div class="container mx-auto px-4 max-w-7xl">
                <!-- Breadcrumb -->
                <nav class="mb-6 text-sm">
                    <ol class="flex items-center gap-2 text-zinc-600">
                        <li><a href="{{ route('home') }}" class="hover:text-black transition">Home</a></li>
                        <li><i class="fas fa-chevron-right text-xs"></i></li>
                        <li><a href="{{ route('produk.index') }}" class="hover:text-black transition">Produk</a></li>
                        <li><i class="fas fa-chevron-right text-xs"></i></li>
                        <li class="text-black font-medium">{{ $product->name }}</li>
                    </ol>
                </nav>

                <div class="grid md:grid-cols-2 gap-8 lg:gap-12">
                    <!-- Product Image -->
                    <div class="space-y-4">
                        <div class="aspect-square rounded-2xl overflow-hidden bg-zinc-100 border border-zinc-200 relative">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @if($product->hasActiveDiscount())
                                <span class="absolute left-4 top-4 rounded-full bg-rose-500 px-3 py-1.5 text-xs font-semibold text-white shadow-lg">-{{ $product->formatted_discount_percent }}</span>
                            @endif
                            @if($product->package_type === 'bundle')
                                <span class="absolute left-4 {{ $product->hasActiveDiscount() ? 'top-16' : 'top-4' }} rounded-full bg-purple-500 px-3 py-1.5 text-xs font-semibold text-white shadow-lg">Bundle</span>
                            @endif
                            @php
                                $mainSoldCount = \App\Models\OrderItem::where('product_id', $product->id)
                                    ->whereHas('order', function($q) {
                                        $q->whereIn('status', ['completed', 'delivered']);
                                    })->sum('quantity');
                            @endphp
                            @if($mainSoldCount >= 5)
                                <span class="absolute right-4 top-4 rounded-full bg-amber-500 px-3 py-1.5 text-xs font-semibold text-white shadow-lg">Best Seller</span>
                            @endif
                        </div>
                    </div>

                    <!-- Product Info - Lebih Compact -->
                    <div class="space-y-4">
                        <!-- Category Badge -->
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-zinc-100 text-zinc-700 border border-zinc-200">
                                {{ $product->category_label }}
                            </span>
                            
                            @if($product->package_type === 'bundle')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 border border-purple-200">
                                    <i class="fas fa-box-open text-[10px]"></i>
                                    Bundling
                                </span>
                            @endif
                            
                            @if($product->hasActiveDiscount())
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                    Diskon {{ $product->formatted_discount_percent }}
                                </span>
                            @endif

                            @if($product->stock <= 0)
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-zinc-100 text-zinc-500 border border-zinc-200">
                                    Stok Habis
                                </span>
                            @endif
                        </div>

                        <!-- Product Name -->
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-black tracking-tight leading-tight">{{ $product->name }}</h1>
                        </div>

                        <!-- Rating & Terjual -->
                        <div class="flex items-center gap-4 text-sm">
                            <div class="flex items-center gap-1">
                                @php
                                    $totalSold = \App\Models\OrderItem::where('product_id', $product->id)
                                        ->whereHas('order', function($q) {
                                            $q->whereIn('status', ['completed', 'delivered']);
                                        })->sum('quantity');
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-yellow-400 text-sm"></i>
                                @endfor
                                <span class="text-zinc-600 ml-1">5.0</span>
                            </div>
                            <span class="text-zinc-400">|</span>
                            <div class="text-zinc-600">
                                <i class="fas fa-box text-xs mr-1"></i>
                                <span class="font-semibold text-black">{{ $totalSold }}</span> Terjual
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="space-y-1">
                            @if($product->hasActiveDiscount())
                                <div class="flex items-baseline gap-3">
                                    <span class="text-3xl font-bold text-black">{{ $product->formatted_discounted_price }}</span>
                                    <span class="text-lg text-zinc-400 line-through">{{ $product->formatted_price }}</span>
                                </div>
                                <p class="text-sm text-green-600 font-medium">
                                    <i class="fas fa-tag mr-1"></i>Hemat {{ $product->formatted_discount_amount }}
                                </p>
                            @else
                                <span class="text-3xl font-bold text-black">{{ $product->formatted_price }}</span>
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="border-t border-zinc-200 pt-4">
                            <h3 class="text-xs font-semibold text-black uppercase tracking-wider mb-2">Deskripsi Produk</h3>
                            <p class="text-sm text-zinc-600 leading-relaxed">{{ $product->description }}</p>
                        </div>

                        <!-- Product Details -->
                        <div class="border-t border-zinc-200 pt-4">
                            <h3 class="text-xs font-semibold text-black uppercase tracking-wider mb-2">Detail Produk</h3>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div class="flex items-center gap-2 text-zinc-600">
                                    <i class="fas fa-weight-hanging w-4 text-xs"></i>
                                    <span>Berat: <strong class="text-black">{{ $product->formatted_weight }}</strong></span>
                                </div>
                                <div class="flex items-center gap-2 text-zinc-600">
                                    <i class="fas fa-boxes w-4 text-xs"></i>
                                    <span>Stok: <strong class="text-black">{{ $product->stock }}</strong></span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="border-t border-zinc-200 pt-4 space-y-2">
                            @if($product->stock > 0)
                                @auth
                                    @if(auth()->user()->isCustomer())
                                        <form action="{{ route('customer.cart.add', $product) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-full border-2 border-blue-600 text-blue-600 py-3 rounded-xl font-semibold text-sm hover:bg-blue-50 transition duration-200 flex items-center justify-center gap-2">
                                                <i class="fas fa-shopping-cart text-sm"></i>
                                                Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="block w-full border-2 border-blue-600 text-blue-600 py-3 rounded-xl font-semibold text-sm hover:bg-blue-50 transition duration-200 text-center">
                                            <i class="fas fa-shopping-cart mr-2 text-sm"></i>Add to Cart
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="block w-full border-2 border-blue-600 text-blue-600 py-3 rounded-xl font-semibold text-sm hover:bg-blue-50 transition duration-200 text-center">
                                        <i class="fas fa-shopping-cart mr-2 text-sm"></i>Add to Cart
                                    </a>
                                @endauth
                                
                                @auth
                                    @if(auth()->user()->isCustomer())
                                        <a href="{{ route('customer.checkout') }}" class="block w-full bg-blue-600 text-white py-3 rounded-xl font-semibold text-sm hover:bg-blue-700 transition duration-200 text-center">
                                            <i class="fas fa-bolt mr-2 text-sm"></i>Buy Now
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="block w-full bg-blue-600 text-white py-3 rounded-xl font-semibold text-sm hover:bg-blue-700 transition duration-200 text-center">
                                            <i class="fas fa-bolt mr-2 text-sm"></i>Buy Now
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="block w-full bg-blue-600 text-white py-3 rounded-xl font-semibold text-sm hover:bg-blue-700 transition duration-200 text-center">
                                        <i class="fas fa-bolt mr-2 text-sm"></i>Buy Now
                                    </a>
                                @endauth
                            @else
                                <button disabled class="w-full bg-zinc-200 text-zinc-500 py-3 rounded-xl font-semibold text-sm cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Related Products -->
                @if($relatedProducts->count() > 0)
                <div class="mt-16 pt-12">
                   
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

                    <div id="productGrid" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($relatedProducts as $related)
                        @php
                            $soldCount = \App\Models\OrderItem::where('product_id', $related->id)
                                ->whereHas('order', function($q) {
                                    $q->whereIn('status', ['completed', 'delivered']);
                                })->sum('quantity');
                        @endphp
                        <a href="{{ route('produk.show', $related) }}" 
                           class="product-item group block bg-white border border-zinc-200 rounded-xl overflow-hidden hover:shadow-lg transition duration-300" 
                           data-name="{{ strtolower($related->name) }}" 
                           data-price="{{ $related->hasActiveDiscount() ? $related->discounted_price : $related->price }}" 
                           data-discount="{{ $related->hasActiveDiscount() ? 'yes' : 'no' }}"
                           data-bundle="{{ $related->package_type === 'bundle' ? 'yes' : 'no' }}"
                           data-sold="{{ $soldCount }}">
                            <div class="aspect-square bg-zinc-100 overflow-hidden relative">
                                <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @if($related->package_type === 'bundle')
                                    <span class="absolute left-2 top-2 rounded-full bg-purple-500 px-2 py-0.5 text-[10px] font-semibold text-white">
                                        <i class="fas fa-box-open mr-1"></i>Bundle
                                    </span>
                                @endif
                                @if($soldCount > 10)
                                    <span class="absolute right-2 top-2 rounded-full bg-green-500 px-2 py-0.5 text-[10px] font-semibold text-white">
                                        <i class="fas fa-fire mr-1"></i>Popular
                                    </span>
                                @endif
                            </div>
                            <div class="p-3">
                                <h3 class="font-semibold text-sm text-black line-clamp-2 mb-2">{{ $related->name }}</h3>
                                @if($related->hasActiveDiscount())
                                    <div class="space-y-1">
                                        <p class="text-base font-bold text-black">{{ $related->formatted_discounted_price }}</p>
                                        <p class="text-xs text-zinc-400 line-through">{{ $related->formatted_price }}</p>
                                    </div>
                                @else
                                    <p class="text-base font-bold text-black">{{ $related->formatted_price }}</p>
                                @endif
                            </div>
                        </a>
                        @endforeach
                    </div>

                    <div id="noResults" class="hidden text-center py-12">
                        <i class="fas fa-search text-4xl text-zinc-300 mb-3"></i>
                        <p class="text-zinc-500">Tidak ada produk yang ditemukan</p>
                    </div>
                </div>
                @endif

                <!-- Testimonials Section -->
                <section class="mt-16 border-t border-zinc-200 pt-12">
                    @php
                        $testimonialItems = $testimonials->take(3);
                    @endphp

                    @if ($testimonialItems->count() > 0)
                        <div class="relative overflow-hidden rounded-3xl border border-black/6 bg-zinc-50/40 px-2 py-2 shadow-[0_12px_38px_rgba(0,0,0,0.08)] md:px-4 md:py-4" data-testimonial-hero>
                            <div class="np-testimonial-hero-track" data-testimonial-track>
                                @foreach ($testimonialItems as $index => $testimonial)
                                    <article class="np-testimonial-hero-slide">
                                        <div class="relative aspect-video overflow-hidden rounded-2xl">
                                            <img src="{{ $testimonial->image_url ?? '/images/logo.png' }}" alt="Testimoni" class="h-full w-full object-cover" loading="lazy">
                                            <div class="absolute inset-0 bg-linear-to-t from-black/60 via-black/20 to-transparent"></div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>

                            <div class="absolute bottom-4 left-1/2 z-20 flex -translate-x-1/2 items-center gap-2 rounded-full bg-black/35 px-3 py-2 backdrop-blur" data-testimonial-dots>
                                @foreach ($testimonialItems as $index => $testimonial)
                                    <button type="button" class="np-testimonial-dot h-2.5 w-2.5 rounded-full bg-white/45 transition duration-300" data-slide-to="{{ $index }}" aria-label="Slide {{ $index + 1 }}"></button>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-zinc-300 bg-white p-10 text-center text-zinc-500">
                            Belum ada testimoni.
                        </div>
                    @endif
                </section>
            </div>
        </div>
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
</style>
@endpush

@push('scripts')
<script>
(function() {
    const mobileMenuToggle = document.querySelector('[data-mobile-menu-toggle]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            mobileMenuToggle.setAttribute('aria-expanded', String(!mobileMenu.classList.contains('hidden')));
        });
    }

    // Product Filter & Search
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
            const name = product.dataset.name;
            const price = parseInt(product.dataset.price);
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

    // Testimonial carousel
    const testimonialShowcase = document.querySelector('[data-testimonial-hero]');
    if (testimonialShowcase) {
        const viewport = testimonialShowcase;
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
})();
</script>
@endpush
