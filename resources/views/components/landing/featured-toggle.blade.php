@props([
    'products' => collect(),
    'title' => 'Featured Products',
    'subtitle' => 'Curated essentials for serious athletes and premium performance lifestyle.',
    'sectionClass' => 'bg-[#f5f5f7] py-20 lg:py-24',
    'sectionId' => '',
])

@php
    $cardFallbackImage = '/images/logo.png';
@endphp

<section class="np-fade-section {{ $sectionClass }}" data-featured-toggle @if($sectionId) id="{{ $sectionId }}" @endif>
    <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
        <h2 class="text-center text-4xl font-semibold tracking-tight text-black sm:text-5xl">{{ $title }}</h2>
        <p class="mx-auto mt-3 max-w-2xl text-center text-zinc-600">{{ $subtitle }}</p>

    <div class="np-layout-grid mt-10 grid grid-cols-2 gap-4" data-grid>
            @forelse($products as $index => $product)
                <button
                    type="button"
                    class="np-layout-item group flex h-full w-full flex-col overflow-hidden rounded-xl border border-black/5 bg-white pb-6 text-start shadow-[0_8px_26px_rgba(0,0,0,0.05)] transition duration-300 hover:scale-[1.02] hover:shadow-[0_14px_34px_rgba(0,0,0,0.1)]"
                    data-product-trigger
                    data-product-id="{{ $product->id }}"
                    data-product-name="{{ e($product->name) }}"
                    data-product-category="{{ e($product->category_label) }}"
                    data-product-description="{{ e(\Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 180)) }}"
                    data-product-image="{{ $product->image_url ?: $cardFallbackImage }}"
                    data-product-price="{{ $product->hasActiveDiscount() ? $product->formatted_discounted_price : $product->formatted_price }}"
                    data-product-old-price="{{ $product->hasActiveDiscount() ? $product->formatted_price : '' }}"
                >
                    <div class="relative aspect-4/5 overflow-hidden bg-zinc-50">
                        <img
                            src="{{ $product->image_url ?: $cardFallbackImage }}"
                            alt="{{ $product->name }}"
                            class="h-full w-full object-cover"
                            onerror="this.onerror=null;this.src='{{ $cardFallbackImage }}';"
                            loading="lazy"
                        >
                        @if($product->has_variants)
                            <span class="absolute right-2 top-2 z-20 inline-flex items-center rounded-full bg-black/85 px-2 py-1 text-[10px] font-semibold text-white shadow">Varian</span>
                        @endif
                        @if($product->hasActiveDiscount())
                            <span class="absolute left-2 top-2 z-20 inline-flex items-center gap-1 rounded-full bg-rose-500 px-2 py-1 text-[10px] font-semibold text-white shadow">
                                <i class="fas fa-tag text-[9px]"></i>
                                -{{ $product->formatted_discount_percent }}
                            </span>
                        @endif
                        <div class="absolute inset-0 z-10 bg-slate-950/5 transition duration-300 group-hover:bg-slate-950/0"></div>
                    </div>
                    <div class="mt-auto grid grid-cols-[1fr_auto] items-end gap-3 px-4">
                        <div class="min-h-11">
                            <h3 class="line-clamp-1 text-sm font-semibold capitalize tracking-tight text-black">{{ $product->name }}</h3>
                            <p class="mt-1 line-clamp-1 text-[11px] text-zinc-500">{{ $product->category_label }}</p>
                        </div>
                        <p class="self-end text-xs tabular-nums leading-none tracking-tight text-slate-700">
                            @if($product->hasActiveDiscount())
                                <span class="font-semibold text-emerald-700 text-[11px] sm:text-xs">{{ $product->formatted_discounted_price }}</span>
                                <span class="ml-1 text-[9px] text-zinc-400 line-through sm:text-[10px]">{{ $product->formatted_price }}</span>
                            @else
                                {{ $product->formatted_price }}
                            @endif
                        </p>
                    </div>
                </button>
            @empty
                <div class="rounded-xl border border-dashed border-zinc-300 bg-white p-10 text-center text-zinc-500">Produk belum tersedia.</div>
            @endforelse
        </div>
    </div>
</section>