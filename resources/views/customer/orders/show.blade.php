@extends('layouts.app')

@section('title', 'Detail Pesanan')

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<style>
    body { padding-top: 0 !important; padding-bottom: 0 !important; }
    #mainNavbar, .mobile-bottom-nav, .footer { display: none !important; }
    #courierMap { height: 400px; border-radius: 1rem; }
</style>
@endpush

@section('content')
<!-- Navbar -->
<header class="sticky top-0 z-50 border-b border-black/6 bg-white/80 backdrop-blur-xl">
    <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-6 md:px-10 lg:px-12">
        <a href="{{ route('home') }}" class="text-xl font-semibold tracking-tight text-black">NoraPadel</a>
        <nav class="hidden items-center gap-8 md:flex">
            <a href="{{ route('home') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Home</a>
            <a href="{{ route('racket') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Racket</a>
            <a href="{{ route('shoes') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Shoes</a>
            <a href="{{ route('apparel') }}" class="border-b border-transparent text-sm text-black/80 transition duration-300 hover:border-black/30 hover:text-black">Accessories</a>
        </nav>
        <div class="flex items-center gap-3 text-black/80">
            <a href="{{ route('customer.orders.index') }}" class="transition duration-300 hover:text-black" title="Riwayat Pesanan">
                <i class="fas fa-history text-sm"></i>
            </a>
            <a href="{{ route('customer.profile.index') }}" class="transition duration-300 hover:text-black" title="Profile">
                <i class="fas fa-user text-sm"></i>
            </a>
            <a href="{{ route('customer.cart.index') }}" class="relative transition duration-300 hover:text-black" title="Keranjang">
                <i class="fas fa-shopping-bag text-sm"></i>
            </a>
        </div>
    </div>
</header>

