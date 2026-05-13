@extends('layouts.app')

@section('title', $product->name . ' - NoraPadel')

@section('content')
<div class="bg-white text-black antialiased">
    <!-- Navbar sama seperti home_luxury -->
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
                <a href="{{ route('contact') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Contact</a>
            </nav>

            <div class="flex items-center gap-3 text-black/80">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 rounded-full border border-black/15 bg-black px-4 py-1.5 text-xs font-medium text-white transition duration-300 hover:bg-black/90" aria-label="Back to Dashboard">
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
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1 rounded-full border border-black/15 px-3 py-1.5 text-xs font-medium text-black/80 transition duration-300 hover:border-black/30 hover:text-black" aria-label="Masuk">
                        <i class="fas fa-sign-in-alt text-[11px]"></i>
                        <span>Masuk</span>
                    </a>
                @endguest
                
                <a href="{{ route('customer.wishlist.index') }}" class="relative transition duration-300 hover:text-black" aria-label="Wishlist" title="Wishlist">
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
                
                <a href="{{ route('customer.cart.index') }}" class="relative transition duration-300 hover:text-black" aria-label="Cart" title="Keranjang">
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
                        <span class="absolute -right-2 -top-2 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                    @endif
                </a>
                
                <div class="relative">
                    <button onclick="toggleSearchDropdown()" class="transition duration-300 hover:text-black" aria-label="Search" title="Cari Produk">
                        <i class="fas fa-search text-sm"></i>
                    </button>
                    
                    <!-- Search Dropdown -->
                    <div id="searchDropdown" class="hidden absolute right-0 top-full mt-2 w-80 bg-white rounded-lg shadow-xl border border-zinc-200 p-3 z-50">
                        <div class="flex gap-2">
                            <input type="text" placeholder="Cari produk..." class="flex-1 px-3 py-2 text-sm text-black border border-zinc-300 rounded-lg focus:outline-none focus:border-blue-500" id="searchInput" autocomplete="off">
                            <button type="button" class="px-4 py-2 bg-black text-white text-sm rounded-lg hover:bg-zinc-800 transition">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <div id="searchResults" class="mt-2 max-h-60 overflow-y-auto hidden">
                            <!-- Search results will appear here -->
                        </div>
                    </div>
                </div>
                
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

    <main class="pt-16 md:pt-0">
        <div class="bg-white min-h-screen py-8">
            <div class="container mx-auto px-4 max-w-7xl">
                <!-- Breadcrumb -->
                <nav class="mb-6 text-sm">
                    <ol class="flex items-center gap-2 text-zinc-600">
                        <li><a href="{{ route('home') }}" class="hover:text-black transition">Home</a></li>
                        <li><i class="fas fa-chevron-right text-xs"></i></li>
                        <li><a href="{{ route('produk.index') }}" class="hover:text-black transition">Produk</a></li>
                        <li><i class="fas fa-chevron-right text-xs"></i></li>
                        <li class="text-black font-medium">{{ $product->name }}</li>
                    </ol>
                </nav>

                <div class="grid md:grid-cols-[auto_1fr] gap-5 lg:gap-6">
                    <!-- Product Gallery -->
                    <div class="flex gap-3 max-w-[600px]" x-data="{ activeImage: '{{ $product->image_url }}' }">
                        <!-- Thumbnails -->
                        <div class="flex flex-col gap-3">
                            @php
                                $allImages = $product->all_images;
                            @endphp
                            @foreach($allImages as $index => $imageUrl)
                                <button @click="activeImage = '{{ $imageUrl }}'" 
                                        class="w-16 h-16 md:w-20 md:h-20 bg-zinc-50 transition-all duration-200 flex items-center justify-center p-1.5 overflow-hidden"
                                        :class="activeImage === '{{ $imageUrl }}' ? 'ring-2 ring-black ring-offset-2' : 'hover:bg-zinc-100'">
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }} - Gambar {{ $index + 1 }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>

                        <!-- Main Image -->
                        <div class="flex-1 relative group">
                            <div class="w-full bg-zinc-50 overflow-hidden flex items-center justify-center relative aspect-square max-w-[500px]">
                                <img :src="activeImage" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover transition-all duration-500 ease-out"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100">
                                @if($product->hasActiveDiscount())
                                    <span class="absolute left-3 top-3 bg-rose-500 px-3 py-1.5 text-xs font-semibold text-white z-10 rounded">-{{ $product->formatted_discount_percent }}</span>
                                @endif
                                @if($product->package_type === 'bundle')
                                    <span class="absolute left-3 {{ $product->hasActiveDiscount() ? 'top-12' : 'top-3' }} bg-purple-500 px-3 py-1.5 text-xs font-semibold text-white z-10 rounded">Bundle</span>
                                @endif
                                @if($product->isBestSeller())
                                    <span class="absolute right-3 top-3 bg-amber-500 px-3 py-1.5 text-xs font-semibold text-white z-10 rounded">Best Seller</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Product Info - Lebih Compact -->
                    <div class="space-y-4">
                        <!-- Category Badge -->
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-zinc-100 text-zinc-700 border border-zinc-200">
                                {{ $product->category_label }}
                            </span>
                            
                            @if($product->package_type === 'bundle')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 border border-purple-200">
                                    <i class="fas fa-box-open text-[10px]"></i>
                                    Bundling
                                </span>
                            @endif
                            
                            @if($product->hasActiveDiscount())
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                    Diskon {{ $product->formatted_discount_percent }}
                                </span>
                            @endif

                            @if($product->stock <= 0)
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-zinc-100 text-zinc-500 border border-zinc-200">
                                    Stok Habis
                                </span>
                            @endif
                        </div>

                        <!-- Product Name -->
                        <div>
                            <h1 class="text-xl md:text-2xl font-semibold text-black tracking-tight leading-tight">{{ $product->name }}</h1>
                        </div>

                        <!-- Rating & Terjual -->
                        <div class="flex items-center gap-4 text-sm">
                            <div class="flex items-center gap-1">
                                @php
                                    $totalSold = \App\Models\OrderItem::where('product_id', $product->id)
                                        ->whereHas('order', function($q) {
                                            $q->whereIn('status', ['completed', 'delivered']);
                                        })->sum('quantity');
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-zinc-500 text-sm"></i>
                                @endfor
                                <span class="text-zinc-600 ml-1">5.0</span>
                            </div>
                            <span class="text-zinc-400">|</span>
                            <div class="text-zinc-600">
                                <i class="fas fa-box text-xs mr-1"></i>
                                <span class="font-semibold text-black">{{ $totalSold }}</span> Terjual
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="space-y-1">
                            @if($product->hasActiveDiscount())
                                <div class="flex items-baseline gap-3">
                                    <span class="text-3xl font-bold text-black">{{ $product->formatted_discounted_price }}</span>
                                    <span class="text-lg text-zinc-400 line-through">{{ $product->formatted_price }}</span>
                                </div>
                                <p class="text-sm text-green-600 font-medium">
                                    <i class="fas fa-tag mr-1"></i>Hemat {{ $product->formatted_discount_amount }}
                                </p>
                            @else
                                <span class="text-3xl font-bold text-black">{{ $product->formatted_price }}</span>
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="border-t border-zinc-200 pt-4">
                            <h3 class="text-xs font-semibold text-black uppercase tracking-wider mb-2">Deskripsi Produk</h3>
                            @php
                                $rawDescription = trim((string) $product->description);

                                // Split by new lines first, fallback to sentence split.
                                $parts = preg_split("/\r\n|\r|\n/", $rawDescription) ?: [];
                                $parts = array_values(array_filter(array_map('trim', $parts)));

                                if (count($parts) === 0 && $rawDescription !== '') {
                                    $sentences = preg_split('/(?<=[.!?])\s+/', $rawDescription) ?: [];
                                    $sentences = array_values(array_filter(array_map('trim', $sentences)));

                                    // Build up to 3 short paragraphs from sentences.
                                    $parts = [];
                                    $buffer = '';
                                    foreach ($sentences as $sentence) {
                                        $candidate = trim($buffer === '' ? $sentence : ($buffer . ' ' . $sentence));
                                        if (mb_strlen($candidate) > 180 && $buffer !== '') {
                                            $parts[] = $buffer;
                                            $buffer = $sentence;
                                            if (count($parts) >= 3) break;
                                        } else {
                                            $buffer = $candidate;
                                        }
                                    }
                                    if (count($parts) < 3 && trim($buffer) !== '') {
                                        $parts[] = trim($buffer);
                                    }
                                }

                                $maxParagraphs = 2;
                                $displayParts = array_slice($parts, 0, $maxParagraphs);

                                // Clamp each paragraph length to keep it tidy.
                                $displayParts = array_map(function ($p) {
                                    $p = trim((string) $p);
                                    if (mb_strlen($p) > 220) {
                                        return rtrim(mb_substr($p, 0, 217)) . '...';
                                    }
                                    return $p;
                                }, $displayParts);

                                $hasMore = count($parts) > $maxParagraphs;
                            @endphp

                            <div class="space-y-2 text-sm text-zinc-600 leading-relaxed">
                                @forelse($displayParts as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @empty
                                    <p class="text-zinc-500">Belum ada deskripsi.</p>
                                @endforelse
                                @if($hasMore)
                                    <p class="text-zinc-500">...</p>
                                @endif
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="border-t border-zinc-200 pt-4">
                            <h3 class="text-xs font-semibold text-black uppercase tracking-wider mb-2">Detail Produk</h3>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div class="flex items-center gap-2 text-zinc-600">
                                    <i class="fas fa-weight-hanging w-4 text-xs"></i>
                                    <span>Berat: <strong class="text-black">{{ $product->formatted_weight }}</strong></span>
                                </div>
                                <div class="flex items-center gap-2 text-zinc-600">
                                    <i class="fas fa-boxes w-4 text-xs"></i>
                                    <span>Stok: <strong class="text-black">{{ $product->stock }}</strong></span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="border-t border-zinc-200 pt-4 space-y-2">
                            @if($product->stock > 0)
                                <form action="{{ route('customer.cart.add', $product) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full border border-black bg-black px-3 py-3 text-sm font-semibold text-white transition duration-200 hover:bg-black/90 hover:border-black/90 flex items-center justify-center gap-2">
                                        <i class="fas fa-shopping-cart text-sm"></i>
                                        Add to Cart
                                    </button>
                                </form>
                            @else
                                <button disabled class="w-full bg-zinc-200 text-zinc-500 py-3 font-semibold text-sm cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Customer Reviews Section -->
                <section class="mt-16 pt-12 border-t border-zinc-200">
                    <div class="grid lg:grid-cols-[35%_65%] gap-12">
                        <!-- Left Column - Review Summary -->
                        <div class="space-y-8">
                            <div>
                                <p class="text-[10px] font-semibold tracking-[0.15em] text-zinc-400 uppercase mb-4">Customer Reviews</p>
                                <div class="flex items-end gap-3 mb-3">
                                    <span class="text-5xl font-light text-black">{{ $avgRating > 0 ? number_format($avgRating, 1) : '0.0' }}</span>
                                    <span class="text-xl text-zinc-400 mb-2">/5</span>
                                </div>
                                <div class="flex items-center gap-1 mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= floor($avgRating) ? 'text-black' : 'text-zinc-200' }} text-sm"></i>
                                    @endfor
                                </div>
                                <p class="text-[11px] font-medium tracking-[0.1em] text-zinc-500 uppercase">{{ $totalReviews }} {{ $totalReviews === 1 ? 'Review' : 'Reviews' }}</p>
                            </div>

                            <!-- Rating Breakdown -->
                            <div class="space-y-3">
                                @foreach($ratingBreakdown as $star => $percent)
                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-zinc-600 w-8">{{ $star }}★</span>
                                    <div class="flex-1 h-1 bg-zinc-100 overflow-hidden">
                                        <div class="h-full bg-black transition-all duration-300" style="width: {{ $percent }}%"></div>
                                    </div>
                                    <span class="text-xs text-zinc-500 w-10 text-right">{{ $percent }}%</span>
                                </div>
                                @endforeach
                            </div>

                            @if($totalReviews > 0)
                            <!-- Quality Indicator -->
                            <div class="pt-4 border-t border-zinc-100">
                                <p class="text-[10px] font-semibold tracking-[0.15em] text-zinc-400 uppercase mb-3">Quality</p>
                                <div class="relative">
                                    <div class="h-1 bg-zinc-100">
                                        <div class="absolute top-1/2 -translate-y-1/2 w-3 h-3 bg-black rounded-full" style="left: {{ $avgQuality }}%"></div>
                                    </div>
                                    <div class="flex justify-between mt-2">
                                        <span class="text-[9px] text-zinc-400 uppercase tracking-wider">Very Low</span>
                                        <span class="text-[9px] text-zinc-400 uppercase tracking-wider">Very High</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Sizing Indicator -->
                            <div class="pt-4 border-t border-zinc-100">
                                <p class="text-[10px] font-semibold tracking-[0.15em] text-zinc-400 uppercase mb-3">How was the sizing?</p>
                                <div class="relative">
                                    <div class="h-1 bg-zinc-100">
                                        <div class="absolute top-1/2 -translate-y-1/2 w-3 h-3 bg-black rounded-full" style="left: {{ $avgSizing }}%"></div>
                                    </div>
                                    <div class="flex justify-between mt-2">
                                        <span class="text-[9px] text-zinc-400 uppercase tracking-wider">Runs Small</span>
                                        <span class="text-[9px] text-zinc-400 uppercase tracking-wider">True to Size</span>
                                        <span class="text-[9px] text-zinc-400 uppercase tracking-wider">Runs Large</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Usual Size -->
                            @if($usualSizes->count() > 0)
                            <div class="pt-4 border-t border-zinc-100">
                                <p class="text-[10px] font-semibold tracking-[0.15em] text-zinc-400 uppercase mb-3">Usual Size?</p>
                                <div class="flex gap-2 flex-wrap">
                                    @foreach($usualSizes as $size => $count)
                                        <span class="text-xs text-zinc-600">{{ $size }} ({{ $count }})</span>
                                        @if(!$loop->last)
                                            <span class="text-zinc-300">·</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @endif
                        </div>

                        <!-- Right Column - Reviews List -->
                        <div class="space-y-6">
                            <!-- Header -->
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-[11px] font-semibold tracking-[0.15em] text-black uppercase">Reviews {{ $totalReviews }}</h3>
                                @auth
                                    <button onclick="openReviewModal()" class="bg-black text-white px-6 py-2.5 text-[10px] font-semibold tracking-[0.1em] uppercase transition duration-200 hover:bg-white hover:text-black border border-black">
                                        Write a Review
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="bg-black text-white px-6 py-2.5 text-[10px] font-semibold tracking-[0.1em] uppercase transition duration-200 hover:bg-white hover:text-black border border-black">
                                        Login to Review
                                    </a>
                                @endauth
                            </div>

                            <!-- Search & Filter -->
                            <div class="flex gap-3 mb-8">
                                <input type="text" placeholder="Search reviews" class="flex-1 px-4 py-2.5 border border-zinc-200 text-sm focus:outline-none focus:border-zinc-400 transition">
                                <select class="px-4 py-2.5 border border-zinc-200 text-sm focus:outline-none focus:border-zinc-400 transition bg-white">
                                    <option>All ratings</option>
                                    <option>5 stars</option>
                                    <option>4 stars</option>
                                    <option>3 stars</option>
                                    <option>2 stars</option>
                                    <option>1 star</option>
                                </select>
                            </div>

                            <!-- Reviews List -->
                            @if($reviews->count() > 0)
                            <div class="space-y-0">
                                @foreach($reviews as $review)
                                <div class="py-8 border-b border-zinc-100 last:border-0">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <h4 class="text-xs font-semibold tracking-[0.05em] text-black uppercase">{{ $review->user->name }}</h4>
                                                @if($review->is_verified)
                                                <span class="text-[9px] text-zinc-400 uppercase tracking-wider">· Verified Buyer</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-black' : 'text-zinc-200' }} text-xs"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <span class="text-[10px] text-zinc-400">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>

                                    @if($review->comment)
                                    <p class="text-sm text-zinc-600 leading-relaxed mb-4">{{ $review->comment }}</p>
                                    @endif

                                    <div class="grid grid-cols-3 gap-4 pt-4 border-t border-zinc-50">
                                        @if($review->usual_size)
                                        <div>
                                            <p class="text-[9px] font-semibold tracking-[0.1em] text-zinc-400 uppercase mb-2">Usual Size</p>
                                            <p class="text-xs text-zinc-600">{{ $review->usual_size }}</p>
                                        </div>
                                        @endif
                                        @if($review->quality_rating)
                                        <div>
                                            <p class="text-[9px] font-semibold tracking-[0.1em] text-zinc-400 uppercase mb-2">Quality</p>
                                            <div class="relative h-1 bg-zinc-100 mt-2">
                                                <div class="absolute top-0 left-0 h-full bg-black" style="width: {{ $review->quality_rating }}%"></div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($review->sizing_rating)
                                        <div>
                                            <p class="text-[9px] font-semibold tracking-[0.1em] text-zinc-400 uppercase mb-2">Sizing</p>
                                            <div class="relative h-1 bg-zinc-100 mt-2">
                                                <div class="absolute top-1/2 -translate-y-1/2 w-2 h-2 bg-black rounded-full" style="left: {{ $review->sizing_rating }}%"></div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="py-12 text-center">
                                <i class="fas fa-star text-4xl text-zinc-200 mb-3"></i>
                                <p class="text-sm text-zinc-500">No reviews yet. Be the first to review this product!</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </section>

                <!-- Related Products -->
                @if($relatedProducts->count() > 0)
                <div class="mt-16 pt-12 border-t border-zinc-200">
                    <div class="mb-6">
                        <h2 class="text-2xl font-semibold tracking-tight text-black">Produk Terkait</h2>
                        <p class="mt-2 text-zinc-600">Produk lain yang mungkin Anda suka</p>
                    </div>

                    <div class="flex gap-4 overflow-x-auto pb-3 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden snap-x snap-mandatory">
                        @foreach($relatedProducts as $related)
                        @php
                            $soldCount = \App\Models\OrderItem::where('product_id', $related->id)
                                ->whereHas('order', function($q) {
                                    $q->whereIn('status', ['completed', 'delivered']);
                                })->sum('quantity');
                        @endphp
                        <div class="product-item group snap-start shrink-0 basis-[85%] sm:basis-[48%] md:basis-[31%] lg:basis-[23.5%] block overflow-hidden bg-white transition duration-300 hover:-translate-y-1"
                             data-name="{{ strtolower($related->name) }}"
                             data-price="{{ $related->hasActiveDiscount() ? $related->discounted_price : $related->price }}"
                             data-discount="{{ $related->hasActiveDiscount() ? 'yes' : 'no' }}"
                             data-bundle="{{ $related->package_type === 'bundle' ? 'yes' : 'no' }}"
                             data-sold="{{ $soldCount }}">
                            <a href="{{ route('produk.show', $related) }}" class="block relative">
                                <div class="relative aspect-square overflow-hidden">
                                    <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" onerror="this.onerror=null;this.src='/images/logo.png';" loading="lazy">
                                    
                                    <!-- Discount Badge - Always Visible -->
                                    @if($related->hasActiveDiscount())
                                        <span class="absolute left-0 top-0 z-20 bg-rose-500 px-2 py-1 text-[10px] font-bold text-white shadow-md">-{{ $related->formatted_discount_percent }}</span>
                                    @endif
                                    
                                    <!-- Latest Badge -->
                                    @if($related->category === 'arrivals')
                                        <span class="absolute left-0 {{ $related->hasActiveDiscount() ? 'top-8' : 'top-0' }} z-20 bg-blue-500 px-2 py-1 text-[10px] font-bold text-white shadow-md">Latest</span>
                                    @endif
                                    
                                    <!-- Bundle Badge -->
                                    @if($related->package_type === 'bundle')
                                        <span class="absolute left-0 {{ $related->hasActiveDiscount() && $related->category === 'arrivals' ? 'top-16' : ($related->hasActiveDiscount() || $related->category === 'arrivals' ? 'top-8' : 'top-0') }} z-20 bg-purple-500 px-2 py-1 text-[10px] font-bold text-white shadow-md">Bundle</span>
                                    @endif
                                    
                                    <!-- Popular Badge -->
                                    @if($related->isBestSeller())
                                        <span class="absolute right-0 top-0 z-20 bg-amber-500 px-2 py-1 text-[10px] font-bold text-white shadow-md">Popular</span>
                                    @endif
                                </div>
                                <div class="p-3">
                                    <h3 class="line-clamp-1 text-sm font-semibold text-black">{{ $related->name }}</h3>
                                    <p class="mt-1 text-xs text-zinc-600">{{ $related->category_label }}</p>
                                    @if($related->hasActiveDiscount())
                                        <p class="mt-1 text-base font-bold text-black">{{ $related->formatted_discounted_price }}</p>
                                        <p class="text-xs text-zinc-400 line-through">{{ $related->formatted_price }}</p>
                                    @else
                                        <p class="mt-1 text-base font-bold text-black">{{ $related->formatted_price }}</p>
                                    @endif
                                </div>
                            </a>
                            <div class="px-3 pb-3">
                                <div class="flex items-center gap-3">
                                    <button onclick="addToCart('{{ $related->slug }}', event)" class="border border-zinc-300 bg-transparent px-3 py-1.5 text-[11px] font-semibold text-zinc-800 transition duration-300 hover:border-zinc-500 hover:text-zinc-950">
                                        Add to cart
                                    </button>
                                    <button onclick="addToWishlist('{{ $related->slug }}', event)" class="text-zinc-400 transition duration-300 hover:text-rose-500">
                                        <i class="fas fa-heart text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </main>
</div>

<x-search-modal />
@endsection

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
    #mainNavbar,
    .mobile-bottom-nav {
        display: none !important;
    }

    .np-testimonial-hero-track {
        display: flex;
        gap: 0.75rem;
        transition: transform 700ms ease;
        will-change: transform;
    }

    .np-testimonial-hero-slide {
        position: relative;
        min-width: calc(100% - 2.5rem);
        overflow: hidden;
        border-radius: 1rem;
    }

    @media (min-width: 768px) {
        .np-testimonial-hero-slide {
            min-width: calc(100% - 7rem);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Add to Cart Function
    function addToCart(productId, event) {
        event.preventDefault();
        event.stopPropagation();
        
        fetch(`/customer/cart/add/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity: 1 })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Produk berhasil ditambahkan ke keranjang!');
                location.reload();
            } else {
                alert(data.message || 'Gagal menambahkan produk ke keranjang');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    }

    // Add to Wishlist Function
    function addToWishlist(productId, event) {
        event.preventDefault();
        event.stopPropagation();
        
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
                alert('Produk berhasil ditambahkan ke wishlist!');
                location.reload();
            } else {
                alert(data.message || 'Produk sudah ada di wishlist');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    }

(function() {
    const mobileMenuToggle = document.querySelector('[data-mobile-menu-toggle]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            mobileMenuToggle.setAttribute('aria-expanded', String(!mobileMenu.classList.contains('hidden')));
        });
    }

    // Search Dropdown Toggle
    window.toggleSearchDropdown = function() {
        const dropdown = document.getElementById('searchDropdown');
        if (dropdown) {
            dropdown.classList.toggle('hidden');
            if (!dropdown.classList.contains('hidden')) {
                const navbarSearchInput = document.getElementById('searchInput');
                if (navbarSearchInput) {
                    navbarSearchInput.focus();
                    // Attach autocomplete listener if not already attached
                    if (!navbarSearchInput.hasAttribute('data-autocomplete-attached')) {
                        attachAutocompleteListener(navbarSearchInput);
                        navbarSearchInput.setAttribute('data-autocomplete-attached', 'true');
                    }
                }
            }
        }
    };

    // Close search dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('searchDropdown');
        const searchButton = event.target.closest('button[onclick="toggleSearchDropdown()"]');
        
        if (dropdown && !dropdown.contains(event.target) && !searchButton) {
            dropdown.classList.add('hidden');
        }
    });

    // Autocomplete Search Function
    function attachAutocompleteListener(searchInput) {
        const searchResults = document.getElementById('searchResults');
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length < 2) {
                searchResults.classList.add('hidden');
                searchResults.innerHTML = '';
                return;
            }
            
            searchTimeout = setTimeout(() => {
                fetch(`/api/products/search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.products && data.products.length > 0) {
                            searchResults.innerHTML = data.products.map(product => `
                                <a href="${product.url}" class="flex items-center gap-3 p-2 hover:bg-zinc-100 rounded-lg transition">
                                    <img src="${product.image}" alt="${product.name}" class="w-12 h-12 object-cover rounded">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-black truncate">${product.name}</p>
                                        <p class="text-xs text-zinc-600">${product.category}</p>
                                    </div>
                                    <p class="text-sm font-semibold text-black">${product.price}</p>
                                </a>
                            `).join('');
                            searchResults.classList.remove('hidden');
                        } else {
                            searchResults.innerHTML = '<p class="text-sm text-zinc-500 p-2 text-center">Tidak ada produk ditemukan</p>';
                            searchResults.classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                    });
            }, 300);
        });
    }

    // Product Filter & Search
    const searchInput = document.getElementById('searchProduct');
    const filterDiscount = document.getElementById('filterDiscount');
    const filterPriceBtn = document.getElementById('filterPrice');
    const priceRangeFilter = document.getElementById('priceRangeFilter');
    const applyPriceBtn = document.getElementById('applyPriceFilter');
    const resetPriceBtn = document.getElementById('resetPriceFilter');
    const minPriceInput = document.getElementById('minPrice');
    const maxPriceInput = document.getElementById('maxPrice');
    const productGrid = document.getElementById('productGrid');
    const noResults = document.getElementById('noResults');

    let minPrice = 0;
    let maxPrice = Infinity;

    if (filterPriceBtn && priceRangeFilter) {
        filterPriceBtn.addEventListener('click', () => {
            priceRangeFilter.classList.toggle('hidden');
        });
    }

    if (applyPriceBtn) {
        applyPriceBtn.addEventListener('click', () => {
            minPrice = parseInt(minPriceInput.value) || 0;
            maxPrice = parseInt(maxPriceInput.value) || Infinity;
            filterProducts();
        });
    }

    if (resetPriceBtn) {
        resetPriceBtn.addEventListener('click', () => {
            minPriceInput.value = '';
            maxPriceInput.value = '';
            minPrice = 0;
            maxPrice = Infinity;
            filterProducts();
        });
    }

    function filterProducts() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const discountFilter = filterDiscount ? filterDiscount.value : '';
        const bundleFilter = document.getElementById('filterBundle') ? document.getElementById('filterBundle').value : '';
        const popularFilter = document.getElementById('filterPopular') ? document.getElementById('filterPopular').value : '';
        const products = document.querySelectorAll('.product-item');
        let visibleCount = 0;

        products.forEach(product => {
            const name = product.dataset.name;
            const price = parseInt(product.dataset.price);
            const discount = product.dataset.discount;
            const bundle = product.dataset.bundle;
            const sold = parseInt(product.dataset.sold || 0);

            const matchSearch = name.includes(searchTerm);
            const matchDiscount = !discountFilter || discount === discountFilter;
            const matchPrice = price >= minPrice && price <= maxPrice;
            const matchBundle = !bundleFilter || bundle === bundleFilter;
            const matchPopular = !popularFilter || (popularFilter === 'yes' && sold > 10);

            if (matchSearch && matchDiscount && matchPrice && matchBundle && matchPopular) {
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
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterProducts);
    }

    if (filterDiscount) {
        filterDiscount.addEventListener('change', filterProducts);
    }

    const filterBundleEl = document.getElementById('filterBundle');
    if (filterBundleEl) {
        filterBundleEl.addEventListener('change', filterProducts);
    }

    const filterPopularEl = document.getElementById('filterPopular');
    if (filterPopularEl) {
        filterPopularEl.addEventListener('change', filterProducts);
    }

    // Testimonial carousel
    const testimonialShowcase = document.querySelector('[data-testimonial-hero]');
    if (testimonialShowcase) {
        const viewport = testimonialShowcase;
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
})();

