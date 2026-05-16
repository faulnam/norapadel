@extends('layouts.app')

@section('title', 'My Profile - NoraPadel')

@section('content')
<div class="bg-white text-black antialiased">
    <header class="fixed left-0 top-0 z-50 w-full border-b border-black/6 bg-white/80 backdrop-blur-xl md:sticky">
        <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('storage/logo.png') }}" alt="NoraPadel" class="h-7 w-7 object-contain" loading="lazy">
                <span class="text-xl font-semibold tracking-tight text-black">NoraPadel</span>
            </a>

            <nav class="hidden items-center gap-8 md:flex">
                <a href="{{ route('home') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Home</a>
                <a href="{{ route('new-arrivals') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">New Arrivals</a>
                <a href="{{ route('racket') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Racket</a>
                <a href="{{ route('shoes') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Shoes</a>
                <a href="{{ route('apparel') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Accessories</a>
                <a href="{{ route('contact') }}"
                        class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Contact</a>
            </nav>

            <div class="flex items-center gap-3 text-black/80">
                <a href="{{ route('customer.orders.index') }}" class="transition duration-300 hover:text-black" title="Riwayat Pesanan">
                <i class="fas fa-history text-sm"></i>
            </a>
                <a href="{{ route('customer.profile.index') }}" class="transition duration-300 hover:text-black" aria-label="Profile">
                    <i class="fas fa-user text-sm"></i>
                </a>
                <a href="{{ route('customer.cart.index') }}" class="transition duration-300 hover:text-black" aria-label="Cart">
                    <i class="fas fa-shopping-bag text-sm"></i>
                </a>
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-black/15 text-black transition duration-300 hover:border-black/35 md:hidden" data-mobile-menu-toggle aria-label="Toggle navigation" aria-expanded="false">
                    <i class="fas fa-bars text-sm"></i>
                </button>
            </div>
        </div>

        <div class="hidden border-t border-black/10 bg-white/95 px-6 py-4 md:hidden" data-mobile-menu>
            <nav class="flex flex-col gap-3 text-sm font-medium text-black/85">
                <a href="{{ route('home') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Home</a>
                <a href="{{ route('racket') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Racket</a>
                <a href="{{ route('shoes') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Shoes</a>
                <a href="{{ route('apparel') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Accessories</a>
            </nav>
        </div>
    </header>

