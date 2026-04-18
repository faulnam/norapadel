<footer class="border-t border-black/10 bg-white py-12 text-zinc-600" data-parallax data-parallax-speed="0.01">
    <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4">
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
                    <li><a href="{{ route('help-center') }}" class="inline-flex transition-colors duration-200 hover:text-black">Help Center</a></li>
                    <li><a href="{{ route('contact') }}" class="inline-flex transition-colors duration-200 hover:text-black">Contact</a></li>
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
                <h3 class="text-xs font-semibold uppercase tracking-[0.14em] text-black">About NoraPadel</h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="{{ route('about') }}" class="inline-flex transition-colors duration-200 hover:text-black">About</a></li>
                    <li><a href="{{ route('home') }}#testimonials" class="inline-flex transition-colors duration-200 hover:text-black">Testimonials</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-10 border-t border-black/10 pt-4 text-xs text-zinc-400">
            © {{ now()->year }} NoraPadel. All rights reserved.
        </div>
    </div>
</footer>
