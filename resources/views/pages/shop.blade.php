@extends('layouts.app')

@section('title', 'NoraPadel Shop — Curated Performance Collection')

@section('content')
    <div class="bg-white text-black antialiased">
        <header class="sticky top-0 z-50 border-b border-black/6 bg-white/80 backdrop-blur-xl">
            <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
                <a href="{{ route('home') }}" class="text-xl font-semibold tracking-tight text-black">NoraPadel</a>

                <nav class="hidden items-center gap-8 md:flex">
                    <a href="{{ route('home') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Home</a>
                    <a href="{{ route('racket') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Racket</a>
                    <a href="{{ route('shoes') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Shoes</a>
                    <a href="{{ route('apparel') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Accessories</a>
                    <a href="{{ route('shop') }}" class="border-b border-black text-sm text-black transition duration-300">Shop</a>
                </nav>

                <div class="flex items-center gap-3 text-black/80">
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
                    <button
                        type="button"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-black/15 text-black transition duration-300 hover:border-black/35 md:hidden"
                        data-mobile-menu-toggle
                        aria-label="Toggle navigation"
                        aria-expanded="false"
                    >
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
                    <a href="{{ route('shop') }}" class="rounded-lg bg-black/5 px-2 py-1.5 text-black">Shop</a>
                </nav>
            </div>
        </header>

        <section class="np-fade-section bg-white py-16 lg:py-20">
            <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                

                @foreach($sections as $sectionIndex => $section)
                    <section class="mb-14 last:mb-0 rounded-3xl border border-black/6 bg-zinc-50/40 p-3 md:p-4" data-shop-showcase data-parallax data-parallax-speed="0.022">
                        

                        @if($section['latest'])
                            <button
                                type="button"
                                class="group relative block w-full overflow-hidden rounded-2xl border border-black/8 bg-white text-start shadow-[0_12px_34px_rgba(0,0,0,0.08)]"
                                data-parallax
                                data-parallax-speed="0.028"
                                data-product-trigger
                                data-product-id="{{ $section['latest']->id }}"
                                data-product-name="{{ e($section['latest']->name) }}"
                                data-product-category="{{ e($section['latest']->category_label) }}"
                                data-product-description="{{ e(\Illuminate\Support\Str::limit(strip_tags($section['latest']->description ?? ''), 180)) }}"
                                data-product-image="{{ $section['latest']->image ? asset('storage/' . $section['latest']->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80' }}"
                                data-product-price="{{ $section['latest']->hasActiveDiscount() ? $section['latest']->formatted_discounted_price : $section['latest']->formatted_price }}"
                                data-product-old-price="{{ $section['latest']->hasActiveDiscount() ? $section['latest']->formatted_price : '' }}"
                            >
                                <img
                                    src="{{ $section['latest']->image ? asset('storage/' . $section['latest']->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80' }}"
                                    alt="{{ $section['latest']->name }}"
                                    class="h-80 w-full object-cover transition duration-500 group-hover:scale-105 md:h-96"
                                    loading="lazy"
                                >
                                <div class="absolute inset-0 bg-linear-to-t from-black/65 via-black/20 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-4 text-white md:p-6">
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-white/80">Produk Terbaru</p>
                                    <h3 class="mt-2 text-2xl font-semibold tracking-tight md:text-3xl">{{ $section['latest']->name }}</h3>
                                    <p class="mt-2 text-sm text-white/85 md:text-base">{{ \Illuminate\Support\Str::limit($section['latest']->description, 120) }}</p>
                                </div>
                            </button>
                        @endif

                        <div class="relative mt-5">
                            <div class="pointer-events-none absolute inset-y-0 left-0 z-10 w-10 bg-linear-to-r from-zinc-50 to-transparent"></div>
                            <div class="pointer-events-none absolute inset-y-0 right-0 z-10 w-10 bg-linear-to-l from-zinc-50 to-transparent"></div>

                            <button
                                type="button"
                                class="shop-slide-btn absolute left-2 top-1/2 z-20 inline-flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-full border border-black/10 bg-white/90 text-zinc-700 shadow transition hover:bg-white"
                                data-slide-prev
                                aria-label="Geser kiri"
                            >
                                <i class="fas fa-chevron-left text-xs"></i>
                            </button>

                            <div class="overflow-x-auto scroll-smooth px-10 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" data-slide-container>
                                <div class="flex gap-4 py-1" data-slide-track>
                                    @forelse($section['others'] as $product)
                                        <button
                                            type="button"
                                            class="group block w-56 shrink-0 overflow-hidden rounded-xl border border-black/6 bg-white text-start shadow-[0_6px_22px_rgba(0,0,0,0.06)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_12px_28px_rgba(0,0,0,0.1)]"
                                            data-parallax
                                            data-parallax-speed="0.018"
                                            data-product-trigger
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ e($product->name) }}"
                                            data-product-category="{{ e($product->category_label) }}"
                                            data-product-description="{{ e(\Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 180)) }}"
                                            data-product-image="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80' }}"
                                            data-product-price="{{ $product->hasActiveDiscount() ? $product->formatted_discounted_price : $product->formatted_price }}"
                                            data-product-old-price="{{ $product->hasActiveDiscount() ? $product->formatted_price : '' }}"
                                        >
                                            <div class="relative">
                                                <img
                                                    src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80' }}"
                                                    alt="{{ $product->name }}"
                                                    class="aspect-4/5 w-full object-cover transition duration-500 group-hover:scale-105"
                                                    loading="lazy"
                                                >
                                                @if($product->hasActiveDiscount())
                                                    <span class="absolute left-3 top-3 rounded-full bg-rose-500 px-2.5 py-1 text-[11px] font-semibold text-white">-{{ $product->formatted_discount_percent }}</span>
                                                @endif
                                            </div>
                                            <div class="p-3">
                                                <p class="line-clamp-1 text-sm font-semibold tracking-tight text-zinc-800">{{ $product->name }}</p>
                                                <p class="mt-1 text-xs text-zinc-500">{{ $product->category_label }}</p>
                                            </div>
                                        </button>
                                    @empty
                                        <div class="w-full rounded-xl border border-dashed border-zinc-300 bg-white p-6 text-center text-zinc-500">Belum ada produk tambahan untuk kategori ini.</div>
                                    @endforelse
                                </div>
                            </div>

                            <button
                                type="button"
                                class="shop-slide-btn absolute right-2 top-1/2 z-20 inline-flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-full border border-black/10 bg-white/90 text-zinc-700 shadow transition hover:bg-white"
                                data-slide-next
                                aria-label="Geser kanan"
                            >
                                <i class="fas fa-chevron-right text-xs"></i>
                            </button>
                        </div>
                    </section>
                @endforeach
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

        [data-parallax] {
            will-change: transform;
            transform: translate3d(0, 0, 0);
            transition: transform 420ms cubic-bezier(0.22, 1, 0.36, 1);
        }

        @media (prefers-reduced-motion: reduce) {
            [data-parallax] {
                transition: none;
                transform: none !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function () {
            const revealEls = document.querySelectorAll('.np-fade-section');
            const mobileMenuToggle = document.querySelector('[data-mobile-menu-toggle]');
            const mobileMenu = document.querySelector('[data-mobile-menu]');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, { threshold: 0.12 });

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
                    container.scrollBy({ left: -getStep(), behavior: 'smooth' });
                });

                nextBtn.addEventListener('click', () => {
                    container.scrollBy({ left: getStep(), behavior: 'smooth' });
                });
            });

            const parallaxEls = Array.from(document.querySelectorAll('[data-parallax]'));
            const canAnimate = !window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (canAnimate && parallaxEls.length) {
                let ticking = false;

                const updateParallax = () => {
                    const viewportH = window.innerHeight || document.documentElement.clientHeight;

                    parallaxEls.forEach((el) => {
                        const speed = Number.parseFloat(el.dataset.parallaxSpeed || '0.02') || 0.02;
                        const rect = el.getBoundingClientRect();
                        const centerY = rect.top + (rect.height / 2);
                        const offsetFromCenter = centerY - (viewportH / 2);
                        const rawShift = -offsetFromCenter * speed;
                        const maxShift = 18;
                        const shift = Math.max(-maxShift, Math.min(maxShift, rawShift));
                        el.style.transform = `translate3d(0, ${shift.toFixed(2)}px, 0)`;
                    });

                    ticking = false;
                };

                const requestTick = () => {
                    if (!ticking) {
                        window.requestAnimationFrame(updateParallax);
                        ticking = true;
                    }
                };

                window.addEventListener('scroll', requestTick, { passive: true });
                window.addEventListener('resize', requestTick);
                requestTick();
            }

            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                    mobileMenuToggle.setAttribute('aria-expanded', String(!mobileMenu.classList.contains('hidden')));
                });
            }
        })();
    </script>
@endpush
