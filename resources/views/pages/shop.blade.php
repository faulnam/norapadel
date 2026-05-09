@extends('layouts.app')

@section('title', 'Shop - NoraPadel')

@section('content')
<div class="min-h-screen bg-[#f5f5f7] text-black antialiased">
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
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 rounded-full border border-black/15 px-4 py-1.5 text-xs font-medium text-black/80 transition duration-300 hover:border-black/30 hover:text-black" aria-label="Dashboard">
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
                        <span class="absolute -right-2 -top-2 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white">{{ $wishlistCount > 9 ? '9+' : $wishlistCount }}</span>
                    @endif
                </a>
                
                <a href="{{ route('customer.cart.index') }}" class="relative transition duration-300 hover:text-black" aria-label="Cart" title="Keranjang">
                    <i class="fas fa-shopping-bag text-sm"></i>
                    @php
                        if (auth()->check() && auth()->user()->role === 'customer') {
                            $cartCount = auth()->user()->cartItems()->sum('quantity');
                        } else {
                            $guestCart = session()->get('guest_cart', []);
                            $cartCount = array_sum(array_column($guestCart, 'quantity'));
                        }
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute -right-2 -top-2 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                    @endif
                </a>
                
                <button onclick="openSearchModal()" class="transition duration-300 hover:text-black" aria-label="Search" title="Cari Produk">
                    <i class="fas fa-search text-sm"></i>
                </button>
                
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
                <a href="{{ route('contact') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Contact</a>
            </nav>
        </div>
    </header>

    <main class="pt-16 md:pt-0">
        <section class="bg-white py-8 lg:py-10">
            <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                <div class="mb-6">
                    <h1 class="text-3xl font-semibold tracking-tight text-black sm:text-4xl lg:text-5xl">Shop All Products</h1>
                    <p class="mt-2 text-zinc-600">Discover our complete collection</p>
                </div>

                <!-- Search & Filter -->
                <div class="mb-6 flex flex-col gap-3 md:flex-row">
                    <div class="flex flex-wrap gap-2">
                        <form action="{{ route('shop') }}" method="GET" class="flex flex-wrap gap-2">
                            <select name="category" onchange="this.form.submit()" class="rounded-xl border border-zinc-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none transition">
                                <option value="">Semua Kategori</option>
                                <option value="racket" {{ request('category') === 'racket' ? 'selected' : '' }}>Racket</option>
                                <option value="shoes" {{ request('category') === 'shoes' ? 'selected' : '' }}>Shoes</option>
                                <option value="accessories" {{ request('category') === 'accessories' ? 'selected' : '' }}>Accessories</option>
                            </select>
                            <select name="brand" onchange="this.form.submit()" class="rounded-xl border border-zinc-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none transition">
                                <option value="">Semua Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand }}" {{ request('brand') === $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                @endforeach
                            </select>
                            <select name="level" onchange="this.form.submit()" class="rounded-xl border border-zinc-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none transition">
                                <option value="">Semua Level</option>
                                <option value="beginner" {{ request('level') === 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ request('level') === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="pro" {{ request('level') === 'pro' ? 'selected' : '' }}>Pro</option>
                            </select>
                            <select name="sort" onchange="this.form.submit()" class="rounded-xl border border-zinc-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none transition">
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        @foreach($products as $product)
                            <div class="group overflow-hidden rounded-2xl border border-black/6 bg-white shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                                <a href="{{ route('produk.show', $product) }}" class="block">
                                    <div class="relative aspect-square overflow-hidden">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" onerror="this.onerror=null;this.src='/images/logo.png';" loading="lazy">
                                        @if($product->hasActiveDiscount())
                                            <span class="absolute left-3 top-3 rounded-full bg-rose-500 px-2.5 py-1 text-[11px] font-semibold text-white">-{{ $product->formatted_discount_percent }}</span>
                                        @endif
                                        @if($product->category === 'arrivals')
                                            <span class="absolute left-3 {{ $product->hasActiveDiscount() ? 'top-12' : 'top-3' }} rounded-full bg-blue-500 px-2.5 py-1 text-[11px] font-semibold text-white">Latest</span>
                                        @endif
                                        @if($product->package_type === 'bundle')
                                            <span class="absolute left-3 {{ $product->hasActiveDiscount() && $product->category === 'arrivals' ? 'top-[5.25rem]' : ($product->hasActiveDiscount() || $product->category === 'arrivals' ? 'top-12' : 'top-3') }} rounded-full bg-purple-500 px-2.5 py-1 text-[11px] font-semibold text-white">Bundle</span>
                                        @endif
                                        @if($product->isBestSeller())
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
                                    <div class="flex items-center gap-3">
                                        <button onclick="addToCart('{{ $product->slug }}', event)" class="text-zinc-400 transition duration-300 hover:text-blue-600">
                                            <i class="fas fa-shopping-bag text-base"></i>
                                        </button>
                                        <button onclick="addToWishlist('{{ $product->slug }}', event)" class="text-zinc-400 transition duration-300 hover:text-rose-500">
                                            <i class="fas fa-heart text-base"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="py-12 text-center">
                        <i class="fas fa-search mb-3 text-4xl text-zinc-300"></i>
                        <p class="text-zinc-500">Tidak ada produk yang ditemukan</p>
                    </div>
                @endif
            </div>
        </section>
    </main>
</div>

<x-search-modal />
@endsection

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

    // Mobile menu toggle
    const mobileMenuToggle = document.querySelector('[data-mobile-menu-toggle]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            mobileMenuToggle.setAttribute('aria-expanded', String(!mobileMenu.classList.contains('hidden')));
        });
    }
</script>
@endpush
