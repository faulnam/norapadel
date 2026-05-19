@extends('layouts.app')

@section('title', 'Reward & Points - NoraPadel')

@section('content')
<div class="bg-white text-black antialiased">
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
                <a href="{{ route('contact') }}"
                        class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Contact</a>
            </nav>

            <div class="flex items-center gap-3 text-black/80">
                <a href="{{ route('customer.orders.index') }}" class="transition duration-300 hover:text-black" title="Riwayat Pesanan">
                <i class="fas fa-history text-sm"></i>
            </a>
                <a href="{{ route('customer.profile.index') }}" class="transition duration-300 hover:text-black" aria-label="Profile">
                    <i class="fas fa-user text-sm"></i>
                </a>
                <a href="{{ route('customer.cart.index') }}" class="transition duration-300 hover:text-black" aria-label="Cart">
                    <i class="fas fa-shopping-bag text-sm"></i>
                </a>
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-black/15 text-black transition duration-300 hover:border-black/35 md:hidden" data-mobile-menu-toggle aria-label="Toggle navigation" aria-expanded="false">
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

    <div class="mx-auto w-full max-w-7xl px-6 py-8 pt-16 md:px-10 md:py-12 md:pt-0 lg:px-12 lg:py-16">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-3xl font-semibold tracking-tight text-black sm:text-4xl">
                    <i class="fas fa-gift mr-3 text-black"></i>Reward & Points
                </h3>
                <p class="mt-1 text-sm text-zinc-500">Kelola poin loyalitas dan lihat riwayat transaksi poin Anda</p>
            </div>
            <a href="{{ route('customer.profile.index') }}" class="inline-flex items-center gap-2 rounded-full border border-black/10 bg-white px-4 py-2 text-sm font-medium text-black transition hover:bg-black hover:text-white">
                <i class="fas fa-arrow-left text-xs"></i> Kembali ke Profile
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Left: Points Summary -->
            <div class="space-y-6 lg:col-span-1">
                <!-- Total Points Card -->
                <div class="overflow-hidden rounded-2xl border border-black/6 bg-white shadow-sm">
                    <div class="bg-gradient-to-br from-violet-500 to-purple-600 px-6 py-8 text-white">
                        <div class="mb-4 flex items-center gap-2">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20">
                                <i class="fas fa-coins text-lg"></i>
                            </div>
                            <span class="text-sm font-medium text-white/90">Total Point</span>
                        </div>
                        <div class="mb-1 text-4xl font-bold tracking-tight">
                            {{ number_format($user->points) }} Points
                        </div>
                        <div class="text-sm text-white/80">
                            Setara dengan {{ $user->formatted_points_value }}
                        </div>
                    </div>
                    <div class="px-6 py-5">
                        <div class="mb-3 flex items-center justify-between">
                            <span class="text-sm text-zinc-500">Nilai Tukar</span>
                            <span class="text-sm font-semibold text-black">1 Point = Rp100</span>
                        </div>
                        <div class="rounded-xl bg-zinc-50 p-4">
                            <div class="text-xs text-zinc-500 mb-2">Contoh penggunaan:</div>
                            <div class="text-sm text-zinc-700">
                                <div class="flex justify-between py-1">
                                    <span>100 Points</span>
                                    <span class="font-medium text-black">Rp10.000</span>
                                </div>
                                <div class="flex justify-between py-1">
                                    <span>200 Points</span>
                                    <span class="font-medium text-black">Rp20.000</span>
                                </div>
                                <div class="flex justify-between py-1">
                                    <span>500 Points</span>
                                    <span class="font-medium text-black">Rp50.000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="overflow-hidden rounded-2xl border border-black/6 bg-white shadow-sm">
                    <div class="border-b border-black/6 bg-zinc-50 px-6 py-4">
                        <h4 class="text-sm font-semibold text-black">Ringkasan</h4>
                    </div>
                    <div class="px-6 py-5">
                        @php
                            $totalEarned = $user->pointTransactions()->where('points', '>', 0)->sum('points');
                            $totalRedeemed = abs($user->pointTransactions()->where('points', '<', 0)->sum('points'));
                        @endphp
                        <div class="grid grid-cols-2 gap-4">
                            <div class="rounded-xl bg-emerald-50 p-4 text-center">
                                <div class="mb-1 text-2xl font-bold text-emerald-600">+{{ number_format($totalEarned) }}</div>
                                <div class="text-xs text-emerald-700">Point Masuk</div>
                            </div>
                            <div class="rounded-xl bg-rose-50 p-4 text-center">
                                <div class="mb-1 text-2xl font-bold text-rose-600">-{{ number_format($totalRedeemed) }}</div>
                                <div class="text-xs text-rose-700">Point Keluar</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Point History -->
            <div class="lg:col-span-2">
                <div class="overflow-hidden rounded-2xl border border-black/6 bg-white shadow-sm">
                    <div class="border-b border-black/6 bg-zinc-50 px-6 py-4">
                        <h4 class="text-lg font-semibold text-black"><i class="fas fa-history mr-2"></i>Riwayat Point</h4>
                    </div>

                    <div class="divide-y divide-black/6">
                        @forelse($pointTransactions as $transaction)
                            <div class="flex items-start gap-4 px-6 py-4 transition hover:bg-zinc-50/50">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full {{ $transaction->points > 0 ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
                                    <i class="fas {{ $transaction->points > 0 ? 'fa-plus' : 'fa-minus' }}"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <div>
                                            <div class="text-sm font-semibold text-black">
                                                @if($transaction->points > 0)
                                                    +{{ number_format($transaction->points) }} Points
                                                @else
                                                    {{ number_format($transaction->points) }} Points
                                                @endif
                                            </div>
                                            <div class="mt-0.5 text-sm text-zinc-500">{{ $transaction->description ?? '-' }}</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xs text-zinc-400">{{ $transaction->created_at->format('d M Y') }}</div>
                                            <div class="mt-0.5 text-xs text-zinc-400">{{ $transaction->created_at->format('H:i') }}</div>
                                        </div>
                                    </div>
                                    @if($transaction->order_id)
                                        <div class="mt-1">
                                            <a href="{{ route('customer.orders.show', $transaction->order_id) }}" class="inline-flex items-center gap-1 text-xs font-medium text-violet-600 transition hover:text-violet-800">
                                                <i class="fas fa-receipt"></i> Order #{{ $transaction->order_id }}
                                            </a>
                                        </div>
                                    @endif
                                    <div class="mt-1 text-xs text-zinc-400">
                                        Saldo: {{ number_format($transaction->balance_before) }} &rarr; {{ number_format($transaction->balance_after) }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-12 text-center">
                                <div class="mb-3 inline-flex h-16 w-16 items-center justify-center rounded-full bg-zinc-100">
                                    <i class="fas fa-coins text-2xl text-zinc-300"></i>
                                </div>
                                <h5 class="mb-1 text-base font-semibold text-black">Belum Ada Riwayat Point</h5>
                                <p class="text-sm text-zinc-500">Riwayat transaksi point Anda akan muncul di sini.</p>
                            </div>
                        @endforelse
                    </div>

                    @if($pointTransactions->hasPages())
                        <div class="border-t border-black/6 px-6 py-4">
                            {{ $pointTransactions->links() }}
                        </div>
                    @endif
                </div>

                <!-- How to Earn -->
                <div class="mt-6 overflow-hidden rounded-2xl border border-black/6 bg-white shadow-sm">
                    <div class="border-b border-black/6 bg-zinc-50 px-6 py-4">
                        <h4 class="text-lg font-semibold text-black"><i class="fas fa-lightbulb mr-2"></i>Cara Mendapatkan Point</h4>
                    </div>
                    <div class="px-6 py-5">
                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="rounded-xl border border-black/6 p-4 text-center transition hover:shadow-sm">
                                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-blue-50 text-blue-600">
                                    <i class="fas fa-user-plus text-lg"></i>
                                </div>
                                <div class="text-sm font-semibold text-black">Bonus Akun</div>
                                <div class="mt-1 text-xs text-zinc-500">Dapatkan point bonus saat pertama kali mendaftar</div>
                            </div>
                            <div class="rounded-xl border border-black/6 p-4 text-center transition hover:shadow-sm">
                                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                                    <i class="fas fa-shopping-bag text-lg"></i>
                                </div>
                                <div class="text-sm font-semibold text-black">Cashback Order</div>
                                <div class="mt-1 text-xs text-zinc-500">Dapatkan cashback dari setiap pembelian yang berhasil</div>
                            </div>
                            <div class="rounded-xl border border-black/6 p-4 text-center transition hover:shadow-sm">
                                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-amber-50 text-amber-600">
                                    <i class="fas fa-star text-lg"></i>
                                </div>
                                <div class="text-sm font-semibold text-black">Promo Khusus</div>
                                <div class="mt-1 text-xs text-zinc-500">Ikuti promo tertentu untuk mendapatkan bonus point</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="border-t border-black/10 bg-white py-10 text-sm text-zinc-500">
        <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
            <div class="hidden grid-cols-2 gap-8 md:grid md:grid-cols-4">
                <div>
                    <h3 class="mb-3 text-xs font-semibold uppercase tracking-wide text-black">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('policy') }}" class="hover:underline">Policy</a></li>
                        <li><a href="{{ route('return-refund') }}" class="hover:underline">Return & Refund</a></li>
                        <li><a href="{{ route('guarantee') }}" class="hover:underline">Nora Guarantee</a></li>
                        <li><a href="{{ route('help-center') }}" class="hover:underline">Help Center</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-3 text-xs font-semibold uppercase tracking-wide text-black">Account</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('customer.profile.index') }}" class="hover:underline">Profile</a></li>
                        <li><a href="{{ route('customer.orders.index') }}" class="hover:underline">Orders</a></li>
                    </ul>
                </div>
            </div>
            <div class="space-y-2 md:hidden">
                <details class="group rounded-xl border border-black/10 bg-white px-4 py-3">
                    <summary class="flex cursor-pointer list-none items-center justify-between text-xs font-semibold uppercase tracking-wide text-black">
                        Support
                        <i class="fas fa-chevron-down text-[10px] text-zinc-500 transition group-open:rotate-180"></i>
                    </summary>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li><a href="{{ route('policy') }}" class="hover:underline">Policy</a></li>
                        <li><a href="{{ route('return-refund') }}" class="hover:underline">Return & Refund</a></li>
                        <li><a href="{{ route('guarantee') }}" class="hover:underline">Nora Guarantee</a></li>
                        <li><a href="{{ route('help-center') }}" class="hover:underline">Help Center</a></li>
                    </ul>
                </details>
                <details class="group rounded-xl border border-black/10 bg-white px-4 py-3">
                    <summary class="flex cursor-pointer list-none items-center justify-between text-xs font-semibold uppercase tracking-wide text-black">
                        Account
                        <i class="fas fa-chevron-down text-[10px] text-zinc-500 transition group-open:rotate-180"></i>
                    </summary>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li><a href="{{ route('customer.profile.index') }}" class="hover:underline">Profile</a></li>
                        <li><a href="{{ route('customer.orders.index') }}" class="hover:underline">Orders</a></li>
                    </ul>
                </details>
            </div>
            <div class="mx-auto mt-8 w-full max-w-7xl border-t border-black/10 px-6 pt-5 text-xs text-zinc-400 md:px-10 lg:px-12 text-center">
                © {{ now()->year }} NoraPadel. All rights reserved.
            </div>
        </div>
    </footer>
</div>

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
@endpush

@push('scripts')
<script>
(function() {
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
@endsection
