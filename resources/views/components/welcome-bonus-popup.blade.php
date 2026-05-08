<div x-data="{ show: @js(!auth()->check()) }" 
     x-show="show" 
     x-cloak
     class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-md px-4"
     style="display: none;">
    
    <div @click.away="show = false" 
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="relative w-full max-w-2xl bg-white rounded-xl shadow-2xl overflow-hidden"
         style="max-height: 70vh;">
        
        <!-- Close Button -->
        <button @click="show = false" 
                class="absolute top-3 right-3 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-black/5 text-black/60 transition-all hover:bg-black/10 hover:text-black hover:rotate-90">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-5 h-full">
            <!-- Left Side - Image Grip -->
            <div class="relative bg-gradient-to-br from-gray-50 to-gray-100 md:col-span-2 flex items-center justify-center overflow-hidden">
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-black rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-black rounded-full blur-3xl"></div>
                </div>
                
                <div class="relative z-10 w-full h-full">
                    <!-- Grip Image -->
                    <img src="{{ asset('storage/grip.png') }}" 
                         onerror="this.src='https://znakegrips.com/wp-content/uploads/sites/5/2021/05/Znake_overgrip_sticky_ribbed_white__1200x1200.jpg'"
                         alt="Premium Grip" 
                         class="w-full h-full object-cover drop-shadow-2xl transform hover:scale-105 transition-transform duration-500">
                </div>
            </div>

            <!-- Right Side - Content -->
            <div class="md:col-span-3 p-5 md:p-6 flex flex-col justify-center">
                <div class="space-y-4">
                    <!-- Subtitle -->
                    <div>
                        <p class="text-[9px] font-semibold tracking-[0.2em] uppercase text-black/50 mb-1.5">Member Benefits</p>
                        <h3 class="text-lg md:text-xl font-bold text-black tracking-tight">
                            Join Today & Receive
                        </h3>
                    </div>

                    <!-- Benefits List -->
                    <div class="space-y-2.5">
                        <!-- Benefit 1 -->
                        <div class="flex items-start gap-2.5 p-2.5 bg-gray-50 rounded-lg border border-black/5 transition-all hover:border-black/10">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-black text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-black text-sm mb-0.5">100 Points</h4>
                                <p class="text-[11px] text-black/60 leading-tight">Worth Rp 10.000 for your next purchase</p>
                            </div>
                        </div>

                        <!-- Benefit 2 -->
                        <div class="flex items-start gap-2.5 p-2.5 bg-gray-50 rounded-lg border border-black/5 transition-all hover:border-black/10">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-black text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-black text-sm mb-0.5">Free Premium Grip</h4>
                                <p class="text-[11px] text-black/60 leading-tight">Complimentary with your first order</p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Button -->
                    <div class="pt-2">
                        <a href="{{ route('register') }}" 
                           class="inline-flex h-11 w-full items-center justify-center rounded-full bg-black px-5 text-sm font-semibold text-white transition-all duration-300 hover:bg-black/90 hover:scale-[1.02] hover:shadow-xl">
                            Join Now & Claim Rewards
                        </a>
                        <p class="mt-2.5 text-center text-[10px] text-black/50">
                            Already a member? <a href="{{ route('login') }}" class="font-semibold text-black hover:underline">Sign In</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
