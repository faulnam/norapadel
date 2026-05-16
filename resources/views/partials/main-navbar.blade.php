<!-- Marquee Text -->
<div class="fixed top-0 left-0 right-0 z-[60] bg-white text-black py-2 overflow-hidden transition-all duration-300 border-b border-zinc-200" id="marqueeBar">
    <div class="marquee-container">
        <div class="marquee-content">
            <span class="marquee-item">NORAPADEL PREMIUM • PRECISION. POWER. PERFORMANCE. • </span>
            <span class="marquee-item">NORAPADEL PREMIUM • PRECISION. POWER. PERFORMANCE. • </span>
            <span class="marquee-item">NORAPADEL PREMIUM • PRECISION. POWER. PERFORMANCE. • </span>
            <span class="marquee-item">NORAPADEL PREMIUM • PRECISION. POWER. PERFORMANCE. • </span>
            <span class="marquee-item">NORAPADEL PREMIUM • PRECISION. POWER. PERFORMANCE. • </span>
            <span class="marquee-item">NORAPADEL PREMIUM • PRECISION. POWER. PERFORMANCE. • </span>
        </div>
    </div>
</div>

<header class="fixed left-0 top-8 z-50 w-full border-b border-black/10 bg-white/90 backdrop-blur-md transition-all duration-300" id="mainHeader">
    <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ asset('storage/logo.png') }}" alt="NoraPadel" class="h-7 w-7 object-contain" loading="lazy">
            <span class="text-xl font-semibold tracking-tight text-black" id="logoText">NoraPadel</span>
        </a>

        <nav class="hidden items-center gap-8 md:flex" id="navLinks">
            <a href="{{ route('home') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Home</a>

            <!-- New Arrivals Mega Dropdown -->
            <div class="relative group" data-dropdown="new-arrivals">
                <a href="{{ route('new-arrivals') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black flex items-center gap-1">
                    New Arrivals
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
                <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-50">
                    <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl border border-zinc-100 p-0 overflow-hidden aspect-video">
                        <div class="grid grid-cols-[1fr_1fr] h-full">
                            <div class="flex flex-col justify-center items-center bg-zinc-50/50 p-8 space-y-6">
                                <div class="w-full text-center">
                                    <h4 class="text-sm font-bold text-black mb-4 tracking-wide">BRAND</h4>
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <a href="{{ route('new-arrivals', ['brand' => 'Bullpadel']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Bullpadel</a>
                                        <a href="{{ route('new-arrivals', ['brand' => 'Babolat']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Babolat</a>
                                        <a href="{{ route('new-arrivals', ['brand' => 'Nox']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Nox</a>
                                        <a href="{{ route('new-arrivals', ['brand' => 'Alpha']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Alpha</a>
                                    </div>
                                </div>
                                <div class="w-full text-center">
                                    <h4 class="text-sm font-bold text-black mb-4 tracking-wide">LEVEL</h4>
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <a href="{{ route('new-arrivals', ['level' => 'beginner']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Beginner</a>
                                        <a href="{{ route('new-arrivals', ['level' => 'intermediate']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Intermediate</a>
                                        <a href="{{ route('new-arrivals', ['level' => 'pro']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Pro</a>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col justify-center items-center bg-zinc-50/50 p-8">
                                <div class="w-full text-center">
                                    <h4 class="text-sm font-bold text-black mb-4 tracking-wide">CATEGORY</h4>
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <a href="{{ route('racket') }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Racket</a>
                                        <a href="{{ route('shoes') }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Shoes</a>
                                        <a href="{{ route('apparel') }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Accessories</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Racket Mega Dropdown -->
            <div class="relative group" data-dropdown="racket">
                <a href="{{ route('racket') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black flex items-center gap-1">
                    Racket
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
                <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-50">
                    <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl border border-zinc-100 p-0 overflow-hidden aspect-video">
                        <div class="grid grid-cols-[1fr_1.2fr] h-full">
                            <div class="flex flex-col justify-center items-center bg-zinc-50/50 p-8 space-y-6">
                                <div class="w-full text-center">
                                    <h4 class="text-sm font-bold text-black mb-4 tracking-wide">BRAND</h4>
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <a href="{{ route('racket', ['brand' => 'Bullpadel']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Bullpadel</a>
                                        <a href="{{ route('racket', ['brand' => 'Babolat']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Babolat</a>
                                        <a href="{{ route('racket', ['brand' => 'Nox']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Nox</a>
                                        <a href="{{ route('racket', ['brand' => 'Alpha']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Alpha</a>
                                    </div>
                                </div>
                                <div class="w-full text-center">
                                    <h4 class="text-sm font-bold text-black mb-4 tracking-wide">LEVEL</h4>
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <a href="{{ route('racket', ['level' => 'beginner']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Beginner</a>
                                        <a href="{{ route('racket', ['level' => 'intermediate']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Intermediate</a>
                                        <a href="{{ route('racket', ['level' => 'pro']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Pro</a>
                                    </div>
                                </div>
                            </div>
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('storage/iconracket.jpg') }}" alt="Racket" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                <div class="absolute bottom-6 left-6 right-6">
                                    <h5 class="text-white font-bold text-2xl mb-1">Premium Rackets</h5>
                                    <p class="text-white/90 text-sm font-medium">Precision & Power</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shoes Mega Dropdown -->
            <div class="relative group" data-dropdown="shoes">
                <a href="{{ route('shoes') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black flex items-center gap-1">
                    Shoes
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
                <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-50">
                    <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl border border-zinc-100 p-0 overflow-hidden aspect-video">
                        <div class="grid grid-cols-[1fr_1.2fr] h-full">
                            <div class="flex flex-col justify-center items-center bg-zinc-50/50 p-8 space-y-6">
                                <div class="w-full text-center">
                                    <h4 class="text-sm font-bold text-black mb-4 tracking-wide">BRAND</h4>
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <a href="{{ route('shoes', ['brand' => 'Bullpadel']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Bullpadel</a>
                                        <a href="{{ route('shoes', ['brand' => 'Babolat']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Babolat</a>
                                        <a href="{{ route('shoes', ['brand' => 'Nox']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Nox</a>
                                        <a href="{{ route('shoes', ['brand' => 'Alpha']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Alpha</a>
                                    </div>
                                </div>
                                <div class="w-full text-center">
                                    <h4 class="text-sm font-bold text-black mb-4 tracking-wide">LEVEL</h4>
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <a href="{{ route('shoes', ['level' => 'beginner']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Beginner</a>
                                        <a href="{{ route('shoes', ['level' => 'intermediate']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Intermediate</a>
                                        <a href="{{ route('shoes', ['level' => 'pro']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Pro</a>
                                    </div>
                                </div>
                            </div>
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('storage/iconsepatu.png') }}" alt="Shoes" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                <div class="absolute bottom-6 left-6 right-6">
                                    <h5 class="text-white font-bold text-2xl mb-1">Premium Shoes</h5>
                                    <p class="text-white/90 text-sm font-medium">Move Faster, Play Smarter</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accessories Mega Dropdown -->
            <div class="relative group" data-dropdown="accessories">
                <a href="{{ route('apparel') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black flex items-center gap-1">
                    Accessories
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
                <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-50">
                    <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl border border-zinc-100 p-0 overflow-hidden aspect-video">
                        <div class="grid grid-cols-[1fr_1.2fr] h-full">
                            <div class="flex flex-col justify-center items-center bg-zinc-50/50 p-8 space-y-6">
                                <div class="w-full text-center">
                                    <h4 class="text-sm font-bold text-black mb-4 tracking-wide">BRAND</h4>
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <a href="{{ route('apparel', ['brand' => 'Bullpadel']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Bullpadel</a>
                                        <a href="{{ route('apparel', ['brand' => 'Babolat']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Babolat</a>
                                        <a href="{{ route('apparel', ['brand' => 'Nox']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Nox</a>
                                        <a href="{{ route('apparel', ['brand' => 'Alpha']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Alpha</a>
                                    </div>
                                </div>
                                <div class="w-full text-center">
                                    <h4 class="text-sm font-bold text-black mb-4 tracking-wide">LEVEL</h4>
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <a href="{{ route('apparel', ['level' => 'beginner']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Beginner</a>
                                        <a href="{{ route('apparel', ['level' => 'intermediate']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Intermediate</a>
                                        <a href="{{ route('apparel', ['level' => 'pro']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Pro</a>
                                    </div>
                                </div>
                            </div>
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('storage/icontas.jpg') }}" alt="Accessories" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                <div class="absolute bottom-6 left-6 right-6">
                                    <h5 class="text-white font-bold text-2xl mb-1">Premium Accessories</h5>
                                    <p class="text-white/90 text-sm font-medium">Comfort Meets Performance</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('contact') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Contact</a>
        </nav>

        <div class="flex items-center gap-3 text-black/80">
            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 rounded border border-black/15 bg-black px-4 py-1.5 text-xs font-medium text-white transition duration-300 hover:bg-black/90">
                        <i class="fas fa-arrow-left text-[10px]"></i>
                        <span>Dashboard</span>
                    </a>
                @elseif(auth()->user()->role === 'customer')
                    <a href="{{ route('customer.orders.index') }}" class="transition duration-300 hover:text-black" title="Order History">
                        <i class="fas fa-history text-sm"></i>
                    </a>
                    <a href="{{ route('customer.profile.index') }}" class="transition duration-300 hover:text-black" title="Profile">
                        <i class="fas fa-user text-sm"></i>
                    </a>
                @endif
            @endauth
            @guest
                <a href="{{ route('login') }}" class="inline-flex items-center gap-1 rounded border border-black/15 bg-white px-3 py-1.5 text-xs font-medium text-black transition duration-300 hover:bg-black/5">
                    <i class="fas fa-sign-in-alt text-[11px]"></i>
                    <span>Login</span>
                </a>
            @endguest

            <a href="{{ route('customer.wishlist.index') }}" class="relative transition duration-300 hover:text-black" title="Wishlist">
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
                    <span class="pointer-events-none absolute -right-2 -top-2 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white">{{ $wishlistCount > 9 ? '9+' : $wishlistCount }}</span>
                @endif
            </a>

            <a href="{{ route('customer.cart.index') }}" class="relative transition duration-300 hover:text-black" title="Cart">
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
                    <span class="pointer-events-none absolute -right-2 -top-2 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                @endif
            </a>

            <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded border border-black/15 bg-white text-black transition duration-300 hover:bg-black/5 md:hidden" data-mobile-menu-toggle aria-label="Toggle navigation" aria-expanded="false">
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
