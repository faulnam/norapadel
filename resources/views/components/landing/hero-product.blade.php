@props([
    'id' => null,
    'title',
    'subtitle',
    'image',
    'alt',
    'primaryText' => 'Explore',
    'primaryHref' => '#',
    'secondaryText' => 'Buy Now',
    'secondaryHref' => '#',
    'sectionClass' => 'bg-[#f5f5f7]',
    'contentClass' => '',
    'imageWrapperClass' => '',
    'ctaClass' => '',
])

<section id="{{ $id }}" class="np-fade-section relative overflow-hidden {{ $sectionClass }}">
    <div class="mx-auto w-full max-w-7xl px-6 pb-14 pt-14 text-center md:px-10 md:pb-16 md:pt-16 lg:px-12 lg:pb-18 lg:pt-18 {{ $contentClass }}">
        <h2 class="text-4xl font-semibold tracking-tight text-black sm:text-5xl lg:text-6xl">{{ $title }}</h2>
        <p class="mx-auto mt-3 max-w-2xl text-lg font-normal text-zinc-700 sm:text-2xl">{{ $subtitle }}</p>

        <div class="mt-7 flex flex-wrap items-center justify-center gap-3 {{ $ctaClass }}">
            <a href="{{ $primaryHref }}"
               class="inline-flex items-center justify-center rounded-full bg-[#0071e3] px-7 py-3 text-sm font-medium text-white transition duration-300 hover:scale-[1.02] hover:bg-[#0077ED]">
                {{ $primaryText }}
            </a>
            <a href="{{ $secondaryHref }}"
               class="inline-flex items-center justify-center rounded-full border border-black/25 bg-transparent px-7 py-3 text-sm font-medium text-black transition duration-300 hover:scale-[1.02] hover:border-black/40 hover:bg-black/2">
                {{ $secondaryText }}
            </a>
        </div>

        <div class="relative mx-auto mt-8 max-w-5xl md:mt-10 {{ $imageWrapperClass }}">
            <img
                src="{{ $image }}"
                alt="{{ $alt }}"
                class="np-parallax-image mx-auto w-full max-w-4xl object-contain drop-shadow-[0_20px_45px_rgba(0,0,0,0.08)]"
                loading="lazy"
            >
        </div>
    </div>
</section>