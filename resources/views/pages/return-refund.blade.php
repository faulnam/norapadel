@extends('layouts.app')

@section('title', 'Return & Refund - NoraPadel')

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
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500">Customer Service</p>
                        <h1 class="mt-3 text-3xl font-semibold tracking-tight text-black sm:text-4xl">Return & Refund Policy</h1>
                        <p class="mt-4 text-zinc-600">We want you to be completely satisfied with your purchase.</p>
                    </div>
                </div>

                <div class="mx-auto mt-12 max-w-3xl rounded-2xl border border-black/10 bg-white p-6 shadow-sm md:p-8">
                    <div class="prose prose-zinc max-w-none text-sm text-zinc-600">
                        <h2 class="text-lg font-semibold text-black">1. Return Eligibility</h2>
                        <p class="mt-2">You may return most new, unopened items within 7 days of delivery for a full refund. Items must be in their original packaging with all tags attached. Used, damaged, or altered products are not eligible for return.</p>

                            <h2 class="mt-6 text-lg font-semibold text-black">2. Non-Returnable Items</h2>
                            <p class="mt-2">The following items cannot be returned:</p>
                            <ul class="mt-2 list-disc pl-5">
                                <li>Grips, overgrips, and other consumable accessories that have been opened or used</li>
                                <li>Custom strung rackets at customer specification</li>
                                <li>Items marked as "Final Sale" or "Clearance"</li>
                                <li>Gift cards and promotional vouchers</li>
                            </ul>

                            <h2 class="mt-6 text-lg font-semibold text-black">3. How to Request a Return</h2>
                            <p class="mt-2">To initiate a return, please contact our customer service team via WhatsApp at {{ config('branding.phone', '08511735858') }} or email at support@norapadel.com with your order number and reason for return. We will provide you with a return authorization and instructions.</p>

                            <h2 class="mt-6 text-lg font-semibold text-black">4. Refund Process</h2>
                            <p class="mt-2">Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. If approved, your refund will be processed within 5-7 business days to your original payment method. Shipping costs for returns are the responsibility of the customer unless the item was defective or incorrect.</p>

                            <h2 class="mt-6 text-lg font-semibold text-black">5. Exchanges</h2>
                            <p class="mt-2">We only replace items if they are defective or damaged. If you need to exchange an item for the same product, contact us with your order details and photos of the defect.</p>

                            <h2 class="mt-6 text-lg font-semibold text-black">6. Damaged or Incorrect Items</h2>
                            <p class="mt-2">If you receive a damaged or incorrect item, please contact us within 48 hours of delivery with photos. We will arrange a replacement or full refund at no additional cost, including return shipping.</p>

                            <h2 class="mt-6 text-lg font-semibold text-black">7. Contact Us</h2>
                            <p class="mt-2">For any return or refund inquiries, reach out to us at support@norapadel.com or WhatsApp {{ config('branding.phone', '08511735858') }}. Our team is available Monday-Saturday, 9 AM - 6 PM WIB.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection
