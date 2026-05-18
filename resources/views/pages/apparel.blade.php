@extends('layouts.app')

@section('title', 'NoraPadel Accessories — Comfort meets performance.')

@section('content')
<style>
    html, body { overflow-x: hidden; }
</style>
<div class="bg-white text-black antialiased">
    @include('components.luxury-navbar')
    <main class="bg-white pt-16 md:pt-20 lg:pt-32">
        <!-- Page Title -->
        <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 md:px-10 lg:px-12 py-4 lg:hidden">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500">Accessories</p>
            <h1 class="mt-2 text-2xl font-semibold tracking-tight text-black sm:text-3xl">Padel Accessories</h1>
            <p class="mt-2 text-zinc-600 text-sm">Essential gear for your game</p>
        </div>

        <!-- Main Layout: Sidebar + Grid -->
        <div class="mx-auto max-w-7xl px-6 pb-16 md:px-10 lg:px-12">
            <div class="flex flex-col gap-8 md:flex-row">
                
                <!-- Sidebar Filters -->
                <aside class="hidden lg:block w-[240px] flex-shrink-0">
                    <div class="space-y-6">
                        <!-- Search -->
                        <div>
                            <h3 class="mb-3 text-sm font-semibold text-black">Search</h3>
                            <input type="text" id="searchProduct" placeholder="Search products..." class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm outline-none focus:border-black transition">
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
                                    <input type="radio" name="filterPrice" class="border-zinc-300 text-black focus:ring-black" value="low" {{ request()->get('price') === 'low' ? 'checked' : '' }} onchange="applyFilters()">
                                    <span class="text-sm text-zinc-600">Low to High</span>
                                </label>
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" name="filterPrice" class="border-zinc-300 text-black focus:ring-black" value="high" {{ request()->get('price') === 'high' ? 'checked' : '' }} onchange="applyFilters()">
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
                                    <input type="radio" name="filterSort" class="border-zinc-300 text-black focus:ring-black" value="popular" {{ request()->get('sort') === 'popular' ? 'checked' : '' }} onchange="applyFilters()">
                                    <span class="text-sm text-zinc-600">Popular</span>
                                </label>
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" name="filterSort" class="border-zinc-300 text-black focus:ring-black" value="latest" {{ request()->get('sort') === 'latest' ? 'checked' : '' }} onchange="applyFilters()">
                                    <span class="text-sm text-zinc-600">Latest</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Product Grid Area -->
                <div class="flex-1">
                    <!-- Mobile Filter Dropdown -->
                    <div class="lg:hidden mb-4">
                        <div class="mb-3">
                            <label class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-700">Filter</label>
                        </div>
                        <div class="flex gap-2 overflow-x-auto pb-1 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                            <select id="filterBrand" class="px-2 py-1.5 border border-zinc-300 rounded-lg text-xs focus:outline-none focus:border-blue-500 transition bg-white shrink-0 min-w-[100px]" onchange="applyFilters()">
                                <option value="">Brand</option>
                                <option value="Bullpadel" {{ $selectedBrand === 'Bullpadel' ? 'selected' : '' }}>Bullpadel</option>
                                <option value="Babolat" {{ $selectedBrand === 'Babolat' ? 'selected' : '' }}>Babolat</option>
                                <option value="Nox" {{ $selectedBrand === 'Nox' ? 'selected' : '' }}>Nox</option>
                                <option value="Alpha" {{ $selectedBrand === 'Alpha' ? 'selected' : '' }}>Alpha</option>
                                <option value="Zephyr" {{ $selectedBrand === 'Zephyr' ? 'selected' : '' }}>Zephyr</option>
                                <option value="Arronax" {{ $selectedBrand === 'Arronax' ? 'selected' : '' }}>Arronax</option>
                            </select>
                            <select id="filterPrice" class="px-2 py-1.5 border border-zinc-300 rounded-lg text-xs focus:outline-none focus:border-blue-500 transition bg-white shrink-0 min-w-[100px]" onchange="applyFilters()">
                                <option value="">Price</option>
                                <option value="low" {{ request()->get('price') === 'low' ? 'selected' : '' }}>Low to High</option>
                                <option value="high" {{ request()->get('price') === 'high' ? 'selected' : '' }}>High to Low</option>
                            </select>
                            <select id="filterSort" class="px-2 py-1.5 border border-zinc-300 rounded-lg text-xs focus:outline-none focus:border-blue-500 transition bg-white shrink-0 min-w-[100px]" onchange="applyFilters()">
                                <option value="">Sort</option>
                                <option value="popular" {{ request()->get('sort') === 'popular' ? 'selected' : '' }}>Popular</option>
                                <option value="latest" {{ request()->get('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                            </select>
                        </div>
                    </div>

                    <!-- Grid -->
                    <div id="productGrid" class="grid grid-cols-3 gap-3 sm:grid-cols-2 lg:grid-cols-4">
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
                                <div class="px-2 pb-2">
                                    <div class="flex items-center gap-2">
                                        <button onclick="addToCart('{{ $product->slug }}', event)" class="flex-1 border border-zinc-300 bg-transparent px-2 py-1 text-[10px] font-semibold text-zinc-800 transition duration-300 hover:border-zinc-500 hover:text-zinc-950 text-center">
                                            Add to cart
                                        </button>
                                        <button onclick="addToWishlist('{{ $product->slug }}', event)" class="p-1 text-zinc-400 transition duration-300 hover:text-rose-500 shrink-0">
                                            <i class="fas fa-heart text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 p-12 text-center">
                                <i class="fas fa-box-open text-3xl text-zinc-400"></i>
                                <p class="mt-3 font-medium text-zinc-500">Accessories products not available yet.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination with Numbers -->
                    @if($products->hasPages())
                        <div class="mt-10 flex justify-center">
                            <div class="flex items-center gap-2 overflow-x-auto pb-1 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                                {{-- Previous --}}
                                @if($products->onFirstPage())
                                    <span class="px-2 py-1.5 text-xs text-zinc-400 cursor-not-allowed shrink-0">Previous</span>
                                @else
                                    <a href="{{ $products->previousPageUrl() }}" class="px-2 py-1.5 text-xs text-zinc-700 hover:text-black border border-zinc-200 rounded hover:border-black transition shrink-0">Previous</a>
                                @endif

                                {{-- Page Numbers --}}
                                @php
                                    $startPage = max(1, $products->currentPage() - 2);
                                    $endPage = min($products->lastPage(), $products->currentPage() + 2);
                                    if ($startPage > 1) $startPage = 1;
                                    if ($endPage < $products->lastPage()) $endPage = $products->lastPage();
                                @endphp

                                @for($i = $startPage; $i <= $endPage; $i++)
                                    @if($i == $products->currentPage())
                                        <span class="px-2 py-1.5 text-xs bg-black text-white rounded shrink-0">{{ $i }}</span>
                                    @else
                                        <a href="{{ $products->url($i) }}" class="px-2 py-1.5 text-xs text-zinc-700 hover:text-black border border-zinc-200 rounded hover:border-black transition shrink-0">{{ $i }}</a>
                                    @endif
                                @endfor

                                {{-- Next --}}
                                @if($products->hasMorePages())
                                    <a href="{{ $products->nextPageUrl() }}" class="px-2 py-1.5 text-xs text-zinc-700 hover:text-black border border-zinc-200 rounded hover:border-black transition shrink-0">Next</a>
                                @else
                                    <span class="px-2 py-1.5 text-xs text-zinc-400 cursor-not-allowed shrink-0">Next</span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div id="noResults" class="hidden text-center py-12">
                        <i class="fas fa-search text-4xl text-zinc-300 mb-3"></i>
                        <p class="text-zinc-500">No products found</p>
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
                body: JSON.stringify({ quantity: 1 })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Product successfully added to cart!');
                    location.reload();
                } else {
                    alert(data.message || 'Failed to add product to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding to cart');
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
                    alert('Product successfully added to wishlist!');
                    location.reload();
                } else {
                    alert(data.message || 'Product already in wishlist');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding to wishlist');
            });
        }

        function applyFilters() {
            const brand = document.getElementById('filterBrand').value;
            const price = document.getElementById('filterPrice').value;
            const sort = document.getElementById('filterSort').value;
            
            const url = new URL(window.location.href);
            if (brand) url.searchParams.set('brand', brand);
            else url.searchParams.delete('brand');
            if (price) url.searchParams.set('price', price);
            else url.searchParams.delete('price');
            if (sort) url.searchParams.set('sort', sort);
            else url.searchParams.delete('sort');
            
            window.location.href = url.toString();
        }
    </script>
@endpush

