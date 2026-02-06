<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PATAH - Kerupuk Pakcoy & Tahu')</title>
    
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
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('branding.name', 'PATAH') }}" height="40" class="brand-logo">
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
                                        <i class="fas fa-shopping-bag me-2 text-primary"></i>Pesanan Saya
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
                                    <i class="fas fa-shopping-bag me-2 text-primary"></i>Pesanan
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

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-12">
                    <h5>
                        <img src="{{ asset('images/logo.png') }}" alt="{{ config('branding.name', 'PATAH') }}" height="30" class="me-2">
                        {{ config('branding.name', 'PATAH') }}
                    </h5>
                    <p class="text-white-50 mb-3">Kerupuk sehat dari pakcoy & tahu. Renyah, gurih, tanpa pengawet ✨</p>
                    <div class="footer-social">
                        <a href="https://www.instagram.com/kriptasticpatah?igsh=MWNtODJibzczbWVwbQ=="><i class="fab fa-instagram"></i></a>
                        <a href="https://www.tiktok.com/@kerupukpatah?_r=1&_t=ZS-92QzZHimGYi"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <!-- Menu & Lainnya - hidden di mobile -->
                <div class="col-6 col-lg-2 d-none d-md-block">
                    <h6 class="text-white-50 mb-3">Menu</h6>
                    <a href="{{ route('home') }}" class="footer-link">Beranda</a>
                    <a href="{{ route('tentang') }}" class="footer-link">Tentang</a>
                    <a href="{{ route('produk.index') }}" class="footer-link">Produk</a>
                    <a href="{{ route('galeri') }}" class="footer-link">Galeri</a>
                </div>
                <div class="col-6 col-lg-2 d-none d-md-block">
                    <h6 class="text-white-50 mb-3">Lainnya</h6>
                    <a href="{{ route('testimoni') }}" class="footer-link">Testimoni</a>
                    <a href="{{ route('login') }}" class="footer-link">Masuk</a>
                    <a href="{{ route('register') }}" class="footer-link">Daftar</a>
                </div>
                <div class="col-lg-4 col-12">
                    <h6 class="text-white-50 mb-3">Kontak</h6>
                    <p class="text-white-50 mb-2"><i class="fas fa-phone me-2"></i>+62 858 0620 5829</p>
                    <p class="text-white-50"><i class="fas fa-map-marker-alt me-2"></i>Mojokerto, Jawa Timur</p>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.1); margin: 2rem 0 1rem;">
        </div>
    </footer>

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
                        <i class="fas fa-receipt"></i>
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

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
    
    {{-- Notification Sound Component for Customer --}}
    @auth
        <x-notification-sound role="customer" />
    @endauth
    
    @stack('scripts')
</body>
</html>
