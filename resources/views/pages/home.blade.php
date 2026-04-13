@extends('layouts.app')

@section('title', 'Nora Padel - Performa Maksimal, Game Makin Total')

@section('content')
    <!-- Hero Banner Section - Full Width -->
    <section class="hero-banner">
        <div class="hero-banner-overlay"></div>
        <div class="container position-relative">
            <div class="row align-items-center min-vh-hero">
                <div class="col-lg-6 hero-content">
                    <div class="hero-badge-wrapper">
                        <span class="hero-badge-new">
                            <i class="fas fa-bolt me-2"></i>Gear Padel Original & Bergaransi
                        </span>
                    </div>

                    <h1 class="hero-title-new">
                        <span class="highlight">Nora Padel</span>
                    </h1>

                    <p class="hero-tagline">Performa Maksimal • Game Makin Total</p>

                    <!-- HERO IMAGE MOBILE ONLY -->
                    <div class="hero-image-mobile d-block d-lg-none text-center my-4">
                        <img src="https://images.unsplash.com/photo-1648341248072-e8f8d3dcef7b?w=900" alt="Nora Padel Gear" class="img-fluid">
                    </div>



                    <p class="hero-desc">
                        Temukan raket, bola, tas, sepatu, dan aksesori padel pilihan untuk latihan harian hingga turnamen.
                        Kualitas premium, harga kompetitif, siap kirim cepat ke seluruh Indonesia.
                    </p>

                    <div class="hero-cta">
                        @auth
                            <a href="{{ route('customer.products.index') }}" class="btn btn-hero-primary">
                                <i class="fas fa-shopping-bag me-2"></i>Belanja Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-hero-primary">
                                <i class="fas fa-shopping-bag me-2"></i>Belanja Sekarang
                            </a>
                        @endauth
                        <a href="{{ route('produk.index') }}" class="btn btn-hero-outline">
                            <i class="fas fa-play-circle me-2"></i>Lihat Produk
                        </a>
                    </div>

                    <!-- Stats Row -->
                    <div class="hero-stats-row">
                        <div class="stat-box">
                            <span class="stat-num">{{ $stats['total_customers'] }}+</span>
                            <span class="stat-text">Pelanggan</span>
                        </div>
                        <div class="stat-box">
                            <span class="stat-num">{{ $stats['total_reviews'] }}+</span>
                            <span class="stat-text">Review</span>
                        </div>
                        <div class="stat-box">
                            <span class="stat-num">{{ $stats['avg_rating'] }}</span>
                            <span class="stat-text">Rating ⭐</span>
                        </div>
                    </div>
                </div>

                <!-- ❌ DESKTOP TIDAK DIUBAH -->
                <div class="col-lg-6 hero-visual d-none d-lg-block">
                    <div class="hero-image-float">
                        <img src="https://images.unsplash.com/photo-1593766827228-8737b4534aa6?w=900" alt="Perlengkapan Nora Padel" class="main-product-img" id="heroImage">
                        <div class="deco-circle deco-1"></div>
                        <div class="deco-circle deco-2"></div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Wave separator -->
        <div class="hero-wave">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z"
                    fill="#fafafa" />
            </svg>
        </div>
    </section>



    <!-- About Section - Clean & Minimal -->
    <section class="about-section" id="about-brief">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="about-visual">
                        <div class="about-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1599058917212-d750089bc07e?w=900" alt="Nora Padel Team" class="about-main-img">
                            <div class="about-pattern"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="about-content">
                        <span class="section-label">Tentang Kami</span>
                        <h2 class="section-heading">
                            Cerita di Balik <span class="text-accent">Nora Padel</span>
                        </h2>
                        <p class="about-text">
                            Nora Padel hadir untuk menjawab kebutuhan pemain padel Indonesia akan perlengkapan yang
                            andal, modern, dan nyaman digunakan.
                            Kami memilih produk dengan standar kualitas tinggi agar pemula hingga profesional bisa bermain
                            lebih percaya diri di setiap pertandingan.
                        </p>

                        <div class="feature-grid">
                            <div class="feature-item">
                                <div class="feature-icon-box">
                                    <i class="fas fa-seedling"></i>
                                </div>
                                <div class="feature-text">
                                    <h6>Produk Terkurasi</h6>
                                    <p>Raket, bola, sepatu & aksesori terbaik</p>
                                </div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon-box">
                                    <i class="fas fa-hand-holding-heart"></i>
                                </div>
                                <div class="feature-text">
                                    <h6>Layanan Profesional</h6>
                                    <p>Rekomendasi gear sesuai level permainan</p>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('tentang') }}" class="btn btn-dark-outline">
                            Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us - Minimal Grid -->
    <section class="why-section" id="why-us">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-label">Keunggulan</span>
                <h2 class="section-heading">Mengapa Memilih Nora Padel?</h2>
                <p class="section-subtext">Alasan pemain padel memilih perlengkapan dari Nora Padel</p>
            </div>

            <div class="why-grid">
                <div class="why-item">
                    <div class="why-icon-wrap">
                        <img src="https://images.unsplash.com/photo-1599058917212-d750089bc07e?w=320" alt="Performa Stabil">
                    </div>
                    <h5>Performa Stabil</h5>
                    <p>Gear dengan material berkualitas membantu kontrol dan power tetap konsisten sepanjang game.</p>
                </div>
                <div class="why-item">
                    <div class="why-icon-wrap">
                        <img src="https://images.unsplash.com/photo-1517649763962-0c623066013b?w=320" alt="Untuk Semua Level">
                    </div>
                    <h5>Untuk Semua Level</h5>
                    <p>Mulai dari beginner sampai tournament player, ada pilihan produk yang tepat untuk kebutuhanmu.</p>
                </div>
                <div class="why-item">
                    <div class="why-icon-wrap">
                        <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=320" alt="Koleksi Lengkap">
                    </div>
                    <h5>Koleksi Lengkap</h5>
                    <p>Raket padel, bola, tas, sepatu, hingga grip tersedia dalam satu tempat belanja praktis.</p>
                </div>
                <div class="why-item">
                    <div class="why-icon-wrap">
                        <img src="https://images.unsplash.com/photo-1547347298-4074fc3086f0?w=320" alt="Pengiriman Cepat">
                    </div>
                    <h5>Pengiriman Cepat</h5>
                    <p>Pesanan diproses cepat dengan packing aman agar gear sampai dalam kondisi prima.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products - Clean Layout -->
    <section class="products-section" id="products">
        <div class="container">
            <div class="section-header-flex">
                <div>
                    <span class="section-label">Produk</span>
                    <h2 class="section-heading mb-0">Produk Unggulan</h2>
                </div>
                <a href="{{ route('produk.index') }}" class="btn-link-arrow d-none d-md-flex">
                    Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>

            <div class="products-grid">
                @forelse($products->take(4) as $product)
                    <div class="product-item">
                        <div class="product-img-wrap">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=400' }}"
                                alt="{{ $product->name }}">
                            <div class="product-badge-wrap">
                                <span
                                    class="product-badge {{ $product->category == 'original' ? 'badge-green' : 'badge-orange' }}">
                                    {{ $product->category_label }}
                                </span>
                                @if ($product->hasActiveDiscount())
                                    <span
                                        class="product-badge badge-red">-{{ $product->formatted_discount_percent }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="product-info">
                            <div class="product-meta">
                                <h5 class="product-name">{{ $product->name }}</h5>
                                <span
                                    class="product-weight-tag d-none d-sm-inline">{{ $product->formatted_weight }}</span>
                            </div>
                            <p class="product-desc-text d-none d-md-block">{{ Str::limit($product->description, 60) }}</p>
                            <div class="product-footer">
                                <div class="product-pricing">
                                    @if ($product->hasActiveDiscount())
                                        <span class="price-current">{{ $product->formatted_discounted_price }}</span>
                                        <small class="price-old">{{ $product->formatted_price }}</small>
                                    @else
                                        <span class="price-current">{{ $product->formatted_price }}</span>
                                    @endif
                                </div>
                                @auth
                                    <a href="{{ route('customer.products.show', $product) }}" class="btn-product">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span class="d-none d-sm-inline ms-1">Beli</span>
                                    </a>
                                @else
                                    <a href="{{ route('produk.show', $product) }}" class="btn-product btn-product-outline">
                                        <i class="fas fa-eye"></i>
                                        <span class="d-none d-sm-inline ms-1">Detail</span>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Produk segera hadir!</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-4 d-md-none">
                <a href="{{ route('produk.index') }}" class="btn btn-outline-dark">
                    Lihat Semua Produk <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Gallery Section - Masonry Style -->
    @if ($galleries->count() > 0)
        <section class="gallery-section" id="gallery">
            <div class="container">
                <div class="section-header-flex">
                    <div>
                        <span class="section-label">Galeri</span>
                        <h2 class="section-heading mb-0">Momen Kami</h2>
                    </div>
                    <a href="{{ route('galeri') }}" class="btn-link-arrow d-none d-md-flex">
                        Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>

                <div class="gallery-grid">
                    @foreach ($galleries->take(6) as $index => $gallery)
                        <div class="gallery-card {{ $index == 0 ? 'gallery-card-large' : '' }}">
                            @if ($gallery->isImage())
                                <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}">
                                <div class="gallery-card-overlay">
                                    <span class="gallery-card-title">{{ $gallery->title }}</span>
                                </div>
                            @else
                                <div class="gallery-video-wrap">
                                    {!! $gallery->embed_url !!}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4 d-md-none">
                    <a href="{{ route('galeri') }}" class="btn btn-outline-dark">
                        Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Testimonials Section - Clean Cards -->
    <section class="testimonials-section" id="testimonials">
        <div class="container">
            <div class="section-header-flex">
                <div>
                    <span class="section-label">Testimoni</span>
                    <h2 class="section-heading mb-0">Apa Kata Mereka?</h2>
                </div>
                <a href="{{ route('testimoni') }}" class="btn-link-arrow d-none d-md-flex">
                    Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>

            <div class="testimonials-slider">
                @forelse($testimonials as $testimonial)
                    <div class="testimonial-item">
                        <div class="testimonial-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $testimonial->rating ? 'active' : '' }}"></i>
                            @endfor
                        </div>
                        <p class="testimonial-text">"{{ Str::limit($testimonial->content, 120) }}"</p>
                        <div class="testimonial-author-info">
                            <img src="{{ $testimonial->user->avatar_url }}" alt="{{ $testimonial->user->name }}"
                                class="testimonial-avatar">
                            <div>
                                <h6 class="testimonial-name">{{ $testimonial->user->name }}</h6>
                                <span class="testimonial-date">{{ $testimonial->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 w-100">
                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada testimoni.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-4 d-md-none">
                <a href="{{ route('testimoni') }}" class="btn btn-outline-dark">
                    Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    
@endsection

@push('styles')
    <style>
        /* ========================================
           HERO BANNER - PROFESSIONAL & MINIMALIST
        ======================================== */
        .hero-banner {
            position: relative;
            background: linear-gradient(135deg, #f8fffe 0%, #e8f5e9 50%, #f1f8e9 100%);
            overflow: hidden;
            padding-top: 2rem;
        }

        .hero-banner-overlay {
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2316a34a' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .min-vh-hero {
            min-height: calc(100vh - 200px);
            padding: 3rem 0;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-badge-wrapper {
            margin-bottom: 1.5rem;
        }

        .hero-badge-new {
            display: inline-flex;
            align-items: center;
            background: rgba(22, 163, 74, 0.1);
            color: var(--primary);
            padding: 0.625rem 1.25rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            border: 1px solid rgba(22, 163, 74, 0.2);
        }

        .hero-title-new {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            line-height: 1.1;
            color: var(--dark);
            margin-bottom: 0.5rem;
            letter-spacing: -1px;
        }

        .hero-title-new .highlight {
            background: linear-gradient(135deg, var(--primary), #22c55e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-tagline {
            font-size: 1.25rem;
            color: var(--gray);
            font-weight: 500;
            margin-bottom: 1.5rem;
            letter-spacing: 2px;
        }

        .hero-desc {
            font-size: 1.125rem;
            color: #4b5563;
            max-width: 520px;
            margin-bottom: 2rem;
            line-height: 1.7;
        }

        .hero-cta {
            display: flex;
            gap: 1rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .btn-hero-primary {
            background: linear-gradient(135deg, var(--primary), #15803d);
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(22, 163, 74, 0.3);
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(22, 163, 74, 0.4);
            color: white;
        }

        .btn-hero-outline {
            background: transparent;
            color: var(--dark);
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            border: 2px solid #e5e7eb;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .btn-hero-outline:hover {
            border-color: var(--dark);
            background: var(--dark);
            color: white;
        }

        /* Hero Stats */
        .hero-stats-row {
            display: flex;
            gap: 2.5rem;
        }

        .stat-box {
            text-align: left;
        }

        .stat-num {
            display: block;
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark);
            line-height: 1.2;
        }

        .stat-text {
            font-size: 0.875rem;
            color: var(--gray);
            font-weight: 500;
        }

        /* Hero Visual */
        .hero-visual {
            position: relative;
            z-index: 1;
        }

        .hero-image-float {
            position: relative;
            padding: 2rem;
        }

        .main-product-img {
            width: 100%;
            max-width: 480px;
            border-radius: 24px;
            animation: gentleFloat 6s ease-in-out infinite;
            position: relative;
            z-index: 2;
        }

        .float-badge {
            position: absolute;
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 50%;
            padding: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            z-index: 3;
            animation: floatBadge 4s ease-in-out infinite;
        }

        .float-badge img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .float-badge-1 {
            top: 5%;
            left: 0;
            animation-delay: 0s;
        }

        .float-badge-2 {
            bottom: 20%;
            left: -5%;
            animation-delay: 1s;
        }

        .float-badge-3 {
            top: 20%;
            right: 0;
            animation-delay: 2s;
        }

        .deco-circle {
            position: absolute;
            border-radius: 50%;
            z-index: 1;
        }

        .deco-1 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, rgba(22, 163, 74, 0.1), transparent);
            top: -50px;
            right: -50px;
        }

        .deco-2 {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.1), transparent);
            bottom: 0;
            left: 0;
        }

        @keyframes gentleFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        @keyframes floatBadge {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-8px) scale(1.05);
            }
        }

        /* Hero Wave */
        .hero-wave {
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            line-height: 0;
        }

        .hero-wave svg {
            width: 100%;
            height: 80px;
        }

        /* Mobile Hero */
        .hero-mobile {
            background: linear-gradient(135deg, #f8fffe 0%, #e8f5e9 100%);
            padding: 2rem 0;
            text-align: center;
        }

        .hero-mobile-image img {
            max-width: 280px;
            width: 100%;
            border-radius: 20px;
        }

        /* ========================================
           SECTION COMMON STYLES
        ======================================== */
        .section-label {
            display: inline-block;
            background: linear-gradient(135deg, rgba(22, 163, 74, 0.1), rgba(22, 163, 74, 0.05));
            color: var(--primary);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
            border: 1px solid rgba(22, 163, 74, 0.1);
        }

        .section-heading {
            font-size: clamp(1.75rem, 3vw, 2.5rem);
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -0.5px;
            margin-bottom: 0.75rem;
        }

        .section-subtext {
            color: var(--gray);
            font-size: 1.0625rem;
            max-width: 500px;
            margin: 0 auto;
        }

        .section-header {
            margin-bottom: 3rem;
        }

        .section-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 2rem;
        }

        .btn-link-arrow {
            color: var(--dark);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            padding: 0.5rem 0;
            border-bottom: 2px solid transparent;
        }

        .btn-link-arrow:hover {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        .text-accent {
            color: var(--primary);
        }

        /* ========================================
           ABOUT SECTION
        ======================================== */
        .about-section {
            padding: 6rem 0;
            background: var(--off-white);
        }

        .about-visual {
            position: relative;
        }

        .about-img-wrapper {
            position: relative;
        }

        .about-main-img {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        }

        .about-pattern {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 20px;
            left: 20px;
            border: 2px solid var(--primary);
            border-radius: 20px;
            z-index: -1;
            opacity: 0.3;
        }

        .about-content {
            padding-left: 2rem;
        }

        .about-text {
            color: #4b5563;
            font-size: 1.0625rem;
            line-height: 1.8;
            margin-bottom: 2rem;
        }

        .feature-grid {
            display: grid;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem;
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 15px rgba(22, 163, 74, 0.1);
        }

        .feature-icon-box {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-light), #dcfce7);
            color: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .feature-text h6 {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .feature-text p {
            font-size: 0.875rem;
            color: var(--gray);
            margin: 0;
        }

        .btn-dark-outline {
            background: transparent;
            color: var(--dark);
            padding: 0.875rem 1.75rem;
            border-radius: 10px;
            font-weight: 600;
            border: 2px solid var(--dark);
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .btn-dark-outline:hover {
            background: var(--dark);
            color: white;
        }

        /* ========================================
           WHY SECTION
        ======================================== */
        .why-section {
            padding: 6rem 0;
            background: white;
        }

        .why-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .why-item {
            text-align: center;
            padding: 2rem 1.5rem;
            background: #fafafa;
            border-radius: 16px;
            transition: all 0.4s ease;
            border: 1px solid transparent;
        }

        .why-item:hover {
            background: white;
            border-color: var(--primary);
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(22, 163, 74, 0.1);
        }

        .why-icon-wrap {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #fff, #f0fdf4);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .why-item:hover .why-icon-wrap {
            transform: scale(1.1) rotate(5deg);
        }

        .why-icon-wrap img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        .why-item h5 {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.75rem;
            font-size: 1.125rem;
        }

        .why-item p {
            color: var(--gray);
            font-size: 0.9375rem;
            line-height: 1.6;
            margin: 0;
        }

        /* ========================================
           PRODUCTS SECTION
        ======================================== */
        .products-section {
            padding: 6rem 0;
            background: #fafafa;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .product-item {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            transition: all 0.4s ease;
        }

        .product-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            border-color: transparent;
        }

        .product-img-wrap {
            position: relative;
            /* Rasio 4:5 seperti Instagram */
            aspect-ratio: 4 / 5;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            overflow: hidden;
        }

        .product-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .product-item:hover .product-img-wrap img {
            transform: scale(1.08);
        }

        .product-badge-wrap {
            position: absolute;
            top: 1rem;
            left: 1rem;
            display: flex;
            gap: 0.5rem;
        }

        .product-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 50px;
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-green {
            background: rgba(22, 163, 74, 0.1);
            color: var(--primary);
        }

        .badge-orange {
            background: rgba(249, 115, 22, 0.1);
            color: var(--accent);
        }

        .badge-red {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .product-info {
            padding: 1.25rem;
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.5rem;
        }

        .product-name {
            font-weight: 700;
            color: var(--dark);
            font-size: 1rem;
            margin: 0;
            line-height: 1.4;
        }

        .product-weight-tag {
            background: #f3f4f6;
            padding: 0.25rem 0.625rem;
            border-radius: 50px;
            font-size: 0.6875rem;
            font-weight: 600;
            color: var(--gray);
            white-space: nowrap;
        }

        .product-desc-text {
            color: var(--gray);
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-pricing {
            display: flex;
            flex-direction: column;
        }

        .price-current {
            font-size: 1.125rem;
            font-weight: 800;
            color: var(--primary);
        }

        .price-old {
            font-size: 0.8125rem;
            color: #9ca3af;
            text-decoration: line-through;
        }

        .btn-product {
            background: var(--primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-product:hover {
            background: var(--primary-dark);
            color: white;
            transform: scale(1.05);
        }

        .btn-product-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-product-outline:hover {
            background: var(--primary);
            color: white;
        }

        /* ========================================
           GALLERY SECTION
        ======================================== */
        .gallery-section {
            padding: 6rem 0;
            background: white;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(2, 200px);
            gap: 1rem;
        }

        .gallery-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            cursor: pointer;
        }

        .gallery-card-large {
            grid-row: span 2;
        }

        .gallery-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-card:hover img {
            transform: scale(1.1);
        }

        .gallery-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-card:hover .gallery-card-overlay {
            opacity: 1;
        }

        .gallery-card-title {
            color: white;
            font-weight: 600;
            font-size: 1rem;
        }

        .gallery-video-wrap {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1f2937, #374151);
        }

        .gallery-video-wrap iframe {
            width: 100%;
            height: 100%;
        }

        /* ========================================
           TESTIMONIALS SECTION
        ======================================== */
        .testimonials-section {
            padding: 6rem 0;
            background: #fafafa;
        }

        .testimonials-slider {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            padding-bottom: 1rem;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }

        .testimonials-slider::-webkit-scrollbar {
            height: 4px;
        }

        .testimonials-slider::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }

        .testimonial-item {
            flex: 0 0 340px;
            background: white;
            padding: 1.75rem;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            scroll-snap-align: start;
            transition: all 0.3s ease;
        }

        .testimonial-item:hover {
            border-color: var(--primary);
            box-shadow: 0 10px 30px rgba(22, 163, 74, 0.1);
        }

        .testimonial-stars {
            margin-bottom: 1rem;
        }

        .testimonial-stars i {
            color: #e5e7eb;
            font-size: 0.875rem;
            margin-right: 2px;
        }

        .testimonial-stars i.active {
            color: #fbbf24;
        }

        .testimonial-text {
            color: #4b5563;
            font-size: 0.9375rem;
            line-height: 1.7;
            font-style: italic;
            margin-bottom: 1.5rem;
        }

        .testimonial-author-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .testimonial-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-light);
        }

        .testimonial-name {
            font-weight: 700;
            color: var(--dark);
            font-size: 0.9375rem;
            margin: 0;
        }

        .testimonial-date {
            font-size: 0.8125rem;
            color: var(--gray);
        }

        /* ========================================
           CTA BANNER
        ======================================== */
        .cta-banner {
            padding: 2rem 0;
            background: var(--off-white);
        }

        .cta-inner {
            background: linear-gradient(135deg, var(--primary), #15803d);
            border-radius: 24px;
            padding: 3rem 4rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .cta-content h3 {
            color: white;
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .cta-content p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            margin: 0;
        }

        .btn-cta {
            background: white;
            color: var(--primary);
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-cta:hover {
            background: var(--dark);
            color: white;
            transform: translateY(-3px);
        }

        /* ========================================
           RESPONSIVE STYLES
        ======================================== */
        @media (max-width: 1199.98px) {
            .why-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                grid-template-rows: repeat(3, 180px);
            }

            .gallery-card-large {
                grid-row: span 1;
            }
        }

        @media (max-width: 991.98px) {
            .hero-banner {
                padding-top: 1rem;
            }

            .min-vh-hero {
                min-height: auto;
                padding: 2rem 0;
            }

            .hero-content {
                text-align: center;
            }

            .hero-desc {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-cta {
                justify-content: center;
            }

            .hero-stats-row {
                justify-content: center;
            }

            .hero-wave svg {
                height: 50px;
            }

            .about-section {
                padding: 4rem 0;
            }

            .about-content {
                padding-left: 0;
            }

            .why-section,
            .products-section,
            .gallery-section,
            .testimonials-section {
                padding: 4rem 0;
            }

            .cta-inner {
                padding: 2rem;
                flex-direction: column;
                text-align: center;
            }

            .cta-content h3 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 767.98px) {
            .hero-title-new {
                font-size: 2rem;
            }

            .hero-tagline {
                font-size: 1rem;
                letter-spacing: 1px;
            }

            .hero-desc {
                font-size: 1rem;
            }

            .hero-cta {
                flex-direction: column;
            }

            .btn-hero-primary,
            .btn-hero-outline {
                width: 100%;
                justify-content: center;
                padding: 0.875rem 1.5rem;
            }

            .hero-stats-row {
                flex-wrap: wrap;
                gap: 1.5rem;
                background: white;
                padding: 1.25rem;
                border-radius: 16px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            }

            .stat-box {
                flex: 1;
                min-width: 80px;
                text-align: center;
            }

            .stat-num {
                font-size: 1.5rem;
            }

            .stat-text {
                font-size: 0.75rem;
            }

            .section-heading {
                font-size: 1.5rem;
            }

            .section-header-flex {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .why-grid {
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }

            .why-item {
                padding: 1.25rem 1rem;
            }

            .why-icon-wrap {
                width: 60px;
                height: 60px;
                margin-bottom: 1rem;
            }

            .why-icon-wrap img {
                width: 45px;
                height: 45px;
            }

            .why-item h5 {
                font-size: 0.9375rem;
            }

            .why-item p {
                font-size: 0.8125rem;
            }

            .products-grid {
                grid-template-columns: 1fr 1fr;
                gap: 0.75rem;
            }

            .product-img-wrap {
                /* Rasio 4:5 tetap untuk mobile */
                aspect-ratio: 4 / 5;
            }

            .product-info {
                padding: 0.875rem;
            }

            .product-name {
                font-size: 0.875rem;
            }

            .price-current {
                font-size: 0.9375rem;
            }

            .btn-product {
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
            }

            .gallery-grid {
                grid-template-columns: 1fr 1fr;
                grid-template-rows: repeat(3, 150px);
                gap: 0.75rem;
            }

            .testimonial-item {
                flex: 0 0 280px;
                padding: 1.25rem;
            }

            .testimonial-text {
                font-size: 0.875rem;
            }

            .about-section,
            .why-section,
            .products-section,
            .gallery-section,
            .testimonials-section {
                padding: 3rem 0;
            }

            .feature-grid {
                gap: 0.75rem;
            }

            .feature-item {
                padding: 1rem;
            }

            .feature-icon-box {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .cta-inner {
                padding: 1.5rem;
                border-radius: 16px;
            }

            .cta-content h3 {
                font-size: 1.25rem;
            }

            .cta-content p {
                font-size: 0.875rem;
            }

            .btn-cta {
                width: 100%;
                justify-content: center;
                padding: 0.875rem 1.5rem;
            }
        }

        @media (max-width: 575.98px) {
            .hero-title-new {
                font-size: 1.75rem;
            }

            .hero-badge-new {
                font-size: 0.75rem;
                padding: 0.5rem 1rem;
            }

            .hero-mobile-image img {
                max-width: 220px;
            }

            .product-img-wrap {
                /* Rasio 4:5 tetap untuk small mobile */
                aspect-ratio: 4 / 5;
            }

            .product-info {
                padding: 0.75rem;
            }

            .product-name {
                font-size: 0.8125rem;
            }

            .product-badge {
                font-size: 0.5625rem;
                padding: 0.25rem 0.5rem;
            }

            .price-current {
                font-size: 0.875rem;
            }

            .btn-product {
                padding: 0.25rem 0.5rem;
                font-size: 0.6875rem;
            }

            .gallery-grid {
                grid-template-rows: repeat(3, 120px);
            }

            .testimonial-item {
                flex: 0 0 250px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Smooth parallax effect on hero image
        const heroImage = document.getElementById('heroImage');
        if (heroImage) {
            document.addEventListener('mousemove', function(e) {
                if (window.innerWidth > 991) {
                    const x = (window.innerWidth / 2 - e.pageX) / 50;
                    const y = (window.innerHeight / 2 - e.pageY) / 50;
                    heroImage.style.transform = `translateY(calc(-15px + ${y}px)) translateX(${x}px)`;
                }
            });
        }

        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);

        // Observe elements
        document.querySelectorAll('.why-item, .product-item, .gallery-card, .testimonial-item').forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = `all 0.6s ease ${index * 0.1}s`;
            observer.observe(el);
        });

        // Add animation class
        document.head.insertAdjacentHTML('beforeend', `
        <style>
            .animate-in {
                opacity: 1 !important;
                transform: translateY(0) !important;
            }
        </style>
    `);
    </script>
@endpush
