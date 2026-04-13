@extends('layouts.app')

@section('title', 'NoraPadel Apparel — Comfort meets performance.')

@section('content')
    <div class="bg-white text-black antialiased">
        <header class="sticky top-0 z-50 border-b border-black/6 bg-white/80 backdrop-blur-xl">
            <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
                <a href="{{ route('home') }}" class="text-xl font-semibold tracking-tight text-black">NoraPadel</a>

                <nav class="hidden items-center gap-8 md:flex">
                    <a href="{{ route('home') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Home</a>
                    <a href="{{ route('racket') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Racket</a>
                    <a href="{{ route('shoes') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Shoes</a>
                    <a href="{{ route('apparel') }}" class="border-b border-black text-sm text-black transition duration-300">Apparel</a>
                    <a href="{{ route('shop') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Shop</a>
                </nav>

                <div class="flex items-center gap-4 text-black/80">
                    @guest
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1 rounded-full border border-black/15 px-3 py-1.5 text-xs font-medium text-black/80 transition duration-300 hover:border-black/30 hover:text-black" aria-label="Masuk">
                            <i class="fas fa-sign-in-alt text-[11px]"></i>
                            <span>Masuk</span>
                        </a>
                    @endguest
                    @auth
                        <a href="{{ route('customer.cart.index') }}" class="transition duration-300 hover:text-black" aria-label="Cart">
                            <i class="fas fa-shopping-bag text-sm"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="transition duration-300 hover:text-black" aria-label="Cart">
                            <i class="fas fa-shopping-bag text-sm"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <x-landing.hero-product
            id="apparel"
            title="NoraPadel Apparel"
            subtitle="Comfort meets performance."
            image="https://images.unsplash.com/photo-1518459031867-a89b944bffe4?auto=format&fit=crop&w=1400&q=80"
            alt="NoraPadel Apparel"
            primary-text="Explore"
            :primary-href="route('produk.index')"
            secondary-text="Buy Now"
            :secondary-href="auth()->check() ? route('customer.products.index') : route('login')"
            section-class="bg-[#f5f5f7]"
        />

        <section class="np-fade-section bg-white py-16 lg:py-20">
            <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <h2 class="text-3xl font-semibold tracking-tight text-black sm:text-4xl">Apparel Collection</h2>
                        <p class="mt-2 text-zinc-600">Pilih apparel olahraga premium dengan material nyaman, ringan, dan siap mendukung performa terbaikmu.</p>
                    </div>

                    <form action="{{ route('apparel') }}" method="GET" class="flex w-full max-w-md items-center gap-2 rounded-full border border-black/10 bg-white p-1.5 shadow-[0_8px_24px_rgba(0,0,0,0.06)]">
                        <div class="pl-3 text-zinc-400">
                            <i class="fas fa-search text-sm"></i>
                        </div>
                        <input
                            type="text"
                            name="q"
                            value="{{ $search }}"
                            placeholder="Cari produk apparel..."
                            class="h-10 w-full border-0 bg-transparent px-1 text-sm text-zinc-800 outline-none placeholder:text-zinc-400 focus:ring-0"
                        >
                        <button type="submit" class="inline-flex h-10 shrink-0 items-center rounded-full bg-zinc-900 px-4 text-sm font-medium text-white transition duration-300 hover:bg-zinc-800">
                            Search
                        </button>
                    </form>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @forelse($products as $product)
                        <button
                            type="button"
                            class="group flex h-full w-full flex-col overflow-hidden rounded-2xl border border-black/6 bg-white text-start shadow-[0_8px_26px_rgba(0,0,0,0.05)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_16px_36px_rgba(0,0,0,0.09)]"
                            data-product-trigger
                            data-product-id="{{ $product->id }}"
                            data-product-name="{{ e($product->name) }}"
                            data-product-category="{{ e($product->category_label) }}"
                            data-product-description="{{ e(\Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 180)) }}"
                            data-product-image="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80' }}"
                            data-product-price="{{ $product->hasActiveDiscount() ? $product->formatted_discounted_price : $product->formatted_price }}"
                            data-product-old-price="{{ $product->hasActiveDiscount() ? $product->formatted_price : '' }}"
                        >
                            <div class="relative aspect-4/5 overflow-hidden bg-zinc-50">
                                <img
                                    src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80' }}"
                                    alt="{{ $product->name }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                    loading="lazy"
                                >
                                @if($product->hasActiveDiscount())
                                    <span class="absolute left-3 top-3 rounded-full bg-rose-500 px-2.5 py-1 text-[11px] font-semibold text-white">-{{ $product->formatted_discount_percent }}</span>
                                @endif
                            </div>

                            <div class="flex flex-1 flex-col p-4">
                                <h3 class="line-clamp-2 text-base font-semibold tracking-tight text-black">{{ $product->name }}</h3>
                                <p class="mt-1 text-xs text-zinc-500">{{ $product->category_label }}</p>

                                <div class="mt-auto pt-4">
                                    @if($product->hasActiveDiscount())
                                        <p class="text-base font-semibold text-emerald-600">{{ $product->formatted_discounted_price }}</p>
                                        <p class="text-xs text-zinc-400 line-through">{{ $product->formatted_price }}</p>
                                    @else
                                        <p class="text-base font-semibold text-emerald-600">{{ $product->formatted_price }}</p>
                                    @endif
                                </div>
                            </div>
                        </button>
                    @empty
                        <div class="col-span-full rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 p-12 text-center">
                            <i class="fas fa-box-open text-3xl text-zinc-400"></i>
                            <p class="mt-3 font-medium text-zinc-500">Produk apparel belum tersedia.</p>
                        </div>
                    @endforelse
                </div>

                @if($products->hasPages())
                    <div class="mt-10">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </section>

        <footer class="border-t border-black/10 bg-white py-14 text-sm text-zinc-500">
            <div class="mx-auto grid w-full max-w-7xl grid-cols-2 gap-8 px-6 md:grid-cols-4 md:px-10 lg:px-12">
                <div>
                    <h3 class="mb-3 text-xs font-semibold uppercase tracking-wide text-black">Shop</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('racket') }}" class="hover:underline">Racket</a></li>
                        <li><a href="{{ route('shoes') }}" class="hover:underline">Shoes</a></li>
                        <li><a href="{{ route('apparel') }}" class="hover:underline">Apparel</a></li>
                        <li><a href="{{ route('shop') }}" class="hover:underline">Shop</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-3 text-xs font-semibold uppercase tracking-wide text-black">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('tentang') }}" class="hover:underline">Help Center</a></li>
                        <li><a href="{{ route('tentang') }}" class="hover:underline">Shipping</a></li>
                        <li><a href="{{ route('tentang') }}" class="hover:underline">Returns</a></li>
                        <li><a href="{{ route('tentang') }}" class="hover:underline">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-3 text-xs font-semibold uppercase tracking-wide text-black">Account</h3>
                    <ul class="space-y-2">
                        @auth
                            <li><a href="{{ route('customer.profile.index') }}" class="hover:underline">Dashboard</a></li>
                            <li><a href="{{ route('customer.orders.index') }}" class="hover:underline">Orders</a></li>
                            <li><a href="{{ route('customer.notifications.index') }}" class="hover:underline">Notifications</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:underline">Sign In</a></li>
                            <li><a href="{{ route('register') }}" class="hover:underline">Create Account</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h3 class="mb-3 text-xs font-semibold uppercase tracking-wide text-black">About NoraPadel</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('tentang') }}" class="hover:underline">Our Story</a></li>
                        <li><a href="{{ route('galeri') }}" class="hover:underline">Gallery</a></li>
                        <li><a href="{{ route('testimoni') }}" class="hover:underline">Testimonials</a></li>
                        <li><a href="{{ route('tentang') }}" class="hover:underline">Careers</a></li>
                    </ul>
                </div>
            </div>
            <div class="mx-auto mt-10 w-full max-w-7xl border-t border-black/10 px-6 pt-5 text-xs text-zinc-400 md:px-10 lg:px-12">
                © {{ now()->year }} NoraPadel. All rights reserved.
            </div>
        </footer>
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
    </style>
@endpush

@push('scripts')
    <script>
        (function () {
            const revealEls = document.querySelectorAll('.np-fade-section');
            const heroImages = document.querySelectorAll('.np-parallax-image');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, { threshold: 0.12 });

            revealEls.forEach((el) => observer.observe(el));

            const applyParallax = () => {
                const scrollTop = window.scrollY || window.pageYOffset;
                heroImages.forEach((img, index) => {
                    const intensity = 0.04 + (index * 0.005);
                    img.style.transform = `translate3d(0, ${scrollTop * intensity}px, 0)`;
                });
            };

            window.addEventListener('scroll', applyParallax, { passive: true });
            applyParallax();
        })();
    </script>
@endpush