<div class="min-h-screen bg-zinc-50 py-8">
    <div class="mx-auto max-w-7xl px-6 md:px-10 lg:px-12">
        <!-- Breadcrumb -->
        <div class="mb-6 text-sm text-zinc-500">
            <a href="{{ route('customer.orders.index') }}" class="hover:text-black">Pesanan</a>
            <span class="mx-2">/</span>
            <span class="text-black">{{ $order->order_number }}</span>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Status Card -->
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-black">{{ $order->order_number }}</h2>
                        @php
                            $statusColors = [
                                'pending_payment' => 'bg-amber-100 text-amber-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                                'ready_to_ship' => 'bg-indigo-100 text-indigo-800',
                                'shipped' => 'bg-purple-100 text-purple-800',
                                'delivered' => 'bg-teal-100 text-teal-800',
                                'completed' => 'bg-emerald-100 text-emerald-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                            $statusColor = $statusColors[$order->status] ?? 'bg-zinc-100 text-zinc-800';
                        @endphp
                        <span class="rounded-full px-3 py-1 text-xs font-medium {{ $statusColor }}">{{ $order->status_label }}</span>
                    </div>
                    <p class="text-sm text-zinc-500">{{ $order->created_at->format('d F Y, H:i') }}</p>
                </div>

                <!-- Tracking Timeline -->
                @if(in_array($order->status, ['processing', 'ready_to_ship', 'shipped', 'delivered', 'completed']))
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="mb-6 text-base font-semibold text-black">Status Pengiriman</h3>
                    
                    <!-- Horizontal Timeline -->
                    <div class="relative">
                        @php
                            $timeline = [
                                ['status' => 'processing', 'label' => 'Diproses', 'icon' => 'fa-box'],
                                ['status' => 'ready_to_ship', 'label' => 'Siap Pickup', 'icon' => 'fa-check-circle'],
                                ['status' => 'shipped', 'label' => 'Dikirim', 'icon' => 'fa-truck', 'photo' => $order->pickup_photo],
                                ['status' => 'delivered', 'label' => 'Sampai', 'icon' => 'fa-home', 'photo' => $order->delivery_photo],
                                ['status' => 'completed', 'label' => 'Selesai', 'icon' => 'fa-star'],
                            ];
                            $currentIndex = array_search($order->status, array_column($timeline, 'status'));
                        @endphp

                        <!-- Progress Line -->
                        <div class="absolute top-5 left-0 right-0 h-0.5 bg-zinc-200" style="margin: 0 2.5rem;"></div>
                        <div class="absolute top-5 left-0 h-0.5 bg-black transition-all duration-500" 
                             style="width: calc({{ ($currentIndex / (count($timeline) - 1)) * 100 }}% - {{ (1 - $currentIndex / (count($timeline) - 1)) * 2.5 }}rem); margin-left: 2.5rem;"></div>

                        <!-- Timeline Steps -->
                        <div class="relative flex justify-between">
                            @foreach($timeline as $index => $step)
                                @php
                                    $isActive = $index <= $currentIndex;
                                    $isCurrent = $index === $currentIndex;
                                    $hasPhoto = isset($step['photo']) && $step['photo'];
                                @endphp
                                <div class="flex flex-col items-center" style="flex: 1;">
                                    <div class="relative">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full {{ $isActive ? 'bg-black text-white' : 'bg-zinc-200 text-zinc-400' }} transition-all duration-300 {{ $isCurrent ? 'ring-4 ring-black/20' : '' }}">
                                            <i class="fas {{ $step['icon'] }} text-sm"></i>
                                        </div>
                                        @if($hasPhoto && $isActive)
                                            <button onclick="togglePhotoDropdown('photo-{{ $index }}')" class="absolute -top-1 -right-1 h-5 w-5 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs hover:bg-blue-600 transition">
                                                <i class="fas fa-camera"></i>
                                            </button>
                                        @endif
                                    </div>
                                    <p class="mt-3 text-xs font-medium text-center {{ $isActive ? 'text-black' : 'text-zinc-400' }}">{{ $step['label'] }}</p>
                                    
                                    @if($hasPhoto && $isActive)
                                        <div id="photo-{{ $index }}" class="hidden absolute top-16 z-10 mt-2 w-64 rounded-lg bg-white shadow-xl border border-zinc-200 p-3">
                                            <div class="flex items-center justify-between mb-2">
                                                <p class="text-xs font-semibold text-black">
                                                    {{ $step['status'] === 'shipped' ? 'Bukti Foto Pickup' : 'Bukti Foto Pengiriman' }}
                                                </p>
                                                <button onclick="togglePhotoDropdown('photo-{{ $index }}')" class="text-zinc-400 hover:text-black">
                                                    <i class="fas fa-times text-xs"></i>
                                                </button>
                                            </div>
                                            <img src="{{ asset('storage/' . $step['photo']) }}" 
                                                 class="w-full rounded-lg cursor-pointer hover:opacity-90 transition"
                                                 onclick="openPhotoModal('{{ asset('storage/' . $step['photo']) }}', '{{ $step['status'] === 'shipped' ? 'Bukti Foto Pickup' : 'Bukti Foto Pengiriman' }}')"
                                                 alt="Bukti Foto">
                                            <p class="text-xs text-zinc-500 mt-2 text-center">Klik untuk memperbesar</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Courier Tracking Map -->
                @if($order->courier_driver_name && in_array($order->status, ['shipped', 'delivered']))
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-base font-semibold text-black">Lacak Posisi Kurir</h3>
                    <div id="courierMap" class="mb-4"></div>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <div class="h-3 w-3 rounded-full bg-blue-500"></div>
                            <span class="text-zinc-600">Posisi Kurir</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="h-3 w-3 rounded-full bg-red-500"></div>
                            <span class="text-zinc-600">Tujuan Anda</span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Courier Info -->
                @if($order->courier_driver_name && in_array($order->status, ['ready_to_ship', 'shipped', 'delivered', 'completed']))
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-base font-semibold text-black">Informasi Kurir</h3>
                    <div class="flex items-center gap-4">
                        <img src="{{ $order->courier_driver_photo ?? 'https://ui-avatars.com/api/?name=' . urlencode($order->courier_driver_name) }}" 
                             class="h-16 w-16 rounded-full object-cover" alt="{{ $order->courier_driver_name }}">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <p class="font-semibold text-black">{{ $order->courier_driver_name }}</p>
                                @if($order->courier_driver_rating)
                                    <span class="flex items-center gap-1 text-xs text-amber-600">
                                        <i class="fas fa-star"></i>
                                        {{ number_format($order->courier_driver_rating, 1) }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-zinc-600">{{ $order->courier_name ?? 'Ekspedisi' }}</p>
                            @if($order->courier_driver_vehicle)
                                <p class="text-xs text-zinc-500 mt-1">
                                    <i class="fas fa-motorcycle mr-1"></i>
                                    {{ $order->courier_driver_vehicle }}
                                    @if($order->courier_driver_vehicle_number)
                                        - {{ $order->courier_driver_vehicle_number }}
                                    @endif
                                </p>
                            @endif
                        </div>
                        @if($order->courier_driver_phone)
                            <a href="tel:{{ $order->courier_driver_phone }}" 
                               class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 hover:bg-emerald-200">
                                <i class="fas fa-phone text-sm"></i>
                            </a>
                        @endif
                    </div>
                    @if($order->waybill_id)
                        <div class="mt-4 rounded-lg bg-zinc-50 p-3">
                            <p class="text-xs text-zinc-500 mb-1">Nomor Resi</p>
                            <p class="font-mono text-sm font-semibold text-black">{{ $order->waybill_id }}</p>
                        </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Items -->
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-base font-semibold text-black">Item Pesanan</h3>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-start gap-3">
                            <img src="{{ $item->product && $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/60' }}" 
                                 class="h-14 w-14 rounded-lg object-cover flex-shrink-0" alt="{{ $item->product_name }}">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-black line-clamp-2">{{ $item->product_name }}</p>
                                <p class="text-xs text-zinc-500 mt-1">{{ $item->formatted_price }} × {{ $item->quantity }}</p>
                                <p class="text-sm font-semibold text-black mt-1">{{ $item->formatted_subtotal }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-base font-semibold text-black">Alamat Pengiriman</h3>
                    <div class="space-y-2 text-sm">
                        <p class="font-medium text-black">{{ $order->shipping_name }}</p>
                        <p class="text-zinc-600">{{ $order->shipping_phone }}</p>
                        <p class="text-zinc-600">{{ $order->shipping_address }}</p>
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-base font-semibold text-black">Ringkasan Pembayaran</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-zinc-600">Subtotal</span>
                            <span class="text-black">{{ $order->formatted_subtotal }}</span>
                        </div>
                        @if($order->product_discount > 0)
                        <div class="flex justify-between text-emerald-600">
                            <span>Diskon Produk</span>
                            <span>-{{ $order->formatted_product_discount }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-zinc-600">Ongkir</span>
                            <span class="text-black">{{ $order->formatted_shipping_cost }}</span>
                        </div>
                        @if($order->shipping_discount > 0)
                        <div class="flex justify-between text-emerald-600">
                            <span>Diskon Ongkir</span>
                            <span>-{{ $order->formatted_shipping_discount }}</span>
                        </div>
                        @endif
                        <div class="border-t border-zinc-200 pt-2 mt-2 flex justify-between font-semibold text-base">
                            <span class="text-black">Total</span>
                            <span class="text-black">{{ $order->formatted_total }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                @if($order->canUploadPaymentProof())
                <a href="{{ route('customer.payment.select-gateway', $order) }}" 
                   class="block w-full rounded-xl bg-black py-3 text-center text-sm font-medium text-white transition hover:bg-black/90">
                    Bayar Sekarang
                </a>
                @endif

                <a href="{{ route('customer.orders.index') }}" 
                   class="block w-full rounded-xl border border-zinc-300 bg-white py-3 text-center text-sm font-medium text-black transition hover:bg-zinc-50">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="border-t border-black/10 bg-white py-10 text-sm text-zinc-500">
    <div class="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-12">
        <div class="text-center">
            <p>© {{ now()->year }} NoraPadel. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Photo Modal -->
<div id="photoModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm" onclick="closePhotoModal()">
    <div class="relative max-w-4xl w-full mx-4" onclick="event.stopPropagation()">
        <button onclick="closePhotoModal()" class="absolute -top-12 right-0 text-white hover:text-zinc-300 transition">
            <i class="fas fa-times text-2xl"></i>
        </button>
        <div class="bg-white rounded-2xl p-4">
            <h3 id="photoModalTitle" class="text-lg font-semibold text-black mb-4"></h3>
            <img id="photoModalImage" src="" class="w-full rounded-lg" alt="Bukti Foto">
        </div>
    </div>
</div>

<script>
// Toggle Photo Dropdown
function togglePhotoDropdown(id) {
    const dropdown = document.getElementById(id);
    const allDropdowns = document.querySelectorAll('[id^="photo-"]');
    
    // Close all other dropdowns
    allDropdowns.forEach(d => {
        if (d.id !== id) {
            d.classList.add('hidden');
        }
    });
    
    // Toggle current dropdown
    dropdown.classList.toggle('hidden');
}

// Open Photo Modal
function openPhotoModal(imageUrl, title) {
    document.getElementById('photoModalImage').src = imageUrl;
    document.getElementById('photoModalTitle').textContent = title;
    document.getElementById('photoModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// Close Photo Modal
function closePhotoModal() {
    document.getElementById('photoModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdowns = document.querySelectorAll('[id^="photo-"]');
    const isClickInside = event.target.closest('[id^="photo-"]') || event.target.closest('button[onclick^="togglePhotoDropdown"]');
    
    if (!isClickInside) {
        dropdowns.forEach(d => d.classList.add('hidden'));
    }
});
</script>

@if($order->courier_driver_name && in_array($order->status, ['shipped', 'delivered']))
<script>
// Initialize Map
const map = L.map('courierMap').setView([{{ $order->shipping_latitude ?? -6.2088 }}, {{ $order->shipping_longitude ?? 106.8456 }}], 14);

// Add Tile Layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors',
    maxZoom: 19
}).addTo(map);

// Destination Marker (Customer Address)
const destinationIcon = L.divIcon({
    html: '<div style="background: #ef4444; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.3);"><i class="fas fa-home" style="color: white; font-size: 14px;"></i></div>',
    className: '',
    iconSize: [32, 32],
    iconAnchor: [16, 16]
});

const destinationMarker = L.marker([{{ $order->shipping_latitude ?? -6.2088 }}, {{ $order->shipping_longitude ?? 106.8456 }}], {
    icon: destinationIcon
}).addTo(map);

destinationMarker.bindPopup('<b>Alamat Tujuan</b><br>{{ $order->shipping_address }}');

// Courier Marker (Moving)
const courierIcon = L.divIcon({
    html: '<div style="background: #3b82f6; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 3px solid white; box-shadow: 0 4px 12px rgba(59,130,246,0.5); animation: pulse 2s infinite;"><i class="fas fa-motorcycle" style="color: white; font-size: 16px;"></i></div><style>@keyframes pulse { 0%, 100% { box-shadow: 0 4px 12px rgba(59,130,246,0.5); } 50% { box-shadow: 0 4px 20px rgba(59,130,246,0.8); } }</style>',
    className: '',
    iconSize: [40, 40],
    iconAnchor: [20, 20]
});

// Simulate courier position (random nearby location for demo)
let courierLat = {{ $order->shipping_latitude ?? -6.2088 }} + (Math.random() - 0.5) * 0.02;
let courierLng = {{ $order->shipping_longitude ?? 106.8456 }} + (Math.random() - 0.5) * 0.02;

const courierMarker = L.marker([courierLat, courierLng], {
    icon: courierIcon
}).addTo(map);

courierMarker.bindPopup('<b>{{ $order->courier_driver_name }}</b><br>{{ $order->courier_name }}<br><small>Sedang menuju lokasi Anda</small>');

// Draw route line
const routeLine = L.polyline([
    [courierLat, courierLng],
    [{{ $order->shipping_latitude ?? -6.2088 }}, {{ $order->shipping_longitude ?? 106.8456 }}]
], {
    color: '#3b82f6',
    weight: 3,
    opacity: 0.6,
    dashArray: '10, 10'
}).addTo(map);

// Fit bounds to show both markers
const bounds = L.latLngBounds([
    [courierLat, courierLng],
    [{{ $order->shipping_latitude ?? -6.2088 }}, {{ $order->shipping_longitude ?? 106.8456 }}]
]);
map.fitBounds(bounds, { padding: [50, 50] });

// Simulate real-time courier movement (for demo)
let moveStep = 0;
const totalSteps = 100;
const startLat = courierLat;
const startLng = courierLng;
const endLat = {{ $order->shipping_latitude ?? -6.2088 }};
const endLng = {{ $order->shipping_longitude ?? 106.8456 }};

function moveCourier() {
    if (moveStep < totalSteps) {
        moveStep++;
        const progress = moveStep / totalSteps;
        const newLat = startLat + (endLat - startLat) * progress;
        const newLng = startLng + (endLng - startLng) * progress;
        
        courierMarker.setLatLng([newLat, newLng]);
        routeLine.setLatLngs([
            [newLat, newLng],
            [endLat, endLng]
        ]);
        
        // Update map view to follow courier
        const newBounds = L.latLngBounds([
            [newLat, newLng],
            [endLat, endLng]
        ]);
        map.fitBounds(newBounds, { padding: [50, 50], animate: true });
    }
}

// Move courier every 3 seconds (for demo)
setInterval(moveCourier, 3000);
</script>
@endif
@endsection
