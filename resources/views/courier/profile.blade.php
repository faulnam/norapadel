@extends('layouts.courier')

@section('title', 'Profil Saya')

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('courier.dashboard') }}" class="text-decoration-none" style="color: var(--primary);">Dashboard</a></li>
        <li class="breadcrumb-item active">Profil</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="font-weight: 700; color: var(--dark);">Profil Saya</h4>
        <p class="text-muted mb-0">Kelola informasi akun Anda</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <!-- Avatar with upload -->
                <div class="position-relative d-inline-block mb-3">
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" 
                         class="rounded-circle" id="avatarPreview"
                         style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #2563eb;">
                    <label for="avatarInput" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                           style="width: 36px; height: 36px; cursor: pointer; border: 3px solid white;">
                        <i class="fas fa-camera"></i>
                    </label>
                </div>
                
                <form action="{{ route('courier.profile.avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                    @csrf
                    <input type="file" name="avatar" id="avatarInput" accept="image/*" class="d-none">
                </form>
                
                @error('avatar')
                    <div class="text-danger small mb-2">{{ $message }}</div>
                @enderror
                
                <h5 class="mb-1" style="font-weight: 600; color: var(--dark);">{{ auth()->user()->name }}</h5>
                <p class="text-muted mb-3">Kurir</p>
                <div class="d-flex justify-content-center gap-4 text-center">
                    <div>
                        <h5 class="mb-0" style="font-weight: 700; color: #10b981;">{{ auth()->user()->completedDeliveries()->count() }}</h5>
                        <small class="text-muted">Pengiriman Selesai</small>
                    </div>
                    <div>
                        <h5 class="mb-0" style="font-weight: 700; color: var(--primary);">{{ auth()->user()->assignedDeliveries()->count() }}</h5>
                        <small class="text-muted">Total Ditugaskan</small>
                    </div>
                </div>
                <!-- Tombol Logout Mobile -->
                <div class="mt-4 d-lg-none">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-sign-out-alt me-2"></i>Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <!-- Update Profile -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-user-edit me-2" style="color: var(--primary);"></i>Update Profil
            </div>
            <div class="card-body">
                <form action="{{ route('courier.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                               value="{{ old('phone', auth()->user()->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                  rows="3">{{ old('address', auth()->user()->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <!-- Change Password -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-lock me-2" style="color: #f59e0b;"></i>Ubah Password
            </div>
            <div class="card-body">
                <form action="{{ route('courier.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn" style="background: #f59e0b; color: white;">
                        <i class="fas fa-key me-1"></i>Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('avatarInput').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        // Preview image
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);
        
        // Submit form
        document.getElementById('avatarForm').submit();
    }
});
</script>
@endpush
@endsection
