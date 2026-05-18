@extends('layouts.app')

@section('title', 'Nora Guarantee - NoraPadel')

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
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500">Our Promise</p>
                        <h1 class="mt-3 text-3xl font-semibold tracking-tight text-black sm:text-4xl">Nora Guarantee</h1>
                        <p class="mt-4 text-zinc-600">Shop with confidence knowing every product is backed by our commitment.</p>
                    </div>

                    <div class="mx-auto mt-12 max-w-3xl rounded-2xl border border-black/10 bg-white p-6 shadow-sm md:p-8">
                        <div class="prose prose-zinc max-w-none text-sm text-zinc-600">
                            <div class="mb-6 flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-black text-white">
                                    <i class="fas fa-shield-alt text-base"></i>
                                </div>
                                <h2 class="text-lg font-semibold text-black">100% Authentic Products</h2>
                            </div>
                            <p class="mt-2">Every product sold at NoraPadel is 100% authentic and sourced directly from authorized distributors or the brands themselves. We never sell counterfeit or replica items.</p>

                            <div class="mb-6 mt-8 flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-black text-white">
                                    <i class="fas fa-check-circle text-base"></i>
                                </div>
                                <h2 class="text-lg font-semibold text-black">Quality Inspection</h2>
                            </div>
                            <p class="mt-2">All rackets, shoes, and gear are inspected by our team before shipping. We check for defects, verify string tension accuracy, and ensure every item meets our standards.</p>

                            <div class="mb-6 mt-8 flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-black text-white">
                                    <i class="fas fa-undo text-base"></i>
                                </div>
                                <h2 class="text-lg font-semibold text-black">7-Day Return</h2>
                            </div>
                            <p class="mt-2">Not satisfied? Return your unused, unopened purchase within 7 days for a full refund. See our <a href="{{ route('return-refund') }}" class="underline hover:text-black">Return & Refund Policy</a> for full details.</p>

                            <div class="mb-6 mt-8 flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-black text-white">
                                    <i class="fas fa-tools text-base"></i>
                                </div>
                                <h2 class="text-lg font-semibold text-black">Stringing Warranty</h2>
                            </div>
                            <p class="mt-2">Rackets strung by NoraPadel come with a 30-day stringing warranty. If the strings break within 30 days under normal playing conditions, we will restring your racket free of charge.</p>

                            <div class="mb-6 mt-8 flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-black text-white">
                                    <i class="fas fa-headset text-base"></i>
                                </div>
                                <h2 class="text-lg font-semibold text-black">Expert Support</h2>
                            </div>
                            <p class="mt-2">Our team consists of padel enthusiasts and certified stringers. Whether you need advice on racket selection, string tension, or shoe sizing, we are here to help you make the right choice.</p>

                            <div class="mb-6 mt-8 flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-black text-white">
                                    <i class="fas fa-lock text-base"></i>
                                </div>
                                <h2 class="text-lg font-semibold text-black">Secure Shopping</h2>
                            </div>
                            <p class="mt-2">Your payment and personal information are protected with industry-standard encryption. We partner with trusted payment gateways to ensure every transaction is safe.</p>

                            <h2 class="mt-8 text-lg font-semibold text-black">Questions?</h2>
                            <p class="mt-2">If you have any questions about the Nora Guarantee, feel free to reach out at support@norapadel.com or WhatsApp {{ config('branding.phone', '08511735858') }}.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection
