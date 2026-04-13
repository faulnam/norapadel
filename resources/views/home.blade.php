@extends('layouts.app')

@section('title', 'Nora Padel - Performa Maksimal, Game Makin Total')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, #1B5E20 0%, #43A047 100%); padding: 100px 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-white">
                <h1 class="display-4 fw-bold mb-4">Nora Padel</h1>
                <h2 class="h4 mb-4">Perlengkapan Padel Premium</h2>
                <p class="lead mb-4">Raket, bola, tas, sepatu, dan aksesori padel berkualitas untuk pemula hingga profesional.</p>
                <div class="d-flex gap-3 mb-4">
                    @auth
                        <a href="{{ route('customer.products.index') }}" class="btn btn-warning btn-lg px-4">
                            <i class="fas fa-shopping-cart me-2"></i>Belanja Sekarang
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-warning btn-lg px-4">
                            <i class="fas fa-shopping-cart me-2"></i>Belanja Sekarang
                        </a>
                    @endauth
                    <a href="#about" class="btn btn-outline-light btn-lg px-4">Pelajari Lebih</a>
                </div>
                <!-- Stats -->
                <div class="d-flex gap-4 mt-4">
                    <div class="text-center">
                        <div class="h3 fw-bold mb-0">{{ $stats['total_customers'] }}+</div>
                        <small class="text-white-50">Pelanggan Puas</small>
                    </div>
                    <div class="border-start border-white-50 ps-4 text-center">
                        <div class="h3 fw-bold mb-0">{{ $stats['total_reviews'] }}+</div>
                        <small class="text-white-50">Review</small>
                    </div>
                    <div class="border-start border-white-50 ps-4 text-center">
                        <div class="h3 fw-bold mb-0">{{ $stats['avg_rating'] }}</div>
                        <small class="text-white-50">Rating ⭐</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center mt-5 mt-lg-0">
                <img src="https://images.unsplash.com/photo-1593766827228-8737b4534aa6?w=900" alt="Nora Padel" class="img-fluid rounded-4 shadow-lg" style="max-height: 400px; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5" id="about" style="background: linear-gradient(180deg, #F1F8E9 0%, #fff 100%);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Mengapa Memilih Nora Padel?</h2>
            <p class="text-muted">Keunggulan perlengkapan padel kami</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-leaf fa-2x text-success"></i>
                        </div>
                        <h5 class="card-title">Kualitas Teruji</h5>
                        <p class="card-text text-muted">Produk dipilih dari material premium yang tahan lama dan nyaman digunakan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-heart fa-2x text-warning"></i>
                        </div>
                        <h5 class="card-title">Untuk Semua Level</h5>
                        <p class="card-text text-muted">Pilihan gear lengkap untuk pemain pemula, intermediate, hingga kompetitif.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="rounded-circle bg-info bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-table-tennis fa-2x text-info"></i>
                        </div>
                        <h5 class="card-title">Performa Maksimal</h5>
                        <p class="card-text text-muted">Bantu kontrol, power, dan kenyamanan bermain di setiap sesi latihan maupun match.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-5" id="products">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Produk Kami</h2>
            <p class="text-muted">Pilihan perlengkapan padel yang lengkap</p>
        </div>
        
        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 product-card">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=400' }}" 
                             class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <div class="mb-2">
                                <span class="badge bg-{{ $product->category == 'original' ? 'success' : 'danger' }} me-1">{{ $product->category_label }}</span>
                                <span class="badge bg-secondary">{{ $product->formatted_weight }}</span>
                            </div>
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-success mb-0">{{ $product->formatted_price }}</span>
                                @auth
                                    <a href="{{ route('customer.products.show', $product) }}" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-shopping-cart me-1"></i>Pesan
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada produk tersedia.</p>
                </div>
            @endforelse
        </div>
        
        @if($products->count() > 0)
            <div class="text-center mt-5">
                @auth
                    <a href="{{ route('customer.products.index') }}" class="btn btn-success btn-lg px-5">
                        Lihat Semua Produk <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-success btn-lg px-5">
                        Lihat Semua Produk <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                @endauth
            </div>
        @endif
    </div>
</section>

