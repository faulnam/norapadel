@extends('layouts.app')

@section('title', 'PATAH - Kerupuk Pakcoy & Tahu')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, #1B5E20 0%, #43A047 100%); padding: 100px 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-white">
                <h1 class="display-4 fw-bold mb-4">Kerupuk PATAH</h1>
                <h2 class="h4 mb-4">Pakcoy & Tahu</h2>
                <p class="lead mb-4">Camilan sehat, gurih, dan inovatif dari bahan alami pakcoy dan tahu. Tanpa pengawet, tanpa MSG, 100% alami!</p>
                <div class="d-flex gap-3">
                    @auth
                        <a href="{{ route('customer.products.index') }}" class="btn btn-warning btn-lg px-4">
                            <i class="fas fa-shopping-cart me-2"></i>Pesan Sekarang
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-warning btn-lg px-4">
                            <i class="fas fa-shopping-cart me-2"></i>Pesan Sekarang
                        </a>
                    @endauth
                    <a href="#about" class="btn btn-outline-light btn-lg px-4">Pelajari Lebih</a>
                </div>
            </div>
            <div class="col-lg-6 text-center mt-5 mt-lg-0">
                <img src="https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=500" alt="Kerupuk PATAH" class="img-fluid rounded-4 shadow-lg" style="max-height: 400px; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5" id="about" style="background: linear-gradient(180deg, #F1F8E9 0%, #fff 100%);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Mengapa Memilih PATAH?</h2>
            <p class="text-muted">Keunggulan produk kerupuk kami</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-leaf fa-2x text-success"></i>
                        </div>
                        <h5 class="card-title">100% Alami</h5>
                        <p class="card-text text-muted">Terbuat dari bahan alami pilihan tanpa pengawet dan pewarna buatan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-heart fa-2x text-warning"></i>
                        </div>
                        <h5 class="card-title">Sehat & Bergizi</h5>
                        <p class="card-text text-muted">Mengandung nutrisi dari pakcoy dan protein dari tahu untuk camilan yang menyehatkan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="rounded-circle bg-info bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-cookie-bite fa-2x text-info"></i>
                        </div>
                        <h5 class="card-title">Renyah & Gurih</h5>
                        <p class="card-text text-muted">Tekstur renyah sempurna dengan rasa gurih yang nikmat di setiap gigitan.</p>
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
            <p class="text-muted">Pilihan kerupuk sehat dan lezat</p>
        </div>
        
        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 product-card">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=400' }}" 
                             class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <span class="badge bg-success mb-2">
                                {{ ucfirst($product->category) }}
                            </span>
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
                <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600" alt="Tentang PATAH" class="img-fluid rounded-4 shadow">
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Tentang PATAH</h2>
                <p class="text-muted mb-4">
                    PATAH (Pakcoy dan Tahu) adalah produk inovatif dari UMKM lokal yang menghadirkan kerupuk sehat berbahan dasar sayuran pakcoy dan tahu berkualitas tinggi.
                </p>
                <p class="text-muted mb-4">
                    Kami berkomitmen untuk menyediakan camilan yang tidak hanya lezat, tetapi juga menyehatkan. Setiap produk kami dibuat dengan standar kebersihan tinggi dan menggunakan bahan-bahan alami tanpa pengawet.
                </p>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Tanpa Pengawet</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Tanpa MSG</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Halal</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>BPOM</span>
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
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    {{ strtoupper(substr($testimonial->user->name, 0, 1)) }}
                                </div>
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

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, #1B5E20 0%, #43A047 100%);">
    <div class="container text-center text-white">
        <h2 class="fw-bold mb-4">Siap Mencoba Kerupuk PATAH?</h2>
        <p class="lead mb-4">Pesan sekarang dan rasakan sensasi camilan sehat yang lezat!</p>
        @auth
            <a href="{{ route('customer.products.index') }}" class="btn btn-warning btn-lg px-5">
                <i class="fas fa-shopping-cart me-2"></i>Pesan Sekarang
            </a>
        @else
            <a href="{{ route('register') }}" class="btn btn-warning btn-lg px-5">
                <i class="fas fa-user-plus me-2"></i>Daftar & Pesan
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
</style>
@endpush