// Review Modal
function openReviewModal() {
    document.getElementById('reviewModal').classList.remove('hidden');
}

function closeReviewModal() {
    document.getElementById('reviewModal').classList.add('hidden');
}

// Handle star rating selection
function selectRating(rating) {
    document.querySelectorAll('.star-rating i').forEach((star, index) => {
        if (index < rating) {
            star.classList.remove('text-zinc-200');
            star.classList.add('text-black');
        } else {
            star.classList.remove('text-black');
            star.classList.add('text-zinc-200');
        }
    });
    document.getElementById('ratingInput').value = rating;
}

// Handle quality rating slider
document.getElementById('qualityRatingInput')?.addEventListener('input', function() {
    document.getElementById('qualityRatingValue').textContent = this.value + '%';
});

// Handle sizing rating slider
document.getElementById('sizingRatingInput')?.addEventListener('input', function() {
    document.getElementById('sizingRatingValue').textContent = this.value + '%';
});

// Submit review form
document.getElementById('reviewForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ route('customer.reviews.store', $product) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            rating: formData.get('rating'),
            comment: formData.get('comment'),
            quality_rating: formData.get('quality_rating'),
            sizing_rating: formData.get('sizing_rating'),
            usual_size: formData.get('usual_size')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            closeReviewModal();
            location.reload();
        } else {
            alert(data.message || 'Gagal mengirim review');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
});
</script>

