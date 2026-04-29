@extends('layouts.admin')

@section('page-title', 'Edit Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-edit me-2"></i>Edit Produk: {{ $product->name }}
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price', $product->price) }}" min="0" required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                       id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                                       {{ $product->has_variants ? 'readonly' : 'required' }}>
                                @if($product->has_variants)
                                    <small class="text-muted">Stok dihitung otomatis dari varian.</small>
                                @endif
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Diskon Produk -->
                    <div class="card border-warning mb-3">
                        <div class="card-header bg-warning bg-opacity-10">
                            <i class="fas fa-percent me-1"></i>Diskon Produk (Opsional)
                            @if($product->hasActiveDiscount())
                                <span class="badge bg-success ms-2">Aktif</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="discount_percent" class="form-label">Diskon</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control @error('discount_percent') is-invalid @enderror" 
                                                   id="discount_percent" name="discount_percent" value="{{ old('discount_percent', $product->discount_percent) }}" min="0" max="100" step="0.01">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        @error('discount_percent')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="discount_start" class="form-label">Mulai</label>
                                        <input type="datetime-local" class="form-control @error('discount_start') is-invalid @enderror" 
                                               id="discount_start" name="discount_start" value="{{ old('discount_start', $product->discount_start?->format('Y-m-d\TH:i')) }}">
                                        @error('discount_start')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="discount_end" class="form-label">Berakhir</label>
                                        <input type="datetime-local" class="form-control @error('discount_end') is-invalid @enderror" 
                                               id="discount_end" name="discount_end" value="{{ old('discount_end', $product->discount_end?->format('Y-m-d\TH:i')) }}">
                                        @error('discount_end')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @if($product->hasActiveDiscount())
                                <div class="alert alert-success mb-0">
                                    <small><strong>Harga setelah diskon:</strong> {{ $product->formatted_discounted_price }} <del class="text-muted">{{ $product->formatted_price }}</del></small>
                                </div>
                            @else
                                <small class="text-muted">Kosongkan tanggal jika diskon berlaku selamanya. Set diskon 0 untuk menonaktifkan.</small>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach(\App\Models\Product::categories() as $value => $label)
                                        <option value="{{ $value }}" {{ old('category', $product->category) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="weight" class="form-label">Berat <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('weight') is-invalid @enderror" 
                                           id="weight" name="weight" value="{{ old('weight', $product->weight) }}" min="1" step="1" required>
                                    <span class="input-group-text">gram</span>
                                </div>
                                @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Isi berat produk dalam gram (contoh: 360, 900, 1200).</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Produk</label>
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded" style="max-height: 150px;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*" onchange="previewImage(this)">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                        
                        <div id="imagePreview" class="mt-3"></div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktifkan Produk</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" 
                                   {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <i class="fas fa-star text-warning me-1"></i>Jadikan Highlight (Card Besar)
                            </label>
                        </div>
                        <small class="text-muted">Produk highlight akan tampil sebagai card besar di halaman utama. Hanya 1 produk per kategori yang bisa menjadi highlight.</small>
                    </div>
                </div>
            </div>
            
            <hr>

            <!-- Varian Produk -->
            <div class="mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="has_variants" name="has_variants" value="1"
                        {{ old('has_variants', $product->has_variants) ? 'checked' : '' }} onchange="toggleVariants(this)">
                    <label class="form-check-label fw-semibold" for="has_variants">
                        <i class="fas fa-layer-group me-1"></i>Produk ini memiliki Varian
                    </label>
                </div>
                <small class="text-muted">Aktifkan jika produk memiliki pilihan warna, ukuran, dll.</small>
            </div>

            <div id="variantsSection" style="display:{{ old('has_variants', $product->has_variants) ? 'block' : 'none' }}">
                <div class="card border-primary mb-3">
                    <div class="card-header bg-primary bg-opacity-10 d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-layer-group me-1"></i>Daftar Varian</span>
                        <button type="button" class="btn btn-sm btn-primary" onclick="addVariant()">
                            <i class="fas fa-plus me-1"></i>Tambah Varian
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="variantsList">
                            @foreach($product->variants as $vi => $variant)
                            <div class="border rounded p-3 mb-3 variant-item">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Varian #{{ $vi + 1 }}</strong>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVariant(this)"><i class="fas fa-trash"></i></button>
                                </div>
                                <input type="hidden" name="variants[{{ $vi }}][id]" value="{{ $variant->id }}">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <label class="form-label">Nama Varian <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="variants[{{ $vi }}][name]" value="{{ $variant->name }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Stok <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="variants[{{ $vi }}][stock]" value="{{ $variant->stock }}" min="0" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Tambahan Harga</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control" name="variants[{{ $vi }}][price_adjustment]" value="{{ $variant->price_adjustment }}" step="100">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Gambar</label>
                                        @if($variant->image)
                                            <img src="{{ asset('storage/' . $variant->image) }}" class="img-fluid rounded mb-1" style="max-height:60px;">
                                        @endif
                                        <input type="file" class="form-control" name="variants[{{ $vi }}][image]" accept="image/*" onchange="previewVariantImage(this)">
                                        <div class="variant-img-preview mt-1"></div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <p id="variantsEmpty" style="display:{{ $product->variants->count() ? 'none' : 'block' }}" class="text-muted text-center py-3">Belum ada varian.</p>
                    </div>
                </div>
            </div>

            <hr>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => preview.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded" style="max-height:200px;">`;
        reader.readAsDataURL(input.files[0]);
    }
}

let variantCount = {{ $product->variants->count() }};

function toggleVariants(cb) {
    const section = document.getElementById('variantsSection');
    const stockInput = document.getElementById('stock');
    section.style.display = cb.checked ? 'block' : 'none';
    stockInput.readOnly = cb.checked;
    if (cb.checked) stockInput.removeAttribute('required');
    else stockInput.setAttribute('required', '');
}

function addVariant(data = {}) {
    const i = variantCount++;
    const list = document.getElementById('variantsList');
    document.getElementById('variantsEmpty').style.display = 'none';
    const div = document.createElement('div');
    div.className = 'border rounded p-3 mb-3 variant-item';
    div.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <strong>Varian Baru</strong>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVariant(this)"><i class="fas fa-trash"></i></button>
        </div>
        <div class="row g-2">
            <div class="col-md-4">
                <label class="form-label">Nama Varian <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="variants[${i}][name]" placeholder="cth: Merah, XL" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Stok <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="variants[${i}][stock]" min="0" value="0" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tambahan Harga</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" name="variants[${i}][price_adjustment]" value="0" step="100">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label">Gambar</label>
                <input type="file" class="form-control" name="variants[${i}][image]" accept="image/*" onchange="previewVariantImage(this)">
                <div class="variant-img-preview mt-1"></div>
            </div>
        </div>`;
    list.appendChild(div);
}

function removeVariant(btn) {
    btn.closest('.variant-item').remove();
    if (!document.querySelectorAll('.variant-item').length) {
        document.getElementById('variantsEmpty').style.display = 'block';
    }
}

function previewVariantImage(input) {
    const preview = input.nextElementSibling;
    preview.innerHTML = '';
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => preview.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded" style="max-height:80px;">`;
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
