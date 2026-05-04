@extends('layouts.app')

@section('title', 'Detail Pesanan')

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
<style>
    body { padding-top: 0 !important; padding-bottom: 0 !important; }
    #mainNavbar, .mobile-bottom-nav, .footer { display: none !important; }
    
    /* Fix z-index for navbar */
    header {
        position: sticky;
        top: 0;
        z-index: 9999 !important;
    }
    
    /* Map container with proper z-index */
    #courierMap { 
        height: 450px; 
        border-radius: 1rem;
        position: relative;
        z-index: 1;
    }
    
    /* Ensure Leaflet map doesn't override navbar */
    .leaflet-container {
        z-index: 1 !important;
    }
    
    .leaflet-pane {
        z-index: auto !important;
    }
    
    .leaflet-top,
    .leaflet-bottom {
        z-index: 10 !important;
    }
    
    /* Hide routing instructions */
    .leaflet-routing-container {
        display: none;
    }
    
    /* Pulse animation for courier marker */
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.9; }
    }
    
    .courier-marker {
        animation: pulse 2s ease-in-out infinite;
    }
</style>
@endpush

@section('content')
<!-- Navbar -->
<header class="fixed left-0 top-0 z-[9999] w-full border-b border-black/6 bg-white/80 backdrop-blur-xl md:sticky">
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

