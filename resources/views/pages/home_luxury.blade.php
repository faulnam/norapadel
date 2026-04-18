@extends('layouts.app')

@section('title', 'NoraPadel — Precision. Power. Performance.')

@section('content')
    <div class="bg-white text-black antialiased">
        <header class="sticky top-0 z-50 border-b border-black/6 bg-white/80 backdrop-blur-xl">
            <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
                <a href="{{ route('home') }}" class="text-xl font-semibold tracking-tight text-black">NoraPadel</a>

                <nav class="hidden items-center gap-8 md:flex">
                    <a href="{{ route('home') }}"
                        class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Home</a>
                    <a href="{{ route('racket') }}"
                        class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Racket</a>
                    <a href="{{ route('shoes') }}"
                        class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Shoes</a>
                    <a href="{{ route('apparel') }}"
                        class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Accessories</a>
                </nav>

                <div class="flex items-center gap-3 text-black/80">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center gap-1.5 rounded-full border border-black/15 bg-black px-4 py-1.5 text-xs font-medium text-white transition duration-300 hover:bg-black/90"
                                aria-label="Back to Dashboard">
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
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center gap-1 rounded-full border border-black/15 px-3 py-1.5 text-xs font-medium text-black/80 transition duration-300 hover:border-black/30 hover:text-black"
                            aria-label="Masuk">
                            <i class="fas fa-sign-in-alt text-[11px]"></i>
                            <span>Masuk</span>
                        </a>
                    @endguest
                    @auth
                        <a href="{{ route('customer.cart.index') }}" class="relative transition duration-300 hover:text-black"
                            aria-label="Cart" title="Keranjang">
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
                    <button type="button"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-black/15 text-black transition duration-300 hover:border-black/35 md:hidden"
                        data-mobile-menu-toggle aria-label="Toggle navigation" aria-expanded="false">
                        <i class="fas fa-bars text-sm"></i>
                    </button>
                </div>
            </div>

            <div class="hidden border-t border-black/10 bg-white/95 px-6 py-4 md:hidden" data-mobile-menu>
                <nav class="flex flex-col gap-3 text-sm font-medium text-black/85">
                    <a href="{{ route('home') }}" class="rounded-lg bg-black/5 px-2 py-1.5 text-black">Home</a>
                    <a href="{{ route('racket') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Racket</a>
                    <a href="{{ route('shoes') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Shoes</a>
                    <a href="{{ route('apparel') }}"
                        class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Accessories</a>
                </nav>
            </div>
        </header>
        <x-landing.hero-product id="racket" title="NoraPadel" subtitle="Precision. Power. Performance."
            image="{{ asset('storage/banner.png') }}" alt="NoraPadel Racket" primary-text="Explore"
            primary-href="{{ route('produk.index') }}" secondary-text="Buy Now"
            secondary-href="{{ route('home') }}#products"
            section-class="bg-[#f5f5f7] border-b-[14px] border-white" />

        <!-- Why Choose NoraPadel -->
        <section class="np-fade-section bg-white py-12 lg:py-14">
            <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                <div class="mb-8 text-center">
                    <h2 class="text-3xl font-semibold tracking-tight text-black sm:text-4xl lg:text-5xl">Why Choose NoraPadel</h2>
                    <p class="mx-auto mt-3 max-w-2xl text-zinc-600">Experience the difference with premium quality and exceptional service</p>
                </div>
                <div class="grid gap-6 md:grid-cols-3">
                    <div class="group rounded-2xl border border-black/6 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                        <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-black/5 text-black transition duration-300 group-hover:text-white">
                            <i class="fas fa-shipping-fast text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-black">Fast Delivery</h3>
                        <p class="mt-2 text-sm text-zinc-600">Get your order delivered quickly with our reliable shipping partners</p>
                    </div>
                    <div class="group rounded-2xl border border-black/6 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                        <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-black/5 text-black transition duration-300 group-hover:text-white">
                            <i class="fas fa-shield-alt text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-black">Quality Guaranteed</h3>
                        <p class="mt-2 text-sm text-zinc-600">100% authentic products with warranty and quality assurance</p>
                    </div>
                    <div class="group rounded-2xl border border-black/6 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                        <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-black/5 text-black transition duration-300  group-hover:text-white">
                            <i class="fas fa-headset text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-black">24/7 Support</h3>
                        <p class="mt-2 text-sm text-zinc-600">Our customer service team is always ready to help you</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="np-fade-section bg-white pt-6 pb-6 lg:pt-8 lg:pb-8">
            <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                @php
                    $section = $sections[0] ?? null;
                @endphp

                @if ($section)
                    <section class="mb-14 last:mb-0 rounded-3xl border border-black/6 bg-zinc-50/40 p-3 md:p-4"
                        data-shop-showcase>


                        @if ($section['latest'])
                            <button type="button"
                                class="group relative block w-full overflow-hidden rounded-2xl border border-black/8 bg-white text-start shadow-[0_12px_34px_rgba(0,0,0,0.08)]"
                                data-product-trigger data-product-id="{{ $section['latest']->id }}"
                                data-product-name="{{ e($section['latest']->name) }}"
                                data-product-category="{{ e($section['latest']->category_label) }}"
                                data-product-description="{{ e(\Illuminate\Support\Str::limit(strip_tags($section['latest']->description ?? ''), 180)) }}"
                                data-product-image="{{ $section['latest']->image_url }}"
                                data-product-price="{{ $section['latest']->hasActiveDiscount() ? $section['latest']->formatted_discounted_price : $section['latest']->formatted_price }}"
                                data-product-old-price="{{ $section['latest']->hasActiveDiscount() ? $section['latest']->formatted_price : '' }}">
                                <div class="relative">
                                    <img src="{{ $section['latest']->image_url }}"
                                        alt="{{ $section['latest']->name }}"
                                        class="h-[500px] w-full object-cover transition duration-500 group-hover:scale-105 md:h-[600px] lg:h-[700px]"
                                        onerror="this.onerror=null;this.src='/images/logo.png';"
                                        loading="lazy">
                                    @if($section['latest']->hasActiveDiscount())
                                        <span class="absolute left-3 top-3 rounded-full bg-rose-500 px-2.5 py-1 text-[11px] font-semibold text-white">-{{ $section['latest']->formatted_discount_percent }}</span>
                                    @endif
                                </div>
                                <div class="absolute inset-0 bg-linear-to-t from-black/65 via-black/20 to-transparent">
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 p-4 text-white md:p-6">
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-white/80">Produk
                                        Terbaru</p>
                                    <h3 class="mt-2 text-2xl font-semibold tracking-tight md:text-3xl">
                                        {{ $section['latest']->name }}</h3>
                                    <p class="mt-2 text-sm text-white/85 md:text-base">
                                        {{ \Illuminate\Support\Str::limit($section['latest']->description, 120) }}</p>
                                </div>
                            </button>
                        @endif

                        <div class="relative mt-5">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 z-10 w-10 bg-linear-to-r from-zinc-50 to-transparent">
                            </div>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 z-10 w-10 bg-linear-to-l from-zinc-50 to-transparent">
                            </div>

                            <button type="button"
                                class="shop-slide-btn absolute left-2 top-1/2 z-20 inline-flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-full border border-black/10 bg-white/90 text-zinc-700 shadow transition hover:bg-white"
                                data-slide-prev aria-label="Geser kiri">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </button>

                            <div class="overflow-x-scroll scroll-smooth px-10 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
                                data-slide-container>
                                <div class="flex gap-4 py-1" data-slide-track>
                                    @forelse($section['others'] as $product)
                                        <button type="button"
                                            class="group block w-56 shrink-0 overflow-hidden rounded-xl border border-black/6 bg-white text-start shadow-[0_6px_22px_rgba(0,0,0,0.06)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_12px_28px_rgba(0,0,0,0.1)]"
                                            data-product-trigger data-product-id="{{ $product->id }}"
                                            data-product-name="{{ e($product->name) }}"
                                            data-product-category="{{ e($product->category_label) }}"
                                            data-product-description="{{ e(\Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 180)) }}"
                                            data-product-image="{{ $product->image_url }}"
                                            data-product-price="{{ $product->hasActiveDiscount() ? $product->formatted_discounted_price : $product->formatted_price }}"
                                            data-product-old-price="{{ $product->hasActiveDiscount() ? $product->formatted_price : '' }}">
                                            <div class="relative">
                                                <img src="{{ $product->image_url }}"
                                                    alt="{{ $product->name }}"
                                                    class="aspect-4/5 w-full object-cover transition duration-500 group-hover:scale-105"
                                                    onerror="this.onerror=null;this.src='/images/logo.png';"
                                                    loading="lazy">
                                                @if($product->hasActiveDiscount())
                                                    <span class="absolute left-3 top-3 rounded-full bg-rose-500 px-2.5 py-1 text-[11px] font-semibold text-white">-{{ $product->formatted_discount_percent }}</span>
                                                @endif
                                            </div>
                                            <div class="p-3">
                                                <p class="line-clamp-1 text-sm font-semibold tracking-tight text-zinc-800">
                                                    {{ $product->name }}</p>
                                                <p class="mt-1 text-xs text-zinc-500">{{ $product->category_label }}</p>
                                            </div>
                                        </button>
                                    @empty
                                        <div
                                            class="w-full rounded-xl border border-dashed border-zinc-300 bg-white p-6 text-center text-zinc-500">
                                            Belum ada produk tambahan untuk kategori ini.</div>
                                    @endforelse
                                </div>
                            </div>

                            <button type="button"
                                class="shop-slide-btn absolute right-2 top-1/2 z-20 inline-flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-full border border-black/10 bg-white/90 text-zinc-700 shadow transition hover:bg-white"
                                data-slide-next aria-label="Geser kanan">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </button>
                        </div>
                    </section>
                @endif
            </div>
        </section>


        <x-landing.featured-toggle :products="$products" section-class="bg-[#f5f5f7] pt-3 pb-20 lg:pt-5 lg:pb-24" section-id="products" />

    <section id="testimonials" class="np-fade-section bg-white py-18 lg:py-22" data-gallery-showcase>
            <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                <div class="mb-8 text-center"><br><br>
                    <h2 class="text-3xl font-semibold tracking-tight text-black sm:text-4xl lg:text-5xl">NoraPadel Gallery
                    </h2>
                    <p class="mx-auto mt-3 max-w-2xl text-zinc-600">Momen latihan, matchday, dan lifestyle premium
                        NoraPadel dalam satu showcase yang bergerak dinamis.</p>
                </div>

                @php
                    $galleryItems = $galleries->take(8);
                    $smallGalleryItems = $galleryItems->take(4)->values();
                    $marqueeItems = $smallGalleryItems->concat($smallGalleryItems);
                @endphp

                @if ($galleryItems->count() > 0)
                    <div class="relative overflow-hidden rounded-3xl border border-black/6 bg-zinc-50/40 px-2 py-2 shadow-[0_12px_38px_rgba(0,0,0,0.08)] md:px-4 md:py-4"
                        data-gallery-hero>
                        <div class="np-gallery-hero-track" data-gallery-track>
                            @foreach ($galleryItems as $index => $gallery)
                                <article class="np-gallery-hero-slide">
                                    <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}"
                                        class="h-[500px] w-full object-cover md:h-[600px] lg:h-[700px]" loading="lazy">
                                    <div class="absolute inset-0 bg-linear-to-t from-black/60 via-black/20 to-transparent">
                                    </div>
                                    <div class="absolute bottom-0 left-0 right-0 p-4 text-white md:p-6">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-white/80">
                                            Gallery Highlight</p>
                                        <h3 class="mt-2 text-2xl font-semibold tracking-tight md:text-3xl">
                                            {{ $gallery->title }}</h3>
                                        @if ($gallery->description)
                                            <p class="mt-2 max-w-2xl text-sm text-white/85 md:text-base">
                                                {{ \Illuminate\Support\Str::limit($gallery->description, 120) }}</p>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="absolute bottom-4 left-1/2 z-20 flex -translate-x-1/2 items-center gap-2 rounded-full bg-black/35 px-3 py-2 backdrop-blur"
                            data-gallery-dots>
                            @foreach ($galleryItems as $index => $gallery)
                                <button type="button"
                                    class="np-gallery-dot h-2.5 w-2.5 rounded-full bg-white/45 transition duration-300"
                                    data-slide-to="{{ $index }}" aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                    </div>

                    <div class="relative mt-6 overflow-hidden">
                        <div
                            class="pointer-events-none absolute inset-y-0 left-0 z-10 w-16 bg-linear-to-r from-white to-transparent">
                        </div>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 z-10 w-16 bg-linear-to-l from-white to-transparent">
                        </div>

                        @php
                            // Collect gallery thumbnails
                            $marqueeCards = collect();
                            foreach ($smallGalleryItems as $idx => $gi) {
                                $marqueeCards->push([
                                    'type' => 'gallery',
                                    'image' => $gi->image_url,
                                    'title' => $gi->title,
                                    'link' => route('galeri'),
                                ]);
                            }

                            // Add testimonial images
                            $testimonialImages = $testimonials->filter(fn($t) => $t->image)->take(6);
                            foreach ($testimonialImages as $ti) {
                                $marqueeCards->push([
                                    'type' => 'testimonial',
                                    'image' => $ti->image_url,
                                    'title' => $ti->user->name,
                                    'link' => route('testimoni'),
                                ]);
                            }

                            // Duplicate for infinite scroll
                            $allMarqueeCards = $marqueeCards->concat($marqueeCards);
                        @endphp

                        <div class="np-gallery-marquee" data-gallery-marquee>
                            @foreach ($allMarqueeCards as $index => $card)
                                @if ($card['type'] === 'gallery')
                                    <a href="{{ $card['link'] }}"
                                        class="group block w-40 shrink-0 overflow-hidden rounded-xl border border-black/6 bg-white shadow-[0_6px_24px_rgba(0,0,0,0.06)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_12px_28px_rgba(0,0,0,0.1)] sm:w-48 md:w-55">
                                        <div class="relative">
                                            <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}"
                                                class="h-24 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-28"
                                                loading="lazy">
                                        </div>
                                        <div class="px-3 py-2.5">
                                            <p class="line-clamp-1 text-xs font-semibold tracking-tight text-zinc-800">
                                                {{ $card['title'] }}</p>
                                        </div>
                                    </a>
                                @else
                                    <div class="block w-64 shrink-0 overflow-hidden rounded-xl border border-black/6 bg-white shadow-[0_6px_24px_rgba(0,0,0,0.06)] sm:w-80 md:w-96">
                                        <div class="aspect-video">
                                            <img src="{{ $card['image'] }}" alt="Testimoni"
                                                class="h-full w-full object-contain"
                                                loading="lazy">
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>

        

        <section class="np-fade-section bg-white py-16 lg:py-20">
            <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                <div
                    class="rounded-3xl border border-black/5 bg-linear-to-r from-zinc-100 to-white px-8 py-14 text-center shadow-[0_8px_34px_rgba(0,0,0,0.04)] lg:px-12">
                    <h2 class="text-3xl font-semibold tracking-tight text-black sm:text-4xl lg:text-5xl">Level up your game
                        with NoraPadel</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-zinc-600">Designed for players who expect precision craftsmanship
                        and world-class performance in every detail.</p>
                    <a href="{{ route('home') }}#products"
                        class="mt-8 inline-flex rounded-full bg-[#0071e3] px-8 py-3 text-sm font-medium text-white transition duration-300 hover:scale-[1.02] hover:bg-[#0077ED]">
                        Shop Collection
                    </a>
                </div>
            </div>
        </section>

    </div>
