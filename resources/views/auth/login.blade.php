@extends('layouts.app')

@section('title', 'Login - Nora Padel')

@section('content')
    <div class="min-h-screen bg-[#f5f5f7] text-black antialiased">
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
                    <a href="{{ route('register') }}" class="hidden rounded-full border border-black/15 px-3 py-1.5 text-xs font-medium text-black/80 transition duration-300 hover:border-black/30 hover:text-black md:inline-flex md:items-center md:gap-1">
                        <i class="fas fa-user-plus text-[11px]"></i>
                        <span>Daftar</span>
                    </a>
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
                    <a href="{{ route('register') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Daftar</a>
                </nav>
            </div>
        </header>

        <section class="px-6 py-10 md:px-10 lg:px-12 lg:py-14">
            <div class="mx-auto grid w-full max-w-7xl gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                <div class="hidden rounded-3xl border border-black/8 bg-white p-8 shadow-[0_16px_42px_rgba(0,0,0,0.08)] lg:block">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-black/50">Welcome back</p>
                    <h1 class="mt-3 text-4xl font-semibold tracking-tight text-black">Masuk dan lanjutkan permainan terbaikmu.</h1>
                    <p class="mt-4 max-w-xl text-zinc-600">Akses riwayat pesanan, checkout cepat, dan rekomendasi produk pilihan NoraPadel dengan pengalaman yang premium.</p>
                    <div class="mt-8 overflow-hidden rounded-2xl border border-black/10">
                        <img src="{{ asset('storage/2.png') }}" alt="NoraPadel" class="h-64 w-full object-cover">
                    </div>
                </div>

                <div class="rounded-3xl border border-black/8 bg-white p-6 shadow-[0_16px_42px_rgba(0,0,0,0.08)] sm:p-8 lg:p-9">
                    <div class="mb-6 text-center">
                        <img src="{{ asset(config('branding.logo', 'storage/logo.png')) }}" alt="{{ config('branding.name', 'Nora Padel') }}" class="mx-auto h-12 w-auto">
                        <h2 class="mt-4 text-2xl font-semibold tracking-tight text-black">Masuk ke akun Anda</h2>
                        <p class="mt-2 text-sm text-zinc-600">Gunakan email dan password untuk melanjutkan.</p>
                    </div>

                    @if($errors->any())
                        <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            <ul class="list-disc space-y-1 pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-zinc-700">Email</label>
                            <div class="flex items-center gap-2 rounded-xl border border-black/10 bg-white px-3 focus-within:border-black/30">
                                <i class="fas fa-envelope text-xs text-zinc-400"></i>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    class="w-full border-0 bg-transparent py-3 text-sm text-black outline-none focus:ring-0"
                                    placeholder="email@contoh.com"
                                >
                            </div>
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-medium text-zinc-700">Password</label>
                            <div class="flex items-center gap-2 rounded-xl border border-black/10 bg-white px-3 focus-within:border-black/30">
                                <i class="fas fa-lock text-xs text-zinc-400"></i>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    class="w-full border-0 bg-transparent py-3 text-sm text-black outline-none focus:ring-0"
                                    placeholder="Masukkan password"
                                >
                            </div>
                        </div>

                        <label class="inline-flex cursor-pointer items-center gap-2 text-sm text-zinc-600">
                            <input type="checkbox" id="remember" name="remember" class="h-4 w-4 rounded border-zinc-300 text-black focus:ring-zinc-300">
                            <span>Ingat saya</span>
                        </label>

                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-black px-5 py-3 text-sm font-medium text-white transition duration-300 hover:bg-zinc-800">
                            <i class="fas fa-sign-in-alt mr-2 text-xs"></i>Masuk
                        </button>
                    </form>

                    <p class="mt-6 text-center text-sm text-zinc-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-medium text-black underline decoration-black/30 underline-offset-4 transition hover:decoration-black">Daftar Sekarang</a>
                    </p>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('styles')
    <script src="https://cdn.tailwindcss.com"></script>
@endpush

@push('scripts')
    <script>
        (function () {
            const toggle = document.querySelector('[data-mobile-menu-toggle]');
            const menu = document.querySelector('[data-mobile-menu]');
            if (!toggle || !menu) return;

            toggle.addEventListener('click', function () {
                const isOpen = toggle.getAttribute('aria-expanded') === 'true';
                toggle.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
                menu.classList.toggle('hidden', isOpen);
            });
        })();
    </script>
@endpush
