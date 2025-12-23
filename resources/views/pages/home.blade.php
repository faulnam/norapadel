@extends('layouts.app')

@section('title', 'PATAH - Kerupuk Sehat Pakcoy & Tahu')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6 hero-text-col">
                <span class="hero-badge">100% Alami & Sehat</span>
                <h1 class="hero-title">
                    Kerupuk <span class="text-primary">PATAH</span>
                    <br>Renyah & Bergizi
                </h1>
                
                <!-- Hero Image - muncul di sini saat mobile -->
                <div class="hero-image-mobile d-lg-none">
                    <div class="hero-image-container">
                        <img src="images/beranda.png" 
                             alt="Kerupuk PATAH" class="hero-image">
                        <div class="floating-card floating-card-1">
                            <img src="images/ngemilsantairb.png" alt="Organik" class="floating-icon">
                        </div>
                        <div class="floating-card floating-card-2">
                            <img src="images/temankerjarb.png" alt="Sehat" class="floating-icon">
                        </div>
                        <div class="floating-card floating-card-3">
                            <img src="images/oleh2maskotrb.png" alt="Renyah" class="floating-icon">
                        </div>
                    </div>
                </div>
                
                <p class="hero-subtitle">
                    Nikmati sensasi kerupuk sehat dari pakcoy dan tahu. Tanpa pengawet, tanpa MSG, cocok untuk semua usia!
                </p>
                <div class="hero-buttons">
                    @auth
                        <a href="{{ route('customer.products.index') }}" class="btn btn-accent btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Belanja Sekarang
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-accent btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Belanja Sekarang
                        </a>
                    @endauth
                    <a href="{{ route('tentang') }}" class="btn btn-outline-dark btn-lg">
                        Pelajari Lebih
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $stats['total_customers'] }}+</span>
                        <span class="stat-label">Pelanggan Puas</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $stats['total_reviews'] }}+</span>
                        <span class="stat-label">Review</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $stats['avg_rating'] }}</span>
                        <span class="stat-label">Rating ⭐</span>
                    </div>
                </div>
            </div>
            <!-- Hero Image - hanya tampil di desktop -->
            <div class="col-lg-6 hero-image-col d-none d-lg-block">
                <div class="hero-image-wrapper">
                    <div class="hero-image-container">
                        <img src="images/beranda.png" 
                             alt="Kerupuk PATAH" class="hero-image" id="heroImage">
                        <div class="floating-card floating-card-1">
                            <img src="images/ngemilsantairb.png" alt="Organik" class="floating-icon">
                        </div>
                        <div class="floating-card floating-card-2">
                            <img src="images/temankerjarb.png" alt="Sehat" class="floating-icon">
                        </div>
                        <div class="floating-card floating-card-3">
                            <img src="images/oleh2maskotrb.png" alt="Renyah" class="floating-icon">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Brief Section -->
<section class="py-5" id="about-brief">
    <div class="container">
        <div class="row align-items-center g-5">
            <!-- Gambar hanya tampil di desktop -->
            <div class="col-lg-5 d-none d-lg-block">
                <div class="about-image-grid">
                    <img src="images/promo.png" alt="Proses Pembuatan" class="about-img-main">
                </div>
            </div>
            <div class="col-lg-7">
                <span class="section-badge">Tentang Kami</span>
                <h2 class="section-title">Cerita di Balik <span class="text-primary">PATAH</span></h2>
                <p class="text-gray mb-4">
                    PATAH lahir dari keinginan untuk menghadirkan camilan yang tidak hanya lezat, tetapi juga menyehatkan. 
                    Kami menggabungkan sayuran pakcoy yang kaya nutrisi dengan tahu berkualitas tinggi untuk menciptakan kerupuk yang unik.
                </p>
                <div class="about-features">
                    <div class="about-feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Bahan Pilihan</h6>
                            <small class="text-gray">Pakcoy segar & tahu premium</small>
                        </div>
                    </div>
                    <div class="about-feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Dibuat dengan Cinta</h6>
                            <small class="text-gray">Proses higienis & berkualitas</small>
                        </div>
                    </div>
                </div>
                <a href="{{ route('tentang') }}" class="btn btn-primary mt-3">
                    Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5 bg-gray-light" id="why-us">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Mengapa Memilih PATAH?</h2>
            <p class="section-subtitle">Alasan mengapa ribuan orang menyukai kerupuk kami</p>
        </div>
        
        <div class="row g-4">
            <div class="col-6 col-md-6 col-lg-3">
                <div class="why-card" data-aos="fade-up">
                    <div class="why-icon">
                        <img src="images/ngemilsantairb.png">
                    </div>
                    <h5>Ngemil Santai</h5>
                    <p class="text-gray small mb-0">Lagi rebahan, nonton drama, atau main game, Kerupuk Patah siap nemenin!</p>
                </div>
            </div>
            <div class="col-6 col-md-6 col-lg-3">
                <div class="why-card" data-aos="fade-up" data-aos-delay="100">
                     <div class="why-icon">
                        <img src="images/temankerjarb.png">
                    </div>
                    <h5>Teman Kerja</h5>
                    <p class="text-gray small mb-0">Butuh camilan biar kerja makin semangat? Cukup buka bungkus Kerupuk Patah.</p>
                </div>
            </div>
            <div class="col-6 col-md-6 col-lg-3">
                <div class="why-card" data-aos="fade-up" data-aos-delay="200">
                     <div class="why-icon">
                        <img src="images/oleh2maskotrb.png">
                    </div>
                    <h5>Oleh-Oleh Sidoarjo</h5>
                    <p class="text-gray small mb-0">Mau bawa pulang sesuatu yang beda buat keluarga atau teman? Kerupuk Patah aja!</p>
                </div>
            </div>
            <div class="col-6 col-md-6 col-lg-3">
                <div class="why-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="why-icon">
                        <img src="images/maskot2.png">
                    </div>
                    <h5>Pengiriman Cepat</h5>
                    <p class="text-gray small mb-0">Sampai di rumah dengan kondisi fresh</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-5" id="products">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="section-badge">Produk</span>
                <h2 class="section-title mb-0">Produk Unggulan</h2>
            </div>
            <a href="{{ route('produk.index') }}" class="btn btn-outline-primary d-none d-md-inline-flex">
                Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
        
        <div class="row g-3 g-md-4">
            @forelse($products->take(4) as $product)
                <div class="col-6 col-md-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=400' }}" 
                                 alt="{{ $product->name }}">
                            <div class="product-badges">
                                <span class="badge badge-{{ $product->category == 'original' ? 'primary' : 'accent' }}">
                                    {{ $product->category_label }}
                                </span>
                                @if($product->hasActiveDiscount())
                                    <span class="badge bg-danger ms-1">-{{ $product->formatted_discount_percent }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="product-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="product-title mb-0">{{ $product->name }}</h5>
                                <span class="product-weight d-none d-sm-inline">{{ $product->formatted_weight }}</span>
                            </div>
                            <p class="product-desc text-gray small d-none d-md-block">{{ Str::limit($product->description, 60) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @if($product->hasActiveDiscount())
                                        <span class="product-price">{{ $product->formatted_discounted_price }}</span>
                                        <small class="text-decoration-line-through text-muted d-block d-sm-inline">{{ $product->formatted_price }}</small>
                                    @else
                                        <span class="product-price">{{ $product->formatted_price }}</span>
                                    @endif
                                </div>
                                @auth
                                    <a href="{{ route('customer.products.show', $product) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-shopping-cart me-1 d-none d-sm-inline"></i>Beli
                                    </a>
                                @else
                                    <a href="{{ route('produk.show', $product) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1 d-none d-sm-inline"></i>Detail
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-box-open fa-3x text-gray mb-3"></i>
                    <p class="text-gray">Produk segera hadir!</p>
                </div>
            @endforelse
        </div>
        
        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('produk.index') }}" class="btn btn-outline-primary">
                Lihat Semua Produk <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Gallery Section -->
@if($galleries->count() > 0)
<section class="py-5 bg-gray-light" id="gallery">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="section-badge">Galeri</span>
                <h2 class="section-title mb-0">Momen Kami</h2>
            </div>
            <a href="{{ route('galeri') }}" class="btn btn-outline-primary d-none d-md-inline-flex">
                Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
        
        <div class="gallery-scroll">
            @foreach($galleries->take(6) as $gallery)
                <div class="gallery-item">
                    @if($gallery->isImage())
                        <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}">
                        <div class="gallery-overlay">
                            <span>{{ $gallery->title }}</span>
                        </div>
                    @else
                        <div class="gallery-video">
                            {!! $gallery->embed_url !!}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('galeri') }}" class="btn btn-outline-primary">
                Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Testimonials Section -->
