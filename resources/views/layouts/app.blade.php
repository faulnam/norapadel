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
        }
        
        .footer-link {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: var(--transition);
            display: block;
            padding: 0.25rem 0;
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
            .navbar-collapse {
                background: var(--white);
                padding: 1rem;
                border-radius: var(--radius);
                margin-top: 1rem;
                box-shadow: var(--shadow);
            }
            
            .navbar-nav {
                gap: 0;
            }
            
            .nav-link {
                padding: 0.75rem 1rem !important;
                border-radius: 6px;
            }
            
            .nav-link:hover {
                background: var(--off-white);
            }
            
            .nav-link.active {
                background: var(--primary-light);
            }
            
            .nav-link.active::after {
                display: none;
            }
            
            .btn-nav-login {
                display: block;
                text-align: center;
                margin-top: 0.5rem;
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
                <ul class="navbar-nav ms-auto align-items-center">
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
                        @if(auth()->user()->isCustomer())
                            <li class="nav-item ms-lg-2">
                                <a class="nav-link position-relative" href="{{ route('customer.cart.index') }}">
                                    <i class="fas fa-shopping-cart fa-lg"></i>
                                    @php
                                        $cartCount = auth()->user()->cartItems()->sum('quantity');
                                    @endphp
                                    @if($cartCount > 0)
                                        <span class="cart-badge">{{ $cartCount }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif
                        
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>{{ Str::limit(auth()->user()->name, 10) }}
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
                <div class="col-lg-4">
                    <h5>
                        <img src="{{ asset('images/logo.png') }}" alt="{{ config('branding.name', 'PATAH') }}" height="30" class="me-2">
                        {{ config('branding.name', 'PATAH') }}
                    </h5>
                    <p class="text-white-50 mb-3">Kerupuk sehat dari pakcoy & tahu. Renyah, gurih, tanpa pengawet ✨</p>
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="text-white-50 mb-3">Menu</h6>
                    <a href="{{ route('home') }}" class="footer-link">Beranda</a>
                    <a href="{{ route('tentang') }}" class="footer-link">Tentang</a>
                    <a href="{{ route('produk.index') }}" class="footer-link">Produk</a>
                    <a href="{{ route('galeri') }}" class="footer-link">Galeri</a>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="text-white-50 mb-3">Lainnya</h6>
                    <a href="{{ route('testimoni') }}" class="footer-link">Testimoni</a>
                    <a href="{{ route('login') }}" class="footer-link">Masuk</a>
                    <a href="{{ route('register') }}" class="footer-link">Daftar</a>
                </div>
                <div class="col-lg-4">
                    <h6 class="text-white-50 mb-3">Kontak</h6>
                    <p class="text-white-50 mb-2"><i class="fas fa-phone me-2"></i>+62 812 3456 7890</p>
                    <p class="text-white-50 mb-2"><i class="fas fa-envelope me-2"></i>hello@patah.id</p>
                    <p class="text-white-50"><i class="fas fa-map-marker-alt me-2"></i>Surabaya, Jawa Timur</p>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.1); margin: 2rem 0 1rem;">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <small class="text-white-50">&copy; {{ date('Y') }} PATAH. Made with 💚 in Surabaya</small>
                <small class="text-white-50 mt-2 mt-md-0">Kerupuk Pakcoy & Tahu</small>
            </div>
        </div>
    </footer>

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
    
    @stack('scripts')
</body>
</html>
