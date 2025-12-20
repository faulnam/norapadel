@extends('layouts.app')

@section('title', 'Checkout - PATAH')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">
        <i class="fas fa-credit-card me-2 text-success"></i>Checkout
    </h3>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    
    <form action="{{ route('customer.checkout.process') }}" method="POST" id="checkoutForm">
        @csrf
        
        <div class="row">
            <div class="col-lg-7">
                <!-- Shipping Information -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-map-marker-alt me-2"></i>Informasi Pengiriman
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Penerima <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('shipping_name') is-invalid @enderror" 
                                   name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" required>
                            @error('shipping_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('shipping_phone') is-invalid @enderror" 
                                   name="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}" required>
                            @error('shipping_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                      name="shipping_address" rows="3" required>{{ old('shipping_address', auth()->user()->address) }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Sertakan nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota, dan kode pos.</small>
                        </div>

                        <!-- Koordinat Lokasi -->
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="fas fa-map-pin text-danger me-2"></i>Titik Koordinat Alamat
                                </h6>
                                <p class="small text-muted mb-3">
                                    Masukkan koordinat lokasi untuk menghitung ongkos kirim. 
                                    Anda bisa mendapatkan koordinat dari Google Maps.
                                </p>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Latitude <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('shipping_latitude') is-invalid @enderror" 
                                               name="shipping_latitude" id="shipping_latitude"
                                               value="{{ old('shipping_latitude') }}" 
                                               placeholder="Contoh: -7.250445" required>
                                        @error('shipping_latitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Longitude <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('shipping_longitude') is-invalid @enderror" 
                                               name="shipping_longitude" id="shipping_longitude"
                                               value="{{ old('shipping_longitude') }}" 
                                               placeholder="Contoh: 112.768845" required>
                                        @error('shipping_longitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <button type="button" class="btn btn-outline-success btn-sm" id="getLocation">
                                    <i class="fas fa-crosshairs me-1"></i>Gunakan Lokasi Saya
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm ms-2" id="calculateShipping">
                                    <i class="fas fa-calculator me-1"></i>Hitung Ongkir
                                </button>

                                <div class="alert alert-info mt-3 mb-0" id="shippingInfo" style="display: none;">
                                    <small>
                                        <i class="fas fa-truck me-1"></i>
                                        Estimasi jarak: <strong id="distanceText">-</strong> | 
                                        Ongkos kirim: <strong id="shippingCostText">-</strong>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="delivery_distance_minutes" id="delivery_distance_minutes" value="{{ old('delivery_distance_minutes', '0') }}">
                        <input type="hidden" name="shipping_cost" id="shipping_cost_input" value="{{ old('shipping_cost', '0') }}">

                        <!-- Jadwal Pengiriman -->
                        @php
                            $deliveryInfo = \App\Models\Order::calculateDeliveryDate();
                        @endphp
                        <div class="card bg-warning bg-opacity-10 border-warning mb-3">
                            <div class="card-body">
                                <h6 class="card-title text-warning">
                                    <i class="fas fa-clock me-2"></i>Jadwal Pengiriman
                                </h6>
                                <p class="mb-2">
                                    <i class="fas fa-info-circle text-info me-1"></i>
                                    Pesanan diantar pada jam <strong>10:00 - 16:00 WIB</strong>.
                                </p>
                                @if($deliveryInfo['is_today'])
                                    <div class="alert alert-success py-2 mb-0">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Pesanan Anda akan diantar <strong>HARI INI</strong> ({{ $deliveryInfo['formatted'] }})
                                    </div>
                                @else
                                    <div class="alert alert-info py-2 mb-0">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Pesanan Anda akan diantar <strong>BESOK</strong> ({{ $deliveryInfo['formatted'] }})
                                        <br>
                                        <small class="text-muted">Karena pemesanan di luar jam operasional (10:00 - 16:00)</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <input type="hidden" name="delivery_date" value="{{ $deliveryInfo['date'] }}">
                        <input type="hidden" name="delivery_time_slot" value="{{ $deliveryInfo['time_slot'] }}">
                        
                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" name="notes" rows="2" placeholder="Catatan untuk penjual...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Information -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-money-bill-wave me-2"></i>Informasi Pembayaran
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Metode Pembayaran</h6>
                            <p class="mb-2">Pembayaran dilakukan via transfer bank ke rekening berikut:</p>
                            <ul class="mb-0">
                                <li><strong>Bank BCA:</strong> 1234567890 a.n. PATAH Store</li>
                                <li><strong>Bank Mandiri:</strong> 0987654321 a.n. PATAH Store</li>
                            </ul>
                        </div>
                        <p class="text-muted small mb-0">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Setelah melakukan pembayaran, upload bukti transfer pada halaman detail pesanan.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5">
                <!-- Order Summary -->
                <div class="card position-sticky" style="top: 100px;">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-receipt me-2"></i>Ringkasan Pesanan
                    </div>
                    <div class="card-body">
                        @foreach($cartItems as $item)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                                <span>{{ $item->formatted_subtotal }}</span>
                            </div>
                        @endforeach
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ongkos Kirim</span>
                            <span id="displayShippingCost" class="text-muted">Belum dihitung</span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total</strong>
                            <strong class="h4 text-success" id="displayTotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                        </div>

                        <div class="alert alert-warning small" id="warningShipping">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Silakan masukkan koordinat dan hitung ongkir terlebih dahulu.
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg" id="submitBtn" disabled>
                                <i class="fas fa-check me-2"></i>Buat Pesanan
                            </button>
                            <a href="{{ route('customer.cart.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Kembali ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Koordinat Toko PATAH (Surabaya - sesuaikan dengan lokasi sebenarnya)
    const STORE_LAT = -7.250445;
    const STORE_LNG = 112.768845;
    const SUBTOTAL = {{ $subtotal }};

    // Get user's current location
    document.getElementById('getLocation').addEventListener('click', function() {
        if (navigator.geolocation) {
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Mengambil lokasi...';
            
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById('shipping_latitude').value = position.coords.latitude.toFixed(8);
                    document.getElementById('shipping_longitude').value = position.coords.longitude.toFixed(8);
                    document.getElementById('getLocation').disabled = false;
                    document.getElementById('getLocation').innerHTML = '<i class="fas fa-crosshairs me-1"></i>Gunakan Lokasi Saya';
                    
                    // Auto calculate shipping
                    calculateShipping();
                },
                function(error) {
                    alert('Gagal mengambil lokasi. Pastikan GPS aktif dan izinkan akses lokasi.');
                    document.getElementById('getLocation').disabled = false;
                    document.getElementById('getLocation').innerHTML = '<i class="fas fa-crosshairs me-1"></i>Gunakan Lokasi Saya';
                }
            );
        } else {
            alert('Browser tidak mendukung Geolocation.');
        }
    });

    // Calculate shipping
    document.getElementById('calculateShipping').addEventListener('click', calculateShipping);

    function calculateShipping() {
        const lat = parseFloat(document.getElementById('shipping_latitude').value);
        const lng = parseFloat(document.getElementById('shipping_longitude').value);

        if (isNaN(lat) || isNaN(lng)) {
            alert('Masukkan koordinat latitude dan longitude yang valid.');
            return;
        }

        // Calculate distance using Haversine formula
        const distance = haversineDistance(STORE_LAT, STORE_LNG, lat, lng);
        
        // Convert to minutes (assuming 30 km/h average speed)
        let minutes = Math.ceil((distance / 30) * 60);
        minutes = Math.max(10, minutes); // Minimum 10 minutes

        // Calculate shipping cost (10 minutes = Rp 10.000)
        const units = Math.ceil(minutes / 10);
        const shippingCost = units * 10000;

        // Update UI
        document.getElementById('distanceText').textContent = minutes + ' menit';
        document.getElementById('shippingCostText').textContent = formatRupiah(shippingCost);
        document.getElementById('shippingInfo').style.display = 'block';

        document.getElementById('displayShippingCost').textContent = formatRupiah(shippingCost);
        document.getElementById('displayShippingCost').classList.remove('text-muted');
        document.getElementById('displayTotal').textContent = formatRupiah(SUBTOTAL + shippingCost);

        // Set hidden inputs
        document.getElementById('delivery_distance_minutes').value = minutes;
        document.getElementById('shipping_cost_input').value = shippingCost;

        // Enable submit button
        document.getElementById('submitBtn').disabled = false;
        document.getElementById('warningShipping').style.display = 'none';
        
        console.log('Shipping calculated:', { minutes, shippingCost });
    }

    function haversineDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Earth's radius in km
        const dLat = toRad(lat2 - lat1);
        const dLon = toRad(lon2 - lon1);
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                  Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    function toRad(deg) {
        return deg * (Math.PI / 180);
    }

    function formatRupiah(number) {
        return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Form validation before submit
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const distanceMinutes = document.getElementById('delivery_distance_minutes').value;
        const shippingCost = document.getElementById('shipping_cost_input').value;
        
        if (!distanceMinutes || distanceMinutes == '0' || !shippingCost || shippingCost == '0') {
            e.preventDefault();
            alert('Silakan hitung ongkos kirim terlebih dahulu dengan menekan tombol "Hitung Ongkir".');
            return false;
        }
        
        console.log('Submitting form with:', {
            distanceMinutes,
            shippingCost,
            lat: document.getElementById('shipping_latitude').value,
            lng: document.getElementById('shipping_longitude').value
        });
    });
</script>
@endpush
@endsection
