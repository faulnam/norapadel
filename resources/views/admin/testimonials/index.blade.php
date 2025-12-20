@extends('layouts.admin')

@section('page-title', 'Manajemen Testimoni')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-comment me-2"></i>Daftar Testimoni
    </div>
    <div class="card-body">
        <!-- Filters -->
        <form action="{{ route('admin.testimonials.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <select class="form-select" name="status">
                    <option value="">Semua Status</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-select" name="rating">
                    <option value="">Semua Rating</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-search me-1"></i>Filter
                </button>
            </div>
        </form>

        <!-- Testimonials Grid -->
        <div class="row g-4">
            @forelse($testimonials as $testimonial)
                <div class="col-md-6">
                    <div class="card h-100 {{ !$testimonial->is_approved ? 'border-warning' : '' }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" 
                                         style="width: 50px; height: 50px;">
                                        {{ strtoupper(substr($testimonial->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $testimonial->user->name }}</h6>
                                        <small class="text-muted">{{ $testimonial->created_at->format('d M Y') }}</small>
                                    </div>
                                </div>
                                @if($testimonial->is_approved)
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </div>
                            
                            <div class="mb-2">
                                {!! $testimonial->stars !!}
                            </div>
                            
                            <p class="card-text">{{ $testimonial->content }}</p>
                            
                            <small class="text-muted d-block mb-3">
                                Pesanan: <a href="{{ route('admin.orders.show', $testimonial->order) }}">
                                    {{ $testimonial->order->order_number }}
                                </a>
                            </small>
                            
                            <div class="d-flex gap-2">
                                @if(!$testimonial->is_approved)
                                    <form action="{{ route('admin.testimonials.approve', $testimonial) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-check me-1"></i>Setujui
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.testimonials.reject', $testimonial) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-warning">
                                            <i class="fas fa-eye-slash me-1"></i>Sembunyikan
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus testimoni ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">Belum ada testimoni</p>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $testimonials->links() }}
        </div>
    </div>
</div>
@endsection