<div class="mx-auto w-full max-w-7xl px-6 py-8 pt-16 md:px-10 md:py-12 md:pt-0 lg:px-12 lg:py-16">
    <h3 class="mb-6 text-3xl font-semibold tracking-tight text-black sm:text-4xl">
        <i class="fas fa-user mr-3 text-black"></i>My Profile
    </h3>
    
    @if(session('success'))
        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
    @endif
    
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-1">
            <!-- Profile Card -->
            <div class="overflow-hidden rounded-2xl border border-black/6 bg-white shadow-sm">
                <div class="px-6 py-8 text-center">
                    <!-- Avatar with upload -->
                    <div class="relative mb-4 inline-block">
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                             class="h-28 w-28 rounded-full border-4 border-black object-cover" id="avatarPreview">
                        <label for="avatarInput" class="absolute bottom-0 right-0 flex h-9 w-9 cursor-pointer items-center justify-center rounded-full border-3 border-white bg-black text-white transition hover:bg-black/90"> 
                            <i class="fas fa-camera text-xs"></i>
                        </label>
                    </div>
                    
                    <form action="{{ route('customer.profile.avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                        @csrf
                        <input type="file" name="avatar" id="avatarInput" accept="image/*" class="hidden">
                    </form>
                    
                    @error('avatar')
                        <div class="mb-2 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                    
                    <h5 class="mb-1 text-xl font-semibold text-black">{{ $user->name }}</h5>
                    <p class="mb-3 text-sm text-zinc-500">{{ $user->email }}</p>
                    <span class="inline-block rounded-full bg-black px-3 py-1 text-xs font-medium text-white">Customer</span>
                    
                    <!-- Points Display -->
                    <div class="mt-4 rounded-xl bg-gradient-to-r from-violet-500 to-purple-600 px-4 py-3 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-white/80">Loyalty Points</p>
                                <p class="text-2xl font-bold">{{ number_format($user->points) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-white/80">Value</p>
                                <p class="text-sm font-semibold">{{ $user->formatted_points_value }}</p>
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-white/70">100 Points = Rp10,000 (1% cashback)</p>
                    </div>
                </div>
                <div class="border-t border-black/6">
                    <a href="{{ route('customer.profile.rewards') }}" class="flex items-center justify-between border-b border-black/6 px-6 py-3 transition hover:bg-zinc-50">
                        <span class="text-sm text-zinc-600"><i class="fas fa-gift mr-2"></i>Reward & Points</span>
                        <span class="text-sm font-medium text-violet-600">Lihat <i class="fas fa-chevron-right text-xs ml-1"></i></span>
                    </a>
                    <div class="flex items-center justify-between border-b border-black/6 px-6 py-3">
                        <span class="text-sm text-zinc-600"><i class="fas fa-phone mr-2"></i>Phone</span>
                        <span class="text-sm font-medium text-black">{{ $user->phone ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between px-6 py-3">
                        <span class="text-sm text-zinc-600"><i class="fas fa-calendar mr-2"></i>Joined</span>
                        <span class="text-sm font-medium text-black">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                <!-- Tombol Logout -->
                <div class="border-t border-black/6 px-6 py-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full rounded-full border border-rose-600 bg-white px-4 py-2 text-sm font-medium text-rose-600 transition hover:bg-rose-50">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="space-y-6 lg:col-span-2">
            <!-- Update Profile -->
            <div class="overflow-hidden rounded-2xl border border-black/6 bg-white shadow-sm">
                <div class="border-b border-black/6 bg-zinc-50 px-6 py-4">
                    <h4 class="text-lg font-semibold text-black"><i class="fas fa-edit mr-2"></i>Edit Profile</h4>
                </div>
                <div class="px-6 py-6">
                    <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-black">Full Name</label>
                            <input type="text" class="w-full rounded-xl border border-black/10 px-4 py-2.5 text-sm transition focus:border-black focus:outline-none focus:ring-1 focus:ring-black @error('name') border-rose-500 @enderror" 
                                   name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-black">Email</label>
                            <input type="email" class="w-full rounded-xl border border-black/10 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-500" value="{{ $user->email }}" disabled>
                            <p class="mt-1 text-xs text-zinc-500">Email cannot be changed</p>
                        </div>
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-black">Phone Number</label>
                            <input type="text" class="w-full rounded-xl border border-black/10 px-4 py-2.5 text-sm transition focus:border-black focus:outline-none focus:ring-1 focus:ring-black @error('phone') border-rose-500 @enderror" 
                                   name="phone" value="{{ old('phone', $user->phone) }}" required>
                            @error('phone')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-black">Address</label>
                            <textarea class="w-full rounded-xl border border-black/10 px-4 py-2.5 text-sm transition focus:border-black focus:outline-none focus:ring-1 focus:ring-black @error('address') border-rose-500 @enderror" 
                                      name="address" rows="3" required>{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" class="rounded-full bg-black px-6 py-2.5 text-sm font-medium text-white transition hover:bg-black/90">
                            <i class="fas fa-save mr-2"></i>Save Changes
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Change Password -->
            <div class="overflow-hidden rounded-2xl border border-black/6 bg-white shadow-sm">
                <div class="border-b border-black/6 bg-zinc-50 px-6 py-4">
                    <h4 class="text-lg font-semibold text-black"><i class="fas fa-lock mr-2"></i>Change Password</h4>
                </div>
                <div class="px-6 py-6">
                    <form action="{{ route('customer.profile.update-password') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-black">Current Password</label>
                            <input type="password" class="w-full rounded-xl border border-black/10 px-4 py-2.5 text-sm transition focus:border-black focus:outline-none focus:ring-1 focus:ring-black @error('current_password') border-rose-500 @enderror" 
                                   name="current_password" required>
                            @error('current_password')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-black">New Password</label>
                            <input type="password" class="w-full rounded-xl border border-black/10 px-4 py-2.5 text-sm transition focus:border-black focus:outline-none focus:ring-1 focus:ring-black @error('password') border-rose-500 @enderror" 
                                   name="password" required>
                            @error('password')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-zinc-500">Minimum 8 characters</p>
                        </div>
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-black">Confirm New Password</label>
                            <input type="password" class="w-full rounded-xl border border-black/10 px-4 py-2.5 text-sm transition focus:border-black focus:outline-none focus:ring-1 focus:ring-black" name="password_confirmation" required>
                        </div>
                        
                        <button type="submit" class="rounded-full border border-black bg-white px-6 py-2.5 text-sm font-medium text-black transition hover:bg-black hover:text-white">
                            <i class="fas fa-key mr-2"></i>Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="border-t border-black/10 bg-white py-10 text-sm text-zinc-500">
    <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
        <div class="hidden grid-cols-2 gap-8 md:grid md:grid-cols-4">
            <div>
                <h3 class="mb-3 text-xs font-semibold uppercase tracking-wide text-black">Support</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('policy') }}" class="hover:underline">Policy</a></li>
                    <li><a href="{{ route('return-refund') }}" class="hover:underline">Return & Refund</a></li>
                    <li><a href="{{ route('guarantee') }}" class="hover:underline">Nora Guarantee</a></li>
                    <li><a href="{{ route('help-center') }}" class="hover:underline">Help Center</a></li>
                </ul>
            </div>
            <div>
                <h3 class="mb-3 text-xs font-semibold uppercase tracking-wide text-black">Account</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('customer.profile.index') }}" class="hover:underline">Profile</a></li>
                    <li><a href="{{ route('customer.orders.index') }}" class="hover:underline">Orders</a></li>
                </ul>
            </div>
        </div>
        <div class="space-y-2 md:hidden">
            <details class="group rounded-xl border border-black/10 bg-white px-4 py-3">
                <summary class="flex cursor-pointer list-none items-center justify-between text-xs font-semibold uppercase tracking-wide text-black">
                    Support
                    <i class="fas fa-chevron-down text-[10px] text-zinc-500 transition group-open:rotate-180"></i>
                </summary>
                <ul class="mt-3 space-y-2 text-sm">
                    <li><a href="{{ route('policy') }}" class="hover:underline">Policy</a></li>
                    <li><a href="{{ route('return-refund') }}" class="hover:underline">Return & Refund</a></li>
                    <li><a href="{{ route('guarantee') }}" class="hover:underline">Nora Guarantee</a></li>
                    <li><a href="{{ route('help-center') }}" class="hover:underline">Help Center</a></li>
                </ul>
            </details>
            <details class="group rounded-xl border border-black/10 bg-white px-4 py-3">
                <summary class="flex cursor-pointer list-none items-center justify-between text-xs font-semibold uppercase tracking-wide text-black">
                    Account
                    <i class="fas fa-chevron-down text-[10px] text-zinc-500 transition group-open:rotate-180"></i>
                </summary>
                <ul class="mt-3 space-y-2 text-sm">
                    <li><a href="{{ route('customer.profile.index') }}" class="hover:underline">Profile</a></li>
                    <li><a href="{{ route('customer.orders.index') }}" class="hover:underline">Orders</a></li>
                </ul>
            </details>
        </div>
        <div class="mx-auto mt-8 w-full max-w-7xl border-t border-black/10 px-6 pt-5 text-xs text-zinc-400 md:px-10 lg:px-12 text-center">
            © {{ now()->year }} NoraPadel. All rights reserved.
        </div>
    </div>
</footer>
</div>

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
@endpush

@push('scripts')
<script>
(function() {
    const avatarInput = document.getElementById('avatarInput');
    const mobileMenuToggle = document.querySelector('[data-mobile-menu-toggle]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');

    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
                document.getElementById('avatarForm').submit();
            }
        });
    }

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            mobileMenuToggle.setAttribute('aria-expanded', String(!mobileMenu.classList.contains('hidden')));
        });
    }
})();
</script>
@endpush
@endsection