<div class="min-h-screen bg-zinc-50 py-8 pt-16 md:pt-0">
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
                        @php
                            $displayStatusLabel = $order->biteship_order_id
                                ? $order->shipment_stage_label
                                : $order->status_label;
                        @endphp
                        <span class="rounded-full px-3 py-1 text-xs font-medium {{ $statusColor }}">{{ $displayStatusLabel }}</span>
                    </div>
                    <p class="text-sm text-zinc-500">{{ $order->created_at->format('d F Y, H:i') }}</p>
                    
                    @if($order->status === 'pending_payment' && !$order->isExpired())
                        <div class="mt-4 rounded-xl bg-amber-50 border border-amber-200 p-4">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-clock text-amber-600 mt-0.5"></i>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-amber-900 mb-1">Segera Lakukan Pembayaran</p>
                                    <p class="text-xs text-amber-800 mb-2">Pesanan akan otomatis dibatalkan jika tidak dibayar dalam:</p>
                                    <div class="text-lg font-bold text-amber-900" id="expirationTimer">{{ $order->formatted_expiration_time }}</div>
                                </div>
                            </div>
                        </div>
                    @elseif($order->status === 'pending_payment' && $order->isExpired())
                        <div class="mt-4 rounded-xl bg-red-50 border border-red-200 p-4">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-exclamation-circle text-red-600 mt-0.5"></i>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-red-900 mb-1">Pesanan Expired</p>
                                    <p class="text-xs text-red-800">Pesanan ini akan segera dibatalkan karena tidak dibayar dalam 24 jam.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Tracking Timeline -->
                @if(in_array($order->status, ['processing', 'ready_to_ship', 'shipped', 'delivered', 'completed', 'cancelled']) || $order->biteship_order_id)
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                        <h3 class="text-base font-semibold text-black">Status Pengiriman</h3>
                        @if(!empty($biteshipDetail))
                            <button
                                type="button"
                                onclick="toggleOrderDetailPanel()"
                                class="inline-flex items-center gap-2 rounded-full bg-black px-4 py-2 text-xs font-semibold text-white transition hover:bg-black/85">
                                <i class="fas fa-file-alt"></i>
                                <span id="orderDetailToggleLabel">Lihat Detail</span>
                            </button>
                        @endif
                    </div>
                    
                    <!-- Horizontal Timeline -->
                    <div class="relative">
                        @php
                            $timeline = [
                                ['stage' => 'sedang_diproses', 'label' => 'Sedang Diproses', 'icon' => 'fa-cog'],
                                ['stage' => 'penjemputan', 'label' => 'Penjemputan', 'icon' => 'fa-box', 'photo' => $order->pickup_photo],
                                ['stage' => 'pengantaran', 'label' => 'Pengantaran', 'icon' => 'fa-truck', 'photo' => $order->delivery_photo],
                                ['stage' => 'pengembalian', 'label' => 'Pengembalian', 'icon' => 'fa-undo'],
                                ['stage' => 'ditahan', 'label' => 'Di Tahan', 'icon' => 'fa-pause-circle'],
                                ['stage' => 'selesai', 'label' => 'Selesai', 'icon' => 'fa-star'],
                            ];
                            $currentStage = $order->shipment_stage;
                            $stagePositions = array_flip(array_column($timeline, 'stage'));
                            $currentIndex = $stagePositions[$currentStage] ?? 0;
                            $progressRatio = $currentIndex / max((count($timeline) - 1), 1);
                        @endphp

                        <!-- Progress Line -->
                        <div class="absolute top-5 left-0 right-0 h-0.5 bg-zinc-200" style="margin: 0 2.5rem;"></div>
                        <div class="absolute top-5 left-0 h-0.5 bg-black transition-all duration-500" 
                             style="width: calc((100% - 5rem) * {{ $progressRatio }}); margin-left: 2.5rem;"></div>

                        <!-- Timeline Steps -->
                        <div class="relative flex justify-between">
                            @foreach($timeline as $index => $step)
                                @php
                                    $stepStage = $step['stage'];
                                    $isCurrent = $stepStage === $currentStage;
                                    $isPassed = $index < $currentIndex;

                                    // Kondisi khusus: saat status di tahan,
                                    // step Pengembalian harus dianggap sudah dilewati (hijau)
                                    if ($currentStage === 'ditahan' && $stepStage === 'pengembalian') {
                                        $isPassed = true;
                                    }

                                    // Step aktif selalu hitam (termasuk Pengembalian / Di Tahan)
                                    if ($isCurrent) {
                                        $isPassed = false;
                                    }

                                    $isReached = $isPassed || $isCurrent;
                                    $hasPhoto = isset($step['photo']) && $step['photo'];

                                    $stepCircleClass = $isCurrent
                                        ? 'bg-black text-white ring-4 ring-black/20'
                                        : ($isPassed
                                            ? 'bg-emerald-500 text-white'
                                            : 'bg-zinc-200 text-zinc-400');

                                    $stepLabelClass = $isCurrent
                                        ? 'text-black'
                                        : ($isPassed ? 'text-emerald-700' : 'text-zinc-400');
                                @endphp
                                <div class="flex flex-col items-center" style="flex: 1;">
                                    <div class="relative">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full {{ $stepCircleClass }} transition-all duration-300">
                                            <i class="fas {{ $step['icon'] }} text-sm"></i>
                                        </div>
                                        @if($hasPhoto && $isReached)
                                            <button onclick="togglePhotoDropdown('photo-{{ $index }}')" class="absolute -top-1 -right-1 h-5 w-5 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs hover:bg-blue-600 transition">
                                                <i class="fas fa-camera"></i>
                                            </button>
                                        @endif
                                    </div>
                                    <p class="mt-3 text-xs font-medium text-center {{ $stepLabelClass }}">{{ $step['label'] }}</p>
                                    
                                    @if($hasPhoto && $isReached)
                                        <div id="photo-{{ $index }}" class="hidden absolute top-16 z-10 mt-2 w-64 rounded-lg bg-white shadow-xl border border-zinc-200 p-3">
                                            <div class="flex items-center justify-between mb-2">
                                                <p class="text-xs font-semibold text-black">
                                                    {{ $step['stage'] === 'penjemputan' ? 'Bukti Foto Pickup' : 'Bukti Foto Pengiriman' }}
                                                </p>
                                                <button onclick="togglePhotoDropdown('photo-{{ $index }}')" class="text-zinc-400 hover:text-black">
                                                    <i class="fas fa-times text-xs"></i>
                                                </button>
                                            </div>
                                            <img src="{{ asset('storage/' . $step['photo']) }}" 
                                                 class="w-full rounded-lg cursor-pointer hover:opacity-90 transition"
                                                 onclick="openPhotoModal('{{ asset('storage/' . $step['photo']) }}', '{{ $step['stage'] === 'penjemputan' ? 'Bukti Foto Pickup' : 'Bukti Foto Pengiriman' }}')"
                                                 alt="Bukti Foto">
                                            <p class="text-xs text-zinc-500 mt-2 text-center">Klik untuk memperbesar</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-info-circle mt-0.5 text-amber-700"></i>
                            <div>
                                <p class="text-sm font-semibold text-amber-900">Informasi Pengembalian</p>
                                <p class="mt-1 text-xs text-amber-800">
                                    Jika ingin mengajukan pengembalian, silakan hubungi admin terlebih dahulu.
                                    Pengajuan pengembalian tidak bisa dilakukan langsung dari sistem.
                                </p>
                            </div>
                        </div>
                    </div>

                    @if(!empty($biteshipDetail))
                        <div id="orderDetailPanel" class="mt-6 hidden space-y-6">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 space-y-3 text-sm">
                                    <div><p class="text-xs text-zinc-500">Order ID</p><p class="font-mono font-semibold text-black">{{ $biteshipDetail['order_id'] ?? '-' }}</p></div>
                                    <div><p class="text-xs text-zinc-500">Reference ID</p><p class="font-semibold text-black">{{ $biteshipDetail['reference_id'] ?? '-' }}</p></div>
                                    <div><p class="text-xs text-zinc-500">No. Resi</p><p class="font-semibold text-black">{{ $biteshipDetail['waybill_id'] ?? '-' }}</p></div>
                                    <div><p class="text-xs text-zinc-500">Status</p><p class="font-semibold text-emerald-700">{{ $biteshipDetail['status_label'] ?? '-' }}</p></div>
                                    <div>
                                        <p class="text-xs text-zinc-500">Tanggal Order</p>
                                        <p class="font-semibold text-black">
                                            {{ $order->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y') }}<br>
                                            {{ $order->created_at->timezone('Asia/Jakarta')->format('H.i') }} WIB
                                        </p>
                                    </div>
                                </div>

                                <div class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 space-y-3 text-sm">
                                    <div><p class="text-xs text-zinc-500">Kurir</p><p class="font-semibold text-black">{{ $biteshipDetail['courier_name'] ?? '-' }}</p></div>
                                    <div><p class="text-xs text-zinc-500">Berat</p><p class="font-semibold text-black">{{ number_format((float) ($biteshipDetail['total_weight_kg'] ?? 0), 3, ',', '.') }} kg</p></div>
                                    <div><p class="text-xs text-zinc-500">Ongkos Kirim</p><p class="font-semibold text-black">{{ $biteshipDetail['shipping_cost'] ?? '-' }}</p></div>
                                    <div><p class="text-xs text-zinc-500">Nama Driver</p><p class="font-semibold text-black">{{ $biteshipDetail['driver_name'] ?? '-' }}</p></div>
                                    <div><p class="text-xs text-zinc-500">Nomor HP Driver</p><p class="font-semibold text-black">{{ $biteshipDetail['driver_phone'] ?? '-' }}</p></div>
                                    <div><p class="text-xs text-zinc-500">Plat Nomor</p><p class="font-semibold text-black">{{ $biteshipDetail['vehicle_number'] ?? '-' }}</p></div>
                                </div>
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="rounded-xl border border-zinc-200 p-4">
                                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Alamat Penjemputan</p>
                                    <p class="text-sm font-semibold text-black">{{ data_get($biteshipDetail, 'pickup.name', '-') }}</p>
                                    <p class="text-sm text-zinc-600">{{ data_get($biteshipDetail, 'pickup.phone', '-') }}</p>
                                    <p class="mt-1 text-sm text-zinc-600">{{ data_get($biteshipDetail, 'pickup.address', '-') }}</p>
                                </div>
                                <div class="rounded-xl border border-zinc-200 p-4">
                                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Alamat Penerima</p>
                                    <p class="text-sm font-semibold text-black">{{ data_get($biteshipDetail, 'receiver.name', '-') }}</p>
                                    <p class="text-sm text-zinc-600">{{ data_get($biteshipDetail, 'receiver.phone', '-') }}</p>
                                    <p class="mt-1 text-sm text-zinc-600">{{ data_get($biteshipDetail, 'receiver.address', '-') }}</p>
                                </div>
                            </div>

                            <div class="rounded-xl border border-zinc-200 p-4">
                                <p class="mb-4 text-xs font-semibold uppercase tracking-wide text-zinc-500">Informasi Paket</p>
                                <div class="space-y-4">
                                    @foreach(($biteshipDetail['items'] ?? []) as $idx => $itemDetail)
                                        <div class="rounded-lg bg-zinc-50 p-4 text-sm">
                                            <p class="font-semibold text-black">Nama Barang {{ $idx + 1 }}: {{ $itemDetail['name'] ?? '-' }}</p>
                                            <div class="mt-2 grid gap-2 md:grid-cols-2">
                                                <p class="text-zinc-600">Berat Barang {{ $idx + 1 }}: <span class="font-medium text-black">{{ number_format((float) ($itemDetail['weight_kg'] ?? 0), 3, ',', '.') }} kg</span></p>
                                                <p class="text-zinc-600">Kuantiti: <span class="font-medium text-black">{{ $itemDetail['quantity'] ?? 1 }}</span></p>
                                                <p class="text-zinc-600">Harga Barang: <span class="font-medium text-black">{{ $itemDetail['price'] ?? '-' }}</span></p>
                                                <p class="text-zinc-600">Dimensi: <span class="font-medium text-black">{{ $itemDetail['dimension'] ?? '-' }}</span></p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="rounded-xl border border-zinc-200 p-4 text-sm space-y-2">
                                <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Catatan</p>
                                <p class="font-medium text-black">{{ $biteshipDetail['note'] ?? '-' }}</p>
                            </div>

                            <div class="rounded-xl border border-zinc-200 p-4 text-sm">
                                <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-zinc-500">Rincian Tagihan</p>
                                <div class="flex items-center justify-between py-1">
                                    <span class="text-zinc-600">Ongkos Kirim</span>
                                    <span class="font-semibold text-black">{{ data_get($biteshipDetail, 'billing.shipping_cost', '-') }}</span>
                                </div>
                                <div class="mt-2 border-t border-zinc-200 pt-3 flex items-center justify-between">
                                    <span class="font-semibold text-black">Total Tagihan</span>
                                    <span class="font-semibold text-black">{{ data_get($biteshipDetail, 'billing.total', $order->formatted_total) }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @endif

                <!-- Courier Tracking Map -->
                @if($order->shipment_stage === 'pengantaran')
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-black">Lacak Posisi Kurir</h3>
                        <div class="flex items-center gap-2 text-xs text-emerald-600">
                            <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
                            <span class="font-medium">Live Tracking</span>
                        </div>
                    </div>
                    <div id="courierMap" class="relative" style="z-index: 1;">
                        <div class="absolute inset-0 flex items-center justify-center bg-zinc-100 rounded-xl z-10" id="mapLoader">
                            <div class="text-center">
                                <i class="fas fa-spinner fa-spin text-3xl text-zinc-400 mb-2"></i>
                                <p class="text-sm text-zinc-600">Memuat peta...</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tracking Info -->
                    <div class="mt-4 rounded-xl bg-zinc-50 p-4 border border-zinc-200">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="fas fa-clock text-zinc-600"></i>
                            <span class="text-sm font-semibold text-black">Estimasi Pengiriman</span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-zinc-600">Layanan</span>
                                <span class="text-sm font-semibold text-black">{{ $order->courier_service_name ?? 'Reguler' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-zinc-600">Estimasi Tiba</span>
                                <span class="text-sm font-semibold text-black">
                                    {{ $order->calculated_estimated_delivery }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($order->shipment_stage === 'selesai')
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-base font-semibold text-black">Bukti Pengiriman</h3>
                    @if($order->delivery_photo)
                        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 p-3">
                            <img
                                src="{{ asset('storage/' . $order->delivery_photo) }}"
                                class="w-full rounded-lg cursor-pointer hover:opacity-90 transition"
                                onclick="openPhotoModal('{{ asset('storage/' . $order->delivery_photo) }}', 'Bukti Foto Pengiriman')"
                                alt="Bukti Pengiriman">
                            <p class="mt-2 text-center text-xs text-zinc-500">Pesanan sudah selesai. Klik gambar untuk memperbesar.</p>
                        </div>
                    @else
                        <div class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 text-sm text-zinc-600">
                            Pesanan sudah selesai, tetapi bukti foto pengiriman belum tersedia.
                        </div>
                    @endif
                </div>
                @endif

                <!-- Courier Info -->
                @if(($order->courier_driver_name || $order->courier_id) && in_array($order->status, ['ready_to_ship', 'shipped', 'on_delivery', 'delivered', 'completed']))
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
                       <img src="{{ $item->product ? $item->product->image_url : 'https://via.placeholder.com/60' }}" 
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
                            <span class="text-black">{{ data_get($biteshipDetail, 'billing.shipping_cost', $order->formatted_shipping_cost) }}</span>
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
                    
                    <!-- Payment Method Info -->
                    @if($order->payment_method)
                        <div class="mt-4 pt-4 border-t border-zinc-200">
                            <p class="text-xs font-semibold text-zinc-500 mb-2">Metode Pembayaran</p>
                            
                            @if(strtolower($order->payment_method) === 'cod' || strtolower($order->payment_gateway) === 'cod')
                                <!-- COD Payment Info -->
                                <div class="rounded-xl bg-amber-50 border border-amber-200 p-4">
                                    <div class="flex items-start gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 flex-shrink-0">
                                            <i class="fas fa-hand-holding-usd text-amber-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-amber-900 mb-1">Cash on Delivery (COD)</p>
                                            <p class="text-xs text-amber-800 mb-2">Bayar saat barang diterima</p>
                                            <div class="space-y-1">
                                                <div class="flex items-center gap-2 text-xs text-amber-700">
                                                    <i class="fas fa-check-circle text-amber-600"></i>
                                                    <span>Siapkan uang pas <strong>{{ $order->formatted_total }}</strong></span>
                                                </div>
                                                <div class="flex items-center gap-2 text-xs text-amber-700">
                                                    <i class="fas fa-check-circle text-amber-600"></i>
                                                    <span>Bayar langsung ke kurir</span>
                                                </div>
                                                @if($order->status === 'processing' || $order->status === 'ready_to_ship')
                                                <div class="flex items-center gap-2 text-xs text-amber-700">
                                                    <i class="fas fa-clock text-amber-600"></i>
                                                    <span>Kurir akan menghubungi Anda</span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Non-COD Payment Info -->
                                <div class="rounded-xl bg-blue-50 border border-blue-200 p-4">
                                    <div class="flex items-start gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 flex-shrink-0">
                                            <i class="fas fa-credit-card text-blue-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-blue-900 mb-1">
                                                {{ ucfirst($order->payment_gateway ?? 'Online Payment') }}
                                            </p>
                                            <p class="text-xs text-blue-800 mb-2">
                                                @if($order->payment_channel)
                                                    {{ str_replace('_', ' ', ucwords($order->payment_channel, '_')) }}
                                                @else
                                                    Pembayaran Online
                                                @endif
                                            </p>
                                            <div class="space-y-1">
                                                @if($order->payment_status === 'paid')
                                                    <div class="flex items-center gap-2 text-xs text-emerald-700">
                                                        <i class="fas fa-check-circle text-emerald-600"></i>
                                                        <span>Pembayaran berhasil</span>
                                                    </div>
                                                    @if($order->paid_at)
                                                    <div class="flex items-center gap-2 text-xs text-blue-700">
                                                        <i class="fas fa-calendar-check text-blue-600"></i>
                                                        <span>{{ $order->paid_at->format('d M Y, H:i') }}</span>
                                                    </div>
                                                    @endif
                                                @elseif($order->payment_status === 'pending')
                                                    <div class="flex items-center gap-2 text-xs text-amber-700">
                                                        <i class="fas fa-clock text-amber-600"></i>
                                                        <span>Menunggu pembayaran</span>
                                                    </div>
                                                @elseif($order->payment_status === 'pending_verification')
                                                    <div class="flex items-center gap-2 text-xs text-blue-700">
                                                        <i class="fas fa-hourglass-half text-blue-600"></i>
                                                        <span>Menunggu verifikasi admin</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                @if($order->canUploadPaymentProof())
                <a href="{{ route('customer.payment.select-gateway', $order) }}" 
                   class="block w-full rounded-xl bg-black py-3 text-center text-sm font-medium text-white transition hover:bg-black/90">
                    Bayar Sekarang
                </a>
                @endif

                @if($order->canBeCancelled())
                <button type="button" onclick="showCancelModal()" 
                   class="block w-full rounded-xl border border-red-300 bg-white py-3 text-center text-sm font-medium text-red-600 transition hover:bg-red-50">
                    Batalkan Pesanan
                </button>
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

<!-- Cancel Order Modal -->
<div id="cancelModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" onclick="closeCancelModal(event)">
    <div class="relative mx-4 w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl" onclick="event.stopPropagation()">
        <div class="mb-6 flex justify-center">
            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-3xl text-red-600"></i>
            </div>
        </div>
        
        <h2 class="mb-4 text-center text-2xl font-bold text-black">Batalkan Pesanan?</h2>
        
        <div class="mb-6 space-y-3 text-center">
            <p class="text-sm text-zinc-600">Apakah Anda yakin ingin membatalkan pesanan ini?</p>
            
            @if($order->requiresRefund())
            <div class="rounded-xl bg-blue-50 p-4 text-left">
                <h3 class="mb-2 flex items-center gap-2 text-sm font-semibold text-blue-900">
                    <i class="fas fa-info-circle"></i>
                    Informasi Refund:
                </h3>
                <ul class="space-y-2 text-xs text-blue-800">
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-0.5 flex-shrink-0"></i>
                        <span>Dana sebesar <strong>{{ $order->formatted_total }}</strong> akan dikembalikan</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-0.5 flex-shrink-0"></i>
                        <span>Proses refund memakan waktu 1-3 hari kerja</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-0.5 flex-shrink-0"></i>
                        <span>Stok produk akan dikembalikan</span>
                    </li>
                </ul>
            </div>
            @else
            <div class="rounded-xl bg-zinc-100 p-4">
                <p class="text-xs text-zinc-600">Stok produk akan dikembalikan setelah pembatalan.</p>
            </div>
            @endif
        </div>
        
        <form action="{{ route('customer.orders.cancel', $order) }}" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-zinc-700 mb-2">Alasan Pembatalan (Opsional)</label>
                <textarea name="cancel_reason" rows="3" class="w-full rounded-xl border border-zinc-300 px-4 py-2 text-sm focus:border-black focus:outline-none focus:ring-2 focus:ring-black/20" placeholder="Berikan alasan pembatalan..."></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeCancelModal()" 
                        class="flex-1 rounded-xl border-2 border-zinc-300 bg-white px-6 py-3 text-sm font-semibold text-black transition hover:bg-zinc-50">
                    Tidak
                </button>
                <button type="submit" 
                        class="flex-1 rounded-xl bg-red-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-red-700">
                    Ya, Batalkan
                </button>
            </div>
        </form>
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

// Toggle Detail Pesanan panel
function toggleOrderDetailPanel() {
    const panel = document.getElementById('orderDetailPanel');
    const label = document.getElementById('orderDetailToggleLabel');

    if (!panel || !label) return;

    panel.classList.toggle('hidden');
    const isHidden = panel.classList.contains('hidden');
    label.textContent = isHidden ? 'Lihat Detail' : 'Sembunyikan Detail';
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

// Show Cancel Modal
function showCancelModal() {
    document.getElementById('cancelModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// Close Cancel Modal
function closeCancelModal(event) {
    if (!event || event.target.id === 'cancelModal') {
        document.getElementById('cancelModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdowns = document.querySelectorAll('[id^="photo-"]');
    const isClickInside = event.target.closest('[id^="photo-"]') || event.target.closest('button[onclick^="togglePhotoDropdown"]');
    
    if (!isClickInside) {
        dropdowns.forEach(d => d.classList.add('hidden'));
    }
});

// Expiration Timer
@if($order->status === 'pending_payment' && !$order->isExpired())
let expirationSeconds = {{ $order->expiration_time }};
const timerElement = document.getElementById('expirationTimer');

function updateTimer() {
    if (expirationSeconds <= 0) {
        timerElement.textContent = 'Expired';
        timerElement.classList.add('text-red-600');
        // Reload page to show expired state
        setTimeout(() => location.reload(), 2000);
        return;
    }
    
    const hours = Math.floor(expirationSeconds / 3600);
    const minutes = Math.floor((expirationSeconds % 3600) / 60);
    const seconds = expirationSeconds % 60;
    
    timerElement.textContent = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    
    expirationSeconds--;
}

// Update timer every second
setInterval(updateTimer, 1000);
updateTimer();
@endif
</script>

@if($order->shipment_stage === 'pengantaran')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
<script>
let map, courierMarker, destinationMarker, routingControl;
let courierPosition = null;
let updateInterval = null;
let routeCoordinates = [];
let currentRouteIndex = 0;

// Motor icon - Simple and clear
const motorIcon = L.divIcon({
    html: `
        <div class="courier-marker" style="position: relative; width: 50px; height: 50px;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 46px; height: 46px; background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); border-radius: 50%; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.5); display: flex; align-items: center; justify-content: center; border: 3px solid white;">
                <i class="fas fa-motorcycle" style="color: white; font-size: 24px;"></i>
            </div>
            <div style="position: absolute; bottom: -8px; left: 50%; transform: translateX(-50%); background: rgba(59, 130, 246, 0.3); width: 40px; height: 8px; border-radius: 50%; filter: blur(4px);"></div>
        </div>
    `,
    className: '',
    iconSize: [50, 50],
    iconAnchor: [25, 25]
});

const destinationIcon = L.divIcon({
    html: `
        <div style="position: relative; width: 40px; height: 50px;">
            <div style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 36px; height: 36px; background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%); border-radius: 50% 50% 50% 0; transform: translateX(-50%) rotate(-45deg); box-shadow: 0 3px 10px rgba(239, 68, 68, 0.4); border: 3px solid white;">
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(45deg); width: 12px; height: 12px; background: white; border-radius: 50%;"></div>
            </div>
        </div>
    `,
    className: '',
    iconSize: [40, 50],
    iconAnchor: [20, 40]
});

function initMap() {
    const destination = { 
        lat: {{ $order->shipping_latitude ?? -6.2088 }}, 
        lng: {{ $order->shipping_longitude ?? 106.8456 }} 
    };

    // Initialize map with proper z-index
    map = L.map('courierMap', {
        zoomControl: true,
        attributionControl: true
    }).setView([destination.lat, destination.lng], 14);
    
    // Set z-index for map container
    const mapContainer = document.getElementById('courierMap');
    if (mapContainer) {
        mapContainer.style.zIndex = '1';
    }

    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Add destination marker only
    destinationMarker = L.marker([destination.lat, destination.lng], { icon: destinationIcon }).addTo(map);
    destinationMarker.bindPopup(`
        <div style="font-family: system-ui; padding: 4px; max-width: 200px;">
            <div style="font-weight: 600; margin-bottom: 4px;">📍 Alamat Tujuan</div>
            <div style="font-size: 12px; color: #666; margin-bottom: 4px;">{{ $order->shipping_name }}</div>
            <div style="font-size: 11px; color: #888;">{{ $order->shipping_address }}</div>
        </div>
    `);

    // Hide loader
    document.getElementById('mapLoader').style.display = 'none';

    // Start tracking
    updateCourierLocation();
    updateInterval = setInterval(updateCourierLocation, 3000); // Update every 3 seconds
}

function updateCourierLocation() {
    fetch('{{ route('customer.orders.courier-location', $order) }}')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.location) {
                const newPosition = {
                    lat: parseFloat(data.location.latitude),
                    lng: parseFloat(data.location.longitude)
                };

                if (!courierMarker) {
                    // Create courier marker
                    courierMarker = L.marker([newPosition.lat, newPosition.lng], { 
                        icon: motorIcon,
                        zIndexOffset: 1000
                    }).addTo(map);

                    courierMarker.bindPopup(`
                        <div style="font-family: system-ui; padding: 6px;">
                            <div style="font-weight: 600; margin-bottom: 4px;">🏍️ ${data.courier.name || 'Kurir'}</div>
                            <div style="font-size: 12px; color: #666; margin-bottom: 2px;">{{ $order->courier_name ?? 'Ekspedisi' }}</div>
                            <div style="font-size: 10px; color: #10B981; margin-top: 4px;">● Sedang menuju lokasi Anda</div>
                        </div>
                    `);

                    // Create routing
                    createRoute(newPosition, {
                        lat: {{ $order->shipping_latitude ?? -6.2088 }},
                        lng: {{ $order->shipping_longitude ?? 106.8456 }}
                    });
                } else {
                    // Smooth animation to new position
                    animateMarker(courierMarker, newPosition);
                    
                    // Update route
                    if (routingControl) {
                        map.removeControl(routingControl);
                    }
                    createRoute(newPosition, {
                        lat: {{ $order->shipping_latitude ?? -6.2088 }},
                        lng: {{ $order->shipping_longitude ?? 106.8456 }}
                    });
                }

                courierPosition = newPosition;

                // Fit bounds to show all markers
                const bounds = L.latLngBounds([
                    [newPosition.lat, newPosition.lng],
                    [{{ $order->shipping_latitude ?? -6.2088 }}, {{ $order->shipping_longitude ?? 106.8456 }}]
                ]);
                map.fitBounds(bounds, { padding: [50, 50] });
            } else {
                console.log('Courier location not available:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching courier location:', error);
        });
}

function createRoute(origin, destination) {
    routingControl = L.Routing.control({
        waypoints: [
            L.latLng(origin.lat, origin.lng),
            L.latLng(destination.lat, destination.lng)
        ],
        routeWhileDragging: false,
        addWaypoints: false,
        draggableWaypoints: false,
        fitSelectedRoutes: false,
        showAlternatives: false,
        lineOptions: {
            styles: [{
                color: '#3B82F6',
                opacity: 0.8,
                weight: 5
            }]
        },
        createMarker: function() { return null; }, // Hide default markers
    }).addTo(map);

    // Get route info
    routingControl.on('routesfound', function(e) {
        const routes = e.routes;
        // Store route coordinates for smooth animation
        routeCoordinates = routes[0].coordinates;
    });
}

function animateMarker(marker, newPosition) {
    const startLatLng = marker.getLatLng();
    const endLatLng = L.latLng(newPosition.lat, newPosition.lng);
    
    let step = 0;
    const numSteps = 30;
    const delay = 100;

    function animate() {
        step++;
        if (step > numSteps) return;

        const progress = step / numSteps;
        const lat = startLatLng.lat + (endLatLng.lat - startLatLng.lat) * progress;
        const lng = startLatLng.lng + (endLatLng.lng - startLatLng.lng) * progress;

        marker.setLatLng([lat, lng]);

        if (step < numSteps) {
            setTimeout(animate, delay);
        }
    }

    animate();
}

// Initialize map when page loads
if (typeof L !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMap);
    } else {
        initMap();
    }
} else {
    window.addEventListener('load', initMap);
}

// Cleanup interval on page unload
window.addEventListener('beforeunload', () => {
    if (updateInterval) {
        clearInterval(updateInterval);
    }
});
</script>
@endif
@endsection
