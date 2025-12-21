@extends('layouts.app')

@section('title', 'Testimoni - PATAH')

@section('content')
<!-- Hero -->
<section class="page-hero">
    <div class="container">
        <span class="section-badge">Testimoni</span>
        <h1 class="page-title">Apa Kata <span class="text-primary">Mereka?</span></h1>
        <p class="page-subtitle">Review jujur dari pelanggan setia PATAH</p>
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
                                <div class="author-avatar">
                                    {{ strtoupper(substr($testimonial->user->name, 0, 1)) }}
                                </div>
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
        
        .stat-box .stat-number {
            font-size: 1.5rem;
        }
    }
</style>
@endpush