<section class="py-5" id="testimonials">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="section-badge">Testimoni</span>
                <h2 class="section-title mb-0">Apa Kata Mereka?</h2>
            </div>
            <a href="{{ route('testimoni') }}" class="btn btn-outline-primary d-none d-md-inline-flex">
                Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
        
        <div class="testimonial-scroll">
            @forelse($testimonials as $testimonial)
                <div class="testimonial-card">
                    <div class="testimonial-rating mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-gray-light' }}"></i>
                        @endfor
                    </div>
                    <p class="testimonial-content">"{{ Str::limit($testimonial->content, 120) }}"</p>
                    <div class="testimonial-author">
                        <img src="{{ $testimonial->user->avatar_url }}" alt="{{ $testimonial->user->name }}" class="author-avatar-img">
                        <div>
                            <h6 class="mb-0">{{ $testimonial->user->name }}</h6>
                            <small class="text-gray">{{ $testimonial->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 w-100">
                    <i class="fas fa-comments fa-3x text-gray mb-3"></i>
                    <p class="text-gray">Belum ada testimoni.</p>
                </div>
            @endforelse
        </div>
        
        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('testimoni') }}" class="btn btn-outline-primary">
                Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>


@endsection

@push('styles')
<style>
    /* Hero Section */
    .hero-section {
        padding: 2rem 0;
        background: var(--white);
        overflow: hidden;
    }
    
    .min-vh-75 {
        min-height: auto;
    }
    
    .hero-badge {
        display: inline-block;
        background: var(--primary-light);
        color: var(--primary);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }
    
    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 1.5rem;
        color: var(--dark);
    }
    
    .hero-subtitle {
        font-size: 1.125rem;
        color: var(--gray);
        margin-bottom: 2rem;
        max-width: 500px;
    }
    
    .hero-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .hero-stats {
        display: flex;
        align-items: center;
        gap: 2rem;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-number {
        display: block;
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--dark);
    }
    
    .stat-label {
        font-size: 0.875rem;
        color: var(--gray);
    }
    
    .stat-divider {
        width: 1px;
        height: 40px;
        background: var(--gray-light);
    }
    
    .hero-image-wrapper {
        position: relative;
        padding: 1rem;
    }
    
    .hero-image-container {
        position: relative;
    }
    
    .hero-image {
        width: 100%;
        max-width: 450px;
        border-radius: 20px;
        animation: float 6s ease-in-out infinite;
    }
    
    /* Hero Image Mobile - tampil setelah judul */
    .hero-image-mobile {
        position: relative;
        padding: 1.5rem 0;
        text-align: center;
    }
    
    .hero-image-mobile .hero-image-container {
        display: inline-block;
        position: relative;
        padding: 2rem 3rem;
    }
    
    .hero-image-mobile .hero-image {
        max-width: 500px;
        margin: 0 auto;
    }
    
    .hero-image-mobile .floating-card {
        transform: scale(0.65);
    }
    
    .hero-image-mobile .floating-card-1 {
        top: 0%;
        left: -15%;
    }
    
    .hero-image-mobile .floating-card-2 {
        bottom: 0%;
        left: -10%;
    }
    
    .hero-image-mobile .floating-card-3 {
        top: 5%;
        right: -15%;
    }
    
    .floating-card {
        position: absolute;
        background: var(--white);
        padding: 0.5rem;
        border-radius: 50%;
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        animation: floatCard 4s ease-in-out infinite;
    }
    
    .floating-icon {
        width: 50px;
        height: 50px;
        object-fit: contain;
    }
    
    .floating-card-1 {
        top: 10%;
        left: -10%;
        animation-delay: 0s;
    }
    
    .floating-card-2 {
        bottom: 20%;
        left: -5%;
        animation-delay: 1s;
    }
    
    .floating-card-3 {
        top: 30%;
        right: -5%;
        animation-delay: 2s;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    
    @keyframes floatCard {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(2deg); }
    }
    
    /* Section Badge */
    .section-badge {
        display: inline-block;
        background: var(--primary-light);
        color: var(--primary);
        padding: 0.375rem 0.875rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
    }
    
    /* About Section */
    .about-image-grid {
        position: relative;
    }
    
    .about-img-main {
        width: 100%;
        border-radius: var(--radius);
    }
    
    .about-badge {
        position: absolute;
        bottom: -20px;
        right: -20px;
        background: var(--primary);
        color: white;
        padding: 1.25rem;
        border-radius: var(--radius);
        text-align: center;
    }
    
    .about-badge-number {
        display: block;
        font-size: 2rem;
        font-weight: 800;
    }
    
    .about-badge-text {
        font-size: 0.75rem;
        opacity: 0.9;
    }
    
    .about-features {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .about-feature-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--gray-light);
        border-radius: var(--radius-sm);
    }
    
    .feature-icon {
        width: 50px;
        height: 50px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    /* Why Cards */
    .why-card {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--radius);
        text-align: center;
        transition: var(--transition);
        height: 100%;
        cursor: pointer;
    }
    
    .why-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
    }
    
    .why-card:hover .why-icon {
        transform: scale(1.1) rotate(10deg);
    }
    
    .why-icon {
        width: 70px;
        height: 70px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 1rem;
        transition: var(--transition);
        overflow: hidden;
    }
    
    .why-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .why-icon-orange {
        background: var(--accent-light);
        color: var(--accent);
    }
    
    .why-icon-red {
        background: #fee2e2;
        color: #ef4444;
    }
    
    .why-icon-blue {
        background: #dbeafe;
        color: #3b82f6;
    }
    
    /* Product Card */
    .product-card {
        background: var(--white);
        border-radius: var(--radius);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--gray-light);
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
    }
    
    .product-image {
        position: relative;
        height: 200px;
        overflow: hidden;
        background: var(--gray-light);
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: var(--transition);
    }
    
    .product-card:hover .product-image img {
        transform: scale(1.05);
    }
    
    .product-badges {
        position: absolute;
        top: 1rem;
        left: 1rem;
    }
    
    .product-body {
        padding: 1.25rem;
    }
    
    .product-title {
        font-weight: 700;
        font-size: 1rem;
    }
    
    .product-weight {
        background: var(--gray-light);
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--gray);
    }
    
    .product-desc {
        margin-bottom: 1rem;
    }
    
    .product-price {
        font-size: 1.125rem;
        font-weight: 800;
        color: var(--primary);
    }
    
    /* Gallery Scroll */
    .gallery-scroll {
        display: flex;
        gap: 1.25rem;
        overflow-x: auto;
        padding-bottom: 1rem;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
    }
    
    .gallery-scroll::-webkit-scrollbar {
        height: 6px;
    }
    
    .gallery-item {
        flex: 0 0 280px;
        aspect-ratio: 1/1;
        border-radius: 12px;
        overflow: hidden;
        position: relative;
        scroll-snap-align: start;
        background: var(--gray-light);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .gallery-item:hover {
        box-shadow: 0 12px 32px rgba(0,0,0,0.2);
        transform: translateY(-6px) scale(1.02);
    }
    
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    
    .gallery-item:hover img {
        transform: scale(1.1);
    }
    
    .gallery-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.2) 50%, transparent 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        padding: 1.5rem;
        color: white;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .gallery-overlay span {
        font-weight: 600;
        font-size: 1rem;
        text-align: center;
    }
    
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
    
    .gallery-video {
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, #833ab4, #fd1d1d, #fcb045);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .gallery-video iframe {
        width: 100%;
        height: 100%;
    }
    
    /* Testimonial Scroll */
    .testimonial-scroll {
        display: flex;
        gap: 1.5rem;
        overflow-x: auto;
        padding-bottom: 1rem;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
    }
    
    .testimonial-scroll::-webkit-scrollbar {
        height: 6px;
    }
    
    .testimonial-card {
        flex: 0 0 350px;
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--radius);
        border: 1px solid var(--gray-light);
        scroll-snap-align: start;
        transition: var(--transition);
    }
    
    .testimonial-card:hover {
        box-shadow: var(--shadow);
    }
    
    .testimonial-content {
        color: var(--dark);
        font-style: italic;
        margin-bottom: 1.5rem;
    }
    
    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .author-avatar {
        width: 45px;
        height: 45px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }
    
    .author-avatar-img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary);
    }
    
    /* CTA Section */
    .cta-section {
        background: var(--primary);
        padding: 4rem 0;
    }
    
    .cta-content {
        text-align: center;
        color: white;
    }
    
    .cta-content h2 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .cta-content p {
        opacity: 0.9;
        margin-bottom: 1.5rem;
        font-size: 1.125rem;
    }
    
    /* Responsive */
    @media (max-width: 991.98px) {
        .hero-section {
            padding: 2rem 0 3rem;
        }
        
        .hero-title {
            font-size: 2.25rem;
            text-align: center;
        }
        
        .hero-badge {
            display: block;
            text-align: center;
        }
        
        .hero-subtitle {
            text-align: center;
            font-size: 1rem;
        }
        
        .hero-buttons {
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .hero-image-wrapper {
            margin-top: 2rem;
        }
        
        .hero-image-container {
            text-align: center;
        }
        
        .hero-image {
            max-width: 320px;
        }
        
        .floating-card {
            transform: scale(0.8);
        }
        
        .floating-card-1 {
            top: 5%;
            left: 5%;
        }
        
        .floating-card-2 {
            bottom: 15%;
            left: 0%;
        }
        
        .floating-card-3 {
            top: 25%;
            right: 0%;
        }
        
        .hero-stats {
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .stat-divider {
            display: none;
        }
        
        .section-title {
            font-size: 1.625rem;
        }
        
        .section-subtitle {
            font-size: 0.9rem;
        }
        
        /* About Section Mobile */
        .about-image-grid {
            margin-bottom: 2rem;
        }
        
        .about-img-main {
            max-height: 280px;
            object-fit: cover;
        }
        
        .about-badge {
            right: 10px;
            bottom: -15px;
            padding: 0.875rem;
        }
        
        .about-badge-number {
            font-size: 1.5rem;
        }
        
        /* Why Cards - 2 per row on tablet */
        .why-card {
            padding: 1.5rem;
        }
        
        .why-icon {
            width: 60px;
            height: 60px;
        }
        
        /* Product Cards */
        .product-image {
            height: 180px;
        }
        
        .product-body {
            padding: 1rem;
        }
        
        .product-title {
            font-size: 0.9375rem;
        }
        
        .product-price {
            font-size: 1rem;
        }
        
        /* Gallery */
        .gallery-item {
            flex: 0 0 240px;
        }
        
        /* Testimonial */
        .testimonial-card {
            flex: 0 0 300px;
            padding: 1.25rem;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 3rem 0;
        }
        
        .cta-content h2 {
            font-size: 1.625rem;
        }
        
        .cta-content p {
            font-size: 1rem;
        }
    }
    
    @media (max-width: 767.98px) {
        .hero-section {
            padding: 1.5rem 0 2rem;
        }
        
        .hero-title {
            font-size: 1.75rem;
            line-height: 1.3;
            text-align: center;
        }
        
        .hero-badge {
            display: block;
            text-align: center;
        }
        
        .hero-subtitle {
            font-size: 0.9375rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .hero-buttons {
            flex-direction: column;
            gap: 0.75rem;
            justify-content: center;
        }
        
        .hero-buttons .btn {
            width: 100%;
        }
        
        /* Hero image mobile styles */
        .hero-image-mobile {
            padding: 1rem 0;
        }
        
        .hero-image-mobile .hero-image-container {
            padding: 1.5rem 2.5rem;
        }
        
        .hero-image-mobile .hero-image {
            max-width: 250px;
        }
        
        .hero-image-mobile .floating-card {
            transform: scale(0.6);
        }
        
        .hero-image-mobile .floating-card-1 {
            top: -5%;
            left: -15%;
        }
        
        .hero-image-mobile .floating-card-2 {
            bottom: -5%;
            left: -10%;
        }
        
        .hero-image-mobile .floating-card-3 {
            top: 0%;
            right: -15%;
        }
        
        .hero-stats {
            background: var(--white);
            padding: 1rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            justify-content: center;
        }
        
        .stat-item {
            flex: 1;
            text-align: center;
        }
        
        .stat-number {
            font-size: 1.25rem;
        }
        
        .stat-label {
            font-size: 0.6875rem;
        }
        
        /* Section styles */
        .section-title {
            font-size: 1.375rem;
        }
        
        .section-badge {
            font-size: 0.6875rem;
            padding: 0.25rem 0.625rem;
        }
        
        /* About Section - tanpa gambar di mobile */
        .about-feature-item {
            padding: 0.875rem;
        }
        
        .feature-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
        
        .about-feature-item h6 {
            font-size: 0.875rem;
        }
        
        .about-feature-item small {
            font-size: 0.75rem;
        }
        
        /* Why Cards - full width on mobile */
        .why-card {
            padding: 1.25rem;
        }
        
        .why-icon {
            width: 55px;
            height: 55px;
        }
        
        .why-card h5 {
            font-size: 1rem;
        }
        
        .why-card p {
            font-size: 0.8125rem;
        }
        
        /* Product Cards - 2 per row on mobile */
        .product-image {
            height: 140px;
        }
        
        .product-body {
            padding: 0.875rem;
        }
        
        .product-title {
            font-size: 0.8125rem;
            line-height: 1.3;
        }
        
        .product-weight {
            font-size: 0.625rem;
            padding: 0.125rem 0.375rem;
        }
        
        .product-desc {
            font-size: 0.75rem;
            margin-bottom: 0.625rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .product-price {
            font-size: 0.875rem;
        }
        
        .product-card .btn-sm {
            font-size: 0.6875rem;
            padding: 0.375rem 0.625rem;
        }
        
        /* Gallery */
        .gallery-item {
            flex: 0 0 200px;
        }
        
        .gallery-overlay span {
            font-size: 0.85rem;
        }
        
        /* Testimonial */
        .testimonial-card {
            flex: 0 0 260px;
            padding: 1rem;
        }
        
        .testimonial-content {
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
        
        .author-avatar {
            width: 36px;
            height: 36px;
            font-size: 0.875rem;
        }
        
        .testimonial-author h6 {
            font-size: 0.875rem;
        }
        
        .testimonial-author small {
            font-size: 0.75rem;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 2rem 0;
        }
        
        .cta-content h2 {
            font-size: 1.375rem;
        }
        
        .cta-content p {
            font-size: 0.875rem;
        }
        
        .cta-section .btn {
            width: 100%;
        }
    }
    
    /* Extra small devices */
    @media (max-width: 575.98px) {
        .hero-title {
            font-size: 1.5rem;
        }
        
        /* Hero image mobile smaller */
        .hero-image-mobile .hero-image-container {
            padding: 1.5rem 2rem;
        }
        
        .hero-image-mobile .hero-image {
            max-width: 200px;
        }
        
        .hero-image-mobile .floating-card {
            transform: scale(0.55);
        }
        
        .hero-image-mobile .floating-card-1 {
            top: -5%;
            left: -20%;
        }
        
        .hero-image-mobile .floating-card-2 {
            bottom: -5%;
            left: -15%;
        }
        
        .hero-image-mobile .floating-card-3 {
            top: 0%;
            right: -20%;
        }
        
        .section-title {
            font-size: 1.25rem;
        }
        
        /* Make product cards 2 per row */
        #products .row {
            margin-left: -0.375rem;
            margin-right: -0.375rem;
        }
        
        #products .row > div {
            padding-left: 0.375rem;
            padding-right: 0.375rem;
        }
        
        .product-image {
            height: 120px;
        }
        
        .product-body {
            padding: 0.625rem;
        }
        
        .product-title {
            font-size: 0.75rem;
        }
        
        .product-price {
            font-size: 0.8125rem;
        }
        
        .product-card .btn-sm {
            font-size: 0.625rem;
            padding: 0.25rem 0.5rem;
        }
        
        .product-card .btn-sm i {
            display: none;
        }
        
        /* Gallery */
        .gallery-item {
            flex: 0 0 160px;
        }
        
        .gallery-overlay span {
            font-size: 0.75rem;
            padding: 0 0.5rem;
        }
        
        /* Testimonial */
        .testimonial-card {
            flex: 0 0 240px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Simple parallax effect on hero image
    document.addEventListener('mousemove', function(e) {
        const heroImage = document.getElementById('heroImage');
        if (heroImage) {
            const x = (window.innerWidth - e.pageX * 2) / 100;
            const y = (window.innerHeight - e.pageY * 2) / 100;
            heroImage.style.transform = `translateX(${x}px) translateY(${y}px)`;
        }
    });
    
    // Scroll animation for why cards
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.why-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `all 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
</script>
@endpush