@endsection

@push('styles')
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
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

        .np-gallery-hero-track {
            display: flex;
            gap: 0.75rem;
            transition: transform 700ms ease;
            will-change: transform;
        }

        .np-gallery-hero-slide {
            position: relative;
            min-width: calc(100% - 2.5rem);
            overflow: hidden;
            border-radius: 1rem;
        }

        @media (min-width: 768px) {
            .np-gallery-hero-slide {
                min-width: calc(100% - 7rem);
            }
        }

        .np-gallery-marquee {
            display: flex;
            gap: 1rem;
            width: max-content;
            animation: npMarquee 26s linear infinite;
        }

        .np-gallery-marquee:hover {
            animation-play-state: paused;
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

        .np-testimonial-marquee {
            display: flex;
            gap: 1.25rem;
            width: max-content;
            animation: npTestimonialMarquee 32s linear infinite;
        }

        .np-testimonial-marquee:hover {
            animation-play-state: paused;
        }

        @keyframes npMarquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(calc(-50% - 0.5rem));
            }
        }

        @keyframes npTestimonialMarquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(calc(-50% - 0.625rem));
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function() {
            const revealEls = document.querySelectorAll('.np-fade-section');
            const heroImages = document.querySelectorAll('.np-parallax-image');
            const layoutSections = document.querySelectorAll('[data-featured-toggle]');
            const galleryShowcase = document.querySelector('[data-gallery-showcase]');
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
                    const isMobile = window.innerWidth <= 768;

                    // 3D rotation effect (starts at 20deg, ends at 0deg)
                    const rotateX = 20 - (20 * progress);
                    
                    // Scale effect (mobile: 0.7 to 0.9, desktop: 1.05 to 1)
                    const startScale = isMobile ? 0.7 : 1.05;
                    const endScale = isMobile ? 0.9 : 1;
                    const scale = startScale + ((endScale - startScale) * progress);
                    
                    // Translate Y for content (moves up as you scroll)
                    const translateY = -100 * progress;

                    // Apply transforms
                    card.style.transform = `perspective(1000px) rotateX(${rotateX.toFixed(2)}deg) scale(${scale.toFixed(3)})`;

                    if (title) title.style.transform = `translate3d(0, ${translateY.toFixed(2)}px, 0)`;
                    if (subtitle) subtitle.style.transform = `translate3d(0, ${translateY.toFixed(2)}px, 0)`;
                    if (cta) cta.style.transform = `translate3d(0, ${translateY.toFixed(2)}px, 0)`;
                });
            };

            window.addEventListener('scroll', applyContainerScroll, {
                passive: true
            });
            window.addEventListener('resize', applyContainerScroll);
            applyContainerScroll();

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

            if (galleryShowcase) {
                const viewport = galleryShowcase.querySelector('[data-gallery-hero]');
                const track = galleryShowcase.querySelector('[data-gallery-track]');
                const dots = galleryShowcase.querySelectorAll('.np-gallery-dot');

                if (viewport && track && dots.length > 0) {
                    let currentSlide = 0;
                    const totalSlides = dots.length;
                    const slides = track.querySelectorAll('.np-gallery-hero-slide');
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
        })();
    </script>
@endpush
