@extends('layouts.admin')

@section('page-title', 'Tambah Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-plus me-2"></i>Tambah Produk Baru
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
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
                                           id="price" name="price" value="{{ old('price') }}" min="0" required>
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
                                       id="stock" name="stock" value="{{ old('stock', 0) }}" min="0" required>
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
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="discount_percent" class="form-label">Diskon</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control @error('discount_percent') is-invalid @enderror" 
                                                   id="discount_percent" name="discount_percent" value="{{ old('discount_percent', 0) }}" min="0" max="100" step="0.01">
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
                                               id="discount_start" name="discount_start" value="{{ old('discount_start') }}">
                                        @error('discount_start')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="discount_end" class="form-label">Berakhir</label>
                                        <input type="datetime-local" class="form-control @error('discount_end') is-invalid @enderror" 
                                               id="discount_end" name="discount_end" value="{{ old('discount_end') }}">
                                        @error('discount_end')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted">Kosongkan tanggal jika diskon berlaku selamanya.</small>
                            <div id="discountedPricePreview" class="mt-2 text-sm text-emerald-700" style="display:none;"></div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach(\App\Models\Product::categories() as $value => $label)
                                        <option value="{{ $value }}" {{ old('category') == $value ? 'selected' : '' }}>{{ $label }}</option>
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
                                           id="weight" name="weight" value="{{ old('weight') }}" min="1" step="1" required>
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
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*" onchange="previewImage(this)">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                        
                        <div id="imagePreview" class="mt-3"></div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Aktifkan Produk</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
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
                        {{ old('has_variants') ? 'checked' : '' }} onchange="toggleVariants(this)">
                    <label class="form-check-label fw-semibold" for="has_variants">
                        <i class="fas fa-layer-group me-1"></i>Produk ini memiliki Varian
                    </label>
                </div>
                <small class="text-muted">Aktifkan jika produk memiliki pilihan warna, ukuran, dll. Stok akan dihitung otomatis dari total stok varian.</small>
            </div>

            <div id="variantsSection" style="display:none">
                <div class="card border-primary mb-3">
                    <div class="card-header bg-primary bg-opacity-10 d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-layer-group me-1"></i>Daftar Varian</span>
                        <button type="button" class="btn btn-sm btn-primary" onclick="addVariant()">
                            <i class="fas fa-plus me-1"></i>Tambah Varian
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="variantsList"></div>
                        <p id="variantsEmpty" class="text-muted text-center py-3">Belum ada varian. Klik "Tambah Varian" untuk menambahkan.</p>
                    </div>
                </div>
            </div>

            <hr>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Simpan Produk
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

let variantCount = 0;

function toggleVariants(cb) {
    document.getElementById('variantsSection').style.display = cb.checked ? 'block' : 'none';
}

function addVariant(data = {}) {
    const i = variantCount++;
    const list = document.getElementById('variantsList');
    document.getElementById('variantsEmpty').style.display = 'none';

    const div = document.createElement('div');
    div.className = 'border rounded p-3 mb-3 variant-item';
    div.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <strong>Varian #${i + 1}</strong>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVariant(this)"><i class="fas fa-trash"></i></button>
        </div>
        <div class="row g-2">
            <div class="col-md-4">
                <label class="form-label">Nama Varian <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="variants[${i}][name]" placeholder="cth: Merah, XL, Biru-L" required value="${data.name || ''}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Stok <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="variants[${i}][stock]" min="0" required value="${data.stock || 0}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tambahan Harga</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" name="variants[${i}][price_adjustment]" value="${data.price_adjustment || 0}" step="100">
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

function formatRupiah(value) {
    return 'Rp ' + Math.round(value).toLocaleString('id-ID');
}

function setupDiscountAutoApply() {
    const priceInput = document.getElementById('price');
    const discountInput = document.getElementById('discount_percent');
    const preview = document.getElementById('discountedPricePreview');
    const form = priceInput?.closest('form');

    if (!priceInput || !discountInput || !form || !preview) {
        return;
    }

    const getBasePrice = () => {
        const stored = priceInput.dataset.originalPrice;
        if (stored) {
            return parseFloat(stored);
        }
        const current = parseFloat(priceInput.value || '0');
        if (!isNaN(current) && current > 0) {
            priceInput.dataset.originalPrice = current.toString();
        }
        return current;
    };

    const applyDiscount = () => {
        const discount = parseFloat(discountInput.value || '0');
        const basePrice = getBasePrice();

        if (!basePrice || isNaN(basePrice) || discount <= 0) {
            if (priceInput.dataset.originalPrice) {
                priceInput.value = priceInput.dataset.originalPrice;
            }
            preview.style.display = 'none';
            preview.textContent = '';
            return;
        }

        const discounted = basePrice - (basePrice * (discount / 100));
        priceInput.value = Math.max(0, Math.round(discounted));
        preview.style.display = 'block';
        preview.textContent = `Harga setelah diskon: ${formatRupiah(discounted)} (harga akan tersimpan setelah dipotong)`;
    };

    priceInput.addEventListener('input', () => {
        if (!discountInput.value || parseFloat(discountInput.value || '0') <= 0) {
            priceInput.dataset.originalPrice = priceInput.value;
        }
    });

    discountInput.addEventListener('input', applyDiscount);

    form.addEventListener('submit', () => {
        const discount = parseFloat(discountInput.value || '0');
        if (!discount || discount <= 0) {
            return;
        }
        discountInput.value = '0';
    });
}

// Restore old input on validation error
@if(old('has_variants'))
document.getElementById('has_variants').checked = true;
toggleVariants(document.getElementById('has_variants'));
@php $oldVariants = old('variants', []); @endphp
@foreach($oldVariants as $v)
addVariant({{ json_encode($v) }});
@endforeach
@endif

document.addEventListener('DOMContentLoaded', setupDiscountAutoApply);
</script>
@endpush
@endsection
