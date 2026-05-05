@extends('layouts.admin')

@section('page-title', 'Tambah Testimoni')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus me-2"></i>Tambah Testimoni Baru
            </div>
            <div class="card-body">
                <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="images" class="form-label">Gambar Testimoni <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror" 
                               id="images" name="images[]" accept="image/*" multiple required>
                        @error('images')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPG, PNG, WEBP. Maksimal 2MB per gambar (maks 3).</small>
                        
                        <div class="mt-3 row g-2" id="imagePreview" style="display: none;"></div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan Testimoni
                        </button>
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('images').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    const files = Array.from(e.target.files || []).slice(0, 3);

    if (!files.length) {
        preview.style.display = 'none';
        return;
    }

    files.forEach((file) => {
        const reader = new FileReader();
        reader.onload = function(event) {
            const col = document.createElement('div');
            col.className = 'col-6 col-md-4';
            col.innerHTML = `<img src="${event.target.result}" alt="Preview" class="img-fluid rounded" style="max-height: 220px;">`;
            preview.appendChild(col);
        };
        reader.readAsDataURL(file);
    });
    preview.style.display = 'flex';
});
</script>
@endpush
