<!-- Luxury Navbar Component -->
<!-- Header / Navbar -->
<header class="fixed left-0 top-0 z-[70] w-full border-b border-black/6 bg-white/80 backdrop-blur-xl transition-all duration-300 overflow-visible" id="mainHeader">
        <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-3 md:px-10 lg:px-12">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('storage/logo.png') }}" alt="NoraPadel" class="h-7 w-7 object-contain" loading="lazy">
                <span class="text-xl font-semibold tracking-tight text-black transition-colors duration-300" id="logoText">NoraPadel</span>
            </a>

            <nav class="hidden items-center gap-8 md:flex relative z-50" id="navLinks">
                <a href="{{ route('home') }}"
                    class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Home</a>

                <!-- New Arrivals Mega Dropdown -->
                <div class="relative group" data-dropdown="new-arrivals">
                    <a href="{{ route('new-arrivals') }}"
                        class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black flex items-center gap-1">
                        New Arrivals
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-[100]">
                        <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl border border-zinc-100 p-0 overflow-hidden aspect-video">
                            <div class="grid grid-cols-[1fr_1.2fr] h-full">
                                <div class="flex flex-col justify-center items-center bg-zinc-50/50 p-8 space-y-6">
                                    <div class="w-full text-center">
                                        <h4 class="text-sm font-bold text-black mb-4 tracking-wide">BRAND</h4>
                                        <div class="flex flex-wrap justify-center gap-2">
                                            <a href="{{ route('new-arrivals', ['brand' => 'Bullpadel']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Bullpadel</a>
                                            <a href="{{ route('new-arrivals', ['brand' => 'Babolat']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Babolat</a>
                                            <a href="{{ route('new-arrivals', ['brand' => 'Nox']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Nox</a>
                                            <a href="{{ route('new-arrivals', ['brand' => 'Alpha']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Alpha</a>
                                            <a href="{{ route('new-arrivals', ['brand' => 'Zephyr']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Zephyr</a>
                                            <a href="{{ route('new-arrivals', ['brand' => 'Arronax']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Arronax</a>
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
                    <a href="{{ route('racket') }}"
                        class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black flex items-center gap-1">
                        Racket
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-[100]">
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
                                            <a href="{{ route('racket', ['brand' => 'Zephyr']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Zephyr</a>
                                            <a href="{{ route('racket', ['brand' => 'Arronax']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Arronax</a>
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
                                    <img src="{{ asset('storage/iconracket.jpg') }}" alt="Racket Collection" class="w-full h-full object-cover">
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
                    <a href="{{ route('shoes') }}"
                        class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black flex items-center gap-1">
                        Shoes
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-[100]">
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
                                            <a href="{{ route('shoes', ['brand' => 'Zephyr']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Zephyr</a>
                                            <a href="{{ route('shoes', ['brand' => 'Arronax']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Arronax</a>
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
                                    <img src="{{ asset('storage/iconsepatu.png') }}" alt="Shoes Collection" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                    <div class="absolute bottom-6 left-6 right-6">
                                        <h5 class="text-white font-bold text-2xl mb-1">Premium Shoes</h5>
                                        <p class="text-white/90 text-sm font-medium">Agility & Speed</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Accessories Mega Dropdown -->
                <div class="relative group" data-dropdown="apparel">
                    <a href="{{ route('apparel') }}"
                        class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black flex items-center gap-1">
                        Accessories
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-[100]">
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
                                            <a href="{{ route('apparel', ['brand' => 'Zephyr']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Zephyr</a>
                                            <a href="{{ route('apparel', ['brand' => 'Arronax']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Arronax</a>
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
                                    <img src="{{ asset('storage/icontas.jpg') }}" alt="Accessories Collection" class="w-full h-full object-cover">
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

                <a href="{{ route('contact') }}"
                    class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Contact</a>
            </nav>

            <div class="flex items-center gap-2 md:gap-3 text-black/80" id="navIcons">
                <!-- Inline Search (all screens) -->
                <div class="flex items-center relative" id="navSearchWrapper">
                    <i class="fas fa-search absolute left-2 md:left-3 text-xs md:text-sm text-zinc-400 pointer-events-none transition-colors duration-300" id="navSearchIcon"></i>
                    <input type="text" id="navSearchInput" placeholder="Cari..."
                           class="bg-zinc-50 border border-zinc-200 rounded-full pl-7 md:pl-9 pr-2 md:pr-4 py-1 md:py-1.5 text-xs md:text-sm text-black placeholder-zinc-400 focus:outline-none focus:bg-white focus:border-zinc-300 w-24 md:w-40 lg:w-48 transition-all duration-300"
                           autocomplete="off">
                </div>

                <!-- Login (desktop only) -->
                @guest
                    <a href="{{ route('login') }}" id="loginBtn" class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 bg-zinc-50 border border-zinc-200 rounded-full text-xs font-semibold text-black transition duration-300 hover:bg-zinc-100 hover:border-zinc-300">
                        <i class="fas fa-sign-in-alt text-sm"></i>
                        <span>Login</span>
                    </a>
                @endauth

                <!-- Cart (desktop only) -->
                <a href="{{ route('customer.cart.index') }}" class="hidden md:relative transition duration-300 hover:text-black">
                    <i class="fas fa-shopping-bag text-sm"></i>
                    @auth
                        @if (auth()->user()->role === 'customer')
                            @php $cartCount = auth()->user()->cartItems()->sum('quantity'); @endphp
                            @if ($cartCount > 0)
                                <span class="cart-badge absolute -right-1.5 -top-1.5 flex h-3 w-3 items-center justify-center rounded-full bg-rose-500 text-[9px] font-bold text-white">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                            @endif
                        @endif
                    @endauth
                    @guest
                        @php 
                            $guestCart = session()->get('guest_cart', []);
                            $guestCartCount = array_sum(array_column($guestCart, 'quantity'));
                        @endphp
                        @if($guestCartCount > 0)
                            <span class="cart-badge absolute -right-1.5 -top-1.5 flex h-3 w-3 items-center justify-center rounded-full bg-rose-500 text-[9px] font-bold text-white">{{ $guestCartCount > 9 ? '9+' : $guestCartCount }}</span>
                        @endif
                    @endguest
                </a>

                <!-- Wishlist (mobile only) -->
                <a href="{{ route('customer.wishlist.index') }}" class="relative md:hidden transition duration-300 hover:text-black">
                    <i class="fas fa-heart text-black/80 text-sm"></i>
                    @php
                        if (auth()->check() && auth()->user()->role === 'customer') {
                            $wishlistCount = auth()->user()->wishlistItems()->count();
                        } else {
                            $guestWishlist = session()->get('guest_wishlist', []);
                            $wishlistCount = count($guestWishlist);
                        }
                    @endphp
                    @if($wishlistCount > 0)
                        <span class="wishlist-badge absolute -right-1.5 -top-1.5 flex h-3 w-3 items-center justify-center rounded-full bg-rose-500 text-[9px] font-bold text-white">{{ $wishlistCount > 9 ? '9+' : $wishlistCount }}</span>
                    @endif
                </a>

                <!-- Cart (mobile only) -->
                <a href="{{ route('customer.cart.index') }}" class="relative md:hidden transition duration-300 hover:text-black">
                    <i class="fas fa-shopping-bag text-black/80 text-sm"></i>
                    @auth
                        @if (auth()->user()->role === 'customer')
                            @php $cartCount = auth()->user()->cartItems()->sum('quantity'); @endphp
                            @if ($cartCount > 0)
                                <span class="cart-badge absolute -right-1.5 -top-1.5 flex h-3 w-3 items-center justify-center rounded-full bg-rose-500 text-[9px] font-bold text-white">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                            @endif
                        @endif
                    @endauth
                    @guest
                        @php 
                            $guestCart = session()->get('guest_cart', []);
                            $guestCartCount = array_sum(array_column($guestCart, 'quantity'));
                        @endphp
                        @if($guestCartCount > 0)
                            <span class="cart-badge absolute -right-1.5 -top-1.5 flex h-3 w-3 items-center justify-center rounded-full bg-rose-500 text-[9px] font-bold text-white">{{ $guestCartCount > 9 ? '9+' : $guestCartCount }}</span>
                        @endif
                    @endguest
                </a>

                <!-- Login (mobile only) -->
                @guest
                    <a href="{{ route('login') }}" class="md:hidden transition duration-300 hover:text-black">
                        <i class="fas fa-sign-in-alt text-black/80 text-sm"></i>
                    </a>
                @endauth

                <!-- Hamburger Menu with combined elements -->
                <div class="relative" id="hamburgerMenuWrapper">
                    <button type="button" id="hamburgerMenuBtn" class="inline-flex h-9 w-9 items-center justify-center rounded border border-black/15 bg-transparent text-black backdrop-blur transition duration-300 hover:border-black/30 relative">
                        <i class="fas fa-bars text-sm"></i>
                    </button>
                    <div id="hamburgerMenuDropdown" class="absolute right-0 mt-2 w-48 z-50 hidden">
                        <div class="bg-white rounded-lg shadow-lg border border-zinc-100 overflow-hidden">
                            <!-- Navigation (mobile only) -->
                            <div class="md:hidden">
                                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                    <i class="fas fa-home text-zinc-500 text-sm"></i>
                                    <span class="text-sm text-zinc-700">Home</span>
                                </a>
                                <a href="{{ route('new-arrivals') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                    <i class="fas fa-star text-zinc-500 text-sm"></i>
                                    <span class="text-sm text-zinc-700">New Arrivals</span>
                                </a>
                                <a href="{{ route('racket') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                    <i class="fas fa-table-tennis text-zinc-500 text-sm"></i>
                                    <span class="text-sm text-zinc-700">Racket</span>
                                </a>
                                <a href="{{ route('shoes') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                    <i class="fas fa-shoe-prints text-zinc-500 text-sm"></i>
                                    <span class="text-sm text-zinc-700">Shoes</span>
                                </a>
                                <a href="{{ route('apparel') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                    <i class="fas fa-tshirt text-zinc-500 text-sm"></i>
                                    <span class="text-sm text-zinc-700">Accessories</span>
                                </a>
                            </div>

                            <!-- Language Switcher -->
                            <div class="border-b border-zinc-100">
                                <div class="px-3 py-2 bg-zinc-50">
                                    <div class="flex gap-2">
                                        <a href="{{ request()->fullUrlWithQuery(['locale' => 'en']) }}" class="flex-1 px-2 py-1.5 text-xs text-zinc-700 hover:bg-white rounded transition {{ session('locale', 'en') === 'en' ? 'bg-white font-semibold' : 'bg-white/50' }}">
                                            EN
                                        </a>
                                        <a href="{{ request()->fullUrlWithQuery(['locale' => 'id']) }}" class="flex-1 px-2 py-1.5 text-xs text-zinc-700 hover:bg-white rounded transition {{ session('locale', 'en') === 'id' ? 'bg-white font-semibold' : 'bg-white/50' }}">
                                            ID
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Auth Section for logged-in users -->
                            @auth
                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-t border-zinc-100">
                                        <i class="fas fa-arrow-left text-zinc-500 text-sm"></i>
                                        <span class="text-sm text-zinc-700">Dashboard</span>
                                    </a>
                                @elseif(auth()->user()->role === 'customer')
                                    <a href="{{ route('customer.orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-t border-zinc-100">
                                        <i class="fas fa-history text-zinc-500 text-sm"></i>
                                        <span class="text-sm text-zinc-700">Orders</span>
                                    </a>
                                    <a href="{{ route('customer.profile.index') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition border-t border-zinc-100">
                                        <i class="fas fa-user text-zinc-500 text-sm"></i>
                                        <span class="text-sm text-zinc-700">Profile</span>
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Search Overlay -->
    <div id="searchOverlay" class="fixed inset-0 z-[100] hidden opacity-0 transition-opacity duration-300" aria-modal="true" role="dialog">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="searchBackdrop"></div>
        <div class="relative mx-auto mt-20 w-full max-w-3xl px-4 sm:px-6 transform transition-all duration-300 -translate-y-4" id="searchPanel">
            <div class="overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-black/5">
                <div class="flex items-center gap-3 border-b border-zinc-100 px-5 py-4">
                    <i class="fas fa-search text-zinc-400"></i>
                    <input type="text" id="searchInput" placeholder="Cari produk, brand, atau kategori..." class="flex-1 bg-transparent text-base text-zinc-900 placeholder-zinc-400 focus:outline-none" autocomplete="off" spellcheck="false">
                    <div id="searchLoading" class="hidden">
                        <svg class="h-5 w-5 animate-spin text-zinc-400" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </div>
                    <button type="button" id="searchCloseBtn" class="rounded-md p-1 text-zinc-400 transition hover:bg-zinc-100 hover:text-zinc-700" aria-label="Tutup">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                    <span class="hidden text-[10px] font-medium uppercase tracking-wider text-zinc-400 sm:inline-block">ESC</span>
                </div>
                <div id="searchResultsArea" class="max-h-[60vh] overflow-y-auto">
                    <div id="searchInitial" class="px-6 py-12 text-center">
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-zinc-100">
                            <i class="fas fa-search text-zinc-400"></i>
                        </div>
                        <p class="text-sm text-zinc-500">Mulai mengetik untuk mencari produk</p>
                        <p class="mt-1 text-xs text-zinc-400">Cari berdasarkan nama, brand, atau kategori</p>
                    </div>
                    <div id="searchEmpty" class="hidden px-6 py-12 text-center">
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-zinc-100">
                            <i class="fas fa-box-open text-zinc-400"></i>
                        </div>
                        <p class="text-sm font-medium text-zinc-700">No products found</p>
                        <p class="mt-1 text-xs text-zinc-400">Coba kata kunci lain</p>
                    </div>
                    <div id="searchResults" class="hidden divide-y divide-zinc-100"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
