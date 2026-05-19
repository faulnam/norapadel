@guest
<div x-data="{
    show: false,
    closePopup() {
        this.show = false;
        window._welcomeShown = true;
    }
}"
     x-show="show"
     x-cloak
     x-init="
        if (!window._welcomeShown) {
            setTimeout(() => { show = true; window._welcomeShown = true; }, 800);
        }
     "
     class="fixed bottom-4 left-4 z-[100]">
    
    <div x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="relative w-[200px] md:w-[280px] bg-white rounded-xl shadow-xl border border-black/5 overflow-hidden">

        <!-- Close Button -->
        <button @click="closePopup()"
                class="absolute top-2 right-2 z-10 flex h-5 w-5 md:h-6 md:w-6 items-center justify-center rounded-full bg-black/5 text-black/50 transition-all hover:bg-black/10 hover:text-black">
            <svg class="h-2.5 w-2.5 md:h-3 md:w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Content -->
        <div class="p-3 md:p-4">
            <p class="text-[8px] md:text-[10px] font-semibold tracking-[0.15em] uppercase text-black/40 mb-0.5 md:mb-1">Member Benefits</p>
            <h3 class="text-[11px] md:text-sm font-bold text-black tracking-tight mb-2 md:mb-3">Join Today & Receive</h3>

            <div class="flex flex-row gap-2 md:space-y-2 md:flex-col mb-2 md:mb-3">
                <div class="flex items-center gap-1.5 md:gap-2">
                    <div class="flex h-5 w-5 md:h-7 md:w-7 shrink-0 items-center justify-center rounded-full bg-black text-white">
                        <svg class="h-2.5 w-2.5 md:h-3 md:w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-black text-[10px] md:text-xs">100 Points</h4>
                        <p class="hidden md:block text-[10px] text-black/50 leading-tight">Worth Rp 10.000</p>
                    </div>
                </div>

                <div class="flex items-center gap-1.5 md:gap-2">
                    <div class="flex h-5 w-5 md:h-7 md:w-7 shrink-0 items-center justify-center rounded-full bg-black text-white">
                        <svg class="h-2.5 w-2.5 md:h-3 md:w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-black text-[10px] md:text-xs">Free Grip</h4>
                        <p class="hidden md:block text-[10px] text-black/50 leading-tight">With first order</p>
                    </div>
                </div>
            </div>

            <a href="{{ route('register') }}"
               class="inline-flex h-8 md:h-9 w-full items-center justify-center rounded-full bg-black px-3 md:px-4 text-[10px] md:text-xs font-semibold text-white transition-all duration-300 hover:bg-black/90">
                Join Now
            </a>
            <p class="mt-1.5 md:mt-2 text-center text-[8px] md:text-[10px] text-black/40">
                Already member? <a href="{{ route('login') }}" class="font-medium text-black hover:underline">Sign In</a>
            </p>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endguest
