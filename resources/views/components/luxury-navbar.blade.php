<!-- Luxury Navbar Component -->
<!-- Header / Navbar -->
<header class="fixed left-0 top-0 z-[70] w-full border-b border-transparent bg-transparent backdrop-blur-none transition-all duration-300" id="mainHeader">
            <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-3 md:px-10 lg:px-12">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('storage/logo.png') }}" alt="NoraPadel" class="h-7 w-7 object-contain" loading="lazy">
                    <!-- <span class="text-xl font-semibold tracking-tight text-white transition-colors duration-300" id="logoText">NoraPadel</span> -->
                </a>
                <nav class="hidden items-center gap-6 md:flex" id="navLinks">
                    <!-- Home Menu -->
                    <a href="{{ route('home') }}"
                    class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">
                        {{ $common['navbar']['home'][$lang] ?? 'Home' }}
                    </a>

                    <!-- New Arrivals Mega Dropdown -->
                    <div class="relative group" data-dropdown="new-arrivals">
                        <a href="{{ route('new-arrivals') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white flex items-center gap-1">
                            {{ $common['navbar']['new_arrivals'][$lang] ?? 'New Arrivals' }}
                            <svg class="h-4 w-4 fill-none stroke-current" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        
                        <!-- Mega Dropdown Content Container -->
                        <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-[100]">
                            <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl border border-zinc-100 p-0 overflow-hidden aspect-video">
                                <div class="grid grid-cols-[1fr_1fr] h-full">
                                    
                                    <!-- Left Column: Brand & Level (Centered) -->
                                    <div class="flex flex-col justify-center items-center bg-zinc-50/50 p-8 space-y-6">
                                        <!-- Brand Section -->
                                        <div class="w-full text-center">
                                            <h4 class="text-sm font-bold text-black mb-4 tracking-wide">
                                                {{ $common['navbar']['headers']['brand'][$lang] ?? 'BRAND' }}
                                            </h4>
                                            <div class="flex flex-wrap justify-center gap-2">
                                                <a href="{{ route('new-arrivals', ['brand' => 'Bullpadel']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Bullpadel</a>
                                                <a href="{{ route('new-arrivals', ['brand' => 'Babolat']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Babolat</a>
                                                <a href="{{ route('new-arrivals', ['brand' => 'Nox']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Nox</a>
                                                <a href="{{ route('new-arrivals', ['brand' => 'Alpha']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Alpha</a>
                                                <a href="{{ route('new-arrivals', ['brand' => 'Zephyr']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Zephyr</a>
                                                <a href="{{ route('new-arrivals', ['brand' => 'Arronax']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">Arronax</a>
                                            </div>
                                        </div>
                                        
                                        <!-- Level Section -->
                                        <div class="w-full text-center">
                                            <h4 class="text-sm font-bold text-black mb-4 tracking-wide">
                                                {{ $common['navbar']['headers']['level'][$lang] ?? 'LEVEL' }}
                                            </h4>
                                            <div class="flex flex-wrap justify-center gap-2">
                                                <a href="{{ route('new-arrivals', ['level' => 'beginner']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">
                                                    {{ $common['navbar']['levels']['beginner'][$lang] ?? 'Beginner' }}
                                                </a>
                                                <a href="{{ route('new-arrivals', ['level' => 'intermediate']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">
                                                    {{ $common['navbar']['levels']['intermediate'][$lang] ?? 'Intermediate' }}
                                                </a>
                                                <a href="{{ route('new-arrivals', ['level' => 'pro']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">
                                                    {{ $common['navbar']['levels']['pro'][$lang] ?? 'Pro' }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Right Column: Category (Centered) -->
                                    <div class="flex flex-col justify-center items-center bg-zinc-50/50 p-8">
                                        <div class="w-full text-center">
                                            <h4 class="text-sm font-bold text-black mb-4 tracking-wide">
                                                {{ $common['navbar']['headers']['category'][$lang] ?? 'CATEGORY' }}
                                            </h4>
                                            <div class="flex flex-wrap justify-center gap-2">
                                                <a href="{{ route('racket') }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">
                                                    {{ $common['navbar']['racket'][$lang] ?? 'Rackets' }}
                                                </a>
                                                <a href="{{ route('shoes') }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">
                                                    {{ $common['navbar']['shoes'][$lang] ?? 'Shoes' }}
                                                </a>
                                                <a href="{{ route('apparel') }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">
                                                    {{ $common['navbar']['accessories'][$lang] ?? 'Accessories' }}
                                                </a>
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
                            class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white flex items-center gap-1">
                            {{ $common['navbar']['racket'][$lang] ?? 'Rackets' }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-[100]">
                            <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl border border-zinc-100 p-0 overflow-hidden aspect-video">
                                <div class="grid grid-cols-[1fr_1.2fr] h-full">
                                    <!-- Left: Categories (Centered) -->
                                    <div class="flex flex-col justify-center items-center bg-zinc-50/50 p-8 space-y-6">
                                        <div class="w-full text-center">
                                            <h4 class="text-sm font-bold text-black mb-4 tracking-wide">{{ $common['navbar']['headers']['brand'][$lang] ?? 'BRAND' }}</h4>
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
                                            <h4 class="text-sm font-bold text-black mb-4 tracking-wide">{{ $common['navbar']['headers']['level'][$lang] ?? 'LEVEL' }}</h4>
                                            <div class="flex flex-wrap justify-center gap-2">
                                                <a href="{{ route('racket', ['level' => 'beginner']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">{{ $common['navbar']['levels']['beginner'][$lang] ?? 'Beginner' }}</a>
                                                <a href="{{ route('racket', ['level' => 'intermediate']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">{{ $common['navbar']['levels']['intermediate'][$lang] ?? 'Intermediate' }}</a>
                                                <a href="{{ route('racket', ['level' => 'pro']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">{{ $common['navbar']['levels']['pro'][$lang] ?? 'Pro' }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Right: Image Preview -->
                                    <div class="relative overflow-hidden">
                                        <img src="{{ asset('storage/iconracket.jpg') }}" alt="Racket Collection" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                        <div class="absolute bottom-6 left-6 right-6">
                                            <h5 class="text-white font-bold text-2xl mb-1">{{ $common['navbar']['promo_texts']['racket_title'][$lang] ?? 'Premium Rackets' }}</h5>
                                            <p class="text-white/90 text-sm font-medium">{{ $common['navbar']['promo_texts']['racket_desc'][$lang] ?? 'Precision & Power' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shoes Mega Dropdown -->
                    <div class="relative group" data-dropdown="shoes">
                        <a href="{{ route('shoes') }}"
                            class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white flex items-center gap-1">
                            {{ $common['navbar']['shoes'][$lang] ?? 'Shoes' }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-[100]">
                            <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl border border-zinc-100 p-0 overflow-hidden aspect-video">
                                <div class="grid grid-cols-[1fr_1.2fr] h-full">
                                    <!-- Left: Categories (Centered) -->
                                    <div class="flex flex-col justify-center items-center bg-zinc-50/50 p-8 space-y-6">
                                        <div class="w-full text-center">
                                            <h4 class="text-sm font-bold text-black mb-4 tracking-wide">{{ $common['navbar']['headers']['brand'][$lang] ?? 'BRAND' }}</h4>
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
                                            <h4 class="text-sm font-bold text-black mb-4 tracking-wide">{{ $common['navbar']['headers']['level'][$lang] ?? 'LEVEL' }}</h4>
                                            <div class="flex flex-wrap justify-center gap-2">
                                                <a href="{{ route('shoes', ['level' => 'beginner']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">{{ $common['navbar']['levels']['beginner'][$lang] ?? 'Beginner' }}</a>
                                                <a href="{{ route('shoes', ['level' => 'intermediate']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">{{ $common['navbar']['levels']['intermediate'][$lang] ?? 'Intermediate' }}</a>
                                                <a href="{{ route('shoes', ['level' => 'pro']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">{{ $common['navbar']['levels']['pro'][$lang] ?? 'Pro' }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Right: Image Preview -->
                                    <div class="relative overflow-hidden">
                                        <img src="{{ asset('storage/iconsepatu.png') }}" alt="Shoes Collection" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                        <div class="absolute bottom-6 left-6 right-6">
                                            <h5 class="text-white font-bold text-2xl mb-1">{{ $common['navbar']['promo_texts']['shoes_title'][$lang] ?? 'Premium Shoes' }}</h5>
                                            <p class="text-white/90 text-sm font-medium">{{ $common['navbar']['promo_texts']['shoes_desc'][$lang] ?? 'Move Faster, Play Smarter' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accessories Mega Dropdown -->
                    <div class="relative group" data-dropdown="accessories">
                        <a href="{{ route('apparel') }}"
                            class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white flex items-center gap-1">
                            {{ $common['navbar']['accessories'][$lang] ?? 'Accessories' }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[700px] opacity-0 invisible translate-y-[-10px] transition-all duration-300 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 z-[100]">
                            <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl border border-zinc-100 p-0 overflow-hidden aspect-video">
                                <div class="grid grid-cols-[1fr_1.2fr] h-full">
                                    <!-- Left: Categories (Centered) -->
                                    <div class="flex flex-col justify-center items-center bg-zinc-50/50 p-8 space-y-6">
                                        <div class="w-full text-center">
                                            <h4 class="text-sm font-bold text-black mb-4 tracking-wide">{{ $common['navbar']['headers']['brand'][$lang] ?? 'BRAND' }}</h4>
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
                                            <h4 class="text-sm font-bold text-black mb-4 tracking-wide">{{ $common['navbar']['headers']['level'][$lang] ?? 'LEVEL' }}</h4>
                                            <div class="flex flex-wrap justify-center gap-2">
                                                <a href="{{ route('apparel', ['level' => 'beginner']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">{{ $common['navbar']['levels']['beginner'][$lang] ?? 'Beginner' }}</a>
                                                <a href="{{ route('apparel', ['level' => 'intermediate']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">{{ $common['navbar']['levels']['intermediate'][$lang] ?? 'Intermediate' }}</a>
                                                <a href="{{ route('apparel', ['level' => 'pro']) }}" class="px-4 py-2 bg-white border border-zinc-200 rounded-lg text-sm font-medium text-zinc-700 hover:bg-black hover:text-white hover:border-black transition-all shadow-sm">{{ $common['navbar']['levels']['pro'][$lang] ?? 'Pro' }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Right: Image Preview -->
                                    <div class="relative overflow-hidden">
                                        <img src="{{ asset('storage/icontas.jpg') }}" alt="Accessories Collection" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                        <div class="absolute bottom-6 left-6 right-6">
                                            <h5 class="text-white font-bold text-2xl mb-1">{{ $common['navbar']['promo_texts']['acc_title'][$lang] ?? 'Premium Accessories' }}</h5>
                                            <p class="text-white/90 text-sm font-medium">{{ $common['navbar']['promo_texts']['acc_desc'][$lang] ?? 'Comfort Meets Performance' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('contact') }}"
                        class="border-b border-transparent text-sm text-white/90 transition duration-300 hover:border-white/30 hover:text-white">{{ $common['navbar']['contact'][$lang] ?? 'Contact' }}</a>
                </nav>

            <div class="flex items-center gap-2 md:gap-3 text-white/90" id="navIcons">
                    <!-- Inline Search (all screens) -->
                    <!-- <div class="flex items-center relative" id="navSearchWrapper">
                        <i class="fas fa-search absolute left-2 md:left-3 text-xs md:text-sm text-white/60 pointer-events-none transition-colors duration-300" id="navSearchIcon"></i>
                        <input type="text" id="navSearchInput" placeholder="Cari..."
                               class="bg-white/10 border border-white/20 rounded-full pl-7 md:pl-9 pr-2 md:pr-4 py-1 md:py-1.5 text-xs md:text-sm text-white placeholder-white/60 focus:outline-none focus:bg-white/20 focus:border-white/40 w-24 md:w-40 lg:w-48 transition-all duration-300"
                               autocomplete="off">
                    </div> -->
                    
                    <!-- Wishlist (mobile only) -->
                    <!-- <a href="{{ route('customer.wishlist.index') }}" class="relative md:hidden transition duration-300 hover:text-white">
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
                            <span class="wishlist-badge absolute -right-1.5 -top-1.5 flex h-3 w-3 items-center justify-center rounded-full bg-rose-500 text-[9px] font-bold text-white">{{ $wishlistCount > 9 ? '9+' : $wishlistCount }}</span>
                        @endif
                    </a>
 -->
                    <!-- Mobile Search Icon (hidden since inline search is now visible) -->
                    <button type="button" id="searchToggleBtn" class="hidden transition duration-300 hover:text-white" aria-label="Search" title="Cari Produk">
                        <i class="fas fa-search text-sm"></i>
                    </button>

                    @guest
                        <a href="{{ route('login') }}" 
                        class="inline-flex h-9 w-9 md:hidden items-center justify-center rounded-full border border-white/30 bg-white/10 text-white backdrop-blur transition duration-300 hover:bg-white/20"
                        title="Login">
                            <i class="fas fa-user text-sm"></i>
                        </a>
                    @endguest

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" 
                            class="inline-flex h-9 w-9 md:hidden items-center justify-center rounded-full border border-white/30 bg-white/10 text-white backdrop-blur transition duration-300 hover:bg-white/20" 
                            title="Dashboard">
                                <i class="fas fa-user-shield text-sm"></i>
                            </a>
                        @elseif(auth()->user()->role === 'customer')
                            <a href="{{ route('customer.profile.index') }}" 
                            class="inline-flex h-9 w-9 md:hidden items-center justify-center rounded-full border border-white/30 bg-white/10 text-white backdrop-blur transition duration-300 hover:bg-white/20" 
                            title="Profile">
                                <i class="fas fa-user-circle text-sm"></i>
                            </a>
                        @endif
                    @endauth

                    <a href="{{ route('customer.cart.index') }}" 
                    class="relative inline-flex h-9 w-9 md:hidden items-center justify-center rounded-full border border-white/30 bg-white/10 text-white backdrop-blur transition duration-300 hover:bg-white/20"
                    title="Cart">
                        <i class="fas fa-shopping-bag text-sm"></i>
                        @php
                            if (auth()->check() && auth()->user()->role === 'customer') {
                                $mobileCartCount = auth()->user()->cartItems()->sum('quantity');
                            } else {
                                $guestCart = session()->get('guest_cart', []);
                                $mobileCartCount = array_sum(array_column($guestCart, 'quantity'));
                            }
                        @endphp
                        @if($mobileCartCount > 0)
                            <span class="cart-badge absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[9px] font-bold text-white">
                                {{ $mobileCartCount > 9 ? '9+' : $mobileCartCount }}
                            </span>
                        @endif
                    </a>
                    
                    <a href="{{ route('customer.wishlist.index') }}" 
                    class="relative inline-flex h-9 w-9 md:hidden items-center justify-center rounded-full border border-white/30 bg-white/10 text-white backdrop-blur transition duration-300 hover:bg-white/20"
                    title="Wishlist">
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
                            <span class="wishlist-badge absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[9px] font-bold text-white">
                                {{ $wishlistCount > 9 ? '9+' : $wishlistCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Dark Mode Toggle (Home Page) -->
                    <button type="button" id="darkModeToggleHome"
                            class="hidden md:inline-flex inline-flex h-9 w-9 items-center justify-center rounded-full border border-white/30 bg-white/10 text-white backdrop-blur transition duration-300 hover:bg-white/20"
                            title="Toggle Dark/Light Mode" aria-label="Toggle dark mode">
                        <i class="fas fa-moon text-sm" id="darkModeIconHome"></i>
                    </button>

                    <!-- ==========================================
                DESKTOP ONLY UTILITIES (Hidden on Mobile)
                ========================================== -->
            <div class="hidden md:flex items-center gap-4 text-white/90">
                <!-- Language Switcher (Desktop) -->
                <div class="flex gap-2 bg-white/10 backdrop-blur p-1 rounded border border-white/20">
                    <a href="{{ request()->fullUrlWithQuery(['locale' => 'en']) }}" class="px-2 py-1 text-xs text-white rounded transition {{ session('locale', 'en') === 'en' ? 'bg-white/20 font-semibold' : 'opacity-60 hover:opacity-100' }}">
                        EN
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['locale' => 'id']) }}" class="px-2 py-1 text-xs text-white rounded transition {{ session('locale', 'en') === 'id' ? 'bg-white/20 font-semibold' : 'opacity-60 hover:opacity-100' }}">
                        ID
                    </a>
                </div>

                <!-- Login / Account Dashboard (Desktop) -->
                @guest
                    <a href="{{ route('login') }}" class="text-sm font-medium hover:text-white transition duration-300">
                        {{ $common['navbar']['login'][$lang] ?? 'Login' }}
                    </a>
                @endguest

                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium hover:text-white transition duration-300 flex items-center gap-1.5">
                            <i class="fas fa-arrow-left text-xs"></i> Dashboard
                        </a>
                    @elseif(auth()->user()->role === 'customer')
                        <a href="{{ route('customer.profile.index') }}" class="text-sm font-medium hover:text-white transition duration-300 flex items-center gap-1.5" title="Profile">
                            <i class="fas fa-user text-xs"></i>
                            <span class="max-w-[80px] truncate">{{ auth()->user()->name }}</span>
                        </a>
                        <a href="{{ route('customer.orders.index') }}" class="text-sm font-medium hover:text-white transition duration-300" title="Orders">
                            <i class="fas fa-history text-xs"></i>
                        </a>
                    @endif
                @endauth

                <!-- Wishlist (Desktop) -->
                <a href="{{ route('customer.wishlist.index') }}" class="relative transition duration-300 hover:text-white p-1" title="Wishlist">
                    <i class="fas fa-heart text-base"></i>
                    @php
                        if (auth()->check() && auth()->user()->role === 'customer') {
                            $wishlistCount = auth()->user()->wishlistItems()->count();
                        } else {
                            $guestWishlist = session()->get('guest_wishlist', []);
                            $wishlistCount = count($guestWishlist);
                        }
                    @endphp
                    @if($wishlistCount > 0)
                        <span class="absolute -right-1.5 -top-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-blue-500 text-[10px] font-bold text-white">{{ $wishlistCount > 9 ? '9+' : $wishlistCount }}</span>
                    @endif
                </a>

                <!-- Cart (Desktop) -->
                <a href="{{ route('customer.cart.index') }}" class="relative transition duration-300 hover:text-white p-1" title="Cart">
                    <i class="fas fa-shopping-bag text-base"></i>
                    @auth
                        @if (auth()->user()->role === 'customer')
                            @php $cartCount = auth()->user()->cartItems()->sum('quantity'); @endphp
                            @if ($cartCount > 0)
                                <span class="absolute -right-1.5 -top-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                            @endif
                        @endif
                    @endauth
                    @guest
                        @php
                            $guestCart = session()->get('guest_cart', []);
                            $guestCartCount = array_sum(array_column($guestCart, 'quantity'));
                        @endphp
                        @if($guestCartCount > 0)
                            <span class="absolute -right-1.5 -top-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white">{{ $guestCartCount > 9 ? '9+' : $guestCartCount }}</span>
                        @endif
                    @endguest
                </a>
            </div>


            <!-- ==========================================
                MOBILE ONLY HAMBURGER (Hidden on Desktop)
                ========================================== -->
            
                <div class="md:hidden relative" id="hamburgerMenuWrapper">
                <button type="button" id="hamburgerMenuBtn" class="inline-flex h-9 w-9 items-center justify-center rounded border border-white/30 bg-white/10 text-white backdrop-blur transition duration-300 hover:bg-white/20 relative">
                    <i class="fas fa-bars text-sm"></i>
                    
                    <!-- Cart Badge (Mobile Indicator) -->
                    @auth
                        @if (auth()->user()->role === 'customer')
                            @php $cartCount = auth()->user()->cartItems()->sum('quantity'); @endphp
                            @if ($cartCount > 0)
                                <span class="hamburger-cart-badge absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                            @endif
                        @endif
                    @endauth
                    @guest
                        @php
                            $guestCart = session()->get('guest_cart', []);
                            $guestCartCount = array_sum(array_column($guestCart, 'quantity'));
                        @endphp
                        @if($guestCartCount > 0)
                            <span class="hamburger-cart-badge absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white">{{ $guestCartCount > 9 ? '9+' : $guestCartCount }}</span>
                        @endif
                    @endguest

                    <!-- Wishlist Badge (Mobile Indicator) -->
                    @auth
                        @if (auth()->user()->role === 'customer')
                            @php $wishlistCount = auth()->user()->wishlistItems()->count(); @endphp
                            @if ($wishlistCount > 0)
                                <span class="hamburger-wishlist-badge absolute -bottom-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-blue-500 text-[10px] font-bold text-white">{{ $wishlistCount > 9 ? '9+' : $wishlistCount }}</span>
                            @endif
                        @endif
                    @endauth
                    @guest
                        @php
                            $guestWishlist = session()->get('guest_wishlist', []);
                            $guestWishlistCount = count($guestWishlist);
                        @endphp
                        @if($guestWishlistCount > 0)
                            <span class="hamburger-wishlist-badge absolute -bottom-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-blue-500 text-[10px] font-bold text-white">{{ $guestWishlistCount > 9 ? '9+' : $guestWishlistCount }}</span>
                        @endif
                    @endguest
                </button>

                <!-- Dropdown Menu Panel (Mobile Drawer) -->
                <div id="hamburgerMenuDropdown" class="absolute right-0 mt-2 w-56 z-[100] hidden">
                    <div class="bg-white rounded-lg shadow-lg border border-zinc-100 overflow-hidden">
                        <!-- Navigation Links -->
                        <div class="flex flex-col">
                            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                <i class="fas fa-home text-zinc-400 text-sm w-4"></i>
                                <span class="text-sm text-zinc-700">{{ $common['navbar']['home'][$lang] ?? 'Home' }}</span>
                            </a>
                            <a href="{{ route('new-arrivals') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                <i class="fas fa-star text-zinc-400 text-sm w-4"></i>
                                <span class="text-sm text-zinc-700">{{ $common['navbar']['new_arrivals'][$lang] ?? 'New Arrivals' }}</span>
                            </a>
                            <a href="{{ route('racket') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                <i class="fas fa-table-tennis text-zinc-400 text-sm w-4"></i>
                                <span class="text-sm text-zinc-700">{{ $common['navbar']['racket'][$lang] ?? 'Rackets' }}</span>
                            </a>
                            <a href="{{ route('shoes') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                <i class="fas fa-shoe-prints text-zinc-400 text-sm w-4"></i>
                                <span class="text-sm text-zinc-700">{{ $common['navbar']['shoes'][$lang] ?? 'Shoes' }}</span>
                            </a>
                            <a href="{{ route('apparel') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-zinc-50 transition border-b border-zinc-100">
                                <i class="fas fa-tshirt text-zinc-400 text-sm w-4"></i>
                                <span class="text-sm text-zinc-700">{{ $common['navbar']['accessories'][$lang] ?? 'Accessories' }}</span>
                            </a>
                        </div>

                        <!-- Language Switcher & Dark mode mobile Zone -->
                        <div class="border-b border-zinc-100 p-2.5 bg-zinc-50">
                            <div class="flex gap-2 mb-2">
                                <a href="{{ request()->fullUrlWithQuery(['locale' => 'en']) }}" class="flex-1 text-center py-1.5 text-xs text-zinc-700 hover:bg-white rounded border border-transparent shadow-sm transition {{ session('locale', 'en') === 'en' ? 'bg-white font-semibold border-zinc-200' : 'bg-white/50' }}">
                                    EN
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['locale' => 'id']) }}" class="flex-1 text-center py-1.5 text-xs text-zinc-700 hover:bg-white rounded border border-transparent shadow-sm transition {{ session('locale', 'en') === 'id' ? 'bg-white font-semibold border-zinc-200' : 'bg-white/50' }}">
                                    ID
                                </a>
                            </div>

                            <div class="flex gap-2">
                                <button type="button" id="mobileLightModeBtn" 
                                        class="flex-1 flex items-center justify-center py-1.5 rounded border border-transparent shadow-sm transition dark:bg-white/50 dark:border-transparent bg-white font-semibold border-zinc-200 dark:font-normal">
                                    <i class="fas fa-sun text-sm transition-colors duration-200" id="iconMobileLight"></i>
                                </button>

                                <button type="button" id="mobileDarkModeBtn" 
                                        class="flex-1 flex items-center justify-center py-1.5 rounded border border-transparent shadow-sm transition bg-white/50 dark:bg-white dark:font-semibold dark:border-zinc-200">
                                    <i class="fas fa-moon text-sm transition-colors duration-200" id="iconMobileDark"></i>
                                </button>
                            </div>
                        </div>

                        
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
@push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const desktopBtn = document.getElementById('darkModeToggleHome');
        const mobileLightBtn = document.getElementById('mobileLightModeBtn');
        const mobileDarkBtn = document.getElementById('mobileDarkModeBtn');
        
        // Ambil elemen icon di dalam button untuk ganti warna
        const iconLight = mobileLightBtn ? mobileLightBtn.querySelector('i') : null;
        const iconDark = mobileDarkBtn ? mobileDarkBtn.querySelector('i') : null;

        // Fungsi pembantu untuk setel warna icon secara instan
        function setMobileIconColor(isDarkActive) {
            if (!iconLight || !iconDark) return;
            
            if (isDarkActive) {
                // Mode Gelap Aktif: Bulan terang (zinc-400), Matahari redup (zinc-300)
                iconLight.classList.remove('text-zinc-400');
                iconLight.classList.add('text-zinc-300');
                
                iconDark.classList.remove('text-zinc-300');
                iconDark.classList.add('text-zinc-400');
            } else {
                // Mode Terang Aktif: Matahari terang (zinc-400), Bulan redup (zinc-300)
                iconLight.classList.remove('text-zinc-300');
                iconLight.classList.add('text-zinc-400');
                
                iconDark.classList.remove('text-zinc-400');
                iconDark.classList.add('text-zinc-300');
            }
        }

        // Cek status awal saat halaman selesai dimuat (kasih delay dikit biar script temanmu kelar execute)
        setTimeout(() => {
            const isDarkNow = document.documentElement.classList.contains('dark');
            setMobileIconColor(isDarkNow);
        }, 50);

        // Klik Matahari di mobile -> Langsung paksa trigger klik desktop & setel warna matahari aktif
        if (mobileLightBtn && desktopBtn) {
            mobileLightBtn.addEventListener('click', () => {
                desktopBtn.click();
                setMobileIconColor(false); // Matahari aktif
            });
        }
        
        // Klik Bulan di mobile -> Langsung paksa trigger klik desktop & setel warna bulan aktif
        if (mobileDarkBtn && desktopBtn) {
            mobileDarkBtn.addEventListener('click', () => {
                desktopBtn.click();
                setMobileIconColor(true); // Bulan aktif
            });
        }
    });
</script>
    <script>
        // Dark Mode Toggle Home Page Custom Navbar
        (function() {
            const html = document.documentElement;
            const btnHome = document.getElementById('darkModeToggleHome');
            const iconHome = document.getElementById('darkModeIconHome');

            function syncHomeIcon(theme) {
                if (iconHome) {
                    iconHome.className = theme === 'dark' ? 'fas fa-sun text-sm' : 'fas fa-moon text-sm';
                }
            }

            // Sync on load
            const currentTheme = html.getAttribute('data-theme') || localStorage.getItem('np_theme') || 'light';
            syncHomeIcon(currentTheme);

            if (btnHome) {
                btnHome.addEventListener('click', function() {
                    const current = html.getAttribute('data-theme');
                    const next = current === 'dark' ? 'light' : 'dark';
                    html.setAttribute('data-theme', next);
                    localStorage.setItem('np_theme', next);
                    
                    syncHomeIcon(next);
                    
                    // Sync global toggle if present
                    const iconGlobal = document.getElementById('darkModeIcon');
                    if (iconGlobal) {
                        iconGlobal.className = next === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
                    }
                });
            }

            // Sync if global toggle is clicked
            const btnGlobal = document.getElementById('darkModeToggle');
            if (btnGlobal) {
                btnGlobal.addEventListener('click', function() {
                    setTimeout(() => {
                        const newTheme = html.getAttribute('data-theme');
                        syncHomeIcon(newTheme);
                    }, 50);
                });
            }
        })();

        // Animate badge function
        function animateBadge(badgeElement) {
            if (!badgeElement) return;
            
            // Add animation class
            badgeElement.classList.add('animate-bounce');
            
            // Remove animation after it completes
            setTimeout(() => {
                badgeElement.classList.remove('animate-bounce');
            }, 1000);
        }

        // Update cart badge count
        function updateCartBadge(newCount) {
            const cartBadges = document.querySelectorAll('.cart-badge');
            cartBadges.forEach(badge => {
                if (newCount > 0) {
                    badge.textContent = newCount > 9 ? '9+' : newCount;
                    badge.classList.remove('hidden');
                    animateBadge(badge);
                } else {
                    badge.classList.add('hidden');
                }
            });

            // Update hamburger button badge
            const hamburgerCartBadges = document.querySelectorAll('.hamburger-cart-badge');
            hamburgerCartBadges.forEach(badge => {
                if (newCount > 0) {
                    badge.textContent = newCount > 9 ? '9+' : newCount;
                    badge.classList.remove('hidden');
                    animateBadge(badge);
                } else {
                    badge.classList.add('hidden');
                }
            });
        }

        // Update wishlist badge count
        function updateWishlistBadge(newCount) {
            const wishlistBadges = document.querySelectorAll('.wishlist-badge');
            wishlistBadges.forEach(badge => {
                if (newCount > 0) {
                    badge.textContent = newCount > 9 ? '9+' : newCount;
                    badge.classList.remove('hidden');
                    animateBadge(badge);
                } else {
                    badge.classList.add('hidden');
                }
            });

            // Update hamburger button badge
            const hamburgerWishlistBadges = document.querySelectorAll('.hamburger-wishlist-badge');
            hamburgerWishlistBadges.forEach(badge => {
                if (newCount > 0) {
                    badge.textContent = newCount > 9 ? '9+' : newCount;
                    badge.classList.remove('hidden');
                    animateBadge(badge);
                } else {
                    badge.classList.add('hidden');
                }
            });
        }

        // Add to Cart Function
        function addToCart(productId, event) {
            event.preventDefault();
            event.stopPropagation();
            
            const button = event.target.closest('button');
            if (button) {
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            }
            
            fetch(`/customer/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Animate and update cart badge
                    const currentCount = parseInt(data.cart_count || 0);
                    updateCartBadge(currentCount);
                    
                    if (button) {
                        button.innerHTML = '✓ Added';
                        setTimeout(() => {
                            button.disabled = false;
                            button.innerHTML = 'Add to cart';
                        }, 1500);
                    }
                } else {
                    alert(data.message || 'Gagal menambahkan produk ke keranjang');
                    if (button) {
                        button.disabled = false;
                        button.innerHTML = 'Add to cart';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                if (button) {
                    button.disabled = false;
                    button.innerHTML = 'Add to cart';
                }
            });
        }

        // Add to Wishlist Function
        function addToWishlist(productId, event) {
            event.preventDefault();
            event.stopPropagation();
            
            const button = event.target.closest('button');
            const icon = button.querySelector('i');
            if (icon) {
                icon.classList.remove('fa-heart');
                icon.classList.add('fa-spinner', 'fa-spin');
            }
            
            fetch(`/customer/wishlist/add/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Animate and update wishlist badge
                    const currentCount = parseInt(data.wishlist_count || 0);
                    updateWishlistBadge(currentCount);
                    
                    if (icon) {
                        icon.classList.remove('fa-spinner', 'fa-spin');
                        icon.classList.add('fa-heart');
                        icon.classList.add('text-rose-500');
                    }
                    if (button) {
                        button.classList.add('text-rose-500');
                    }
                } else {
                    alert(data.message || 'Gagal menambahkan produk ke wishlist');
                    if (icon) {
                        icon.classList.remove('fa-spinner', 'fa-spin');
                        icon.classList.add('fa-heart');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                if (icon) {
                    icon.classList.remove('fa-spinner', 'fa-spin');
                    icon.classList.add('fa-heart');
                }
            });
        }

        // Claim Voucher Function
        function claimVoucher(voucherId, btn) {
            if (!btn) return;
            
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            fetch('{{ route('customer.vouchers.claim') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    voucher_id: voucherId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    btn.innerHTML = '✓ Diklaim';
                    setTimeout(() => {
                        window.location.href = '{{ route('shop') }}';
                    }, 1000);
                } else {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        alert(data.message || 'Gagal mengklaim voucher');
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        }

        // Apply Filters Function
        window.applyFilters = function() {
            const brand = document.getElementById('filterBrandBottom').value;
            const category = document.getElementById('filterCategoryBottom').value;
            const price = document.getElementById('filterPriceBottom').value;
            const sort = document.getElementById('filterSortBottom').value;

            // Show loading state
            const container = document.getElementById('newArrivalsContainer');
            container.innerHTML = '<div class="flex items-center justify-center w-full py-8"><i class="fas fa-spinner fa-spin text-2xl text-gray-400"></i></div>';

            // Fetch filtered products via AJAX
            fetch(`/api/new-arrivals/filter?brand=${brand}&category=${category}&price=${price}&sort=${sort}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.html) {
                        container.innerHTML = data.html;
                    } else {
                        container.innerHTML = '<div class="flex items-center justify-center w-full py-8 text-gray-500">{{$home['search']['overlay']['empty_title'][$lang] ?? 'No products found'}}</div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    container.innerHTML = '<div class="flex items-center justify-center w-full py-8 text-gray-500">Error loading products</div>';
                });
        };

        // Hamburger Menu Toggle
        (function() {
            const btn = document.getElementById('hamburgerMenuBtn');
            const dropdown = document.getElementById('hamburgerMenuDropdown');
            const wrapper = document.getElementById('hamburgerMenuWrapper');
            if (!btn || !dropdown || !wrapper) return;
            btn.addEventListener('click', function(e){ e.stopPropagation(); dropdown.classList.toggle('hidden'); });
            document.addEventListener('click', function(e){ if(!wrapper.contains(e.target)) dropdown.classList.add('hidden'); });
            return;
            // legacy
            
            if (!btn || !dropdown || !wrapper) return;

            const openClasses = ['opacity-100', 'visible', 'translate-y-0'];
            const closedClasses = ['opacity-0', 'invisible', 'translate-y-[-10px]'];

            function openMenu() {
                closedClasses.forEach(c => dropdown.classList.remove(c));
                openClasses.forEach(c => dropdown.classList.add(c));
            }

            function closeMenu() {
                openClasses.forEach(c => dropdown.classList.remove(c));
                closedClasses.forEach(c => dropdown.classList.add(c));
            }

            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (dropdown.classList.contains('invisible')) {
                    openMenu();
                } else {
                    closeMenu();
                }
            });

            document.addEventListener('click', function(e) {
                if (!wrapper.contains(e.target)) {
                    closeMenu();
                }
            });
        })();

        (function() {
            // Scroll New Arrivals Function
            window.scrollNewArrivals = function(direction) {
                const container = document.getElementById('newArrivalsContainer');
                if (!container) return;
                
                const scrollAmount = 400;
                if (direction === 'left') {
                    container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                } else {
                    container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                }
            };

            // Welcome Bonus Modal
            const welcomeModal = document.getElementById('welcomeBonusModal');
            if (welcomeModal) {
                const hasSeenWelcome = localStorage.getItem('hasSeenWelcomeBonus');
                if (!hasSeenWelcome) {
                    setTimeout(() => {
                        welcomeModal.style.display = 'flex';
                    }, 1000); // Show after 1 second
                }
            }

            window.closeWelcomeBonus = function() {
                const welcomeModal = document.getElementById('welcomeBonusModal');
                if (welcomeModal) {
                    welcomeModal.style.display = 'none';
                    localStorage.setItem('hasSeenWelcomeBonus', 'true');
                }
            };

            // ==========================================
            // Modern Realtime Search Overlay
            // ==========================================
            (function() {
                const overlay = document.getElementById('searchOverlay');
                const panel = document.getElementById('searchPanel');
                const toggleBtn = document.getElementById('searchToggleBtn');
                const closeBtn = document.getElementById('searchCloseBtn');
                const backdrop = document.getElementById('searchBackdrop');
                const input = document.getElementById('searchInput');
                const loading = document.getElementById('searchLoading');
                const initialState = document.getElementById('searchInitial');
                const emptyState = document.getElementById('searchEmpty');
                const resultsList = document.getElementById('searchResults');

                if (!overlay || !toggleBtn || !input) return;

                let debounceTimer;
                let currentController;

                function openOverlay() {
                    overlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                    requestAnimationFrame(() => {
                        overlay.classList.remove('opacity-0');
                        overlay.classList.add('opacity-100');
                        panel.classList.remove('-translate-y-4');
                        panel.classList.add('translate-y-0');
                        setTimeout(() => input.focus(), 50);
                    });
                }

                function closeOverlay() {
                    overlay.classList.add('opacity-0');
                    overlay.classList.remove('opacity-100');
                    panel.classList.add('-translate-y-4');
                    panel.classList.remove('translate-y-0');
                    setTimeout(() => {
                        overlay.classList.add('hidden');
                        document.body.style.overflow = '';
                        input.value = '';
                        showState('initial');
                    }, 300);
                }

                function showState(state) {
                    initialState.classList.toggle('hidden', state !== 'initial');
                    emptyState.classList.toggle('hidden', state !== 'empty');
                    resultsList.classList.toggle('hidden', state !== 'results');
                }

                function escapeHtml(s) {
                    return String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
                }

                function renderResults(products) {
                    resultsList.innerHTML = products.map(p => `
                        <a href="${escapeHtml(p.detail_url)}" class="flex items-center gap-6 px-5 py-3 transition hover:bg-zinc-50">
                            <div class="h-14 w-14 flex-shrink-0 overflow-hidden rounded-lg bg-zinc-100">
                                <img src="${escapeHtml(p.image_url)}" alt="${escapeHtml(p.name)}" class="h-full w-full object-cover" onerror="this.onerror=null;this.src='/images/logo.png';" loading="lazy">
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-zinc-900">${escapeHtml(p.name)}</p>
                                <div class="mt-0.5 flex items-center gap-2 text-xs text-zinc-500">
                                    ${p.brand ? `<span class="font-medium">${escapeHtml(p.brand)}</span>` : ''}
                                    ${p.brand && p.category_label ? '<span class="text-zinc-300">·</span>' : ''}
                                    ${p.category_label ? `<span>${escapeHtml(p.category_label)}</span>` : ''}
                                </div>
                            </div>
                            <p class="flex-shrink-0 text-sm font-semibold text-zinc-900">${escapeHtml(p.formatted_price)}</p>
                        </a>
                    `).join('');
                }

                async function performSearch(query) {
                    if (currentController) currentController.abort();
                    currentController = new AbortController();

                    loading.classList.remove('hidden');
                    try {
                        const res = await fetch(`/api/search-products?q=${encodeURIComponent(query)}`, {
                            signal: currentController.signal,
                            headers: { 'Accept': 'application/json' }
                        });
                        const data = await res.json();
                        loading.classList.add('hidden');

                        if (data.products && data.products.length > 0) {
                            renderResults(data.products);
                            showState('results');
                        } else {
                            showState('empty');
                        }
                    } catch (err) {
                        if (err.name !== 'AbortError') {
                            loading.classList.add('hidden');
                            console.error('Search error:', err);
                        }
                    }
                }

                // Input with debounce
                input.addEventListener('input', function() {
                    const q = this.value.trim();
                    clearTimeout(debounceTimer);

                    if (q.length < 2) {
                        loading.classList.add('hidden');
                        if (currentController) currentController.abort();
                        showState('initial');
                        return;
                    }

                    debounceTimer = setTimeout(() => performSearch(q), 250);
                });

                // Triggers
                toggleBtn.addEventListener('click', openOverlay);
                closeBtn.addEventListener('click', closeOverlay);
                backdrop.addEventListener('click', closeOverlay);

                // Navbar inline search input
                const navSearchInputEl = document.getElementById('navSearchInput');
                if (navSearchInputEl) {
                    navSearchInputEl.addEventListener('focus', function() {
                        openOverlay();
                        const q = this.value.trim();
                        if (q.length >= 2) {
                            input.value = q;
                            performSearch(q);
                        }
                    });
                }

                // ESC to close
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && !overlay.classList.contains('hidden')) {
                        closeOverlay();
                    }
                });
            })();

            // Clone marquee content for seamless loop
            (function() {
                const marqueeContent = document.getElementById('marqueeContent');
                if (marqueeContent) {
                    marqueeContent.innerHTML += marqueeContent.innerHTML;
                }
            })();

            // Navbar scroll effect
            const header = document.getElementById('mainHeader');
            const logoText = document.getElementById('logoText');
            const navLinks = document.getElementById('navLinks');
            const navIcons = document.getElementById('navIcons');

            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.add('bg-white/80', 'backdrop-blur-xl', 'border-black/6');
                    header.classList.remove('bg-transparent', 'backdrop-blur-none', 'border-transparent');
                    
                    logoText.classList.remove('text-white');
                    logoText.classList.add('text-black');
                    
                    navLinks.querySelectorAll('a').forEach(link => {
                        link.classList.remove('text-white/90', 'hover:border-white/30', 'hover:text-white');
                        link.classList.add('text-black/80', 'hover:border-black/30', 'hover:text-black');
                    });
                    
                    navIcons.classList.remove('text-white/90');
                    navIcons.classList.add('text-black/80');

                    const navSearchInputScroll = document.getElementById('navSearchInput');
                    const navSearchIconScroll = document.getElementById('navSearchIcon');
                    if (navSearchInputScroll) {
                        navSearchInputScroll.classList.remove('bg-white/10', 'border-white/20', 'text-white', 'placeholder-white/60', 'focus:bg-white/20', 'focus:border-white/40');
                        navSearchInputScroll.classList.add('bg-zinc-50', 'border-zinc-200', 'text-black', 'placeholder-zinc-400', 'focus:bg-white', 'focus:border-zinc-300');
                    }
                    if (navSearchIconScroll) {
                        navSearchIconScroll.classList.remove('text-white/60');
                        navSearchIconScroll.classList.add('text-zinc-400');
                    }

                    navIcons.querySelectorAll('a, button').forEach(el => {
                        if (el.classList.contains('border-white/30')) {
                            el.classList.remove('border-white/30', 'bg-white/10', 'hover:bg-white/20', 'text-white');
                            el.classList.add('border-black/15', 'bg-transparent', 'hover:border-black/30', 'text-black');
                        }
                        el.classList.remove('hover:text-white');
                        el.classList.add('hover:text-black');
                    });
                } else {
                    header.classList.remove('bg-white/80', 'backdrop-blur-xl', 'border-black/6');
                    header.classList.add('bg-transparent', 'backdrop-blur-none', 'border-transparent');
                    
                    logoText.classList.add('text-white');
                    logoText.classList.remove('text-black');
                    
                    navLinks.querySelectorAll('a').forEach(link => {
                        link.classList.add('text-white/90', 'hover:border-white/30', 'hover:text-white');
                        link.classList.remove('text-black/80', 'hover:border-black/30', 'hover:text-black');
                    });
                    
                    navIcons.classList.add('text-white/90');
                    navIcons.classList.remove('text-black/80');

                    const navSearchInputScroll = document.getElementById('navSearchInput');
                    const navSearchIconScroll = document.getElementById('navSearchIcon');
                    if (navSearchInputScroll) {
                        navSearchInputScroll.classList.add('bg-white/10', 'border-white/20', 'text-white', 'placeholder-white/60', 'focus:bg-white/20', 'focus:border-white/40');
                        navSearchInputScroll.classList.remove('bg-zinc-50', 'border-zinc-200', 'text-black', 'placeholder-zinc-400', 'focus:bg-white', 'focus:border-zinc-300');
                    }
                    if (navSearchIconScroll) {
                        navSearchIconScroll.classList.add('text-white/60');
                        navSearchIconScroll.classList.remove('text-zinc-400');
                    }

                    navIcons.querySelectorAll('a, button').forEach(el => {
                        if (el.classList.contains('border-black/15')) {
                            el.classList.add('border-white/30', 'bg-white/10', 'hover:bg-white/20', 'text-white');
                            el.classList.remove('border-black/15', 'bg-transparent', 'hover:border-black/30', 'text-black');
                        }
                        el.classList.add('hover:text-white');
                        el.classList.remove('hover:text-black');
                    });
                }
            }, { passive: true });

            const revealEls = document.querySelectorAll('.np-fade-section');
            const heroImages = document.querySelectorAll('.np-parallax-image');
            const layoutSections = document.querySelectorAll('[data-featured-toggle]');
            const testimonialShowcase = document.querySelector('[data-testimonial-showcase]');

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
                if (window.innerWidth < 768) {
                    heroImages.forEach((img) => {
                        img.style.transform = '';
                    });
                    return;
                }

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

                if (window.innerWidth < 768) {
                    containers.forEach((container) => {
                        const card = container.querySelector('.np-container-scroll-card');
                        const content = container.querySelector('.np-container-scroll-content');
                        const title = content?.querySelector('h2');
                        const subtitle = content?.querySelector('p');
                        const cta = content?.querySelector('.mt-7');

                        if (card) card.style.transform = '';
                        if (title) title.style.transform = '';
                        if (subtitle) subtitle.style.transform = '';
                        if (cta) cta.style.transform = '';
                    });
                    return;
                }

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

                    // 3D rotation effect (starts at 20deg, ends at 0deg)
                    const rotateX = 20 - (20 * progress);

                    // Scale effect desktop (tetap seperti semula)
                    const startScale = 1.05;
                    const endScale = 1;
                    const scale = startScale + ((endScale - startScale) * progress);

                    // Translate Y for content (moves up as you scroll)
                    const translateY = -100 * progress;

                    // Apply transforms
                    card.style.transform =
                        `perspective(1000px) rotateX(${rotateX.toFixed(2)}deg) scale(${scale.toFixed(3)})`;

                    if (title) title.style.transform = `translate3d(0, ${translateY.toFixed(2)}px, 0)`;
                    if (subtitle) subtitle.style.transform =
                    `translate3d(0, ${translateY.toFixed(2)}px, 0)`;
                    if (cta) cta.style.transform = `translate3d(0, ${translateY.toFixed(2)}px, 0)`;
                });
            };

            window.addEventListener('scroll', applyContainerScroll, {
                passive: true
            });
            window.addEventListener('resize', applyContainerScroll);
            applyContainerScroll();

            const mobileHero = document.querySelector('[data-mobile-hero-carousel]');
            if (mobileHero) {
                // Mobile hero carousel removed - using static banner now
            }

            const layoutClasses = {
                list: ['flex', 'flex-col', 'space-y-4'],
                '2col': ['grid', 'grid-cols-2', 'gap-6'],
                '4col': ['grid', 'grid-cols-1', 'gap-6', 'sm:grid-cols-2', 'lg:grid-cols-4'],
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

            if (testimonialShowcase) {
                const viewport = testimonialShowcase.querySelector('[data-testimonial-hero]');
                const track = testimonialShowcase.querySelector('[data-testimonial-track]');
                const dots = testimonialShowcase.querySelectorAll('.np-testimonial-dot');

                if (viewport && track && dots.length > 0) {
                    let currentSlide = 0;
                    const totalSlides = dots.length;
                    const slides = track.querySelectorAll('.np-testimonial-hero-slide');
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


            // Brand and Level Filter (server-side via URL params)
            const filterBrand = document.getElementById('filterBrand');
            const filterLevel = document.getElementById('filterLevel');

            function updateUrlParam(key, value) {
                const url = new URL(window.location.href);
                if (value) {
                    url.searchParams.set(key, value);
                } else {
                    url.searchParams.delete(key);
                }
                window.location.href = url.toString();
            }

            if (filterBrand) {
                filterBrand.addEventListener('change', function() {
                    updateUrlParam('brand', this.value);
                });
            }

            if (filterLevel) {
                filterLevel.addEventListener('change', function() {
                    updateUrlParam('level', this.value);
                });
            }

            // Price Range Filter (client-side only)
            const filterPriceRange = document.getElementById('filterPriceRange');
            const productGrid = document.getElementById('productGrid');
            const noResults = document.getElementById('noResults');

            const filterProducts = () => {
                const priceRange = filterPriceRange ? filterPriceRange.value : '';
                const products = document.querySelectorAll('.product-item');
                let visibleCount = 0;

                let minPrice = 0;
                let maxPrice = Infinity;

                if (priceRange) {
                    const [min, max] = priceRange.split('-').map(Number);
                    minPrice = min;
                    maxPrice = max;
                }

                products.forEach(product => {
                    const price = parseInt(product.dataset.price || '0');
                    const matchPrice = price >= minPrice && price <= maxPrice;

                    if (matchPrice) {
                        product.style.display = 'block';
                        visibleCount++;
                    } else {
                        product.style.display = 'none';
                    }
                });

                if (productGrid && noResults) {
                    if (visibleCount === 0) {
                        productGrid.style.display = 'none';
                        noResults.classList.remove('hidden');
                    } else {
                        productGrid.style.display = 'grid';
                        noResults.classList.add('hidden');
                    }
                }
            };

            if (filterPriceRange) {
                filterPriceRange.addEventListener('change', filterProducts);
            }

            // Mega Dropdown Hover Control
            const dropdownContainers = document.querySelectorAll('[data-dropdown]');
            let activeDropdown = null;
            let hoverTimeout = null;

            dropdownContainers.forEach(container => {
                const dropdown = container.querySelector('.absolute');

                container.addEventListener('mouseenter', () => {
                    if (hoverTimeout) {
                        clearTimeout(hoverTimeout);
                        hoverTimeout = null;
                    }

                    dropdownContainers.forEach(otherContainer => {
                        if (otherContainer !== container) {
                            const otherDropdown = otherContainer.querySelector('.absolute');
                            if (otherDropdown) {
                                otherDropdown.classList.add('invisible', 'opacity-0', 'translate-y-[-10px]');
                                otherDropdown.classList.remove('visible', 'opacity-100', 'translate-y-0');
                            }
                        }
                    });

                    if (dropdown) {
                        dropdown.classList.remove('invisible', 'opacity-0', 'translate-y-[-10px]');
                        dropdown.classList.add('visible', 'opacity-100', 'translate-y-0');
                    }
                    activeDropdown = container;
                });

                container.addEventListener('mouseleave', () => {
                    hoverTimeout = setTimeout(() => {
                        if (dropdown) {
                            dropdown.classList.add('invisible', 'opacity-0', 'translate-y-[-10px]');
                            dropdown.classList.remove('visible', 'opacity-100', 'translate-y-0');
                        }
                        activeDropdown = null;
                    }, 100);
                });

                if (dropdown) {
                    dropdown.addEventListener('mouseenter', () => {
                        if (hoverTimeout) {
                            clearTimeout(hoverTimeout);
                            hoverTimeout = null;
                        }
                    });

                    dropdown.addEventListener('mouseleave', () => {
                        hoverTimeout = setTimeout(() => {
                            dropdown.classList.add('invisible', 'opacity-0', 'translate-y-[-10px]');
                            dropdown.classList.remove('visible', 'opacity-100', 'translate-y-0');
                            activeDropdown = null;
                        }, 100);
                    });
                }
            });
        })();

        /* ============================================================
         * Buttery-Smooth Marquee Engine (requestAnimationFrame)
         * RAF syncs with the screen's actual refresh rate (60/120 fps)
         * guaranteeing zero stutter, zero pause, and zero glitch at loop.
         * ============================================================ */
        (function initMarquee() {
            const content = document.querySelector('.marquee-content');
            if (!content) return;

            const SPEED = 0.10; // vw per frame — slow & elegant, never pauses
            let offset = 0;
            let setWidth = 0; // width of one set of 6 logos in px
            let rafId = null;

            function getSetWidth() {
                // Total children = 12 (2 sets of 6). One set = first half.
                const items = content.children;
                const half = Math.floor(items.length / 2);
                let w = 0;
                for (let i = 0; i < half; i++) {
                    w += items[i].getBoundingClientRect().width;
                }
                return w;
            }

            function tick() {
                const pxPerFrame = (SPEED / 100) * window.innerWidth;
                offset += pxPerFrame;

                // Re-measure on first frame or after resize
                if (!setWidth) setWidth = getSetWidth();

                // Seamless snap: when offset equals one full set, reset to 0
                if (offset >= setWidth) {
                    offset -= setWidth;
                }

                content.style.transform = `translateX(${-offset}px)`;
                rafId = requestAnimationFrame(tick);
            }

            // Re-init on resize so setWidth stays accurate
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    setWidth = getSetWidth();
                }, 150);
            });

            // Pause on tab hidden, resume on visible (battery-friendly)
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    cancelAnimationFrame(rafId);
                } else {
                    rafId = requestAnimationFrame(tick);
                }
            });

            // Start the engine after images have loaded
            window.addEventListener('load', function() {
                setWidth = getSetWidth();
                rafId = requestAnimationFrame(tick);
            });
        })();
    </script>
    
@endpush