<!-- Review Modal -->
<div id="reviewModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="relative w-full max-w-lg mx-4 bg-white rounded-2xl shadow-xl">
        <div class="flex items-center justify-between p-6 border-b border-zinc-200">
            <h3 class="text-lg font-semibold text-black">Write a Review</h3>
            <button onclick="closeReviewModal()" class="text-zinc-400 hover:text-black transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="reviewForm" class="p-6 space-y-4">
            <!-- Rating -->
            <div>
                <label class="block text-sm font-medium text-black mb-2">Rating *</label>
                <div class="flex gap-2 star-rating cursor-pointer">
                    <i class="fas fa-star text-2xl text-zinc-200 hover:text-black transition" onclick="selectRating(1)"></i>
                    <i class="fas fa-star text-2xl text-zinc-200 hover:text-black transition" onclick="selectRating(2)"></i>
                    <i class="fas fa-star text-2xl text-zinc-200 hover:text-black transition" onclick="selectRating(3)"></i>
                    <i class="fas fa-star text-2xl text-zinc-200 hover:text-black transition" onclick="selectRating(4)"></i>
                    <i class="fas fa-star text-2xl text-zinc-200 hover:text-black transition" onclick="selectRating(5)"></i>
                </div>
                <input type="hidden" id="ratingInput" name="rating" required>
            </div>

            <!-- Comment -->
            <div>
                <label for="comment" class="block text-sm font-medium text-black mb-2">Comment</label>
                <textarea id="comment" name="comment" rows="4" class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg text-sm focus:outline-none focus:border-zinc-400 transition" placeholder="Share your experience with this product..."></textarea>
            </div>

            <!-- Quality Rating -->
            <div>
                <label for="qualityRatingInput" class="block text-sm font-medium text-black mb-2">Quality Rating</label>
                <input type="range" id="qualityRatingInput" name="quality_rating" min="0" max="100" value="50" class="w-full">
                <div class="flex justify-between text-xs text-zinc-500 mt-1">
                    <span>Low</span>
                    <span id="qualityRatingValue">50%</span>
                    <span>High</span>
                </div>
            </div>

            <!-- Sizing Rating -->
            <div>
                <label for="sizingRatingInput" class="block text-sm font-medium text-black mb-2">Sizing Rating</label>
                <input type="range" id="sizingRatingInput" name="sizing_rating" min="0" max="100" value="50" class="w-full">
                <div class="flex justify-between text-xs text-zinc-500 mt-1">
                    <span>Runs Small</span>
                    <span id="sizingRatingValue">50%</span>
                    <span>Runs Large</span>
                </div>
            </div>

            <!-- Usual Size -->
            <div>
                <label for="usualSize" class="block text-sm font-medium text-black mb-2">Usual Size (Optional)</label>
                <input type="text" id="usualSize" name="usual_size" class="w-full px-4 py-2.5 border border-zinc-200 rounded-lg text-sm focus:outline-none focus:border-zinc-400 transition" placeholder="e.g., M, L, 42, etc.">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-black text-white py-3 rounded-lg font-semibold text-sm hover:bg-black/90 transition">
                Submit Review
            </button>
        </form>
    </div>
</div>
@endpush
