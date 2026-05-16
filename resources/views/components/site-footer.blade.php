<footer class="border-t border-black/10 bg-white py-12 text-zinc-600" data-parallax data-parallax-speed="0.01">
    <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
        <div class="hidden grid-cols-1 gap-10 sm:grid-cols-2 lg:grid md:grid-cols-3">
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.14em] text-black">Shop</h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="{{ route('racket') }}" class="inline-flex transition-colors duration-200 hover:text-black">Racket</a></li>
                    <li><a href="{{ route('shoes') }}" class="inline-flex transition-colors duration-200 hover:text-black">Shoes</a></li>
                    <li><a href="{{ route('accessories') }}" class="inline-flex transition-colors duration-200 hover:text-black">Accessories</a></li>
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

        <div class="mt-10 border-t border-black/10 pt-4 text-xs text-zinc-400">
            © {{ now()->year }} NoraPadel. All rights reserved.
        </div>
    </div>
</footer>
