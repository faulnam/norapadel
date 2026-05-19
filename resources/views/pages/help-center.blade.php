@extends('layouts.app')

@section('title', 'Help Center - NoraPadel')

@section('content')
    <style>
        #marqueeBar { 
            display: block !important; 
            visibility: visible !important;
            opacity: 1 !important;
            z-index: 60 !important;
            position: fixed !important;
            top: 0 !important;
        }
        .mobile-bottom-nav { display: none !important; }
        #mainNavbar { display: none !important; }
    </style>
    <div class="bg-white text-black antialiased">
        @include('components.luxury-navbar')
        <main class="pt-16 md:pt-20">
            <section class="bg-[#f8fafc] pt-4 pb-14 lg:pt-4 lg:pb-16">
                <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                    <div class="mx-auto max-w-3xl text-center">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500">Support</p>
                        <h1 class="mt-3 text-3xl font-semibold tracking-tight text-black sm:text-4xl">Help Center</h1>
                        <p class="mt-4 text-zinc-600">Need help with orders, shipping, or payment? Find quick answers here.</p>
                    </div>

                    <div class="mx-auto mt-12 grid max-w-5xl gap-5 md:grid-cols-2">
                        <article class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
                            <h2 class="text-lg font-semibold text-black">How to track order</h2>
                            <p class="mt-3 text-sm leading-relaxed text-zinc-600">Log in to your account, open order history menu, then select order to view pickup, shipping, and completion status.</p>
                        </article>
                        <article class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
                            <h2 class="text-lg font-semibold text-black">Payment Information</h2>
                            <p class="mt-3 text-sm leading-relaxed text-zinc-600">We support bank transfers, online payment gateway.</p>
                        </article>
                        <article class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
                            <h2 class="text-lg font-semibold text-black">Return policy</h2>
                            <p class="mt-3 text-sm leading-relaxed text-zinc-600">Return requests can be made maximum 7 days after product is received, as long as product hasn't been used and packaging is still complete.</p>
                        </article>
                        <article class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
                            <h2 class="text-lg font-semibold text-black">Still need help?</h2>
                            <p class="mt-3 text-sm leading-relaxed text-zinc-600">Our support team is ready to help you through the contact page for technical questions or product consultation.</p>
                            <a href="{{ route('contact') }}" class="mt-4 inline-flex rounded-full bg-black px-4 py-2 text-sm font-medium text-white transition hover:bg-zinc-800">Contact Us</a>
                        </article>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection
