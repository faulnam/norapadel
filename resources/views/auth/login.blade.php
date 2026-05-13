@extends('layouts.app')

@section('title', 'Login - Nora Padel')

@section('content')
@include('partials.main-navbar')
<div class="min-h-[100dvh] w-full flex flex-col md:flex-row bg-white text-zinc-900 antialiased pt-28">
    <!-- Left: Form -->
    <section class="flex-1 flex items-center justify-center p-6 md:p-10 overflow-y-auto">
        <div class="w-full max-w-md">
            <div class="flex flex-col gap-6">
                <h1 class="animate-element animate-delay-100 text-4xl md:text-5xl font-light leading-tight tracking-tighter">Welcome <span class="font-semibold">back</span></h1>
                <p class="animate-element animate-delay-200 text-zinc-500">Access your account and continue your journey with NoraPadel.</p>

                @if($errors->any())
                    <div class="animate-element animate-delay-250 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="animate-element animate-delay-300">
                        <label for="email" class="text-sm font-medium text-zinc-500">Email Address</label>
                        <div class="mt-1 rounded-2xl border border-zinc-200 bg-zinc-50 transition-colors focus-within:border-violet-400 focus-within:bg-violet-50">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email address" class="w-full bg-transparent text-sm p-4 rounded-2xl focus:outline-none">
                        </div>
                    </div>

                    <div class="animate-element animate-delay-400">
                        <label for="password" class="text-sm font-medium text-zinc-500">Password</label>
                        <div class="mt-1 rounded-2xl border border-zinc-200 bg-zinc-50 transition-colors focus-within:border-violet-400 focus-within:bg-violet-50">
                            <div class="relative">
                                <input type="password" id="password" name="password" required placeholder="Enter your password" class="w-full bg-transparent text-sm p-4 pr-12 rounded-2xl focus:outline-none">
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-3 flex items-center text-zinc-400 hover:text-zinc-700" aria-label="Toggle password">
                                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.94 17.94A10.94 10.94 0 0112 20c-7 0-11-8-11-8a19.77 19.77 0 014.22-5.36M9.9 4.24A10.94 10.94 0 0112 4c7 0 11 8 11 8a19.77 19.77 0 01-3.16 4.19M1 1l22 22M14.12 14.12a3 3 0 11-4.24-4.24"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="animate-element animate-delay-500 flex items-center justify-between text-sm">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" id="remember" name="remember" class="h-4 w-4 rounded border-zinc-300 text-violet-500 focus:ring-violet-400">
                            <span class="text-zinc-700">Keep me signed in</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-violet-500 hover:underline transition-colors">Reset password</a>
                    </div>

                    <button type="submit" class="animate-element animate-delay-600 w-full rounded-2xl bg-zinc-900 py-4 font-medium text-white hover:bg-zinc-800 transition-colors">
                        Sign In
                    </button>
                </form>

                <div class="animate-element animate-delay-700 relative flex items-center justify-center">
                    <span class="w-full border-t border-zinc-200"></span>
                    <span class="px-4 text-sm text-zinc-500 bg-white absolute">Or continue with</span>
                </div>

                

                <p class="animate-element animate-delay-900 text-center text-sm text-zinc-500">
                    New to NoraPadel? <a href="{{ route('register') }}" class="text-violet-500 hover:underline transition-colors">Create Account</a>
                </p>
            </div>
        </div>
    </section>

    <!-- Right: Hero Image + Testimonials -->
    <section class="hidden md:block flex-1 relative p-4">
        <div class="animate-slide-right animate-delay-300 absolute inset-4 rounded-3xl bg-cover bg-center" style="background-image: url('{{ asset('storage/fiks.jpeg') }}');"></div>
        
    </section>
</div>
@endsection

@push('styles')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .marquee-container { display: flex; overflow: hidden; }
        .marquee-content { display: flex; animation: marquee 30s linear infinite; white-space: nowrap; }
        .marquee-item { font-size: 11px; letter-spacing: 0.15em; font-weight: 600; padding-right: 1rem; }
        @keyframes marquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }
        @keyframes fadeSlideIn { from { opacity: 0; filter: blur(8px); transform: translateY(20px); } to { opacity: 1; filter: blur(0); transform: translateY(0); } }
        @keyframes slideRightIn { from { opacity: 0; filter: blur(8px); transform: translateX(40px); } to { opacity: 1; filter: blur(0); transform: translateX(0); } }
        @keyframes testimonialIn { from { opacity: 0; filter: blur(8px); transform: translateY(20px) scale(0.95); } to { opacity: 1; filter: blur(0); transform: translateY(0) scale(1); } }
        .animate-element { opacity: 0; animation: fadeSlideIn 0.8s ease forwards; }
        .animate-slide-right { opacity: 0; animation: slideRightIn 0.9s ease forwards; }
        .animate-testimonial { opacity: 0; animation: testimonialIn 0.8s ease forwards; }
        .animate-delay-50 { animation-delay: 50ms; }
        .animate-delay-100 { animation-delay: 100ms; }
        .animate-delay-200 { animation-delay: 200ms; }
        .animate-delay-250 { animation-delay: 250ms; }
        .animate-delay-300 { animation-delay: 300ms; }
        .animate-delay-400 { animation-delay: 400ms; }
        .animate-delay-500 { animation-delay: 500ms; }
        .animate-delay-600 { animation-delay: 600ms; }
        .animate-delay-700 { animation-delay: 700ms; }
        .animate-delay-800 { animation-delay: 800ms; }
        .animate-delay-900 { animation-delay: 900ms; }
        .animate-delay-1000 { animation-delay: 1000ms; }
        .animate-delay-1200 { animation-delay: 1200ms; }
        .animate-delay-1400 { animation-delay: 1400ms; }
    </style>
@endpush

@push('scripts')
    <script>
        (function () {
            const toggle = document.querySelector('[data-mobile-menu-toggle]');
            const menu = document.querySelector('[data-mobile-menu]');
            if (toggle && menu) {
                toggle.addEventListener('click', function () {
                    const isOpen = toggle.getAttribute('aria-expanded') === 'true';
                    toggle.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
                    menu.classList.toggle('hidden', isOpen);
                });
            }
        })();
        (function () {
            const toggle = document.getElementById('togglePassword');
            const input = document.getElementById('password');
            const eye = document.getElementById('eyeIcon');
            const eyeOff = document.getElementById('eyeOffIcon');
            if (!toggle || !input) return;
            toggle.addEventListener('click', function () {
                const isPwd = input.type === 'password';
                input.type = isPwd ? 'text' : 'password';
                eye.classList.toggle('hidden', isPwd);
                eyeOff.classList.toggle('hidden', !isPwd);
            });
        })();
    </script>
@endpush
