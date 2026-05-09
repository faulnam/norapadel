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
                                <label for="category" class="form-label">Kategori Produk <span class="text-danger">*</span></label>
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
                                <label for="package_type" class="form-label">Tipe Paket</label>
                                <select class="form-select @error('package_type') is-invalid @enderror" id="package_type" name="package_type">
                                    <option value="single" {{ old('package_type', 'single') == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="bundle" {{ old('package_type') == 'bundle' ? 'selected' : '' }}>Bundle</option>
                                </select>
                                @error('package_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Badge "Best Seller" akan muncul otomatis jika produk terjual lebih dari 3 kali.</small>
                            </div>
                        </div>
                    </div>
                    
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

document.addEventListener('DOMContentLoaded', setupDiscountAutoApply);
</script>
@endpush
@endsection
