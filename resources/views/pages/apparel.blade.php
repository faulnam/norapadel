@extends('layouts.app')

@section('title', 'NoraPadel Accessories — Comfort meets performance.')

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
                         <a href="{{ route('new-arrivals') }}" class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">New Arrivals</a>
                    <a href="{{ route('racket') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">Racket</a>
                    <a href="{{ route('shoes') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">Shoes</a>
                    <a href="{{ route('apparel') }}"
                        class="border-b border-white text-sm text-white transition duration-300" data-active="true">Accessories</a>
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
                            <a href="{{ route('customer.orders.index') }}" class="transition duration-300 hover:text-black"
                                aria-label="Riwayat Pesanan">
                                <i class="fas fa-history text-sm"></i>
                            </a>
                            <a href="{{ route('customer.profile.index') }}" class="transition duration-300 hover:text-black"
                                aria-label="Profile">
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
                        <a href="{{ route('customer.cart.index') }}" class="relative transition duration-300 hover:text-black"
                            aria-label="Cart">
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
                    <button type="button"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-white/30 bg-white/10 text-white backdrop-blur transition duration-300 hover:bg-white/20 md:hidden"
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
                    <a href="{{ route('apparel') }}" class="rounded-lg bg-black/5 px-2 py-1.5 text-black">Accessories</a>
                </nav>
            </div>
        </header>

    <main class="pt-12 sm:pt-16 md:pt-0">
            <section class="relative h-[520px] overflow-hidden bg-zinc-900 md:h-[620px] lg:h-[700px]">
                <div class="absolute inset-0">
                    <img
                        src="{{ asset('storage/tas.png') }}"
                        alt="NoraPadel Accessories"
                        class="h-full w-full object-cover"
                        loading="eager">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/45 to-transparent"></div>
                </div>
                
            </section>

            <section class="np-fade-section bg-white pt-2 pb-12 sm:pt-4 sm:pb-14 md:py-16 lg:py-20 transition-all duration-300">
                <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 md:px-10 lg:px-12">
                    <div class="mb-4 flex flex-col gap-4 sm:mb-6 md:mb-8 lg:flex-row lg:items-end lg:justify-between transition-all duration-300">
                        <div><br>
                            <h2 class="text-2xl font-semibold leading-tight tracking-tight text-black sm:text-3xl md:text-4xl">Accessories Collection
                            </h2>
                            <p class="mt-2 text-sm text-zinc-500 sm:text-base">Pilih accessories olahraga premium dengan material nyaman, ringan,
                                dan siap mendukung performa terbaikmu.</p>
                        </div>

                        
                    </div>

                    <!-- Filter Section -->
                    <div class="mb-6 flex flex-col md:flex-row gap-3">
                        <div class="flex-1">
                            <input type="text" id="searchProduct" placeholder="Cari produk..." class="w-full px-4 py-2.5 border border-zinc-300 rounded-xl text-sm focus:outline-none focus:border-blue-500 transition">
                        </div>
                        <div class="flex gap-2 flex-wrap">
                            <select id="filterBrand" class="px-4 py-2.5 border border-zinc-300 rounded-xl text-sm focus:outline-none focus:border-blue-500 transition">
                                <option value="">Semua Brand</option>
                                @php
                                    $brands = \App\Models\Product::whereNotNull('brand')->distinct()->pluck('brand')->sort();
                                @endphp
                                @foreach($brands as $brand)
                                    <option value="{{ $brand }}">{{ $brand }}</option>
                                @endforeach
                            </select>
                            <select id="filterLevel" class="px-4 py-2.5 border border-zinc-300 rounded-xl text-sm focus:outline-none focus:border-blue-500 transition">
                                <option value="">Semua Level</option>
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="pro">Pro</option>
                            </select>
                            <select id="filterPrice" class="px-4 py-2.5 border border-zinc-300 rounded-xl text-sm focus:outline-none focus:border-blue-500 transition">
                                <option value="">Semua Harga</option>
                                <option value="0-500000">< Rp 500.000</option>
                                <option value="500000-1000000">Rp 500.000 - Rp 1.000.000</option>
                                <option value="1000000-2000000">Rp 1.000.000 - Rp 2.000.000</option>
                                <option value="2000000-5000000">Rp 2.000.000 - Rp 5.000.000</option>
                                <option value="5000000-999999999"> > Rp 5.000.000</option>
                            </select>
                        </div>
                    </div>

                    <div id="productGrid" class="grid grid-cols-2 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @forelse($products as $product)
                            @php
                                $soldCount = \App\Models\OrderItem::where('product_id', $product->id)
                                    ->whereHas('order', function($q) {
                                        $q->whereIn('status', ['completed', 'delivered']);
                                    })->sum('quantity');
                            @endphp
                            <div class="product-item group flex h-full w-full flex-col overflow-hidden rounded-2xl border border-black/6 bg-white text-start shadow-[0_8px_26px_rgba(0,0,0,0.05)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_16px_36px_rgba(0,0,0,0.09)]" 
                                 data-name="{{ strtolower($product->name) }}" 
                                 data-price="{{ $product->hasActiveDiscount() ? $product->discounted_price : $product->price }}"
                                 data-brand="{{ strtolower($product->brand ?? '') }}"
                                 data-level="{{ $product->level ?? '' }}"
                                 data-discount="{{ $product->hasActiveDiscount() ? 'yes' : 'no' }}"
                                 data-bundle="{{ $product->package_type === 'bundle' ? 'yes' : 'no' }}"
                                 data-sold="{{ $soldCount }}">
                                <a href="{{ route('produk.show', $product) }}" class="block">
                                    <div class="relative aspect-4/5 overflow-hidden bg-zinc-50">
                                        <img src="{{ $product->image_url ?: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80' }}"
                                            alt="{{ $product->name }}"
                                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                            loading="lazy">
                                        @if ($product->has_variants)
                                            <span class="absolute right-3 top-3 rounded-full bg-black/80 px-2.5 py-1 text-[11px] font-semibold text-white">Varian</span>
                                        @endif
                                        @if ($product->hasActiveDiscount())
                                            <span class="absolute left-3 top-3 rounded-full bg-rose-500 px-2.5 py-1 text-[11px] font-semibold text-white">-{{ $product->formatted_discount_percent }}</span>
                                        @endif
                                        @if($product->category === 'arrivals')
                                            <span class="absolute left-3 {{ $product->hasActiveDiscount() ? 'top-12' : 'top-3' }} rounded-full bg-blue-500 px-2.5 py-1 text-[11px] font-semibold text-white">Latest</span>
                                        @endif
                                        @if($product->package_type === 'bundle')
                                            <span class="absolute left-3 {{ $product->hasActiveDiscount() && $product->category === 'arrivals' ? 'top-[5.25rem]' : ($product->hasActiveDiscount() || $product->category === 'arrivals' ? 'top-12' : 'top-3') }} rounded-full bg-purple-500 px-2.5 py-1 text-[11px] font-semibold text-white">Bundle</span>
                                        @endif
                                        @if($soldCount >= 5 || $product->package_type === 'bestseller')
                                            <span class="absolute right-3 {{ $product->has_variants ? 'top-12' : 'top-3' }} rounded-full bg-amber-500 px-2.5 py-1 text-[11px] font-semibold text-white">Best Seller</span>
                                        @endif
                                    </div>

                                    <div class="flex flex-1 flex-col p-4">
                                        <h3 class="line-clamp-2 text-base font-semibold tracking-tight text-black">
                                            {{ $product->name }}</h3>
                                        <p class="mt-1 text-xs text-zinc-500">{{ $product->category_label }}</p>

                                        <div class="mt-auto pt-4">
                                            @if ($product->hasActiveDiscount())
                                                <p class="text-sm font-semibold text-emerald-600 sm:text-base">
                                                    {{ $product->formatted_discounted_price }}</p>
                                                <p class="text-xs text-zinc-400 line-through">{{ $product->formatted_price }}
                                                </p>
                                            @else
                                                <p class="text-sm font-semibold text-emerald-600 sm:text-base">
                                                    {{ $product->formatted_price }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                <div class="px-4 pb-4">
                                    <button onclick="addToCart('{{ $product->slug }}', event)" class="w-full flex items-center justify-center gap-2 rounded-full border-2 border-blue-600 bg-transparent px-4 py-2 text-sm font-medium text-blue-600 transition duration-300 hover:bg-blue-600 hover:text-white">
                                        <i class="fas fa-shopping-cart text-sm"></i>
                                        <span>Add to Cart</span>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div
                                class="col-span-full rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 p-12 text-center">
                                <i class="fas fa-box-open text-3xl text-zinc-400"></i>
                                <p class="mt-3 font-medium text-zinc-500">Produk accessories belum tersedia.</p>
                            </div>
                        @endforelse
                    </div>

                    <div id="noResults" class="hidden text-center py-12">
                        <i class="fas fa-search text-4xl text-zinc-300 mb-3"></i>
                        <p class="text-zinc-500">Tidak ada produk yang ditemukan</p>
                    </div>

                    @if ($products->hasPages())
                        <div class="mt-10">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </section>

        </main>
    </div>
@endsection

@push('styles')
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .np-fade-section {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .np-fade-section.is-visible {
            opacity: 1;
            transform: translateY(0);
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

        (function() {
            const header = document.getElementById('mainHeader');
            const logoText = document.getElementById('logoText');
            const navLinks = document.getElementById('navLinks');
            const navIcons = document.getElementById('navIcons');
            const revealEls = document.querySelectorAll('.np-fade-section');
            const heroImages = document.querySelectorAll('.np-parallax-image');
            const mobileMenuToggle = document.querySelector('[data-mobile-menu-toggle]');
            const mobileMenu = document.querySelector('[data-mobile-menu]');

            window.addEventListener('scroll', () => {
                if (!header || !logoText || !navLinks || !navIcons) return;
                if (window.scrollY > 50) {
                    header.classList.add('bg-white/80', 'backdrop-blur-xl', 'border-black/6');
                    header.classList.remove('bg-transparent', 'backdrop-blur-none', 'border-transparent');

                    logoText.classList.remove('text-white');
                    logoText.classList.add('text-black');

                    navLinks.querySelectorAll('a').forEach(link => {
                        const isActive = link.dataset.active === 'true';
                        link.classList.remove('text-white/90', 'text-white', 'hover:border-white/30', 'hover:text-white');
                        link.classList.add('text-black/80', 'hover:border-black/30', 'hover:text-black');
                        if (isActive) {
                            link.classList.remove('border-transparent', 'border-white', 'text-black/80', 'text-white/90', 'text-white');
                            link.classList.add('border-black', 'text-black');
                        } else {
                            link.classList.remove('border-black');
                            link.classList.add('border-transparent');
                        }
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
                        const isActive = link.dataset.active === 'true';
                        link.classList.add('text-white/90', 'hover:border-white/30', 'hover:text-white');
                        link.classList.remove('text-black', 'text-black/80', 'hover:border-black/30', 'hover:text-black');
                        if (isActive) {
                            link.classList.remove('border-transparent', 'border-black', 'text-black', 'text-black/80');
                            link.classList.add('border-white', 'text-white');
                        } else {
                            link.classList.remove('border-black');
                            link.classList.add('border-transparent');
                        }
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

            const applyParallax = () => {
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

            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                    mobileMenuToggle.setAttribute('aria-expanded', String(!mobileMenu.classList.contains(
                        'hidden')));
                });
            }

            // Filter Functionality
            const searchInput = document.getElementById('searchProduct');
            const filterBrand = document.getElementById('filterBrand');
            const filterLevel = document.getElementById('filterLevel');
            const filterPrice = document.getElementById('filterPrice');
            const productGrid = document.getElementById('productGrid');
            const noResults = document.getElementById('noResults');

            function filterProducts() {
                const searchTerm = searchInput.value.toLowerCase();
                const brandFilter = filterBrand.value.toLowerCase();
                const levelFilter = filterLevel.value;
                const priceRange = filterPrice.value;
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
                    const name = product.dataset.name;
                    const price = parseFloat(product.dataset.price);
                    const brand = product.dataset.brand;
                    const level = product.dataset.level;

                    let show = true;

                    if (searchTerm && !name.includes(searchTerm)) show = false;
                    if (brandFilter && brand !== brandFilter) show = false;
                    if (levelFilter && level !== levelFilter) show = false;
                    if (price < minPrice || price > maxPrice) show = false;

                    product.style.display = show ? 'flex' : 'none';
                    if (show) visibleCount++;
                });

                noResults.classList.toggle('hidden', visibleCount > 0);
                productGrid.classList.toggle('hidden', visibleCount === 0);
            }

            searchInput?.addEventListener('input', filterProducts);
            filterBrand?.addEventListener('change', filterProducts);
            filterLevel?.addEventListener('change', filterProducts);
            filterPrice?.addEventListener('change', filterProducts);
        })();
    </script>
@endpush

