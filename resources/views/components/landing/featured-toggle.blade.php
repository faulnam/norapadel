@props([
    'products' => collect(),
    'title' => 'Featured Products',
    'subtitle' => 'Curated essentials for serious athletes and premium performance lifestyle.',
])

@php
    $fallbackImages = [
        'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1491553895911-0055eca6402d?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1582588678413-dbf45f4823e9?auto=format&fit=crop&w=900&q=80',
    ];
@endphp

<section class="np-fade-section bg-[#f5f5f7] py-20 lg:py-24" data-featured-toggle>
    <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
        <h2 class="text-center text-4xl font-semibold tracking-tight text-black sm:text-5xl">{{ $title }}</h2>
        <p class="mx-auto mt-3 max-w-2xl text-center text-zinc-600">{{ $subtitle }}</p>

        <div class="mt-10 flex justify-center">
            <div class="inline-flex overflow-hidden rounded-md border border-black/15 bg-white text-xs font-medium text-zinc-700 shadow-[0_4px_14px_rgba(0,0,0,0.06)]" role="tablist" aria-label="Layout Toggle">
                <button type="button" class="np-layout-btn bg-zinc-900 px-3 py-2 text-white transition duration-300" data-mode="list">list view</button>
                <button type="button" class="np-layout-btn border-x border-black/10 px-3 py-2 transition duration-300 hover:bg-zinc-900/10" data-mode="2col">2 column view</button>
                <button type="button" class="np-layout-btn cursor-not-allowed px-3 py-2 opacity-50 transition duration-300 hover:bg-zinc-900/10 md:cursor-pointer md:opacity-100" data-mode="4col">4 column view</button>
            </div>
        </div>

        <div class="np-layout-grid mt-10 flex flex-col space-y-4" data-grid>
            @forelse($products as $index => $product)
                <a
                    href="{{ auth()->check() ? route('customer.products.show', $product) : route('produk.show', $product) }}"
                    class="np-layout-item group flex h-full flex-col overflow-hidden rounded-sm border border-black/5 bg-white pb-6 shadow-[0_8px_26px_rgba(0,0,0,0.05)] transition duration-300 hover:scale-[1.02] hover:shadow-[0_14px_34px_rgba(0,0,0,0.1)]"
                >
                    <div class="relative flex h-72 items-center justify-center px-6 pt-6">
                        <img
                            src="{{ $product->image ? asset('storage/' . $product->image) : $fallbackImages[$index % count($fallbackImages)] }}"
                            alt="{{ $product->name }}"
                            class="mx-auto h-auto max-h-56 w-auto max-w-[75%] object-contain"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 z-10 bg-slate-950/5 transition duration-300 group-hover:bg-slate-950/0"></div>
                    </div>
                    <div class="mt-auto grid grid-cols-[1fr_auto] items-end gap-3 px-4">
                        <div class="min-h-11">
                            <h3 class="line-clamp-1 text-sm font-semibold capitalize tracking-tight text-black">{{ $product->name }}</h3>
                            <p class="mt-1 line-clamp-1 text-[11px] text-zinc-500">{{ $product->category_label }}</p>
                        </div>
                        <p class="self-end text-xs tabular-nums leading-none tracking-tight text-slate-700">
                            @if($product->hasActiveDiscount())
                                {{ $product->formatted_discounted_price }}
                            @else
                                {{ $product->formatted_price }}
                            @endif
                        </p>
                    </div>
                </a>
            @empty
                <div class="rounded-xl border border-dashed border-zinc-300 bg-white p-10 text-center text-zinc-500">Produk belum tersedia.</div>
            @endforelse
        </div>
    </div>
</section>