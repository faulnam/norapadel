@extends('layouts.app')

@section('title', 'New Arrivals - NoraPadel')

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
                <a href="{{ route('new-arrivals') }}" class="border-b border-black text-sm text-black transition duration-300" data-active="true">New Arrivals</a>
                <a href="{{ route('racket') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Racket</a>
                <a href="{{ route('shoes') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Shoes</a>
                <a href="{{ route('apparel') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Accessories</a>
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
                <a href="{{ route('new-arrivals') }}" class="rounded-lg bg-black/5 px-2 py-1.5 text-black">New Arrivals</a>
                <a href="{{ route('racket') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Racket</a>
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
                    
                    <div class="hidden md:block mt-4 md:mt-0 space-y-6" data-filter-panel>
                        <!-- Search -->
                        <div>
                            <h3 class="mb-3 text-sm font-semibold text-black">Search</h3>
                            <input type="text" id="searchProduct" placeholder="Cari produk..." class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm outline-none focus:border-black transition">
                        </div>

                        <!-- Availability -->
                        <div class="border-t border-zinc-100 pt-6">
                            <button type="button" class="filter-toggle flex w-full items-center justify-between text-left">
                                <h3 class="text-sm font-semibold text-black">Availability</h3>
                                <i class="fas fa-chevron-down text-xs text-zinc-400 transition-transform duration-200"></i>
                            </button>
                            <div class="filter-content mt-3 space-y-2">
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="checkbox" id="filterInStock" class="rounded border-zinc-300 text-black focus:ring-black" value="in_stock">
                                    <span class="text-sm text-zinc-600">In Stock</span>
                                </label>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="border-t border-zinc-100 pt-6">
                            <button type="button" class="filter-toggle flex w-full items-center justify-between text-left">
                                <h3 class="text-sm font-semibold text-black">Category</h3>
                                <i class="fas fa-chevron-down text-xs text-zinc-400 transition-transform duration-200"></i>
                            </button>
                            <div class="filter-content mt-3 flex flex-wrap gap-2">
                                <button type="button" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black" data-filter="category" data-value="racket">Racket</button>
                                <button type="button" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black" data-filter="category" data-value="shoes">Shoes</button>
                                <button type="button" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black" data-filter="category" data-value="apparel">Apparel</button>
                                <button type="button" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black" data-filter="category" data-value="accessories">Accessories</button>
                            </div>
                        </div>

                        <!-- Brand -->
                        <div class="border-t border-zinc-100 pt-6">
                            <button type="button" class="filter-toggle flex w-full items-center justify-between text-left">
                                <h3 class="text-sm font-semibold text-black">Brand</h3>
                                <i class="fas fa-chevron-down text-xs text-zinc-400 transition-transform duration-200"></i>
                            </button>
                            <div class="filter-content mt-3 flex flex-wrap gap-2">
                                @php
                                    $brands = \App\Models\Product::whereNotNull('brand')->distinct()->pluck('brand')->sort();
                                @endphp
                                @foreach($brands as $brand)
                                    <button type="button" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black" data-filter="brand" data-value="{{ strtolower($brand) }}">{{ $brand }}</button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Level -->
                        <div class="border-t border-zinc-100 pt-6">
                            <button type="button" class="filter-toggle flex w-full items-center justify-between text-left">
                                <h3 class="text-sm font-semibold text-black">Level</h3>
                                <i class="fas fa-chevron-down text-xs text-zinc-400 transition-transform duration-200"></i>
                            </button>
                            <div class="filter-content mt-3 flex flex-wrap gap-2">
                                <button type="button" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black" data-filter="level" data-value="beginner">Beginner</button>
                                <button type="button" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black" data-filter="level" data-value="intermediate">Intermediate</button>
                                <button type="button" class="filter-chip rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600 transition hover:border-black hover:text-black" data-filter="level" data-value="pro">Pro</button>
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
                                <p class="mt-3 font-medium text-zinc-500">No new arrivals yet</p>
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
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
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
            const sortSelect = document.getElementById('sortProduct');
            const productGrid = document.getElementById('productGrid');
            const noResults = document.getElementById('noResults');
            const productCount = document.getElementById('productCount');
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
                    const name = product.dataset.name || '';
                    const price = parseFloat(product.dataset.price) || 0;
                    const brand = product.dataset.brand || '';
                    const level = product.dataset.level || '';
                    const category = product.dataset.category || '';
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

                if (productCount) productCount.textContent = visibleCount;

                if (visibleCount === 0) {
                    productGrid.classList.add('hidden');
                    noResults.classList.remove('hidden');
                } else {
                    productGrid.classList.remove('hidden');
                    noResults.classList.add('hidden');
                }
            }

            function sortProducts() {
                const sortValue = sortSelect?.value || 'default';
                const visibleProducts = products.filter(p => p.style.display !== 'none');
                
                visibleProducts.sort((a, b) => {
                    const nameA = a.dataset.name || '';
                    const nameB = b.dataset.name || '';
                    const priceA = parseFloat(a.dataset.price) || 0;
                    const priceB = parseFloat(b.dataset.price) || 0;

                    if (sortValue === 'price_asc') return priceA - priceB;
                    if (sortValue === 'price_desc') return priceB - priceA;
                    if (sortValue === 'name_asc') return nameA.localeCompare(nameB);
                    return 0;
                });

                visibleProducts.forEach(p => productGrid.appendChild(p));
            }

            searchInput?.addEventListener('input', () => { filterProducts(); sortProducts(); });
            filterInStock?.addEventListener('change', () => { filterProducts(); sortProducts(); });
            priceRadios.forEach(r => r.addEventListener('change', () => { filterProducts(); sortProducts(); }));
            sortSelect?.addEventListener('change', sortProducts);

            // Grid toggle
            const gridToggles = document.querySelectorAll('.grid-toggle');
            gridToggles.forEach(btn => {
                btn.addEventListener('click', () => {
                    const cols = btn.dataset.cols;
                    gridToggles.forEach(b => {
                        b.classList.remove('text-black');
                        b.classList.add('text-zinc-400');
                    });
                    btn.classList.remove('text-zinc-400');
                    btn.classList.add('text-black');
                    
                    productGrid.classList.remove('grid-cols-2', 'lg:grid-cols-3');
                    if (cols === '2') {
                        productGrid.classList.add('grid-cols-2');
                    } else {
                        productGrid.classList.add('grid-cols-2', 'lg:grid-cols-3');
                    }
                });
            });

            // Fade-in observer
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.np-fade-in').forEach((el) => observer.observe(el));
        })();
    </script>
@endpush
