<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ config('branding.name', 'Nora Padel') }} - {{ config('branding.tagline', 'Performa Maksimal, Game Makin Total') }}. Toko perlengkapan padel premium untuk pemula hingga profesional.">
    <meta property="og:title" content="@yield('title', config('branding.name', 'Nora Padel'))">
    <meta property="og:description" content="{{ config('branding.tagline', 'Performa Maksimal, Game Makin Total') }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset(config('branding.logo', 'storage/logo.png')) }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset(config('branding.favicon', 'storage/logo.png')) }}">
    <title>@yield('title', 'Nora Padel - Performa Maksimal, Game Makin Total')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts - Plus Jakarta Sans (Modern & Gen-Z friendly) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #16a34a;
            --primary-dark: #15803d;
            --primary-light: #dcfce7;
            --accent: #f97316;
            --accent-light: #ffedd5;
            --dark: #1f2937;
            --gray: #6b7280;
            --gray-light: #f3f4f6;
            --white: #ffffff;
            --off-white: #fafafa;
            --radius: 12px;
            --radius-sm: 8px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--off-white);
            color: var(--dark);
            line-height: 1.6;
        }
        
        /* Navbar - Professional & Formal */
        .navbar {
            background: var(--white);
            padding: 0.875rem 0;
            border-bottom: 1px solid #e5e7eb;
            transition: var(--transition);
        }
        
        .navbar.scrolled {
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.375rem;
            color: var(--dark) !important;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 0.625rem;
        }
        
        .navbar-brand-icon {
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }
        
        .navbar-nav {
            gap: 0.25rem;
        }
        
        .nav-link {
            font-weight: 500;
            font-size: 0.9375rem;
            color: #4b5563 !important;
            padding: 0.5rem 1.125rem !important;
            transition: color 0.2s ease;
            position: relative;
            letter-spacing: -0.01em;
        }
        
        .nav-link:hover {
            color: var(--primary) !important;
        }
        
        .nav-link.active {
            color: var(--primary) !important;
            font-weight: 600;
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -0.875rem;
            left: 1.125rem;
            right: 1.125rem;
            height: 2px;
            background: var(--primary);
        }
        
        /* Auth Button in Navbar */
        .btn-nav-login {
            background: var(--primary);
            color: white !important;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.5rem 1.25rem;
            border-radius: 6px;
            border: none;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-nav-login:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
        }
        
        .btn {
            font-weight: 600;
            padding: 0.625rem 1.5rem;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }
        
        .btn-primary {
            background: var(--primary);
            border: none;
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }
        
        .btn-outline-primary {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }
        
        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
        }
        
        .btn-accent {
            background: var(--accent);
            border: none;
            color: white;
        }
        
        .btn-accent:hover {
            background: #ea580c;
            transform: translateY(-2px);
            box-shadow: var(--shadow);
            color: white;
        }
        
        /* Cards */
        .card {
            background: var(--white);
            border: 1px solid var(--gray-light);
            border-radius: var(--radius);
            box-shadow: none;
            transition: var(--transition);
        }
        
        .card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
        }
        
        /* Badge */
        .badge {
            font-weight: 600;
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
        }
        
        .badge-primary {
            background: var(--primary-light);
            color: var(--primary);
        }
        
        .badge-accent {
            background: var(--accent-light);
            color: var(--accent);
        }
        
        /* Text Utilities */
        .text-primary { color: var(--primary) !important; }
        .text-gray { color: var(--gray) !important; }
        .text-dark { color: var(--dark) !important; }
        .bg-primary { background-color: var(--primary) !important; }
        .bg-primary-light { background-color: var(--primary-light) !important; }
        .bg-gray-light { background-color: var(--gray-light) !important; }
        
        /* Section Title */
        .section-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .section-subtitle {
            color: var(--gray);
            font-size: 1rem;
        }
        
        /* Cart Badge */
        .cart-badge {
            position: absolute;
            top: -4px;
            right: -8px;
            background: var(--accent);
            color: white;
            font-size: 0.65rem;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 700;
        }
        
        /* Mobile Nav Icons */
        .mobile-nav-icons {
            gap: 0.5rem;
            margin-right: 0.75rem;
        }
        
        .nav-icon-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--gray-light);
            color: var(--dark);
            text-decoration: none;
            position: relative;
            transition: var(--transition);
        }
        
        .nav-icon-link:hover {
            background: var(--primary-light);
            color: var(--primary);
        }
        
        .nav-icon-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: var(--accent);
            color: white;
            font-size: 0.6rem;
            min-width: 16px;
            height: 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        
        .nav-avatar {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        
        /* Dropdown */
        .dropdown-menu {
            border: 1px solid var(--gray-light);
            box-shadow: var(--shadow-lg);
            border-radius: var(--radius);
            padding: 0.5rem;
        }
        
        .dropdown-item {
            border-radius: var(--radius-sm);
            padding: 0.625rem 1rem;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .dropdown-item:hover {
            background: var(--primary-light);
            color: var(--primary);
        }
        
        /* Footer */
        .footer {
            background: var(--dark);
            color: white;
            padding: 3rem 0 1.5rem;
            margin-top: auto;
        }
        
        .footer h5 {
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.125rem;
        }
        
        .footer h6 {
            font-size: 0.875rem;
        }
        
        .footer-link {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: var(--transition);
            display: block;
            padding: 0.25rem 0;
            font-size: 0.875rem;
        }
        
        .footer-link:hover {
            color: white;
            padding-left: 5px;
        }
        
        .footer-social a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            color: white;
            margin-right: 0.5rem;
            transition: var(--transition);
        }
        
        .footer-social a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }
        
        /* Footer responsive */
        @media (max-width: 767.98px) {
            .footer {
                padding: 2rem 0 1rem;
            }
            
            .footer h5 {
                font-size: 1rem;
                margin-bottom: 0.75rem;
            }
            
            .footer h5 img {
                height: 24px !important;
            }
            
            .footer p {
                font-size: 0.8125rem;
            }
            
            .footer h6 {
                font-size: 0.8125rem;
                margin-bottom: 0.5rem;
            }
            
            .footer-link {
                font-size: 0.8125rem;
                padding: 0.1875rem 0;
            }
            
            .footer-social a {
                width: 36px;
                height: 36px;
                font-size: 0.875rem;
            }
            
            .footer .text-white-50 {
                font-size: 0.75rem;
            }
            
            .footer hr {
                margin: 1.5rem 0 0.75rem;
            }
        }
        
        /* Alert */
        .alert {
            border: none;
            border-radius: var(--radius);
            padding: 1rem 1.25rem;
        }
        
        .alert-success {
            background: var(--primary-light);
            color: var(--primary-dark);
        }
        
        .alert-danger {
            background: #fee2e2;
            color: #dc2626;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--gray-light);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--gray);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }
        
        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        /* Mobile */
        @media (max-width: 991.98px) {
            .navbar {
                padding: 0.625rem 0;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1040;
                background: var(--white);
            }
            
            /* Add padding to body to account for fixed navbar */
            body {
                padding-top: 60px;
            }
            
            .navbar-brand img {
                height: 32px;
            }
            
            .navbar-toggler {
                padding: 0.375rem 0.5rem;
                font-size: 1rem;
            }
            
            .navbar-collapse {
                background: var(--white);
                padding: 1rem;
                border-radius: var(--radius);
                margin-top: 0.75rem;
                box-shadow: var(--shadow-lg);
                border: 1px solid var(--gray-light);
                max-height: calc(100vh - 80px);
                overflow-y: auto;
            }
            
            .navbar-nav {
                gap: 0.25rem;
            }
            
            .nav-link {
                padding: 0.75rem 1rem !important;
                border-radius: 8px;
                font-size: 0.9375rem;
            }
            
            .nav-link:hover {
                background: var(--gray-light);
            }
            
            .nav-link.active {
                background: var(--primary-light);
            }
            
            .nav-link.active::after {
                display: none;
            }
            
            /* Simpler mobile menu */
            .navbar-nav .border-top {
                border-color: var(--gray-light) !important;
            }
            
            .btn-nav-login {
                display: block;
                text-align: center;
                margin-top: 0.75rem;
                padding: 0.75rem 1.25rem;
            }
            
            /* Mobile utility classes */
            .ms-lg-2, .ms-lg-3 {
                margin-left: 0 !important;
            }
        }
        
        @media (max-width: 575.98px) {
            .navbar-brand img {
                height: 28px;
            }
            
            .nav-link {
                font-size: 0.875rem;
                padding: 0.625rem 0.875rem !important;
            }
            
            .cart-badge {
                font-size: 0.5625rem;
                padding: 1px 4px;
            }
        }
        
        /* Mobile Bottom Navigation */
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--white);
            border-top: 1px solid #e5e7eb;
            padding: 0.5rem 0;
            padding-bottom: calc(0.5rem + env(safe-area-inset-bottom));
            z-index: 1050;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .mobile-bottom-nav-inner {
            display: flex;
            justify-content: space-around;
            align-items: center;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .mobile-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: var(--gray);
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            transition: var(--transition);
            position: relative;
            min-width: 60px;
        }
        
        .mobile-nav-item:hover,
        .mobile-nav-item.active {
            color: var(--primary);
        }
        
        .mobile-nav-item.active {
            background: var(--primary-light);
        }
        
        .mobile-nav-item i {
            font-size: 1.25rem;
            margin-bottom: 0.125rem;
        }
        
        .mobile-nav-item span {
            font-size: 0.625rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .mobile-nav-badge {
            position: absolute;
            top: -2px;
            right: 8px;
            background: var(--accent);
            color: white;
            font-size: 0.55rem;
            min-width: 16px;
            height: 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        
        @media (max-width: 991.98px) {
            .mobile-bottom-nav {
                display: block;
            }
            
            /* Hide default navbar toggler menu on mobile */
            .navbar-toggler {
                display: none !important;
            }
            
            .navbar-collapse {
                display: none !important;
            }
            
            /* Add padding to body to account for bottom nav */
            body {
                padding-bottom: 70px;
            }
            
            /* Hide footer on mobile for cleaner look */
            .footer {
                padding-bottom: 80px;
            }
        }

        [data-auto-parallax] {
            --np-parallax-shift: 0px;
            transform: translate3d(0, var(--np-parallax-shift), 0);
            will-change: transform;
            transition: transform 420ms cubic-bezier(0.22, 1, 0.36, 1);
        }

        @media (prefers-reduced-motion: reduce) {
            [data-auto-parallax] {
                transition: none !important;
                transform: none !important;
            }
        }

        .np-product-modal .modal-dialog {
            max-width: 880px;
        }

        .np-product-modal .modal-content {
            border: 0;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 28px 70px rgba(0, 0, 0, 0.22);
        }

        .np-product-modal .modal-header {
            position: absolute;
            top: 0;
            right: 0;
            z-index: 6;
            border: 0;
            padding: 0.75rem;
        }

        .np-product-modal .btn-close {
            background-color: rgba(255, 255, 255, 0.92);
            border-radius: 999px;
            opacity: 1;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.18);
        }

        .np-product-modal-body {
            padding: 0;
        }

        .np-product-media {
            background: #f5f7fb;
            min-height: 340px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            height: 100%;
        }

        .np-product-media img {
            width: 100%;
            height: 100%;
            min-height: 340px;
            object-fit: cover;
            display: block;
        }

        .np-product-content {
            padding: 1.5rem;
        }

        .np-product-category {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        .np-product-title {
            font-size: 1.6rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 0.75rem;
            color: #111827;
        }

        .np-product-description {
            color: #4b5563;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .np-product-price {
            font-size: 1.55rem;
            font-weight: 800;
            color: #52525b;
            line-height: 1.1;
        }

        .np-product-price-old {
            font-size: 0.875rem;
            color: #94a3b8;
            text-decoration: line-through;
            margin-top: 0.15rem;
        }

        .np-product-actions {
            margin-top: 1.25rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.625rem;
        }

        .np-product-buy-btn {
            background: #18181b;
            color: #ffffff;
            border: 1px solid #18181b;
            font-weight: 600;
            font-size: 0.8125rem;
            padding: 0.45rem 0.8rem;
            line-height: 1.2;
        }

        .np-product-buy-btn:hover {
            background: #27272a;
            border-color: #27272a;
            color: #ffffff;
        }

        .np-product-cart-btn {
            background: transparent;
            color: #3f3f46;
            border: 1px solid #d4d4d8;
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            padding: 0;
        }

        .np-product-cart-btn:hover {
            background: #f4f4f5;
            color: #18181b;
            border-color: #a1a1aa;
        }

        @media (max-width: 767.98px) {
            .np-product-modal .modal-dialog {
                margin: 0.75rem;
            }

            .np-product-media {
                min-height: 220px;
            }

            .np-product-media img {
                min-height: 220px;
            }

            .np-product-title {
                font-size: 1.25rem;
            }

            .np-product-price {
                font-size: 1.25rem;
            }
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>

    @stack('styles')
</head>
<body>
    @unless(request()->routeIs('home', 'racket', 'shoes', 'apparel', 'shop', 'login', 'register', 'customer.products.*', 'customer.cart.*', 'customer.profile.*', 'customer.checkout'))
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                @if(request()->routeIs('help-center', 'contact', 'about'))
                    <span class="text-dark">{{ config('branding.name', 'Nora Padel') }}</span>
                @else
                    <img src="{{ asset(config('branding.logo', 'storage/logo.png')) }}" alt="{{ config('branding.name', 'Nora Padel') }}" height="40" class="brand-logo">
                @endif
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}" href="{{ route('tentang') }}">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('produk.*') ? 'active' : '' }}" href="{{ route('produk.index') }}">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('galeri') ? 'active' : '' }}" href="{{ route('galeri') }}">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('testimoni') ? 'active' : '' }}" href="{{ route('testimoni') }}">Testimoni</a>
                    </li>

                    @guest
                        <li class="nav-item ms-lg-1 d-none d-lg-block">
                            <a class="nav-link" href="{{ route('login') }}" aria-label="Keranjang (login terlebih dahulu)">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        </li>
                        <li class="nav-item ms-lg-3">
                            <a class="btn-nav-login" href="{{ route('login') }}">Masuk</a>
                        </li>
                    @else
                        <!-- Desktop: Cart Icon -->
                        @if(auth()->user()->isCustomer())
                            <li class="nav-item ms-lg-2 d-none d-lg-block">
                                <a class="nav-link position-relative" href="{{ route('customer.cart.index') }}">
                                    <i class="fas fa-shopping-cart fa-lg"></i>
                                    @php $cartCount = auth()->user()->cartItems()->sum('quantity'); @endphp
                                    @if($cartCount > 0)
                                        <span class="cart-badge">{{ $cartCount }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif
                        
                        <!-- Desktop: User Dropdown -->
                        <li class="nav-item dropdown ms-lg-2 d-none d-lg-block">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" 
                                     class="rounded-circle me-2" style="width: 28px; height: 28px; object-fit: cover;">
                                <span>{{ Str::limit(auth()->user()->name, 10) }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(auth()->user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard Admin
                                    </a></li>
                                @elseif(auth()->user()->isCourier())
                                    <li><a class="dropdown-item" href="{{ route('courier.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard Kurir
                                    </a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('customer.products.index') }}">
                                        <i class="fas fa-store me-2 text-primary"></i>Belanja
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('customer.orders.index') }}">
                                        <i class="fas fa-history me-2 text-primary"></i>Riwayat Pesanan
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('customer.profile.index') }}">
                                        <i class="fas fa-user me-2 text-primary"></i>Profil
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('customer.notifications.index') }}">
                                        <i class="fas fa-bell me-2 text-primary"></i>Notifikasi
                                        @if(auth()->user()->unreadNotifications->count() > 0)
                                            <span class="badge bg-danger ms-2">{{ auth()->user()->unreadNotifications->count() }}</span>
                                        @endif
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- Mobile: User Menu -->
                        <li class="nav-item d-lg-none mobile-user-section">
                            <hr class="my-2">
                            @if(auth()->user()->isAdmin())
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me- text-primary"></i>Dashboard
                                </a>
                            @elseif(auth()->user()->isCourier())
                                <a class="nav-link" href="{{ route('courier.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard
                                </a>
                            @else
                                <a class="nav-link" href="{{ route('customer.cart.index') }}">
                                    <i class="fas fa-shopping-cart me-2 text-primary"></i>Keranjang
                                    @if($cartCount > 0)
                                        <span class="badge bg-primary ms-1">{{ $cartCount }}</span>
                                    @endif
                                </a>
                                <a class="nav-link" href="{{ route('customer.products.index') }}">
                                    <i class="fas fa-store me-2 text-primary"></i>Belanja
                                </a>
                                <a class="nav-link" href="{{ route('customer.orders.index') }}">
                                    <i class="fas fa-history me-2 text-primary"></i>Riwayat Pesanan
                                </a>
                                <a class="nav-link" href="{{ route('customer.profile.index') }}">
                                    <i class="fas fa-user me-2 text-primary"></i>Profil
                                </a>
                                <a class="nav-link" href="{{ route('customer.notifications.index') }}">
                                    <i class="fas fa-bell me-2 text-primary"></i>Notifikasi
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <span class="badge bg-danger ms-1">{{ auth()->user()->unreadNotifications->count() }}</span>
                                    @endif
                                </a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                                    <i class="fas fa-sign-out-alt me-2"></i>Keluar
                                </button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @endunless

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <div class="modal fade np-product-modal" id="npProductModal" tabindex="-1" aria-labelledby="npProductModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body np-product-modal-body">
                    <div class="row g-0">
                        <div class="col-md-5">
                            <div class="np-product-media">
                                <img id="npModalImage" src="" alt="Product image">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="np-product-content">
                                <div id="npModalCategory" class="np-product-category">Produk</div>
                                <h3 id="npProductModalTitle" class="np-product-title">Detail Produk</h3>
                                <p id="npModalDescription" class="np-product-description">Deskripsi produk akan ditampilkan di sini.</p>

                                <div>
                                    <div id="npModalPrice" class="np-product-price">-</div>
                                    <div id="npModalOldPrice" class="np-product-price-old d-none"></div>
                                </div>

                                <div class="np-product-actions">
                                    @auth
                                        @if(auth()->user()->isCustomer())
                                            <form id="npModalCartForm" action="{{ route('customer.cart.add', ['product' => 1]) }}" data-action-template="{{ route('customer.cart.add', ['product' => '__PRODUCT_ID__']) }}" method="POST" class="d-flex gap-2 align-items-center">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn np-product-buy-btn">
                                                    <i class="fas fa-shopping-bag me-2"></i>Beli
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-secondary">Akun ini tidak dapat melakukan pembelian</span>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn np-product-buy-btn">
                                            <i class="fas fa-shopping-bag me-2"></i>Beli
                                        </a>
                                        <a href="{{ route('login') }}" class="btn np-product-cart-btn" aria-label="Keranjang (login terlebih dahulu)">
                                            <i class="fas fa-shopping-cart"></i>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-site-footer />

    @unless(request()->routeIs('home', 'racket', 'shoes', 'apparel', 'shop', 'login', 'register', 'customer.products.*', 'customer.cart.*', 'customer.profile.*', 'customer.checkout'))
    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-bottom-nav">
        <div class="mobile-bottom-nav-inner">
            <a href="{{ route('home') }}" class="mobile-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <br>
            </a>
            <a href="{{ route('produk.index') }}" class="mobile-nav-item {{ request()->routeIs('produk.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
               <br>
            </a>
            @auth
                @if(auth()->user()->isCustomer())
                    <a href="{{ route('customer.cart.index') }}" class="mobile-nav-item {{ request()->routeIs('customer.cart.*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i>
                        <br>
                        @php $cartCount = auth()->user()->cartItems()->sum('quantity'); @endphp
                        @if($cartCount > 0)
                            <span class="mobile-nav-badge">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('customer.orders.index') }}" class="mobile-nav-item {{ request()->routeIs('customer.orders.*') ? 'active' : '' }}">
                        <i class="fas fa-history"></i>
                       <br>
                    </a>
                    <a href="{{ route('customer.profile.index') }}" class="mobile-nav-item {{ request()->routeIs('customer.profile.*') ? 'active' : '' }}">
                        <i class="fas fa-user"></i>
                        <br>
                    </a>
                @elseif(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="mobile-nav-item">
                        <i class="fas fa-tachometer-alt"></i>
                        <br>
                    </a>
                    <a href="{{ route('galeri') }}" class="mobile-nav-item {{ request()->routeIs('galeri') ? 'active' : '' }}">
                        <i class="fas fa-images"></i>
                        <br>
                    </a>
                    <a href="{{ route('testimoni') }}" class="mobile-nav-item {{ request()->routeIs('testimoni') ? 'active' : '' }}">
                        <i class="fas fa-star"></i>
                        <br>
                    </a>
                @elseif(auth()->user()->isCourier())
                    <a href="{{ route('courier.dashboard') }}" class="mobile-nav-item">
                        <i class="fas fa-motorcycle"></i>
                        <br>
                    </a>
                    <a href="{{ route('galeri') }}" class="mobile-nav-item {{ request()->routeIs('galeri') ? 'active' : '' }}">
                        <i class="fas fa-images"></i>
                        <br>
                    </a>
                    <a href="{{ route('testimoni') }}" class="mobile-nav-item {{ request()->routeIs('testimoni') ? 'active' : '' }}">
                        <i class="fas fa-star"></i>
                        <br>
                    </a>
                @endif
            @else
                <a href="{{ route('galeri') }}" class="mobile-nav-item {{ request()->routeIs('galeri') ? 'active' : '' }}">
                    <i class="fas fa-images"></i>
                    <br>
                </a>
                <a href="{{ route('testimoni') }}" class="mobile-nav-item {{ request()->routeIs('testimoni') ? 'active' : '' }}">
                    <i class="fas fa-star"></i>
                    <br>
                </a>
                <a href="{{ route('login') }}" class="mobile-nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
                    <i class="fas fa-sign-in-alt"></i>
                    <br>
                </a>
            @endauth
        </div>
    </nav>
    @endunless

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (!navbar) return;
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>

    <script>
        (function () {
            const modalEl = document.getElementById('npProductModal');
            if (!modalEl || typeof bootstrap === 'undefined') return;

            const modal = new bootstrap.Modal(modalEl);
            const modalImage = document.getElementById('npModalImage');
            const modalCategory = document.getElementById('npModalCategory');
            const modalTitle = document.getElementById('npProductModalTitle');
            const modalDescription = document.getElementById('npModalDescription');
            const modalPrice = document.getElementById('npModalPrice');
            const modalOldPrice = document.getElementById('npModalOldPrice');
            const cartForm = document.getElementById('npModalCartForm');
            const fallbackImage = '{{ asset(config('branding.logo', 'storage/logo.png')) }}';

            const toText = (value, fallback = '') => {
                const clean = (value || '').toString().trim();
                return clean.length ? clean : fallback;
            };

            const openProductModal = (trigger) => {
                const dataset = trigger.dataset;

                const productId = toText(dataset.productId);
                const name = toText(dataset.productName, 'Produk NoraPadel');
                const category = toText(dataset.productCategory, 'Produk');
                const description = toText(dataset.productDescription, 'Detail produk belum tersedia.');
                const image = toText(dataset.productImage, fallbackImage);
                const price = toText(dataset.productPrice, '-');
                const oldPrice = toText(dataset.productOldPrice);

                modalImage.src = image;
                modalImage.alt = name;
                modalCategory.textContent = category;
                modalTitle.textContent = name;
                modalDescription.textContent = description;
                modalPrice.textContent = price;

                if (oldPrice && oldPrice !== price) {
                    modalOldPrice.textContent = oldPrice;
                    modalOldPrice.classList.remove('d-none');
                } else {
                    modalOldPrice.textContent = '';
                    modalOldPrice.classList.add('d-none');
                }

                if (cartForm && productId) {
                    const actionTemplate = cartForm.dataset.actionTemplate || '';
                    cartForm.action = actionTemplate.replace('__PRODUCT_ID__', productId);
                }

                modal.show();
            };

            document.addEventListener('click', function (event) {
                const trigger = event.target.closest('[data-product-trigger]');
                if (!trigger) return;

                event.preventDefault();
                openProductModal(trigger);
            });
        })();
    </script>

    <script>
        (function () {
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (prefersReducedMotion) return;

            const selector = [
                'section',
                'footer',
                '.page-hero',
                '.hero-section',
                '.checkout-page',
                '.payment-page',
                '.payment-waiting-page',
                '.order-detail-page',
                '.receipt-wrapper',
                '.quick-categories-section',
                '.about-section',
                '.why-section',
                '.products-section',
                '.gallery-section',
                '.testimonials-section'
            ].join(', ');

            const candidates = Array.from(document.querySelectorAll(selector)).filter((el) => {
                if (el.hasAttribute('data-parallax') || el.hasAttribute('data-auto-parallax')) return false;
                if (el.classList.contains('np-fade-section')) return false;
                if (!el.offsetParent || el.offsetHeight < 56) return false;

                const style = window.getComputedStyle(el);
                if (style.position === 'fixed' || style.position === 'sticky') return false;
                if (el.closest('.navbar, .mobile-bottom-nav, [data-slide-track], .top-navbar, .sidebar')) return false;

                return true;
            });

            if (!candidates.length) return;

            candidates.forEach((el) => {
                const speed = el.matches('.page-hero, .hero-section, .checkout-page, .payment-page, .order-detail-page') ? 0.018 : (el.matches('footer') ? 0.01 : 0.014);
                el.dataset.autoParallax = '1';
                el.dataset.autoParallaxSpeed = String(speed);
            });

            let ticking = false;

            const updateParallax = () => {
                const viewportH = window.innerHeight || document.documentElement.clientHeight;

                candidates.forEach((el) => {
                    const speed = Number.parseFloat(el.dataset.autoParallaxSpeed || '0.014') || 0.014;
                    const rect = el.getBoundingClientRect();
                    const centerY = rect.top + (rect.height / 2);
                    const offsetFromCenter = centerY - (viewportH / 2);
                    const rawShift = -offsetFromCenter * speed;
                    const maxShift = 14;
                    const shift = Math.max(-maxShift, Math.min(maxShift, rawShift));
                    el.style.setProperty('--np-parallax-shift', `${shift.toFixed(2)}px`);
                });

                ticking = false;
            };

            const requestTick = () => {
                if (!ticking) {
                    window.requestAnimationFrame(updateParallax);
                    ticking = true;
                }
            };

            window.addEventListener('scroll', requestTick, { passive: true });
            window.addEventListener('resize', requestTick);
            requestTick();
        })();
    </script>
    
    {{-- Notification Sound Component for Customer --}}
    @auth
        <x-notification-sound role="customer" />
    @endauth
    
    @stack('scripts')
</body>
</html>
