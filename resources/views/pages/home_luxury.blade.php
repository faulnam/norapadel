@extends('layouts.app')

@section('title', 'NoraPadel — Precision. Power. Performance.')

@section('content')
    <div class="bg-white text-black antialiased">
        <header class="sticky top-0 z-50 border-b border-black/6 bg-white/80 backdrop-blur-xl">
            <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
                <a href="{{ route('home') }}" class="text-xl font-semibold tracking-tight text-black">NoraPadel</a>

                <nav class="hidden items-center gap-8 md:flex">
                    <a href="{{ route('home') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Home</a>
                    <a href="{{ route('racket') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Racket</a>
                    <a href="{{ route('shoes') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Shoes</a>
                    <a href="{{ route('apparel') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Apparel</a>
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
            id="racket"
            title="NoraPadel Racket"
            subtitle="Precision. Power. Performance."
            image="https://images.unsplash.com/photo-1547941126-3d5322b218b0?auto=format&fit=crop&w=1400&q=80"
            alt="NoraPadel Racket"
            primary-text="Explore"
            :primary-href="route('produk.index')"
            secondary-text="Buy Now"
            :secondary-href="auth()->check() ? route('customer.products.index') : route('login')"
            section-class="bg-[#f5f5f7]"
        />

        <x-landing.hero-product
            id="shoes"
            title="NoraPadel Shoes"
            subtitle="Move faster. Play smarter."
            image="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=1400&q=80"
            alt="NoraPadel Shoes"
            primary-text="Explore"
            :primary-href="route('produk.index')"
            secondary-text="Buy Now"
            :secondary-href="auth()->check() ? route('customer.products.index') : route('login')"
            section-class="bg-white"
        />

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

        <x-landing.featured-toggle :products="$products" />

        <section class="np-fade-section bg-white py-18 lg:py-22" data-gallery-showcase>
            <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                <div class="mb-8 text-center"><br><br>
                    <h2 class="text-3xl font-semibold tracking-tight text-black sm:text-4xl lg:text-5xl">NoraPadel Gallery</h2>
                    <p class="mx-auto mt-3 max-w-2xl text-zinc-600">Momen latihan, matchday, dan lifestyle premium NoraPadel dalam satu showcase yang bergerak dinamis.</p>
                </div>

                @php
                    $galleryItems = $galleries->take(8);
                    $smallGalleryItems = $galleryItems->take(4)->values();
                    $marqueeItems = $smallGalleryItems->concat($smallGalleryItems);
                    $galleryFallback = [
                        'https://images.unsplash.com/photo-1545239351-1141bd82e8a6?auto=format&fit=crop&w=1600&q=80',
                        'https://images.unsplash.com/photo-1552674605-db6ffd4facb5?auto=format&fit=crop&w=1600&q=80',
                        'https://images.unsplash.com/photo-1517963879433-6ad2b056d712?auto=format&fit=crop&w=1600&q=80',
                        'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=1600&q=80',
                    ];
                @endphp

                @if($galleryItems->count() > 0)
                    <div class="relative overflow-hidden rounded-3xl border border-black/6 bg-zinc-50/40 px-2 py-2 shadow-[0_12px_38px_rgba(0,0,0,0.08)] md:px-4 md:py-4" data-gallery-hero>
                        <div class="np-gallery-hero-track" data-gallery-track>
                            @foreach($galleryItems as $index => $gallery)
                                @php
                                    $heroImage = $gallery->image_url ?: $galleryFallback[$index % count($galleryFallback)];
                                @endphp
                                <article class="np-gallery-hero-slide">
                                    <img src="{{ $heroImage }}" alt="{{ $gallery->title }}" class="h-76 w-full object-cover md:h-96" loading="lazy">
                                    <div class="absolute inset-0 bg-linear-to-t from-black/60 via-black/20 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-4 text-white md:p-6">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-white/80">Gallery Highlight</p>
                                        <h3 class="mt-2 text-2xl font-semibold tracking-tight md:text-3xl">{{ $gallery->title }}</h3>
                                        @if($gallery->description)
                                            <p class="mt-2 max-w-2xl text-sm text-white/85 md:text-base">{{ \Illuminate\Support\Str::limit($gallery->description, 120) }}</p>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="absolute bottom-4 left-1/2 z-20 flex -translate-x-1/2 items-center gap-2 rounded-full bg-black/35 px-3 py-2 backdrop-blur" data-gallery-dots>
                            @foreach($galleryItems as $index => $gallery)
                                <button type="button" class="np-gallery-dot h-2.5 w-2.5 rounded-full bg-white/45 transition duration-300" data-slide-to="{{ $index }}" aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                    </div>

                    <div class="relative mt-6 overflow-hidden">
                        <div class="pointer-events-none absolute inset-y-0 left-0 z-10 w-16 bg-linear-to-r from-white to-transparent"></div>
                        <div class="pointer-events-none absolute inset-y-0 right-0 z-10 w-16 bg-linear-to-l from-white to-transparent"></div>

                        <div class="np-gallery-marquee" data-gallery-marquee>
                            @foreach($marqueeItems as $index => $gallery)
                                @php
                                    $thumbImage = $gallery->image_url ?: $galleryFallback[$index % count($galleryFallback)];
                                @endphp
                                <a href="{{ route('galeri') }}" class="group block w-55 shrink-0 overflow-hidden rounded-xl border border-black/6 bg-white shadow-[0_6px_24px_rgba(0,0,0,0.06)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_12px_28px_rgba(0,0,0,0.1)]">
                                    <img src="{{ $thumbImage }}" alt="{{ $gallery->title }}" class="h-28 w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                                    <div class="px-3 py-2.5">
                                        <p class="line-clamp-1 text-xs font-semibold tracking-tight text-zinc-800">{{ $gallery->title }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section class="np-fade-section bg-white py-16 lg:py-20">
            <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                <div class="rounded-3xl border border-black/5 bg-linear-to-r from-zinc-100 to-white px-8 py-14 text-center shadow-[0_8px_34px_rgba(0,0,0,0.04)] lg:px-12">
                    <h2 class="text-3xl font-semibold tracking-tight text-black sm:text-4xl lg:text-5xl">Level up your game with NoraPadel</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-zinc-600">Designed for players who expect precision craftsmanship and world-class performance in every detail.</p>
                    <a href="{{ auth()->check() ? route('customer.products.index') : route('login') }}"
                       class="mt-8 inline-flex rounded-full bg-[#0071e3] px-8 py-3 text-sm font-medium text-white transition duration-300 hover:scale-[1.02] hover:bg-[#0077ED]">
                        Shop Collection
                    </a>
                </div>
            </div>
        </section>

        <footer class="border-t border-black/10 bg-white py-14 text-sm text-zinc-500">
            <div class="mx-auto grid w-full max-w-7xl grid-cols-2 gap-8 px-6 md:grid-cols-4 md:px-10 lg:px-12">
                <div>
                    <h3 class="mb-3 text-xs font-semibold uppercase tracking-wide text-black">Shop</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('produk.index') }}" class="hover:underline">Racket</a></li>
                        <li><a href="{{ route('produk.index') }}" class="hover:underline">Shoes</a></li>
                        <li><a href="{{ route('produk.index') }}" class="hover:underline">Apparel</a></li>
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

        @keyframes npMarquee {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(calc(-50% - 0.5rem));
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function () {
            const revealEls = document.querySelectorAll('.np-fade-section');
            const heroImages = document.querySelectorAll('.np-parallax-image');
            const layoutSections = document.querySelectorAll('[data-featured-toggle]');
            const galleryShowcase = document.querySelector('[data-gallery-showcase]');

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

            const layoutClasses = {
                list: ['flex', 'flex-col', 'space-y-4'],
                '2col': ['grid', 'grid-cols-1', 'gap-4', 'md:grid-cols-2'],
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
        })();
    </script>
@endpush
