@extends('layouts.app')

@section('title', 'Galeri - PATAH')

@section('content')
<!-- Hero -->
<section class="page-hero">
    <div class="container">
        <span class="section-badge">Galeri</span>
        <h1 class="page-title">Momen & Aktivitas <span class="text-primary">Kami</span></h1>
        <p class="page-subtitle">Dokumentasi perjalanan PATAH dari waktu ke waktu</p>
    </div>
</section>

<!-- Gallery Grid -->
<section class="py-5">
    <div class="container">
        @if($galleries->count() > 0)
            <div class="gallery-grid">
                @foreach($galleries as $gallery)
                    <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal{{ $gallery->id }}">
                        @if($gallery->isImage())
                            <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}">
                            <div class="gallery-hover">
                                <i class="fas fa-expand"></i>
                                <span>{{ $gallery->title }}</span>
                            </div>
                        @else
                            <div class="gallery-video-thumb">
                                <i class="fab fa-instagram fa-3x text-white"></i>
                                <span>{{ $gallery->title }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="galleryModal{{ $gallery->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header border-0">
                                    <h5 class="modal-title">{{ $gallery->title }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-0">
                                    @if($gallery->isImage())
                                        <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" class="img-fluid w-100">
                                    @else
                                        <div class="ratio ratio-16x9">
                                            {!! $gallery->embed_url !!}
                                        </div>
                                    @endif
                                </div>
                                @if($gallery->description)
                                    <div class="modal-footer border-0">
                                        <p class="text-gray mb-0 w-100">{{ $gallery->description }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-images fa-4x text-gray mb-3"></i>
                <h5>Galeri Masih Kosong</h5>
                <p class="text-gray">Dokumentasi akan segera ditambahkan</p>
            </div>
        @endif
    </div>
</section>

<!-- Instagram CTA -->
<section class="py-5 bg-gray-light">
    <div class="container">
        <div class="text-center">
            <i class="fab fa-instagram fa-3x text-primary mb-3"></i>
            <h4>Follow Instagram Kami</h4>
            <p class="text-gray mb-3">Lihat update terbaru dan konten menarik lainnya</p>
            <a href="#" class="btn btn-dark">
                <i class="fab fa-instagram me-2"></i>@patah.id
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
    
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .gallery-item {
        position: relative;
        height: 280px;
        border-radius: var(--radius);
        overflow: hidden;
        cursor: pointer;
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
    
    .gallery-hover {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        opacity: 0;
        transition: var(--transition);
        gap: 0.5rem;
    }
    
    .gallery-hover i {
        font-size: 2rem;
    }
    
    .gallery-hover span {
        font-weight: 600;
    }
    
    .gallery-item:hover .gallery-hover {
        opacity: 1;
    }
    
    .gallery-video-thumb {
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, #833ab4, #fd1d1d, #fcb045);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        color: white;
    }
    
    .gallery-video-thumb span {
        font-weight: 600;
    }
    
    .modal-content {
        border: none;
        border-radius: var(--radius);
        overflow: hidden;
    }
    
    @media (max-width: 767.98px) {
        .page-title {
            font-size: 1.75rem;
        }
        
        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .gallery-item {
            height: 180px;
        }
    }
</style>
@endpush
