@extends('layouts.app')

@section('title', 'Profil Saya - NoraPadel')

@section('content')
<div class="bg-white text-black antialiased">
    <header class="sticky top-0 z-50 border-b border-black/6 bg-white/80 backdrop-blur-xl">
        <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
            <a href="{{ route('home') }}" class="text-xl font-semibold tracking-tight text-black">NoraPadel</a>

            <nav class="hidden items-center gap-8 md:flex">
                <a href="{{ route('home') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Home</a>
                <a href="{{ route('racket') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Racket</a>
                <a href="{{ route('shoes') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Shoes</a>
                <a href="{{ route('apparel') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Accessories</a>
            </nav>

            <div class="flex items-center gap-3 text-black/80">
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

<div class="mx-auto w-full max-w-7xl px-6 py-8 md:px-10 md:py-12 lg:px-12 lg:py-16">
    <h3 class="mb-6 text-3xl font-semibold tracking-tight text-black sm:text-4xl">
        <i class="fas fa-user mr-3 text-black"></i>Profil Saya
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
                </div>
                <div class="border-t border-black/6">
                    <div class="flex items-center justify-between border-b border-black/6 px-6 py-3">
                        <span class="text-sm text-zinc-600"><i class="fas fa-phone mr-2"></i>Telepon</span>
                        <span class="text-sm font-medium text-black">{{ $user->phone ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between px-6 py-3">
                        <span class="text-sm text-zinc-600"><i class="fas fa-calendar mr-2"></i>Bergabung</span>
                        <span class="text-sm font-medium text-black">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                <!-- Tombol Logout -->
                <div class="border-t border-black/6 px-6 py-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full rounded-full border border-rose-600 bg-white px-4 py-2 text-sm font-medium text-rose-600 transition hover:bg-rose-50">
                            <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="space-y-6 lg:col-span-2">
            <!-- Update Profile -->
            <div class="overflow-hidden rounded-2xl border border-black/6 bg-white shadow-sm">
                <div class="border-b border-black/6 bg-zinc-50 px-6 py-4">
                    <h4 class="text-lg font-semibold text-black"><i class="fas fa-edit mr-2"></i>Edit Profil</h4>
                </div>
                <div class="px-6 py-6">
                    <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-black">Nama Lengkap</label>
                            <input type="text" class="w-full rounded-xl border border-black/10 px-4 py-2.5 text-sm transition focus:border-black focus:outline-none focus:ring-1 focus:ring-black @error('name') border-rose-500 @enderror" 
                                   name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-black">Email</label>
                            <input type="email" class="w-full rounded-xl border border-black/10 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-500" value="{{ $user->email }}" disabled>
                            <p class="mt-1 text-xs text-zinc-500">Email tidak dapat diubah</p>
                        </div>
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-black">Nomor Telepon</label>
                            <input type="text" class="w-full rounded-xl border border-black/10 px-4 py-2.5 text-sm transition focus:border-black focus:outline-none focus:ring-1 focus:ring-black @error('phone') border-rose-500 @enderror" 
                                   name="phone" value="{{ old('phone', $user->phone) }}" required>
                            @error('phone')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-black">Alamat</label>
                            <textarea class="w-full rounded-xl border border-black/10 px-4 py-2.5 text-sm transition focus:border-black focus:outline-none focus:ring-1 focus:ring-black @error('address') border-rose-500 @enderror" 
                                      name="address" rows="3" required>{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" class="rounded-full bg-black px-6 py-2.5 text-sm font-medium text-white transition hover:bg-black/90">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Change Password -->
            <div class="overflow-hidden rounded-2xl border border-black/6 bg-white shadow-sm">
                <div class="border-b border-black/6 bg-zinc-50 px-6 py-4">
                    <h4 class="text-lg font-semibold text-black"><i class="fas fa-lock mr-2"></i>Ubah Password</h4>
                </div>
                <div class="px-6 py-6">
                    <form action="{{ route('customer.profile.update-password') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-black">Password Saat Ini</label>
                            <input type="password" class="w-full rounded-xl border border-black/10 px-4 py-2.5 text-sm transition focus:border-black focus:outline-none focus:ring-1 focus:ring-black @error('current_password') border-rose-500 @enderror" 
                                   name="current_password" required>
                            @error('current_password')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-black">Password Baru</label>
                            <input type="password" class="w-full rounded-xl border border-black/10 px-4 py-2.5 text-sm transition focus:border-black focus:outline-none focus:ring-1 focus:ring-black @error('password') border-rose-500 @enderror" 
                                   name="password" required>
                            @error('password')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-zinc-500">Minimal 8 karakter</p>
                        </div>
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-black">Konfirmasi Password Baru</label>
                            <input type="password" class="w-full rounded-xl border border-black/10 px-4 py-2.5 text-sm transition focus:border-black focus:outline-none focus:ring-1 focus:ring-black" name="password_confirmation" required>
                        </div>
                        
                        <button type="submit" class="rounded-full border border-black bg-white px-6 py-2.5 text-sm font-medium text-black transition hover:bg-black hover:text-white">
                            <i class="fas fa-key mr-2"></i>Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="border-t border-black/10 bg-white py-14 text-sm text-zinc-500">
    <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
        <div class="text-center">
            <p class="text-xs text-zinc-400">© {{ now()->year }} NoraPadel. All rights reserved.</p>
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
