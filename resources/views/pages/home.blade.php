@extends('layouts.app')

@section('title', 'PATAH - Kerupuk Sehat Pakcoy & Tahu')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6">
                <span class="hero-badge">🌿 100% Alami & Sehat</span>
                <h1 class="hero-title">
                    Kerupuk <span class="text-primary">PATAH</span>
                    <br>Renyah & Bergizi
                </h1>
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
            <div class="col-lg-6">
                <div class="hero-image-wrapper">
                    <div class="hero-image-container">
                        <img src="https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=600" 
                             alt="Kerupuk PATAH" class="hero-image" id="heroImage">
                        <div class="floating-card floating-card-1">
                            <i class="fas fa-leaf text-primary"></i>
                            <span>Organik</span>
                        </div>
                        <div class="floating-card floating-card-2">
                            <i class="fas fa-heart text-danger"></i>
                            <span>Sehat</span>
                        </div>
                        <div class="floating-card floating-card-3">
                            <i class="fas fa-fire text-warning"></i>
                            <span>Renyah</span>
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
            <div class="col-lg-5">
                <div class="about-image-grid">
                    <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400" alt="Proses Pembuatan" class="about-img-main">
                    <div class="about-badge">
                        <span class="about-badge-number">5+</span>
                        <span class="about-badge-text">Tahun<br>Pengalaman</span>
                    </div>
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
            <span class="section-badge">Keunggulan</span>
            <h2 class="section-title">Mengapa Memilih PATAH?</h2>
            <p class="section-subtitle">Alasan mengapa ribuan orang menyukai kerupuk kami</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="why-card" data-aos="fade-up">
                    <div class="why-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h5>100% Alami</h5>
                    <p class="text-gray small mb-0">Tanpa pengawet, pewarna, dan bahan kimia berbahaya</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="why-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="why-icon why-icon-orange">
                        <i class="fas fa-fire-alt"></i>
                    </div>
                    <h5>Renyah Sempurna</h5>
                    <p class="text-gray small mb-0">Tekstur krispy yang bikin nagih setiap gigitan</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="why-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="why-icon why-icon-red">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h5>Kaya Nutrisi</h5>
                    <p class="text-gray small mb-0">Vitamin & protein dari pakcoy dan tahu</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="why-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="why-icon why-icon-blue">
                        <i class="fas fa-truck"></i>
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
        
        <div class="row g-4">
            @forelse($products->take(3) as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=400' }}" 
                                 alt="{{ $product->name }}">
                            <div class="product-badges">
                                <span class="badge badge-{{ $product->category == 'original' ? 'primary' : 'accent' }}">
                                    {{ $product->category_label }}
                                </span>
                            </div>
                        </div>
                        <div class="product-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="product-title mb-0">{{ $product->name }}</h5>
                                <span class="product-weight">{{ $product->formatted_weight }}</span>
                            </div>
                            <p class="product-desc text-gray small">{{ Str::limit($product->description, 60) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="product-price">{{ $product->formatted_price }}</span>
                                @auth
                                    <a href="{{ route('customer.products.show', $product) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-shopping-cart me-1"></i>Beli
                                    </a>
                                @else
                                    <a href="{{ route('produk.show', $product) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>Detail
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
                        <div class="author-avatar">
                            {{ strtoupper(substr($testimonial->user->name, 0, 1)) }}
                        </div>
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
        padding: 4rem 0;
        background: var(--white);
        overflow: hidden;
    }
    
    .min-vh-75 {
        min-height: 75vh;
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
        margin-bottom: 3rem;
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
        padding: 2rem;
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
    
    .floating-card {
        position: absolute;
        background: var(--white);
        padding: 0.75rem 1rem;
        border-radius: var(--radius);
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        animation: floatCard 4s ease-in-out infinite;
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
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
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
        gap: 1rem;
        overflow-x: auto;
        padding-bottom: 1rem;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
    }
    
    .gallery-scroll::-webkit-scrollbar {
        height: 6px;
    }
    
    .gallery-item {
        flex: 0 0 300px;
        height: 250px;
        border-radius: var(--radius);
        overflow: hidden;
        position: relative;
        scroll-snap-align: start;
    }
    
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }
    
    .gallery-item:hover img {
        transform: scale(1.1);
    }
    
    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1rem;
        background: linear-gradient(transparent, rgba(0,0,0,0.7));
        color: white;
        font-weight: 600;
        opacity: 0;
        transition: var(--transition);
    }
    
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
    
    .gallery-video {
        width: 100%;
        height: 100%;
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
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-image-wrapper {
            margin-top: 3rem;
        }
        
        .floating-card {
            display: none;
        }
        
        .hero-stats {
            justify-content: center;
        }
    }
    
    @media (max-width: 767.98px) {
        .hero-section {
            padding: 2rem 0;
        }
        
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-buttons {
            flex-direction: column;
        }
        
        .hero-stats {
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .stat-divider {
            display: none;
        }
        
        .about-badge {
            right: 10px;
            bottom: -10px;
        }
        
        .gallery-item {
            flex: 0 0 250px;
            height: 200px;
        }
        
        .testimonial-card {
            flex: 0 0 300px;
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
