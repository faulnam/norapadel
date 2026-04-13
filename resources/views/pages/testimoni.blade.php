@extends('layouts.app')

@section('title', 'Testimoni - Nora Padel')

@section('content')
<!-- Hero -->
<section class="page-hero">
    <div class="container">
        <span class="section-badge">Testimoni</span>
        <h1 class="page-title">Apa Kata <span class="text-primary">Mereka?</span></h1>
    <p class="page-subtitle">Review jujur dari pelanggan Nora Padel</p>
    </div>
</section>

<!-- Stats -->
<section class="py-4 bg-gray-light">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-4 col-md-4">
                <div class="stat-box">
                    <span class="stat-number">{{ $stats['total_reviews'] }}+</span>
                    <span class="stat-label">Review</span>
                </div>
            </div>
            <div class="col-4 col-md-4">
                <div class="stat-box">
                    <span class="stat-number">{{ $stats['avg_rating'] }}</span>
                    <span class="stat-label">Rating ⭐</span>
                </div>
            </div>
            <div class="col-4 col-md-4">
                <div class="stat-box">
                    <span class="stat-number">{{ $stats['satisfaction_rate'] }}%</span>
                    <span class="stat-label">Puas</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5">
    <div class="container">
        @if($testimonials->count() > 0)
            <div class="row g-4">
                @foreach($testimonials as $testimonial)
                    <div class="col-md-6 col-lg-4">
                        <div class="testimonial-card h-100">
                            <div class="testimonial-rating mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                            </div>
                            <p class="testimonial-content">"{{ $testimonial->content }}"</p>
                            <div class="testimonial-author">
                                <img src="{{ $testimonial->user->avatar_url }}" alt="{{ $testimonial->user->name }}" class="author-avatar-img">
                                <div>
                                    <h6 class="mb-0">{{ $testimonial->user->name }}</h6>
                                    <small class="text-gray">{{ $testimonial->created_at->format('d M Y') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if($testimonials->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $testimonials->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-comments fa-4x text-gray mb-3"></i>
                <h5>Belum Ada Testimoni</h5>
                <p class="text-gray">Jadilah yang pertama memberikan review!</p>
            </div>
        @endif
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
    
    .stat-box {
        padding: 1rem;
    }
    
    .stat-box .stat-number {
        display: block;
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary);
    }
    
    .stat-box .stat-label {
        color: var(--gray);
        font-size: 0.875rem;
    }
    
    .testimonial-card {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--radius);
        border: 1px solid var(--gray-light);
        transition: var(--transition);
    }
    
    .testimonial-card:hover {
        box-shadow: var(--shadow);
    }
    
    .testimonial-content {
        color: var(--dark);
        font-style: italic;
        margin-bottom: 1.5rem;
        line-height: 1.7;
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
        
        .stats-section {
            padding: 2rem 0;
        }
        
        .stat-box .stat-number {
            font-size: 1.75rem;
        }
        
        .testimonials-section {
            padding: 3rem 0;
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
            font-size: 0.875rem;
        }
        
        .stats-section {
            padding: 1.5rem 0;
        }
        
        .stat-box {
            padding: 1rem;
        }
        
        .stat-box .stat-number {
            font-size: 1.5rem;
        }
        
        .stat-box .stat-label {
            font-size: 0.75rem;
        }
        
        .testimonials-section {
            padding: 2rem 0;
        }
        
        .section-title {
            font-size: 1.25rem;
            margin-bottom: 0.25rem;
        }
        
        .section-subtitle {
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }
        
        .testimonial-card {
            padding: 1.25rem;
            margin-bottom: 1rem;
        }
        
        .testimonial-content {
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.6;
        }
        
        .author-avatar {
            width: 40px;
            height: 40px;
            font-size: 0.875rem;
        }
        
        .author-info h6 {
            font-size: 0.9rem;
        }
        
        .author-info small {
            font-size: 0.75rem;
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
        
        .stat-box .stat-number {
            font-size: 1.25rem;
        }
        
        .stat-box .stat-label {
            font-size: 0.7rem;
        }
        
        .testimonial-card {
            padding: 1rem;
        }
        
        .testimonial-content {
            font-size: 0.85rem;
        }
        
        .testimonial-author {
            gap: 0.75rem;
        }
        
        .author-avatar {
            width: 35px;
            height: 35px;
            font-size: 0.8rem;
        }
        
        .cta-content h2 {
            font-size: 1.125rem;
        }
    }
</style>
@endpush
