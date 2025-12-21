@extends('layouts.app')

@section('title', 'Tentang Kami - PATAH')

@section('content')
<!-- Hero -->
<section class="page-hero">
    <div class="container">
        <span class="section-badge">Tentang Kami</span>
        <h1 class="page-title">Kenali Lebih Dekat <span class="text-primary">PATAH</span></h1>
        <p class="page-subtitle">Cerita perjalanan kami menghadirkan camilan sehat untuk Indonesia</p>
    </div>
</section>

<!-- Story Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600" 
                     alt="Tim PATAH" class="img-fluid rounded-4">
            </div>
            <div class="col-lg-6">
                <h2 class="section-title">Cerita Kami</h2>
                <p class="text-gray mb-4">
                    PATAH (Pakcoy dan Tahu) lahir dari mimpi sederhana: menghadirkan camilan yang tidak hanya enak, 
                    tetapi juga menyehatkan. Berawal dari dapur rumah di Surabaya pada tahun 2019, 
                    kami mulai bereksperimen menggabungkan sayuran pakcoy yang kaya nutrisi dengan tahu premium.
                </p>
                <p class="text-gray mb-4">
                    Nama "PATAH" sendiri merupakan singkatan dari <strong>Pa</strong>kcoy dan <strong>Tah</strong>u, 
                    dua bahan utama yang menjadi keunikan produk kami. Kami percaya bahwa camilan sehat tidak harus 
                    membosankan - itulah mengapa kami terus berinovasi untuk menciptakan rasa yang disukai semua kalangan.
                </p>
                <div class="story-stats">
                    <div class="story-stat">
                        <span class="stat-number">2019</span>
                        <span class="stat-label">Tahun Berdiri</span>
                    </div>
                    <div class="story-stat">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">Pelanggan</span>
                    </div>
                    <div class="story-stat">
                        <span class="stat-number">10+</span>
                        <span class="stat-label">Varian Produk</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision Mission -->
<section class="py-5 bg-gray-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="vm-card">
                    <div class="vm-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Visi Kami</h3>
                    <p class="text-gray mb-0">
                        Menjadi produsen camilan sehat terdepan di Indonesia yang menginspirasi 
                        masyarakat untuk hidup lebih sehat tanpa mengorbankan kenikmatan.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="vm-card">
                    <div class="vm-icon vm-icon-accent">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Misi Kami</h3>
                    <ul class="text-gray mb-0 ps-3">
                        <li>Menghasilkan produk berkualitas tinggi dengan bahan alami</li>
                        <li>Memberikan pelayanan terbaik kepada pelanggan</li>
                        <li>Mendukung petani lokal dengan membeli bahan baku berkualitas</li>
                        <li>Terus berinovasi dalam menciptakan varian rasa baru</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">Nilai-Nilai</span>
            <h2 class="section-title">Yang Kami Pegang Teguh</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h5>Alami</h5>
                    <p class="small text-gray mb-0">100% bahan alami tanpa pengawet dan pewarna buatan</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="value-card">
                    <div class="value-icon value-icon-orange">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h5>Kualitas</h5>
                    <p class="small text-gray mb-0">Standar produksi tinggi untuk hasil terbaik</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="value-card">
                    <div class="value-icon value-icon-blue">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h5>Integritas</h5>
                    <p class="small text-gray mb-0">Jujur dan transparan dalam setiap proses</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="value-card">
                    <div class="value-icon value-icon-purple">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h5>Inovasi</h5>
                    <p class="small text-gray mb-0">Terus berkreasi untuk pengalaman baru</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Process -->
<section class="py-5 bg-gray-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">Proses</span>
            <h2 class="section-title">Dari Bahan Segar ke Meja Anda</h2>
        </div>
        
        <div class="process-timeline">
            <div class="process-item">
                <div class="process-number">1</div>
                <div class="process-content">
                    <h5>Seleksi Bahan</h5>
                    <p class="small text-gray mb-0">Pakcoy dan tahu segar dipilih langsung dari petani lokal</p>
                </div>
            </div>
            <div class="process-item">
                <div class="process-number">2</div>
                <div class="process-content">
                    <h5>Pengolahan</h5>
                    <p class="small text-gray mb-0">Dicuci bersih dan diolah dengan standar higienis</p>
                </div>
            </div>
            <div class="process-item">
                <div class="process-number">3</div>
                <div class="process-content">
                    <h5>Pencampuran</h5>
                    <p class="small text-gray mb-0">Dicampur dengan bumbu rahasia khas PATAH</p>
                </div>
            </div>
            <div class="process-item">
                <div class="process-number">4</div>
                <div class="process-content">
                    <h5>Pengeringan</h5>
                    <p class="small text-gray mb-0">Dikeringkan dengan suhu optimal untuk tekstur renyah</p>
                </div>
            </div>
            <div class="process-item">
                <div class="process-number">5</div>
                <div class="process-content">
                    <h5>Pengemasan</h5>
                    <p class="small text-gray mb-0">Dikemas rapi dan siap dikirim ke rumah Anda</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Tertarik Mencoba?</h2>
            <p>Rasakan sendiri kelezatan kerupuk sehat PATAH</p>
            <a href="{{ route('produk.index') }}" class="btn btn-accent btn-lg">
                <i class="fas fa-shopping-bag me-2"></i>Lihat Produk
            </a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .page-hero {
        background: var(--white);
        padding: 4rem 0;
        text-align: center;
    }
    
    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .page-subtitle {
        color: var(--gray);
        font-size: 1.125rem;
    }
    
    .story-stats {
        display: flex;
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .story-stat {
        text-align: center;
    }
    
    .story-stat .stat-number {
        display: block;
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary);
    }
    
    .story-stat .stat-label {
        color: var(--gray);
        font-size: 0.875rem;
    }
    
    .vm-card {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--radius);
        height: 100%;
    }
    
    .vm-icon {
        width: 60px;
        height: 60px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .vm-icon-accent {
        background: var(--accent-light);
        color: var(--accent);
    }
    
    .value-card {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--radius);
        text-align: center;
        border: 1px solid var(--gray-light);
        transition: var(--transition);
        height: 100%;
    }
    
    .value-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow);
    }
    
    .value-icon {
        width: 60px;
        height: 60px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin: 0 auto 1rem;
    }
    
    .value-icon-orange { background: var(--accent-light); color: var(--accent); }
    .value-icon-blue { background: #dbeafe; color: #3b82f6; }
    .value-icon-purple { background: #f3e8ff; color: #9333ea; }
    
    .process-timeline {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1rem;
    }
    
    .process-item {
        flex: 1;
        min-width: 180px;
        max-width: 200px;
        text-align: center;
        padding: 1.5rem 1rem;
        background: var(--white);
        border-radius: var(--radius);
        position: relative;
    }
    
    .process-number {
        width: 40px;
        height: 40px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin: 0 auto 1rem;
    }
    
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
    }
    
    @media (max-width: 767.98px) {
        .page-title {
            font-size: 1.75rem;
        }
        
        .story-stats {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
</style>
@endpush
