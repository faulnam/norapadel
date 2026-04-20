@extends('layouts.app')

@section('title', 'Daftar - Nora Padel')

@section('content')
    <div class="min-h-screen bg-[#f5f5f7] text-black antialiased">
    <header class="fixed left-0 top-0 z-50 w-full border-b border-black/6 bg-white/80 backdrop-blur-xl md:sticky">
            <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
                <a href="{{ route('home') }}" class="text-xl font-semibold tracking-tight text-black">NoraPadel</a>

                <nav class="hidden items-center gap-8 md:flex">
                    <a href="{{ route('home') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Home</a>
                    <a href="{{ route('racket') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Racket</a>
                    <a href="{{ route('shoes') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Shoes</a>
                    <a href="{{ route('apparel') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Accessories</a>
                </nav>

                <div class="flex items-center gap-3 text-black/80">
                    <a href="{{ route('login') }}" class="hidden rounded-full border border-black/15 px-3 py-1.5 text-xs font-medium text-black/80 transition duration-300 hover:border-black/30 hover:text-black md:inline-flex md:items-center md:gap-1">
                        <i class="fas fa-sign-in-alt text-[11px]"></i>
                        <span>Masuk</span>
                    </a>
                    <button
                        type="button"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-black/15 text-black transition duration-300 hover:border-black/35 md:hidden"
                        data-mobile-menu-toggle
                        aria-label="Toggle navigation"
                        aria-expanded="false"
                    >
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
                    <a href="{{ route('login') }}" class="rounded-lg px-2 py-1.5 transition hover:bg-black/5">Masuk</a>
                </nav>
            </div>
        </header>

    <main class="pt-16 md:pt-0">
    <section class="px-6 py-10 md:px-10 lg:px-12 lg:py-14">
            <div class="mx-auto grid w-full max-w-7xl gap-8 lg:grid-cols-2 lg:items-stretch">
                <div class="hidden h-full min-h-[760px] flex-col rounded-3xl border border-black/8 bg-white p-8 shadow-[0_16px_42px_rgba(0,0,0,0.08)] lg:flex">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-black/50">Join NoraPadel</p>
                    <h1 class="mt-3 text-4xl font-semibold tracking-tight text-black">Buat akun dan nikmati pengalaman belanja premium.</h1>
                    <p class="mt-4 max-w-xl text-zinc-600">Mulai dari pemilihan raket hingga tracking pesanan real-time, semua dirancang untuk kenyamananmu.</p>
                    <div class="mt-7 overflow-hidden rounded-2xl border border-black/10">
                        <img src="{{ asset('storage/2.png') }}" alt="NoraPadel" class="h-80 w-full object-cover">
                    </div>
                </div>

                <div class="h-full min-h-[760px] rounded-3xl border border-black/8 bg-white p-6 shadow-[0_16px_42px_rgba(0,0,0,0.08)] sm:p-8 lg:p-9">
                    <div class="mb-6 text-center">
                        <img src="{{ asset(config('branding.logo', 'storage/logo.png')) }}" alt="{{ config('branding.name', 'Nora Padel') }}" class="mx-auto h-12 w-auto">
                        <h2 class="mt-4 text-2xl font-semibold tracking-tight text-black">Daftar akun baru</h2>
                        <p class="mt-2 text-sm text-zinc-600">Lengkapi data berikut untuk membuat akun Anda.</p>
                    </div>

                    @if($errors->any())
                        <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            <ul class="list-disc space-y-1 pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div id="registerAlert" class="mb-4 hidden rounded-2xl border px-4 py-3 text-sm"></div>

                    <form id="registerForm" action="{{ route('register.request-otp') }}" method="POST" class="space-y-4" data-request-otp-url="{{ route('register.request-otp') }}" data-verify-otp-url="{{ route('register.verify-otp') }}">
                        @csrf

                        <div>
                            <label for="name" class="mb-2 block text-sm font-medium text-zinc-700">Nama Lengkap</label>
                            <div class="flex items-center gap-2 rounded-xl border border-black/10 bg-white px-3 focus-within:border-black/30">
                                <i class="fas fa-user text-xs text-zinc-400"></i>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full border-0 bg-transparent py-3 text-sm text-black outline-none focus:ring-0" placeholder="Nama lengkap Anda">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-zinc-700">Email</label>
                            <div class="flex items-center gap-2 rounded-xl border border-black/10 bg-white px-3 focus-within:border-black/30">
                                <i class="fas fa-envelope text-xs text-zinc-400"></i>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full border-0 bg-transparent py-3 text-sm text-black outline-none focus:ring-0" placeholder="email@contoh.com">
                            </div>
                        </div>

                        <div>
                            <label for="phone" class="mb-2 block text-sm font-medium text-zinc-700">Nomor Telepon</label>
                            <div class="flex items-center gap-2 rounded-xl border border-black/10 bg-white px-3 focus-within:border-black/30">
                                <i class="fas fa-phone text-xs text-zinc-400"></i>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required class="w-full border-0 bg-transparent py-3 text-sm text-black outline-none focus:ring-0" placeholder="08xxxxxxxxxx">
                            </div>
                        </div>

                        <div>
                            <label for="address" class="mb-2 block text-sm font-medium text-zinc-700">Alamat Lengkap</label>
                            <div class="flex items-start gap-2 rounded-xl border border-black/10 bg-white px-3 focus-within:border-black/30">
                                <i class="fas fa-map-marker-alt pt-3 text-xs text-zinc-400"></i>
                                <textarea id="address" name="address" rows="2" required class="w-full border-0 bg-transparent py-3 text-sm text-black outline-none focus:ring-0" placeholder="Alamat lengkap Anda">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-medium text-zinc-700">Password</label>
                            <div class="flex items-center gap-2 rounded-xl border border-black/10 bg-white px-3 focus-within:border-black/30">
                                <i class="fas fa-lock text-xs text-zinc-400"></i>
                                <input type="password" id="password" name="password" required class="w-full border-0 bg-transparent py-3 text-sm text-black outline-none focus:ring-0" placeholder="Minimal 8 karakter">
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-2 block text-sm font-medium text-zinc-700">Konfirmasi Password</label>
                            <div class="flex items-center gap-2 rounded-xl border border-black/10 bg-white px-3 focus-within:border-black/30">
                                <i class="fas fa-lock text-xs text-zinc-400"></i>
                                <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full border-0 bg-transparent py-3 text-sm text-black outline-none focus:ring-0" placeholder="Ulangi password">
                            </div>
                        </div>

                        <button type="submit" id="registerSubmitBtn" class="inline-flex w-full items-center justify-center rounded-full bg-black px-5 py-3 text-sm font-medium text-white transition duration-300 hover:bg-zinc-800">
                            <i class="fas fa-user-plus mr-2 text-xs"></i>Daftar
                        </button>
                    </form>

                    <p class="mt-6 text-center text-sm text-zinc-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-medium text-black underline decoration-black/30 underline-offset-4 transition hover:decoration-black">Masuk</a>
                    </p>
                </div>
            </div>
    </section>
    </main>

        <div id="otpModal" class="fixed inset-0 z-[70] hidden">
            <div class="absolute inset-0 bg-black/45" data-close-otp-modal></div>
            <div class="relative flex min-h-full items-center justify-center px-4 py-8">
                <div class="w-full max-w-md rounded-3xl border border-black/10 bg-white p-6 shadow-[0_18px_50px_rgba(0,0,0,0.18)] sm:p-7">
                    <div class="mb-5 text-center">
                        <h3 class="text-xl font-semibold tracking-tight text-black">Verifikasi OTP</h3>
                        <p class="mt-2 text-sm text-zinc-600">Masukkan 6 digit kode OTP yang dikirim ke <span id="otpTargetEmail" class="font-medium text-black"></span>.</p>
                    </div>

                    <div id="otpAlert" class="mb-4 hidden rounded-2xl border px-4 py-3 text-sm"></div>

                    <form id="otpVerifyForm" class="space-y-4">
                        <div>
                            <label for="otpCode" class="mb-2 block text-sm font-medium text-zinc-700">Kode OTP</label>
                            <input
                                id="otpCode"
                                name="otp"
                                type="text"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                maxlength="6"
                                required
                                class="w-full rounded-xl border border-black/15 px-4 py-3 text-center text-lg tracking-[0.35em] text-black outline-none transition focus:border-black/30"
                                placeholder="000000"
                            >
                        </div>

                        <button type="submit" id="verifyOtpBtn" class="inline-flex w-full items-center justify-center rounded-full bg-black px-5 py-3 text-sm font-medium text-white transition duration-300 hover:bg-zinc-800">
                            Verifikasi & Aktifkan Akun
                        </button>
                    </form>

                    <div class="mt-4 flex items-center justify-between gap-3">
                        <button type="button" id="resendOtpBtn" class="text-sm font-medium text-black underline decoration-black/30 underline-offset-4 transition hover:decoration-black">Kirim ulang OTP</button>
                        <button type="button" class="text-sm text-zinc-500 transition hover:text-black" data-close-otp-modal>Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <script src="https://cdn.tailwindcss.com"></script>
