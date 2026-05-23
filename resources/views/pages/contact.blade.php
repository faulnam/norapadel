@extends('layouts.app')

@section('title', 'Contact - NoraPadel')

@section('content')
    <div class="bg-white text-black antialiased">

    <x-luxury-navbar />

    <main class="pt-16">
    <section class="bg-zinc-50 pt-8 pb-14 lg:pt-10 lg:pb-16">
            <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
                <div class="mx-auto max-w-3xl text-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500">Support</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-black sm:text-4xl">Contact NoraPadel</h1>
                    <p class="mt-4 text-zinc-600">Send your questions. We will respond as soon as possible during business hours.</p>
                </div>

                <div class="mx-auto mt-12 grid max-w-5xl gap-8 lg:grid-cols-[1fr_1.35fr]">
                    <div class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-black">Contact Information</h2>
                        <ul class="mt-5 space-y-3 text-sm text-zinc-600">
                            <li><span class="font-medium text-black">WhatsApp:</span> {{ config('branding.phone', '08511735858') }}</li>
                            <li><span class="font-medium text-black">Email:</span> support@norapadel.com</li>
                            <li><span class="font-medium text-black">Address:</span> {{ config('branding.address', 'Citraland, Surabaya, East Java, Indonesia') }}</li>
                        </ul>
                    </div>

                    <form method="POST" action="{{ route('contact.submit') }}" class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
                        @csrf
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <label for="name" class="mb-2 block text-sm font-medium text-zinc-700">Name</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" required class="w-full rounded-xl border border-zinc-300 px-4 py-2.5 text-sm outline-none transition focus:border-black" />
                                @error('name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="sm:col-span-1">
                                <label for="email" class="mb-2 block text-sm font-medium text-zinc-700">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-zinc-300 px-4 py-2.5 text-sm outline-none transition focus:border-black" />
                                @error('email')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="subject" class="mb-2 block text-sm font-medium text-zinc-700">Subject</label>
                                <input id="subject" name="subject" type="text" value="{{ old('subject') }}" required class="w-full rounded-xl border border-zinc-300 px-4 py-2.5 text-sm outline-none transition focus:border-black" />
                                @error('subject')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="message" class="mb-2 block text-sm font-medium text-zinc-700">Message</label>
                                <textarea id="message" name="message" rows="5" required class="w-full rounded-xl border border-zinc-300 px-4 py-2.5 text-sm outline-none transition focus:border-black">{{ old('message') }}</textarea>
                                @error('message')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <button type="submit" class="mt-6 inline-flex rounded-full bg-black px-5 py-2.5 text-sm font-medium text-white transition hover:bg-zinc-800">Send Message</button>
                    </form>
                </div>
            </div>
        </section>
        </main>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            const mobileMenuToggle = document.querySelector('[data-mobile-menu-toggle]');
            const mobileMenu = document.querySelector('[data-mobile-menu]');

            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                    mobileMenuToggle.setAttribute('aria-expanded', String(!mobileMenu.classList.contains('hidden')));
                });
            }
        })();

        // Hamburger Menu Toggle - independent IIFE
        (function() {
            const btn = document.getElementById('hamburgerMenuBtn');
            const dropdown = document.getElementById('hamburgerMenuDropdown');
            const wrapper = document.getElementById('hamburgerMenuWrapper');
            if (!btn || !dropdown || !wrapper) return;
            btn.addEventListener('click', function(e){ e.stopPropagation(); dropdown.classList.toggle('hidden'); });
            document.addEventListener('click', function(e){ if(!wrapper.contains(e.target)) dropdown.classList.add('hidden'); });
        })();

        // Mega Dropdown Hover Control
        (function() {
            const dropdownContainers = document.querySelectorAll('[data-dropdown]');
            let activeDropdown = null;
            let hoverTimeout = null;

            dropdownContainers.forEach(container => {
                const dropdown = container.querySelector('.absolute');

                container.addEventListener('mouseenter', () => {
                    if (hoverTimeout) {
                        clearTimeout(hoverTimeout);
                        hoverTimeout = null;
                    }

                    dropdownContainers.forEach(otherContainer => {
                        if (otherContainer !== container) {
                            const otherDropdown = otherContainer.querySelector('.absolute');
                            if (otherDropdown) {
                                otherDropdown.classList.add('invisible', 'opacity-0', 'translate-y-[-10px]');
                                otherDropdown.classList.remove('visible', 'opacity-100', 'translate-y-0');
                            }
                        }
                    });

                    if (dropdown) {
                        dropdown.classList.remove('invisible', 'opacity-0', 'translate-y-[-10px]');
                        dropdown.classList.add('visible', 'opacity-100', 'translate-y-0');
                    }
                    activeDropdown = container;
                });

                container.addEventListener('mouseleave', () => {
                    hoverTimeout = setTimeout(() => {
                        if (dropdown) {
                            dropdown.classList.add('invisible', 'opacity-0', 'translate-y-[-10px]');
                            dropdown.classList.remove('visible', 'opacity-100', 'translate-y-0');
                        }
                        activeDropdown = null;
                    }, 100);
                });

                if (dropdown) {
                    dropdown.addEventListener('mouseenter', () => {
                        if (hoverTimeout) {
                            clearTimeout(hoverTimeout);
                            hoverTimeout = null;
                        }
                    });

                    dropdown.addEventListener('mouseleave', () => {
                        hoverTimeout = setTimeout(() => {
                            dropdown.classList.add('invisible', 'opacity-0', 'translate-y-[-10px]');
                            dropdown.classList.remove('visible', 'opacity-100', 'translate-y-0');
                            activeDropdown = null;
                        }, 100);
                    });
                }
            });
        })();

        // Modern Search Overlay
        (function() {
            const overlay = document.getElementById('searchOverlay');
            const panel = document.getElementById('searchPanel');
            const toggleBtn = document.getElementById('searchToggleBtn');
            const closeBtn = document.getElementById('searchCloseBtn');
            const backdrop = document.getElementById('searchBackdrop');
            const input = document.getElementById('searchInput');
            const loading = document.getElementById('searchLoading');
            const initialState = document.getElementById('searchInitial');
            const emptyState = document.getElementById('searchEmpty');
            const resultsList = document.getElementById('searchResults');

            if (!overlay || !toggleBtn || !input) return;

            let debounceTimer;
            let currentController;

            function openOverlay() {
                overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                requestAnimationFrame(() => {
                    overlay.classList.remove('opacity-0');
                    overlay.classList.add('opacity-100');
                    panel.classList.remove('-translate-y-4');
                    panel.classList.add('translate-y-0');
                    setTimeout(() => input.focus(), 50);
                });
            }

            function closeOverlay() {
                overlay.classList.add('opacity-0');
                overlay.classList.remove('opacity-100');
                panel.classList.add('-translate-y-4');
                panel.classList.remove('translate-y-0');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                    document.body.style.overflow = '';
                    input.value = '';
                    initialState.classList.remove('hidden');
                    emptyState.classList.add('hidden');
                    resultsList.classList.add('hidden');
                }, 300);
            }

            function escapeHtml(s) {
                return String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
            }

            function renderResults(products) {
                resultsList.innerHTML = products.map(p => `
                    <a href="${escapeHtml(p.detail_url)}" class="flex items-center gap-4 px-5 py-3 transition hover:bg-zinc-50">
                        <div class="h-14 w-14 flex-shrink-0 overflow-hidden rounded-lg bg-zinc-100">
                            <img src="${escapeHtml(p.image_url)}" alt="${escapeHtml(p.name)}" class="h-full w-full object-cover" onerror="this.onerror=null;this.src='/images/logo.png';" loading="lazy">
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-zinc-900">${escapeHtml(p.name)}</p>
                            <div class="mt-0.5 flex items-center gap-2 text-xs text-zinc-500">
                                ${p.brand ? `<span class="font-medium">${escapeHtml(p.brand)}</span>` : ''}
                                ${p.brand && p.category_label ? '<span class="text-zinc-300">·</span>' : ''}
                                ${p.category_label ? `<span>${escapeHtml(p.category_label)}</span>` : ''}
                            </div>
                        </div>
                        <p class="flex-shrink-0 text-sm font-semibold text-zinc-900">${escapeHtml(p.formatted_price)}</p>
                    </a>
                `).join('');
            }

            async function performSearch(query) {
                if (currentController) currentController.abort();
                currentController = new AbortController();
                loading.classList.remove('hidden');
                try {
                    const res = await fetch(`/api/search-products?q=${encodeURIComponent(query)}`, {
                        signal: currentController.signal,
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await res.json();
                    loading.classList.add('hidden');
                    if (data.products && data.products.length > 0) {
                        renderResults(data.products);
                        initialState.classList.add('hidden');
                        emptyState.classList.add('hidden');
                        resultsList.classList.remove('hidden');
                    } else {
                        initialState.classList.add('hidden');
                        emptyState.classList.remove('hidden');
                        resultsList.classList.add('hidden');
                    }
                } catch (err) {
                    if (err.name !== 'AbortError') {
                        loading.classList.add('hidden');
                        console.error('Search error:', err);
                    }
                }
            }

            input.addEventListener('input', function() {
                const q = this.value.trim();
                clearTimeout(debounceTimer);
                if (q.length < 2) {
                    loading.classList.add('hidden');
                    if (currentController) currentController.abort();
                    initialState.classList.remove('hidden');
                    emptyState.classList.add('hidden');
                    resultsList.classList.add('hidden');
                    return;
                }
                debounceTimer = setTimeout(() => performSearch(q), 250);
            });

            toggleBtn.addEventListener('click', openOverlay);
            closeBtn.addEventListener('click', closeOverlay);
            backdrop.addEventListener('click', closeOverlay);

            const navSearchInputEl = document.getElementById('navSearchInput');
            if (navSearchInputEl) {
                navSearchInputEl.addEventListener('focus', function() {
                    openOverlay();
                    const q = this.value.trim();
                    if (q.length >= 2) {
                        input.value = q;
                        performSearch(q);
                    }
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !overlay.classList.contains('hidden')) {
                    closeOverlay();
                }
            });
        })();
    </script>
@endpush
