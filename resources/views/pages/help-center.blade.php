@extends('layouts.app')

@section('title', 'Help Center - NoraPadel')

@section('content')
    <style>
        #mainNavbar {
            display: none !important;
        }
    </style>

    <div class="bg-white text-black antialiased">
        <header class="sticky top-0 z-50 border-b border-black/6 bg-white/80 backdrop-blur-xl">
            <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
                <a href="{{ route('home') }}" class="text-xl font-semibold tracking-tight text-black">NoraPadel</a>

                <nav class="hidden items-center gap-8 md:flex">
                    <a href="{{ route('home') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Home</a>
                    <a href="{{ route('racket') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Racket</a>
                    <a href="{{ route('shoes') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Shoes</a>
                    <a href="{{ route('apparel') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Accessories</a>
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
                    <a href="{{ route('home') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Home</a>
                    <a href="{{ route('racket') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Racket</a>
                    <a href="{{ route('shoes') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Shoes</a>
                    <a href="{{ route('apparel') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Accessories</a>
                </nav>
            </div>
        </header>

        <section class="bg-[#f8fafc] pt-8 pb-14 lg:pt-10 lg:pb-16">
            <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                <div class="mx-auto max-w-3xl text-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500">Support</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-black sm:text-4xl">Help Center</h1>
                    <p class="mt-4 text-zinc-600">Butuh bantuan seputar order, pengiriman, atau pembayaran? Temukan jawaban cepat di sini.</p>
                </div>

                <div class="mx-auto mt-12 grid max-w-5xl gap-5 md:grid-cols-2">
                    <article class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-black">Cara melacak pesanan</h2>
                        <p class="mt-3 text-sm leading-relaxed text-zinc-600">Masuk ke akun Anda, buka menu riwayat pesanan, lalu pilih order untuk melihat status pickup, pengiriman, hingga selesai.</p>
                    </article>
                    <article class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-black">Informasi pembayaran</h2>
                        <p class="mt-3 text-sm leading-relaxed text-zinc-600">Kami mendukung transfer bank, gateway pembayaran online, dan COD pada area tertentu sesuai kebijakan pengiriman.</p>
                    </article>
                    <article class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-black">Kebijakan retur</h2>
                        <p class="mt-3 text-sm leading-relaxed text-zinc-600">Pengajuan retur dapat dilakukan maksimal 7 hari setelah produk diterima, selama produk belum dipakai dan kemasan masih lengkap.</p>
                    </article>
                    <article class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-black">Masih butuh bantuan?</h2>
                        <p class="mt-3 text-sm leading-relaxed text-zinc-600">Tim support siap membantu Anda melalui halaman kontak untuk pertanyaan teknis maupun konsultasi produk.</p>
                        <a href="{{ route('contact') }}" class="mt-4 inline-flex rounded-full bg-black px-4 py-2 text-sm font-medium text-white transition hover:bg-zinc-800">Hubungi Kami</a>
                    </article>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            const mobileMenuToggle = document.querySelector('[data-mobile-menu-toggle]');
            const mobileMenu = document.querySelector('[data-mobile-menu]');

            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                    mobileMenuToggle.setAttribute('aria-expanded', String(!mobileMenu.classList.contains('hidden')));
                });
            }
        })();
    </script>
@endpush
