@extends('layouts.app')

@section('title', 'Produk - NoraPadel')

@section('content')
<div class="bg-white text-black antialiased">
    <header class="sticky top-0 z-50 border-b border-black/6 bg-white/80 backdrop-blur-xl">
        <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
            <a href="{{ route('home') }}" class="text-xl font-semibold tracking-tight text-black">NoraPadel</a>

            <nav class="hidden items-center gap-8 md:flex">
                <a href="{{ route('home') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Home</a>
                <a href="{{ route('customer.products.index') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Products</a>
                <a href="{{ route('racket') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Racket</a>
                <a href="{{ route('shoes') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Shoes</a>
                <a href="{{ route('apparel') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Accessories</a>
            </nav>

            <div class="flex items-center gap-3 text-black/80">
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
                <a href="{{ route('customer.products.index') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Products</a>
                <a href="{{ route('racket') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Racket</a>
                <a href="{{ route('shoes') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Shoes</a>
                <a href="{{ route('apparel') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Accessories</a>
            </nav>
        </div>
    </header>

<div class="mx-auto w-full max-w-7xl px-6 py-8 md:px-10 md:py-12 lg:px-12 lg:py-16">
    <div class="grid gap-6 lg:grid-cols-4">
        <!-- Sidebar Filters -->
        <div class="lg:col-span-1">
            <button class="mb-4 w-full rounded-2xl border border-black/10 bg-white px-4 py-3 text-left font-medium text-black lg:hidden" type="button" data-filter-toggle>
                <i class="fas fa-filter mr-2"></i>Filter Produk
                <i class="fas fa-chevron-down float-right mt-1"></i>
            </button>
            
            <div class="hidden overflow-hidden rounded-2xl border border-black/6 bg-white shadow-sm lg:block" data-filter-panel>
                <div class="border-b border-black/6 bg-zinc-50 px-6 py-4">
                    <h4 class="text-lg font-semibold text-black"><i class="fas fa-filter mr-2"></i>Filter Produk</h4>
                </div>
                <div class="px-6 py-6">
                    <form action="{{ route('customer.products.index') }}" method="GET" class="space-y-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-black">Cari Produk</label>
                            <input type="text" class="w-full rounded-xl border border-black/10 px-4 py-2.5 text-sm transition focus:border-black focus:outline-none focus:ring-1 focus:ring-black" name="search" placeholder="Nama produk..." value="{{ request('search') }}">
                        </div>
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-black">Kategori</label>
                            <select class="w-full rounded-xl border border-black/10 px-4 py-2.5 text-sm transition focus:border-black focus:outline-none focus:ring-1 focus:ring-black" name="category">
                                <option value="">Semua Kategori</option>
                                @foreach(\App\Models\Product::categories() as $value => $label)
                                    <option value="{{ $value }}" {{ request('category') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-black">Urutkan</label>
                            <select class="w-full rounded-xl border border-black/10 px-4 py-2.5 text-sm transition focus:border-black focus:outline-none focus:ring-1 focus:ring-black" name="sort">
                                <option value="">Terbaru</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="w-full rounded-full bg-black px-6 py-2.5 text-sm font-medium text-white transition hover:bg-black/90">
                            <i class="fas fa-search mr-2"></i>Terapkan Filter
                        </button>
                        
                        @if(request()->hasAny(['search', 'category', 'sort']))
                            <a href="{{ route('customer.products.index') }}" class="block w-full rounded-full border border-black/10 bg-white px-6 py-2.5 text-center text-sm font-medium text-black transition hover:bg-black hover:text-white">
                                Reset Filter
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="lg:col-span-3">
            <div class="mb-6 flex items-center justify-between">
                <h3 class="text-2xl font-semibold tracking-tight text-black sm:text-3xl">
                    <i class="fas fa-box mr-3 text-black"></i>Produk Kami
                </h3>
                <span class="text-sm text-zinc-500">{{ $products->total() }} produk</span>
            </div>
            
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                @forelse($products as $product)
                    <button type="button" class="group flex h-full w-full flex-col overflow-hidden rounded-2xl border border-black/6 bg-white text-start shadow-[0_8px_26px_rgba(0,0,0,0.05)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_16px_36px_rgba(0,0,0,0.09)]" data-product-trigger data-product-id="{{ $product->id }}" data-product-name="{{ e($product->name) }}" data-product-category="{{ e($product->category_label) }}" data-product-description="{{ e(\Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 180)) }}" data-product-image="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80' }}" data-product-price="{{ $product->hasActiveDiscount() ? $product->formatted_discounted_price : $product->formatted_price }}" data-product-old-price="{{ $product->hasActiveDiscount() ? $product->formatted_price : '' }}">
                        <div class="relative aspect-4/5 overflow-hidden bg-zinc-50">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80' }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                            @if($product->hasActiveDiscount())
                                <span class="absolute left-3 top-3 rounded-full bg-rose-500 px-2.5 py-1 text-[11px] font-semibold text-white">-{{ $product->formatted_discount_percent }}</span>
                            @endif
                        </div>

                        <div class="flex flex-1 flex-col p-4">
                            <div class="mb-2">
                                <span class="rounded-full px-2 py-0.5 text-[10px] font-medium {{ $product->category == 'original' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">{{ $product->category_label }}</span>
                            </div>
                            <h3 class="line-clamp-2 text-base font-semibold tracking-tight text-black">{{ $product->name }}</h3>

                            <div class="mt-auto pt-4">
                                @if($product->hasActiveDiscount())
                                    <p class="text-base font-semibold text-emerald-600">{{ $product->formatted_discounted_price }}</p>
                                    <p class="text-xs text-zinc-400 line-through">{{ $product->formatted_price }}</p>
                                @else
                                    <p class="text-base font-semibold text-emerald-600">{{ $product->formatted_price }}</p>
                                @endif
                            </div>
                        </div>
                    </button>
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 p-12 text-center">
                        <i class="fas fa-box-open text-3xl text-zinc-400"></i>
                        <p class="mt-3 font-medium text-zinc-500">Tidak ada produk ditemukan</p>
                    </div>
                @endforelse
            </div>
            
            @if($products->hasPages())
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<footer class="border-t border-black/10 bg-white py-14 text-sm text-zinc-500">
    <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
        <div class="text-center">
            <p class="text-xs text-zinc-400">© {{ now()->year }} NoraPadel. All rights reserved.</p>
        </div>
    </div>
</footer>
</div>
@endsection

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
@endpush

@push('scripts')
<script>
(function() {
    const filterToggle = document.querySelector('[data-filter-toggle]');
    const filterPanel = document.querySelector('[data-filter-panel]');
    const mobileMenuToggle = document.querySelector('[data-mobile-menu-toggle]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');

    if (filterToggle && filterPanel) {
        filterToggle.addEventListener('click', () => {
            filterPanel.classList.toggle('hidden');
        });
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
