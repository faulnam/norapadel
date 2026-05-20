<footer class="border-t border-black/10 bg-white py-12 text-zinc-600" data-parallax data-parallax-speed="0.01">
    <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
        <div class="hidden grid-cols-1 gap-10 sm:grid-cols-2 lg:grid md:grid-cols-4">
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.14em] text-black">Shop</h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="{{ route('racket') }}" class="inline-flex transition-colors duration-200 hover:text-black">Racket</a></li>
                    <li><a href="{{ route('shoes') }}" class="inline-flex transition-colors duration-200 hover:text-black">Shoes</a></li>
                    <li><a href="{{ route('accessories') }}" class="inline-flex transition-colors duration-200 hover:text-black">Accessories</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.14em] text-black">Support</h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="{{ route('policy') }}" class="inline-flex transition-colors duration-200 hover:text-black">Policy</a></li>
                    <li><a href="{{ route('return-refund') }}" class="inline-flex transition-colors duration-200 hover:text-black">Return & Refund</a></li>
                    <li><a href="{{ route('guarantee') }}" class="inline-flex transition-colors duration-200 hover:text-black">Nora Guarantee</a></li>
                    <li><a href="{{ route('help-center') }}" class="inline-flex transition-colors duration-200 hover:text-black">Help Center</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.14em] text-black">Account</h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="{{ route('login') }}" class="inline-flex transition-colors duration-200 hover:text-black">Login</a></li>
                    <li><a href="{{ route('register') }}" class="inline-flex transition-colors duration-200 hover:text-black">Register</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.14em] text-black">Social Media</h3>
                <div class="mt-4 flex gap-3">
                    <a href="https://www.instagram.com/norapadel/" target="_blank" rel="noopener" class="flex h-9 w-9 items-center justify-center rounded-full bg-black/5 text-black transition-all duration-200 hover:bg-zinc-200">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.tiktok.com/@norapadel" target="_blank" rel="noopener" class="flex h-9 w-9 items-center justify-center rounded-full bg-black/5 text-black transition-all duration-200 hover:bg-zinc-200">
                        <i class="fab fa-tiktok"></i>
                    </a>
                    <a href="https://shopee.co.id/norads" target="_blank" rel="noopener" class="flex h-9 w-9 items-center justify-center rounded-full bg-black/5 text-black transition-all duration-200 hover:bg-zinc-200">
                        <i class="fas fa-shopping-bag"></i>
                    </a>
                    <a href="https://wa.me/6285117358568" target="_blank" rel="noopener" class="flex h-9 w-9 items-center justify-center rounded-full bg-black/5 text-black transition-all duration-200 hover:bg-zinc-200">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="space-y-2 md:hidden">
            <details class="group rounded-xl border border-black/10 bg-white px-4 py-3">
                <summary class="flex cursor-pointer list-none items-center justify-between text-xs font-semibold uppercase tracking-[0.14em] text-black">
                    Shop
                    <i class="fas fa-chevron-down text-[10px] text-zinc-500 transition group-open:rotate-180"></i>
                </summary>
                <ul class="mt-3 space-y-2.5 text-sm">
                    <li><a href="{{ route('racket') }}" class="inline-flex transition-colors duration-200 hover:text-black">Racket</a></li>
                    <li><a href="{{ route('shoes') }}" class="inline-flex transition-colors duration-200 hover:text-black">Shoes</a></li>
                    <li><a href="{{ route('accessories') }}" class="inline-flex transition-colors duration-200 hover:text-black">Accessories</a></li>
                </ul>
            </details>

            <details class="group rounded-xl border border-black/10 bg-white px-4 py-3">
                <summary class="flex cursor-pointer list-none items-center justify-between text-xs font-semibold uppercase tracking-[0.14em] text-black">
                    Support
                    <i class="fas fa-chevron-down text-[10px] text-zinc-500 transition group-open:rotate-180"></i>
                </summary>
                <ul class="mt-3 space-y-2.5 text-sm">
                    <li><a href="{{ route('policy') }}" class="inline-flex transition-colors duration-200 hover:text-black">Policy</a></li>
                    <li><a href="{{ route('return-refund') }}" class="inline-flex transition-colors duration-200 hover:text-black">Return & Refund</a></li>
                    <li><a href="{{ route('guarantee') }}" class="inline-flex transition-colors duration-200 hover:text-black">Nora Guarantee</a></li>
                    <li><a href="{{ route('help-center') }}" class="inline-flex transition-colors duration-200 hover:text-black">Help Center</a></li>
                </ul>
            </details>

            <details class="group rounded-xl border border-black/10 bg-white px-4 py-3">
                <summary class="flex cursor-pointer list-none items-center justify-between text-xs font-semibold uppercase tracking-[0.14em] text-black">
                    Account
                    <i class="fas fa-chevron-down text-[10px] text-zinc-500 transition group-open:rotate-180"></i>
                </summary>
                <ul class="mt-3 space-y-2.5 text-sm">
                    <li><a href="{{ route('login') }}" class="inline-flex transition-colors duration-200 hover:text-black">Login</a></li>
                    <li><a href="{{ route('register') }}" class="inline-flex transition-colors duration-200 hover:text-black">Register</a></li>
                </ul>
            </details>

            <details class="group rounded-xl border border-black/10 bg-white px-4 py-3">
                <summary class="flex cursor-pointer list-none items-center justify-between text-xs font-semibold uppercase tracking-[0.14em] text-black">
                    Social Media
                    <i class="fas fa-chevron-down text-[10px] text-zinc-500 transition group-open:rotate-180"></i>
                </summary>
                <div class="mt-3 flex gap-3">
                    <a href="https://www.instagram.com/norapadel/" target="_blank" rel="noopener" class="flex h-9 w-9 items-center justify-center rounded-full bg-black/5 text-black transition-all duration-200 hover:bg-zinc-200">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.tiktok.com/@norapadel" target="_blank" rel="noopener" class="flex h-9 w-9 items-center justify-center rounded-full bg-black/5 text-black transition-all duration-200 hover:bg-zinc-200">
                        <i class="fab fa-tiktok"></i>
                    </a>
                    <a href="https://shopee.co.id/norads" target="_blank" rel="noopener" class="flex h-9 w-9 items-center justify-center rounded-full bg-black/5 text-black transition-all duration-200 hover:bg-zinc-200">
                        <i class="fas fa-shopping-bag"></i>
                    </a>
                    <a href="https://wa.me/6285117358568" target="_blank" rel="noopener" class="flex h-9 w-9 items-center justify-center rounded-full bg-black/5 text-black transition-all duration-200 hover:bg-zinc-200">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </details>
        </div>

        <div class="mt-10 flex flex-wrap justify-center items-center gap-x-4 gap-y-3">
            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" alt="QRIS" class="h-4 w-auto object-contain transition-all duration-200" loading="lazy">
            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA" class="h-4 w-auto object-contain transition-all duration-200" loading="lazy">
            <img src="{{ asset('storage/seabank.png') }}" alt="SeaBank" class="h-14 w-14 object-contain transition-all duration-200" loading="lazy">
            <img src="{{ asset('storage/danamon.png') }}" alt="Danamon" class="h-14 w-14 object-contain transition-all duration-200" loading="lazy">
            <img src="{{ asset('storage/permata.jpg') }}" alt="Permata" class="h-14 w-14 object-contain transition-all duration-200" loading="lazy">
            <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" alt="Mandiri" class="h-4 w-auto object-contain transition-all duration-200" loading="lazy">
            <img src="{{ asset('storage/bri.png') }}" alt="BRI" class="h-8 w-8 object-contain transition-all duration-200" loading="lazy">
            <img src="{{ asset('storage/bni.png') }}" alt="BNI" class="h-8 w-8 object-contain transition-all duration-200" loading="lazy">
            <img src="{{ asset('storage/btn.jpeg') }}" alt="BTN" class="h-10 w-10 object-contain transition-all duration-200" loading="lazy">
            <img src="{{ asset('storage/cimb.png') }}" alt="CIMB" class="h-10 w-10 object-contain transition-all duration-200" loading="lazy">
            <img src="{{ asset('storage/ocbc.png') }}" alt="OCBC" class="h-10 w-10 object-contain transition-all duration-200" loading="lazy">
            <img src="{{ asset('storage/mega.png') }}" alt="Bank Mega" class="h-10 w-10 object-contain transition-all duration-200" loading="lazy">
            <img src="{{ asset('storage/dana.jpg') }}" alt="DANA" class="h-10 w-10 object-contain transition-all duration-200" loading="lazy">
            <img src="{{ asset('storage/gopay.webp') }}" alt="GoPay" class="h-12 w-12 object-contain transition-all duration-200" loading="lazy">
            <img src="{{ asset('storage/shopeepay.png') }}" alt="ShopeePay" class="h-14 w-14 object-contain transition-all duration-200" loading="lazy">
            <img src="{{ asset('storage/ovo.png') }}" alt="OVO" class="h-10 w-10 object-contain transition-all duration-200" loading="lazy">
            <img src="{{ asset('storage/linkaja.webp') }}" alt="LinkAja" class="h-16 w-16 object-contain transition-all duration-200" loading="lazy">
            <img src="{{ asset('storage/nobu.png') }}" alt="Nobu Bank" class="h-10 w-10 object-contain transition-all duration-200" loading="lazy">
        </div>

        <div class="mt-6 border-t border-black/10 pt-4 text-center text-md text-zinc-500">
            © {{ now()->year }} NoraPadel. All rights reserved.
        </div>
    </div>
</footer>