</style>
@endpush

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hamburger menu toggle
        const hamburgerBtn = document.getElementById('hamburgerMenuBtn');
        const hamburgerDropdown = document.getElementById('hamburgerMenuDropdown');
        if (hamburgerBtn && hamburgerDropdown) {
            hamburgerBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                hamburgerDropdown.classList.toggle('hidden');
            });
            document.addEventListener('click', function(e) {
                if (!hamburgerDropdown.contains(e.target) && e.target !== hamburgerBtn && !hamburgerBtn.contains(e.target)) {
                    hamburgerDropdown.classList.add('hidden');
                }
            });
        }

        // Search overlay
        const searchOverlay = document.getElementById('searchOverlay');
        const searchCloseBtn = document.getElementById('searchCloseBtn');
        const searchBackdrop = document.getElementById('searchBackdrop');
        const searchInput = document.getElementById('searchInput');
        const navSearchInput = document.getElementById('navSearchInput');

        function openOverlay() {
            if (!searchOverlay) return;
            searchOverlay.classList.remove('hidden');
            requestAnimationFrame(() => {
                searchOverlay.classList.remove('opacity-0');
                document.getElementById('searchPanel').classList.remove('-translate-y-4');
            });
            if (searchInput) searchInput.focus();
        }
        function closeOverlay() {
            if (!searchOverlay) return;
            searchOverlay.classList.add('opacity-0');
            document.getElementById('searchPanel').classList.add('-translate-y-4');
            setTimeout(() => searchOverlay.classList.add('hidden'), 300);
        }
        if (searchCloseBtn) searchCloseBtn.addEventListener('click', closeOverlay);
        if (searchBackdrop) searchBackdrop.addEventListener('click', closeOverlay);
        if (navSearchInput) navSearchInput.addEventListener('focus', openOverlay);
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchOverlay && !searchOverlay.classList.contains('hidden')) {
                closeOverlay();
            }
        });

        // Mega Dropdown Hover Control
        const dropdownContainers = document.querySelectorAll('[data-dropdown]');
        let activeDropdown = null;

        dropdownContainers.forEach(container => {
            const dropdown = container.querySelector('.absolute');
            
            container.addEventListener('mouseenter', () => {
                // Close other dropdowns
                dropdownContainers.forEach(otherContainer => {
                    if (otherContainer !== container) {
                        const otherDropdown = otherContainer.querySelector('.absolute');
                        if (otherDropdown) {
                            otherDropdown.classList.add('invisible', 'opacity-0', 'translate-y-[-10px]');
                            otherDropdown.classList.remove('visible', 'opacity-100', 'translate-y-0');
                        }
                    }
                });
                
                // Open this dropdown
                if (dropdown) {
                    dropdown.classList.remove('invisible', 'opacity-0', 'translate-y-[-10px]');
                    dropdown.classList.add('visible', 'opacity-100', 'translate-y-0');
                }
                activeDropdown = container;
            });
            
            container.addEventListener('mouseleave', () => {
                // Close dropdown
                if (dropdown) {
                    dropdown.classList.add('invisible', 'opacity-0', 'translate-y-[-10px]');
                    dropdown.classList.remove('visible', 'opacity-100', 'translate-y-0');
                }
                activeDropdown = null;
            });
            
            if (dropdown) {
                dropdown.addEventListener('mouseenter', () => {
                    // Keep dropdown open when hovering over it
                });
                
                dropdown.addEventListener('mouseleave', () => {
                    // Close dropdown when leaving it
                    dropdown.classList.add('invisible', 'opacity-0', 'translate-y-[-10px]');
                    dropdown.classList.remove('visible', 'opacity-100', 'translate-y-0');
                    activeDropdown = null;
                });
            }
        });
    });
</script>
