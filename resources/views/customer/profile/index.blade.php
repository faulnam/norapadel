@extends('layouts.app')

@section('title', 'Profil Saya - PATAH')

@section('content')
<div class="container py-4 py-lg-5">
    <h3 class="mb-4 profile-title">
        <i class="fas fa-user me-2 text-success"></i>Profil Saya
    </h3>
    
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
            <!-- Profile Card -->
            <div class="card profile-card">
                <div class="card-body text-center py-3 py-lg-4">
                    <!-- Avatar with upload -->
                    <div class="position-relative d-inline-block mb-3">
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                             class="rounded-circle avatar-img" id="avatarPreview">
                        <label for="avatarInput" class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle d-flex align-items-center justify-content-center avatar-upload-btn"> 
                            <i class="fas fa-camera"></i>
                        </label>
                    </div>
                    
                    <form action="{{ route('customer.profile.avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                        @csrf
                        <input type="file" name="avatar" id="avatarInput" accept="image/*" class="d-none">
                    </form>
                    
                    @error('avatar')
                        <div class="text-danger small mb-2">{{ $message }}</div>
                    @enderror
                    
                    <h5 class="mb-1 profile-name">{{ $user->name }}</h5>
                    <p class="text-muted mb-3 profile-email">{{ $user->email }}</p>
                    <span class="badge bg-success">Customer</span>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between profile-info-item">
                        <span><i class="fas fa-phone me-2 text-muted"></i>Telepon</span>
                        <span class="text-truncate ms-2" style="max-width: 150px;">{{ $user->phone ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between profile-info-item">
                        <span><i class="fas fa-calendar me-2 text-muted"></i>Bergabung</span>
                        <span>{{ $user->created_at->format('d M Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="col-lg-8">
            <!-- Update Profile -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white profile-card-header">
                    <i class="fas fa-edit me-2"></i>Edit Profil
                </div>
                <div class="card-body">
                    <form action="{{ route('customer.profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                            <small class="text-muted">Email tidak dapat diubah</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   name="phone" value="{{ old('phone', $user->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      name="address" rows="3" required>{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i>Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Change Password -->
            <div class="card">
                <div class="card-header bg-white profile-card-header">
                    <i class="fas fa-lock me-2"></i>Ubah Password
                </div>
                <div class="card-body">
                    <form action="{{ route('customer.profile.update-password') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <label class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimal 8 karakter</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key me-1"></i>Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .avatar-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border: 4px solid #16a34a;
    }
    .avatar-upload-btn {
        width: 36px;
        height: 36px;
        cursor: pointer;
        border: 3px solid white;
    }
    
    /* Mobile Responsive */
    @media (max-width: 767.98px) {
        .profile-title {
            font-size: 1.3rem;
        }
        .avatar-img {
            width: 100px;
            height: 100px;
            border-width: 3px;
        }
        .avatar-upload-btn {
            width: 30px;
            height: 30px;
            border-width: 2px;
            font-size: 0.75rem;
        }
        .profile-name {
            font-size: 1.1rem;
        }
        .profile-email {
            font-size: 0.85rem;
        }
        .profile-info-item {
            font-size: 0.85rem;
            padding: 0.6rem 1rem;
        }
        .profile-card-header {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }
        .form-label {
            font-size: 0.85rem;
        }
        .form-control {
            font-size: 0.9rem;
        }
        .profile-card .card-body {
            padding: 1rem;
        }
        .btn {
            font-size: 0.9rem;
        }
    }
    
    @media (max-width: 575.98px) {
        .avatar-img {
            width: 80px;
            height: 80px;
        }
        .avatar-upload-btn {
            width: 26px;
            height: 26px;
            font-size: 0.65rem;
        }
        .profile-info-item {
            font-size: 0.8rem;
        }
    }
</style>
@endpush

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