<!-- About Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="https://images.unsplash.com/photo-1599058917212-d750089bc07e?w=900" alt="Tentang Nora Padel" class="img-fluid rounded-4 shadow">
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Tentang Nora Padel</h2>
                <p class="text-muted mb-4">
                    Nora Padel adalah brand perlengkapan olahraga yang fokus menyediakan gear padel berkualitas untuk pasar Indonesia.
                </p>
                <p class="text-muted mb-4">
                    Kami berkomitmen memberikan pengalaman belanja yang cepat, aman, dan profesional dengan produk yang relevan untuk kebutuhan pemain modern.
                </p>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Kualitas Original</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Garansi Produk</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Konsultasi Gear</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Support Komunitas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5" id="testimonials">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Apa Kata Mereka?</h2>
            <p class="text-muted">Testimoni dari pelanggan setia kami</p>
        </div>
        
        <div class="row g-4">
            @forelse($testimonials as $testimonial)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 p-4">
                        <div class="card-body">
                            <div class="mb-3">
                                {!! $testimonial->stars !!}
                            </div>
                            <p class="card-text text-muted mb-4">"{{ $testimonial->content }}"</p>
                            <div class="d-flex align-items-center">
                                <img src="{{ $testimonial->user->avatar_url }}" alt="{{ $testimonial->user->name }}" 
                                     class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                <div>
                                    <h6 class="mb-0">{{ $testimonial->user->name }}</h6>
                                    <small class="text-muted">{{ $testimonial->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada testimoni.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Gallery Section -->
@if($galleries->count() > 0)
<section class="py-5 bg-light" id="gallery">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Galeri</h2>
            <p class="text-muted">Momen dan aktivitas kami</p>
        </div>
        
        <div class="row g-4">
            @foreach($galleries as $gallery)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 gallery-card overflow-hidden">
                        @if($gallery->isImage())
                            <div class="gallery-image-wrapper" data-bs-toggle="modal" data-bs-target="#galleryModal{{ $gallery->id }}" style="cursor: pointer;">
                                <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" class="card-img-top gallery-image" style="height: 250px; object-fit: cover;">
                                <div class="gallery-overlay">
                                    <i class="fas fa-search-plus fa-2x text-white"></i>
                                </div>
                            </div>
                        @else
                            <div class="ratio ratio-16x9">
                                {!! $gallery->embed_url !!}
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                @if($gallery->isImage())
                                    <span class="badge bg-primary me-2"><i class="fas fa-image me-1"></i>Gambar</span>
                                @else
                                    <span class="badge bg-danger me-2"><i class="fab fa-instagram me-1"></i>Video</span>
                                @endif
                            </div>
                            <h6 class="card-title mb-1">{{ $gallery->title }}</h6>
                            @if($gallery->description)
                                <p class="card-text small text-muted mb-0">{{ Str::limit($gallery->description, 80) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Modal for Image Gallery -->
                @if($gallery->isImage())
                <div class="modal fade" id="galleryModal{{ $gallery->id }}" tabindex="-1" aria-labelledby="galleryModalLabel{{ $gallery->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content bg-transparent border-0">
                            <div class="modal-header border-0">
                                <h5 class="modal-title text-white" id="galleryModalLabel{{ $gallery->id }}">{{ $gallery->title }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0 text-center">
                                <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" class="img-fluid rounded">
                            </div>
                            @if($gallery->description)
                                <div class="modal-footer border-0 justify-content-center">
                                    <p class="text-white mb-0">{{ $gallery->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, #1B5E20 0%, #43A047 100%);">
    <div class="container text-center text-white">
    <h2 class="fw-bold mb-4">Siap Upgrade Gear Padel Kamu?</h2>
    <p class="lead mb-4">Belanja sekarang dan tingkatkan performa permainanmu bersama Nora Padel!</p>
        @auth
            <a href="{{ route('customer.products.index') }}" class="btn btn-warning btn-lg px-5">
                <i class="fas fa-shopping-cart me-2"></i>Belanja Sekarang
            </a>
        @else
            <a href="{{ route('register') }}" class="btn btn-warning btn-lg px-5">
                <i class="fas fa-user-plus me-2"></i>Daftar & Belanja
            </a>
        @endauth
    </div>
</section>
@endsection

@push('styles')
<style>
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    /* Gallery Styles */
    .gallery-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .gallery-image-wrapper {
        position: relative;
        overflow: hidden;
    }
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .gallery-image-wrapper:hover .gallery-overlay {
        opacity: 1;
    }
    .gallery-image-wrapper:hover .gallery-image {
        transform: scale(1.05);
    }
    .gallery-image {
        transition: transform 0.3s;
    }
    
    /* Modal dark background */
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.85) !important;
    }
</style>
@endpush
