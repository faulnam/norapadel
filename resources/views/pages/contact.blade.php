@extends('layouts.app')

@section('title', 'Contact - NoraPadel')

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
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-black sm:text-4xl">Contact NoraPadel</h1>
                    <p class="mt-4 text-zinc-600">Kirimkan pertanyaan Anda. Kami akan merespons secepat mungkin pada jam operasional.</p>
                </div>

                <div class="mx-auto mt-12 grid max-w-5xl gap-8 lg:grid-cols-[1fr_1.35fr]">
                    <div class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-black">Informasi Kontak</h2>
                        <ul class="mt-5 space-y-3 text-sm text-zinc-600">
                            <li><span class="font-medium text-black">WhatsApp:</span> {{ config('branding.phone', '+62 812 7788 9900') }}</li>
                            <li><span class="font-medium text-black">Email:</span> support@norapadel.com</li>
                            <li><span class="font-medium text-black">Alamat:</span> {{ config('branding.address', 'Jl. Padel Arena No. 21, Surabaya') }}</li>
                        </ul>
                    </div>

                    <form method="POST" action="{{ route('contact.submit') }}" class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
                        @csrf
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <label for="name" class="mb-2 block text-sm font-medium text-zinc-700">Nama</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" required class="w-full rounded-xl border border-zinc-300 px-4 py-2.5 text-sm outline-none transition focus:border-black" />
                                @error('name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="sm:col-span-1">
                                <label for="email" class="mb-2 block text-sm font-medium text-zinc-700">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-zinc-300 px-4 py-2.5 text-sm outline-none transition focus:border-black" />
                                @error('email')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="subject" class="mb-2 block text-sm font-medium text-zinc-700">Subjek</label>
                                <input id="subject" name="subject" type="text" value="{{ old('subject') }}" required class="w-full rounded-xl border border-zinc-300 px-4 py-2.5 text-sm outline-none transition focus:border-black" />
                                @error('subject')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="message" class="mb-2 block text-sm font-medium text-zinc-700">Pesan</label>
                                <textarea id="message" name="message" rows="5" required class="w-full rounded-xl border border-zinc-300 px-4 py-2.5 text-sm outline-none transition focus:border-black">{{ old('message') }}</textarea>
                                @error('message')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <button type="submit" class="mt-6 inline-flex rounded-full bg-black px-5 py-2.5 text-sm font-medium text-white transition hover:bg-zinc-800">Kirim Pesan</button>
                    </form>
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