@endpush

@push('scripts')
    <script>
        (function () {
            const toggle = document.querySelector('[data-mobile-menu-toggle]');
            const menu = document.querySelector('[data-mobile-menu]');
            if (!toggle || !menu) return;

            toggle.addEventListener('click', function () {
                const isOpen = toggle.getAttribute('aria-expanded') === 'true';
                toggle.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
                menu.classList.toggle('hidden', isOpen);
            });
        })();

        (function () {
            const form = document.getElementById('registerForm');
            if (!form) return;

            const submitBtn = document.getElementById('registerSubmitBtn');
            const alertBox = document.getElementById('registerAlert');
            const modal = document.getElementById('otpModal');
            const otpForm = document.getElementById('otpVerifyForm');
            const verifyBtn = document.getElementById('verifyOtpBtn');
            const otpInput = document.getElementById('otpCode');
            const otpAlert = document.getElementById('otpAlert');
            const targetEmail = document.getElementById('otpTargetEmail');
            const resendBtn = document.getElementById('resendOtpBtn');
            const closeButtons = document.querySelectorAll('[data-close-otp-modal]');

            const requestOtpUrl = form.dataset.requestOtpUrl;
            const verifyOtpUrl = form.dataset.verifyOtpUrl;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            let pendingEmail = '';
            let latestPayload = {};

            const showAlert = (element, message, type = 'error') => {
                if (!element) return;

                const classes = type === 'success'
                    ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
                    : 'border-red-200 bg-red-50 text-red-700';

                element.className = `mb-4 rounded-2xl border px-4 py-3 text-sm ${classes}`;
                element.textContent = message;
                element.classList.remove('hidden');
            };

            const hideAlert = (element) => {
                if (!element) return;
                element.classList.add('hidden');
                element.textContent = '';
            };

            const openModal = () => {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                otpInput.focus();
            };

            const closeModal = () => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            };

            const parseErrorMessage = (payload, fallback = 'Terjadi kesalahan. Silakan coba lagi.') => {
                if (!payload) return fallback;

                if (payload.errors && typeof payload.errors === 'object') {
                    const firstKey = Object.keys(payload.errors)[0];
                    if (firstKey && Array.isArray(payload.errors[firstKey]) && payload.errors[firstKey][0]) {
                        return payload.errors[firstKey][0];
                    }
                }

                return payload.message || fallback;
            };

            const sendOtpRequest = async (payload) => {
                const response = await fetch(requestOtpUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json().catch(() => ({}));

                if (!response.ok) {
                    throw new Error(parseErrorMessage(data, 'Gagal mengirim OTP.'));
                }

                return data;
            };

            form.addEventListener('submit', async function (event) {
                event.preventDefault();
                hideAlert(alertBox);

                const formData = new FormData(form);
                const payload = Object.fromEntries(formData.entries());
                latestPayload = payload;

                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-70', 'cursor-not-allowed');

                try {
                    const data = await sendOtpRequest(payload);

                    pendingEmail = data.email || payload.email || '';
                    targetEmail.textContent = pendingEmail;
                    otpInput.value = '';
                    hideAlert(otpAlert);
                    openModal();
                    showAlert(alertBox, data.message || 'OTP sudah dikirim ke email Anda.', 'success');
                } catch (error) {
                    showAlert(alertBox, error.message || 'Gagal mengirim OTP.', 'error');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-70', 'cursor-not-allowed');
                }
            });

            otpForm.addEventListener('submit', async function (event) {
                event.preventDefault();
                hideAlert(otpAlert);

                const otp = (otpInput.value || '').replace(/\D/g, '').slice(0, 6);
                otpInput.value = otp;

                if (!pendingEmail) {
                    showAlert(otpAlert, 'Email verifikasi tidak ditemukan. Silakan daftar ulang.', 'error');
                    return;
                }

                verifyBtn.disabled = true;
                verifyBtn.classList.add('opacity-70', 'cursor-not-allowed');

                try {
                    const response = await fetch(verifyOtpUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            email: pendingEmail,
                            otp,
                        }),
                    });

                    const data = await response.json().catch(() => ({}));

                    if (!response.ok) {
                        throw new Error(parseErrorMessage(data, 'Verifikasi OTP gagal.'));
                    }

                    window.location.href = data.redirect || '{{ route('customer.products.index') }}';
                } catch (error) {
                    showAlert(otpAlert, error.message || 'Verifikasi OTP gagal.', 'error');
                } finally {
                    verifyBtn.disabled = false;
                    verifyBtn.classList.remove('opacity-70', 'cursor-not-allowed');
                }
            });

            resendBtn.addEventListener('click', async function () {
                hideAlert(otpAlert);

                if (!latestPayload.email) {
                    showAlert(otpAlert, 'Data pendaftaran belum tersedia. Silakan isi form ulang.', 'error');
                    return;
                }

                resendBtn.disabled = true;
                resendBtn.classList.add('opacity-70', 'cursor-not-allowed');

                try {
                    const data = await sendOtpRequest(latestPayload);
                    pendingEmail = data.email || latestPayload.email;
                    targetEmail.textContent = pendingEmail;
                    showAlert(otpAlert, data.message || 'OTP baru sudah dikirim.', 'success');
                } catch (error) {
                    showAlert(otpAlert, error.message || 'Gagal kirim ulang OTP.', 'error');
                } finally {
                    resendBtn.disabled = false;
                    resendBtn.classList.remove('opacity-70', 'cursor-not-allowed');
                }
            });

            closeButtons.forEach((button) => {
                button.addEventListener('click', closeModal);
            });
        })();
    </script>
@endpush
