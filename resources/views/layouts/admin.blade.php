<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - PATAH')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2E7D32;
            --secondary-color: #81C784;
            --sidebar-width: 260px;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
        }
        
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, #1B5E20 0%, #2E7D32 100%);
            color: white;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s;
        }
        
        .sidebar-brand {
            padding: 20px;
            font-size: 1.5rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-menu {
            padding: 15px 0;
        }
        
        .sidebar-menu .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        
        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
            border-left-color: #FFC107;
        }
        
        .sidebar-menu .nav-link i {
            width: 24px;
            margin-right: 10px;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
        }
        
        .top-navbar {
            background: white;
            padding: 15px 25px;
            margin: -20px -20px 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid #eee;
            font-weight: 600;
        }
        
        .stat-card {
            border-radius: 10px;
            padding: 20px;
            color: white;
        }
        
        .stat-card.bg-gradient-primary {
            background: linear-gradient(135deg, #2E7D32, #43A047);
        }
        
        .stat-card.bg-gradient-success {
            background: linear-gradient(135deg, #1976D2, #42A5F5);
        }
        
        .stat-card.bg-gradient-warning {
            background: linear-gradient(135deg, #F57C00, #FFB74D);
        }
        
        .stat-card.bg-gradient-info {
            background: linear-gradient(135deg, #7B1FA2, #BA68C8);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #1B5E20;
            border-color: #1B5E20;
        }
        
        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }
        
        .badge {
            font-weight: 500;
            padding: 5px 10px;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            .sidebar.show {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-leaf me-2"></i>PATAH Admin
        </div>
        
        <nav class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Produk
            </a>
            
            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> Pesanan
                @php
                    $pendingOrders = \App\Models\Order::where('payment_status', 'pending_verification')->count();
                @endphp
                @if($pendingOrders > 0)
                    <span class="badge bg-danger ms-auto">{{ $pendingOrders }}</span>
                @endif
            </a>
            
            <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                <i class="fas fa-comment"></i> Testimoni
                @php
                    $pendingTestimonials = \App\Models\Testimonial::where('is_approved', false)->count();
                @endphp
                @if($pendingTestimonials > 0)
                    <span class="badge bg-warning ms-auto">{{ $pendingTestimonials }}</span>
                @endif
            </a>
            
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Customer
            </a>
            
            <a href="{{ route('admin.history.index') }}" class="nav-link {{ request()->routeIs('admin.history.*') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Riwayat
            </a>
            
            <a href="{{ route('admin.galleries.index') }}" class="nav-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}">
                <i class="fas fa-images"></i> Galeri
            </a>
            
            <a href="{{ route('admin.notifications.index') }}" class="nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                <i class="fas fa-bell"></i> Notifikasi
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="badge bg-danger ms-auto">{{ auth()->user()->unreadNotifications->count() }}</span>
                @endif
            </a>
            
            <hr class="mx-3 my-3" style="border-color: rgba(255,255,255,0.2);">
            
            <a href="{{ route('home') }}" class="nav-link">
                <i class="fas fa-globe"></i> Lihat Website
            </a>
            
            <form action="{{ route('logout') }}" method="POST" class="px-0">
                @csrf
                <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div>
                <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center">
                <span class="text-muted me-3">
                    <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}
                </span>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @stack('scripts')
</body>
</html>
