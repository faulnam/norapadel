@extends('layouts.app')

@section('title', 'Tentang Kami - Nora Padel')

@section('content')
<!-- Hero -->
<section class="page-hero">
    <div class="container">
        <span class="section-badge">Tentang Kami</span>
    <h1 class="page-title">Kenali Lebih Dekat <span class="text-primary">Nora Padel</span></h1>
    <p class="page-subtitle">Partner perlengkapan padel berkualitas untuk permainan yang lebih maksimal</p>
    </div>
</section>

<!-- Story Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
             <img src="https://images.unsplash.com/photo-1599058917212-d750089bc07e?w=900"
                 alt="Tim Nora Padel" class="img-fluid rounded-4">
            </div>
            <div class="col-lg-6">
                <h2 class="section-title">Cerita Kami</h2>
                <p class="text-gray mb-4">
                    Nora Padel lahir dari semangat menghadirkan perlengkapan padel berkualitas yang mudah diakses 
                    pemain Indonesia. Berawal dari komunitas kecil di Surabaya pada tahun 2023,
                    kami fokus mengkurasi produk yang benar-benar menunjang performa di lapangan.
                </p>
                <p class="text-gray mb-4">
                    Nama "Nora Padel" merepresentasikan energi modern, sportivitas, dan konsistensi kualitas.
                    Kami percaya setiap pemain—dari pemula hingga profesional—berhak mendapatkan gear terbaik
                    agar proses belajar, latihan, dan bertanding terasa lebih nyaman dan menyenangkan.
                </p>
                <div class="story-stats">
                    <div class="story-stat">
                        <span class="stat-number">2023</span>
                        <span class="stat-label">Tahun Berdiri</span>
                    </div>
                    <div class="story-stat">
                        <span class="stat-number">100+</span>
                        <span class="stat-label">Pelanggan</span>
                    </div>
                    <div class="story-stat">
                        <span class="stat-number">5+</span>
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
                    
                    <h3>Visi Kami</h3>
                    <p class="text-gray mb-0">
                        Menjadi toko perlengkapan padel terpercaya di Indonesia yang mendukung pertumbuhan
                        komunitas padel dari level pemula hingga profesional.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="vm-card">
                    
                    <h3>Misi Kami</h3>
                    <ul class="text-gray mb-0 ps-3">
                        <li>Menyediakan raket, bola, sepatu, tas, dan aksesori padel berkualitas tinggi</li>
                        <li>Memberikan konsultasi produk yang sesuai gaya bermain pelanggan</li>
                        <li>Menghadirkan pengalaman belanja cepat, aman, dan transparan</li>
                        <li>Mendukung ekosistem padel lewat edukasi dan event komunitas</li>
                    </ul>
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
            <h2 class="section-title">Dari Seleksi Produk ke Tangan Anda</h2>
        </div>
        
        <div class="process-timeline">
            <div class="process-item">
                <div class="process-number">1</div>
                <div class="process-content">
                    <h5>Kurasi Produk</h5>
                    <p class="small text-gray mb-0">Kami memilih brand dan spesifikasi gear yang sudah teruji kualitasnya</p>
                </div>
            </div>
            <div class="process-item">
                <div class="process-number">2</div>
                <div class="process-content">
                    <h5>Quality Check</h5>
                    <p class="small text-gray mb-0">Setiap produk dicek kondisi fisik dan kelengkapannya sebelum dipajang</p>
                </div>
            </div>
            <div class="process-item">
                <div class="process-number">3</div>
                <div class="process-content">
                    <h5>Rekomendasi Produk</h5>
                    <p class="small text-gray mb-0">Tim kami membantu memilih gear sesuai level, posisi, dan kebutuhan bermain</p>
                </div>
            </div>
            <div class="process-item">
                <div class="process-number">4</div>
                <div class="process-content">
                    <h5>Packaging Aman</h5>
                    <p class="small text-gray mb-0">Produk dipacking rapi agar tetap aman selama proses pengiriman</p>
                </div>
            </div>
            <div class="process-item">
                <div class="process-number">5</div>
                <div class="process-content">
                    <h5>Delivery Cepat</h5>
                    <p class="small text-gray mb-0">Pesanan dikirim tepat waktu agar Anda bisa segera turun ke lapangan</p>
                </div>
            </div>
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
    
    /* Responsive untuk tablet */
    @media (max-width: 991.98px) {
        .page-hero {
            padding: 3rem 0;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .story-stats {
            gap: 1.5rem;
        }
        
        .story-stat .stat-number {
            font-size: 1.75rem;
        }
        
        .vm-card {
            padding: 1.5rem;
        }
        
        .process-item {
            min-width: 150px;
            max-width: 180px;
            padding: 1.25rem 0.75rem;
        }
        
        .cta-section {
            padding: 3rem 0;
        }
        
        .cta-content h2 {
            font-size: 1.75rem;
        }
    }
    
    /* Responsive untuk mobile */
    @media (max-width: 767.98px) {
        .page-hero {
            padding: 2.5rem 0;
        }
        
        .page-title {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            font-size: 0.9rem;
        }
        
        .section-title {
            font-size: 1.25rem;
        }
        
        .story-stats {
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
        }
        
        .story-stat {
            flex: 0 0 calc(33.333% - 0.75rem);
        }
        
        .story-stat .stat-number {
            font-size: 1.5rem;
        }
        
        .story-stat .stat-label {
            font-size: 0.75rem;
        }
        
        .vm-card {
            padding: 1.25rem;
        }
        
        .vm-card h3 {
            font-size: 1.125rem;
        }
        
        .vm-card ul {
            font-size: 0.9rem;
        }
        
        .vm-icon {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }
        
        .value-card {
            padding: 1.25rem;
        }
        
        .value-icon {
            width: 50px;
            height: 50px;
            font-size: 1rem;
        }
        
        .value-card h5 {
            font-size: 1rem;
        }
        
        .process-timeline {
            flex-direction: column;
            align-items: center;
        }
        
        .process-item {
            min-width: 100%;
            max-width: 100%;
            display: flex;
            align-items: center;
            text-align: left;
            padding: 1rem;
            gap: 1rem;
        }
        
        .process-number {
            margin: 0;
            flex-shrink: 0;
        }
        
        .process-content {
            flex: 1;
        }
        
        .process-content h5 {
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }
        
        .cta-section {
            padding: 2rem 0;
        }
        
        .cta-content h2 {
            font-size: 1.25rem;
        }
        
        .cta-content p {
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
        
        .cta-content .btn {
            padding: 0.5rem 1.5rem;
            font-size: 0.875rem;
        }
    }
    
    /* Responsive untuk mobile kecil */
    @media (max-width: 575.98px) {
        .page-hero {
            padding: 2rem 0;
        }
        
        .page-title {
            font-size: 1.25rem;
        }
        
        .section-badge {
            font-size: 0.7rem;
        }
        
        .story-stat {
            flex: 0 0 calc(50% - 0.5rem);
        }
        
        .story-stat .stat-number {
            font-size: 1.25rem;
        }
        
        .vm-card {
            padding: 1rem;
        }
        
        .vm-card p,
        .vm-card ul {
            font-size: 0.85rem;
        }
        
        .process-item {
            padding: 0.75rem;
        }
        
        .process-number {
            width: 35px;
            height: 35px;
            font-size: 0.875rem;
        }
        
        .cta-content h2 {
            font-size: 1.125rem;
        }
    }
</style>
@endpush
