<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kurir') - PATAH</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1565C0;
            --secondary-color: #42A5F5;
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
            background: linear-gradient(180deg, #0D47A1 0%, #1565C0 100%);
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
            position: relative;
            overflow: hidden;
        }
        
        .stat-card .icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 3rem;
            opacity: 0.3;
        }
        
        .stat-card.bg-info {
            background: linear-gradient(135deg, #0288D1, #03A9F4) !important;
        }
        
        .stat-card.bg-warning {
            background: linear-gradient(135deg, #F57C00, #FFB74D) !important;
        }
        
        .stat-card.bg-success {
            background: linear-gradient(135deg, #388E3C, #66BB6A) !important;
        }
        
        .stat-card.bg-primary {
            background: linear-gradient(135deg, #1565C0, #42A5F5) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #0D47A1;
            border-color: #0D47A1;
        }
        
        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }
        
        .badge {
            font-weight: 500;
            padding: 5px 10px;
        }
        
        .delivery-card {
            border-left: 4px solid var(--primary-color);
            transition: all 0.2s ease;
        }
        
        .delivery-card:hover {
            background-color: #f8f9fa;
        }
        
        .user-panel {
            padding: 15px 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: auto;
        }
        
        .user-panel img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
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
    <div class="sidebar d-flex flex-column">
        <div class="sidebar-brand">
            <i class="fas fa-motorcycle me-2"></i>PATAH Kurir
        </div>
        
        <nav class="sidebar-menu">
            <a href="{{ route('courier.dashboard') }}" class="nav-link {{ request()->routeIs('courier.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            
            <a href="{{ route('courier.deliveries.index') }}" class="nav-link {{ request()->routeIs('courier.deliveries.index') || request()->routeIs('courier.deliveries.show') ? 'active' : '' }}">
                <i class="fas fa-truck"></i> Tugas Pengiriman
                @php
                    $activeDeliveries = auth()->user()->activeDeliveries()->count();
                @endphp
                @if($activeDeliveries > 0)
                    <span class="badge bg-danger ms-auto">{{ $activeDeliveries }}</span>
                @endif
            </a>
            
            <a href="{{ route('courier.deliveries.history') }}" class="nav-link {{ request()->routeIs('courier.deliveries.history') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Riwayat Pengiriman
            </a>
            
            <a href="{{ route('courier.profile') }}" class="nav-link {{ request()->routeIs('courier.profile') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i> Profil Saya
            </a>
            
            <hr class="mx-3 my-3" style="border-color: rgba(255,255,255,0.2);">
            
            <form action="{{ route('logout') }}" method="POST" class="px-0">
                @csrf
                <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </nav>
        
        <!-- User Panel -->
        <div class="user-panel d-flex align-items-center mt-auto">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" alt="Profile">
            <div class="ms-3">
                <div class="text-white fw-semibold">{{ auth()->user()->name }}</div>
                <small class="text-white-50">Kurir</small>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div>
                <button class="btn btn-link d-md-none me-2 p-0" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="mb-0 d-inline">@yield('title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center">
                <!-- Notifications Dropdown -->
                <div class="dropdown me-3">
                    <a class="btn btn-link position-relative p-0" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-bell fs-5 text-muted"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" style="width: 320px; max-height: 400px; overflow-y: auto;">
                        <h6 class="dropdown-header">Notifikasi</h6>
                        @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                            <a class="dropdown-item py-2" href="{{ route('courier.deliveries.show', $notification->data['order_id'] ?? 0) }}">
                                <div class="d-flex align-items-start">
                                    <div class="bg-primary text-white rounded-circle p-2 me-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-truck fa-sm"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold small">{{ $notification->data['title'] ?? 'Notifikasi Baru' }}</div>
                                        <small class="text-muted">{{ Str::limit($notification->data['message'] ?? '', 50) }}</small>
                                        <div class="text-muted small mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="dropdown-item text-center text-muted py-3">
                                <i class="fas fa-bell-slash"></i> Tidak ada notifikasi baru
                            </div>
                        @endforelse
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('courier.notifications.markRead') }}" method="POST" class="px-3 py-2">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                                    Tandai Semua Dibaca
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                
                <span class="text-muted">
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
    
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });
    </script>
    
    @stack('scripts')
</body>
</html>
