<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\ShippingDiscount;
use App\Models\CourierLocation;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderCancelledNotification;
use App\Notifications\PaymentUploadedNotification;
use App\Services\BiteshipService;
use App\Services\WebPushService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;

class OrderController extends Controller
{
    /**
     * Show checkout page
     */
    public function checkout()
    {
        $cartItems = auth()->user()->cart()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart.index')
                ->with('error', 'Keranjang belanja kosong.');
        }

        // Calculate subtotal with product discounts (use model accessors to keep logic consistent)
        $subtotal = (float) $cartItems->sum('original_subtotal');
        $productDiscount = (float) $cartItems->sum('discount_amount');

        // Get active shipping discount
        $shippingDiscountInfo = ShippingDiscount::active()->first();

        return view('customer.orders.checkout', compact('cartItems', 'subtotal', 'productDiscount', 'shippingDiscountInfo'));
    }

    /**
     * Process checkout
     */
    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_latitude' => 'required|numeric',
            'shipping_longitude' => 'required|numeric',
            'delivery_distance_km' => 'nullable|numeric|min:0',
            'delivery_distance_minutes' => 'required|numeric|min:1',
            'shipping_cost' => 'required|numeric|min:0',
            'delivery_date' => 'required|date',
            'delivery_time_slot' => 'required|string',
            'courier_code' => 'required|string',
            'courier_name' => 'nullable|string',
            'courier_service_code' => 'required|string|max:50',
            'courier_service_name' => 'nullable|string',
            'estimated_delivery_date' => 'nullable|string',
            'notes' => 'nullable|string|max:500',
        ], [
            'shipping_name.required' => 'Nama penerima wajib diisi.',
            'shipping_phone.required' => 'Nomor telepon penerima wajib diisi.',
            'shipping_address.required' => 'Alamat pengiriman wajib diisi.',
            'shipping_latitude.required' => 'Koordinat latitude wajib diisi.',
            'shipping_latitude.numeric' => 'Koordinat latitude harus berupa angka.',
            'shipping_longitude.required' => 'Koordinat longitude wajib diisi.',
            'shipping_longitude.numeric' => 'Koordinat longitude harus berupa angka.',
            'delivery_distance_minutes.required' => 'Silakan hitung ongkir terlebih dahulu.',
            'shipping_cost.required' => 'Silakan hitung ongkir terlebih dahulu.',
            'delivery_date.required' => 'Tanggal pengiriman wajib diisi.',
            'delivery_time_slot.required' => 'Waktu pengiriman wajib diisi.',
            'courier_service_code.required_with' => 'Silakan pilih layanan ongkir dari ekspedisi terlebih dahulu.',
        ]);

        $cartItems = auth()->user()->cart()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart.index')
                ->with('error', 'Keranjang belanja kosong.');
        }

        // Check stock availability
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', "Stok {$item->product->name} tidak mencukupi.");
            }
        }

        try {
            DB::beginTransaction();

            // Calculate subtotal with product discounts (use model accessors to keep logic consistent)
            $subtotal = (float) $cartItems->sum('original_subtotal');
            $productDiscount = (float) $cartItems->sum('discount_amount');

            $shippingCost = max(0, (int) round((float) $validated['shipping_cost']));
            $netSubtotal = max(0, (int) round($subtotal - $productDiscount));
            
            // Calculate shipping discount
            $shippingDiscount = 0;
            $activeShippingDiscount = ShippingDiscount::active()->first();
            if ($activeShippingDiscount) {
                $shippingDiscount = $activeShippingDiscount->calculateDiscount($shippingCost, $netSubtotal);
            }

            // Guard tambahan agar diskon ongkir tidak pernah melebihi ongkir.
            $shippingDiscount = max(0, min($shippingCost, (int) round((float) $shippingDiscount)));

            $shippingPaid = max(0, $shippingCost - $shippingDiscount);

            // Calculate final total
            $total = max(0, (int) round($netSubtotal + $shippingPaid));

            $deliveryNotes = null;
            if (!empty($validated['courier_service_code'])) {
                $selectedServiceCode = strtolower(trim((string) $validated['courier_service_code']));
                $deliveryNotes = 'biteship_courier_service_code=' . $selectedServiceCode;
            }

            $orderPayload = [
                'user_id' => auth()->id(),
                'subtotal' => $subtotal,
                'product_discount' => $productDiscount,
                'shipping_discount' => $shippingDiscount,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'ongkir_asli' => $shippingCost,
                'diskon_ongkir' => $shippingDiscount,
                'ongkir_dibayar' => $shippingPaid,
                'total_pembayaran' => $total,
                'shipping_name' => $validated['shipping_name'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_postal_code' => '61219',
                'shipping_latitude' => $validated['shipping_latitude'],
                'shipping_longitude' => $validated['shipping_longitude'],
                'delivery_distance_km' => $validated['delivery_distance_km'] ?? null,
                'delivery_distance_minutes' => $validated['delivery_distance_minutes'],
                'delivery_date' => $validated['delivery_date'],
                'delivery_time_slot' => $validated['delivery_time_slot'],
                'courier_code' => $validated['courier_code'] ?? null,
                'courier_name' => $validated['courier_name'] ?? null,
                'courier_service_name' => $validated['courier_service_name'] ?? null,
                'estimated_delivery_date' => $validated['estimated_delivery_date'] ?? null,
                'delivery_notes' => $deliveryNotes,
                'notes' => $validated['notes'],
                'status' => Order::STATUS_PENDING_PAYMENT,
                'payment_status' => Order::PAYMENT_UNPAID,
            ];

            // Create order
            $order = Order::create($orderPayload);

            // Create order items and reduce stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_price' => $item->product->discounted_price, // Use discounted price
                    'quantity' => $item->quantity,
                    'subtotal' => $item->product->discounted_price * $item->quantity,
                ]);

                // Reduce stock
                $item->product->reduceStock($item->quantity);
            }

            // Saat checkout pending payment: buat Draft Order di Biteship (bukan shipment).
            // Shipment tetap dibuat setelah payment sukses oleh observer.
            if (empty($order->biteship_draft_order_id)) {
                try {
                    /** @var BiteshipService $biteship */
                    $biteship = app(BiteshipService::class);

                    $result = $biteship->createDraftOrderFromOrder(
                        $order,
                        $validated['courier_service_code'] ?? null
                    );

                    if ($result['success'] ?? false) {
                        $data = $result['data'] ?? [];

                        $payload = array_filter([
                            'biteship_draft_order_id' => $data['biteship_draft_order_id'] ?? null,
                            'delivery_notes' => trim((string) (($order->delivery_notes ? $order->delivery_notes . "\n" : '') . 'biteship_sync_status=draft_synced')),
                        ], fn ($value) => $value !== null && $value !== '');

                        if (!empty($payload)) {
                            $order->fill($payload)->saveQuietly();
                        }

                        \Log::info('Create Biteship draft order saat checkout sukses (controller)', [
                            'order_number' => $order->order_number,
                            'biteship_draft_order_id' => $data['biteship_draft_order_id'] ?? null,
                        ]);
                    } else {
                        $errorMessage = $result['message'] ?? 'Unknown error';

                        $order->fill([
                            'delivery_notes' => trim((string) (($order->delivery_notes ? $order->delivery_notes . "\n" : '') . 'biteship_sync_status=failed_to_sync_biteship_draft; reason=' . $errorMessage)),
                        ])->saveQuietly();

                        \Log::warning('Create Biteship draft order saat checkout gagal (controller)', [
                            'order_number' => $order->order_number,
                            'message' => $errorMessage,
                        ]);

                        throw new \RuntimeException('Gagal sinkron draft order ke Biteship: ' . $errorMessage);
                    }
                } catch (\Throwable $e) {
                    $order->fill([
                        'delivery_notes' => trim((string) (($order->delivery_notes ? $order->delivery_notes . "\n" : '') . 'biteship_sync_status=failed_to_sync_biteship_draft; reason=' . $e->getMessage())),
                    ])->saveQuietly();

                    \Log::error('Create Biteship draft order saat checkout exception (controller)', [
                        'order_number' => $order->order_number,
                        'error' => $e->getMessage(),
                    ]);

                    throw new \RuntimeException('Checkout dibatalkan karena sinkronisasi Biteship gagal: ' . $e->getMessage());
                }
            }

            // Clear cart
            Cart::where('user_id', auth()->id())->delete();

            // Notify admin
            $admins = User::where('role', 'admin')->get();
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new NewOrderNotification($order));
            }

            // Notify customer
            auth()->user()->notify(new NewOrderNotification($order));

            DB::commit();

            // Redirect to select payment gateway
            return redirect()->route('customer.payment.select-gateway', $order)
                ->with('success', 'Pesanan berhasil dibuat. Silakan pilih metode pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Checkout Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show orders list
     */
    public function index(Request $request)
    {
        $query = Order::where('user_id', auth()->id())->with('items');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Show order detail
     */
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $biteshipRawDetail = null;
        if (!empty($order->biteship_order_id)) {
            try {
                $biteshipRawDetail = $this->syncOrderStatusFromBiteship($order);
                $order->refresh();
            } catch (\Throwable $e) {
                \Log::warning('Sinkronisasi Biteship dilewati karena error saat membuka detail order customer', [
                    'order_number' => $order->order_number,
                    'biteship_order_id' => $order->biteship_order_id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $order->load('items.product');

        $biteshipDetail = null;
        if (!empty($order->biteship_order_id)) {
            $biteshipDetail = $this->buildBiteshipDetailPayload($order, $biteshipRawDetail ?? []);
        }

        return view('customer.orders.show', compact('order', 'biteshipDetail'));
    }

        /**
         * Sinkronisasi status order dari Biteship saat detail dibuka.
         * Fallback ini membantu jika webhook terlambat masuk.
         */
        protected function syncOrderStatusFromBiteship(Order $order): ?array
        {
            if (empty($order->biteship_order_id)) {
                return null;
            }

            try {
                /** @var BiteshipService $biteship */
                $biteship = app(BiteshipService::class);
                $result = $biteship->getOrder((string) $order->biteship_order_id);

                if (!($result['success'] ?? false)) {
                    return null;
                }

                $data = $result['data'] ?? [];
                $courier = $data['courier'] ?? [];

                $trackingStatus = strtolower((string) (
                    $data['courier_tracking_status']
                    ?? $data['status']
                    ?? ($courier['status'] ?? '')
                ));

                $updates = [];

                if ($trackingStatus !== '') {
                    $updates['biteship_tracking_status'] = $trackingStatus;

                    $shipmentStage = Order::normalizeBiteshipStage($trackingStatus);
                    if (!empty($shipmentStage)) {
                        $updates['biteship_status_stage'] = $shipmentStage;
                    }

                    $mappedOrderStatus = Order::mapBiteshipTrackingToOrderStatus($trackingStatus);
                    if (!empty($mappedOrderStatus)) {
                        $updates['status'] = $mappedOrderStatus;
                    }
                }

                if (!empty($courier['waybill_id'])) {
                    $updates['waybill_id'] = $courier['waybill_id'];

                    if (Schema::hasColumn('orders', 'awb_number')) {
                        $updates['awb_number'] = $courier['waybill_id'];
                    }
                }

                if (!empty($data['label_url'])) {
                    $updates['label_url'] = $data['label_url'];
                }

                if ($trackingStatus === 'picked') {
                    $updates['picked_up_at'] = $order->picked_up_at ?? now();
                }

                if ($trackingStatus === 'dropping_off') {
                    $updates['on_delivery_at'] = $order->on_delivery_at ?? now();
                }

                if ($trackingStatus === 'delivered') {
                    $updates['delivered_at'] = $order->delivered_at ?? now();
                }

                if (in_array($trackingStatus, ['completed', 'done'], true)) {
                    $updates['completed_at'] = $order->completed_at ?? now();
                }

                if (!empty($updates)) {
                    $order->fill($updates)->save();
                }

                return $data;
            } catch (\Throwable $e) {
                \Log::warning('Sync status Biteship saat buka detail gagal', [
                    'order_number' => $order->order_number,
                    'biteship_order_id' => $order->biteship_order_id,
                    'error' => $e->getMessage(),
                ]);

                return null;
            }
        }

        /**
         * Siapkan payload detail pengiriman untuk UI customer.
         */
        protected function buildBiteshipDetailPayload(Order $order, array $raw): array
        {
            $courier = data_get($raw, 'courier', []);
            $origin = data_get($raw, 'origin', []);
            $destination = data_get($raw, 'destination', []);
            $rawItems = data_get($raw, 'items', []);

            $normalizedItems = collect(!empty($rawItems) ? $rawItems : $order->items)->map(function ($item, $index) {
                $isArray = is_array($item);

                $name = (string) ($isArray
                    ? (data_get($item, 'name') ?? data_get($item, 'description') ?? 'Barang #' . ($index + 1))
                    : ($item->product_name ?? ('Barang #' . ($index + 1))));

                $quantity = (int) ($isArray
                    ? (data_get($item, 'quantity') ?? 1)
                    : ($item->quantity ?? 1));

                $weightGram = (float) ($isArray
                    ? (data_get($item, 'weight') ?? 0)
                    : (($item->product->weight ?? 0) * max(1, $quantity)));

                $weightKg = $weightGram > 0 ? round($weightGram / 1000, 3) : null;

                $value = (float) ($isArray
                    ? (data_get($item, 'value') ?? 0)
                    : ($item->product_price ?? 0));

                $length = (string) (data_get($item, 'length') ?? 30);
                $width = (string) (data_get($item, 'width') ?? 25);
                $height = (string) (data_get($item, 'height') ?? 3);

                return [
                    'name' => $name,
                    'weight_kg' => $weightKg,
                    'quantity' => $quantity,
                    'price' => $this->formatRupiah($value),
                    'dimension' => $length . ' x ' . $width . ' x ' . $height . ' cm',
                ];
            })->values()->all();

            $totalWeightKg = collect($normalizedItems)
                ->sum(fn ($item) => (float) ($item['weight_kg'] ?? 0));

            $trackingStatus = strtolower((string) (
                data_get($raw, 'courier_tracking_status')
                ?? data_get($raw, 'status')
                ?? data_get($courier, 'status')
                ?? ''
            ));

            $biteshipShippingCost = $this->extractNumericValue([
                data_get($raw, 'shipping.price'),
                data_get($raw, 'shipping.cost'),
                data_get($raw, 'shipping_cost'),
                data_get($raw, 'price'),
                data_get($raw, 'amount'),
                data_get($courier, 'price'),
                data_get($courier, 'cost'),
            ]);

            $shippingCostValue = $biteshipShippingCost ?? (float) $order->shipping_cost;
            $billingTotalValue = (float) $order->subtotal
                - (float) ($order->product_discount ?? 0)
                - (float) ($order->shipping_discount ?? 0)
                + $shippingCostValue;

            return [
                'order_id' => (string) (
                    data_get($raw, 'id')
                    ?? data_get($raw, 'order_id')
                    ?? $order->biteship_order_id
                ),
                'reference_id' => (string) (
                    data_get($raw, 'reference_id')
                    ?? $order->order_number
                ),
                'waybill_id' => (string) (
                    data_get($courier, 'waybill_id')
                    ?? $order->waybill_id
                    ?? '-'
                ),
                'status_label' => $this->formatBiteshipDeliveryStatusLabel($trackingStatus, $order),
                'courier_name' => trim((string) (
                    data_get($courier, 'company_name')
                    ?? data_get($courier, 'company')
                    ?? $order->courier_name
                ) . ' ' . (string) (
                    data_get($courier, 'type')
                    ?? data_get($raw, 'courier_type')
                    ?? $order->courier_service_name
                )),
                'total_weight_kg' => round($totalWeightKg, 3),
                'shipping_cost' => $this->formatRupiah($shippingCostValue),
                'driver_name' => (string) (
                    data_get($courier, 'name')
                    ?? $order->courier_driver_name
                    ?? '-'
                ),
                'driver_phone' => (string) (
                    data_get($courier, 'phone')
                    ?? $order->courier_driver_phone
                    ?? '-'
                ),
                'vehicle_number' => (string) (
                    data_get($courier, 'vehicle_number')
                    ?? $order->courier_driver_vehicle_number
                    ?? '-'
                ),
                'tracking_url' => (string) (
                    data_get($courier, 'link')
                    ?? data_get($raw, 'tracking_link')
                    ?? ''
                ),
                'label_url' => (string) (
                    data_get($raw, 'label_url')
                    ?? $order->label_url
                    ?? ''
                ),
                'pickup' => [
                    'name' => (string) (
                        data_get($origin, 'contact_name')
                        ?? config('branding.name', 'NoraPadel')
                    ),
                    'phone' => (string) (
                        data_get($origin, 'contact_phone')
                        ?? config('branding.phone', '-')
                    ),
                    'address' => (string) (
                        data_get($origin, 'address')
                        ?? config('branding.address', '-')
                    ),
                ],
                'receiver' => [
                    'name' => (string) (
                        data_get($destination, 'contact_name')
                        ?? $order->shipping_name
                    ),
                    'phone' => (string) (
                        data_get($destination, 'contact_phone')
                        ?? $order->shipping_phone
                    ),
                    'address' => (string) (
                        data_get($destination, 'address')
                        ?? $order->shipping_address
                    ),
                ],
                'items' => $normalizedItems,
                'note' => (string) (
                    data_get($raw, 'order_note')
                    ?? ($order->notes ?: '-')
                ),
                'billing' => [
                    'shipping_cost' => $this->formatRupiah($shippingCostValue),
                    'total' => $this->formatRupiah($billingTotalValue),
                ],
            ];
        }

        protected function extractNumericValue(array $candidates): ?float
        {
            foreach ($candidates as $candidate) {
                if ($candidate === null || $candidate === '') {
                    continue;
                }

                if (is_numeric($candidate)) {
                    return (float) $candidate;
                }

                $normalized = preg_replace('/[^0-9\.,]/', '', (string) $candidate);
                if ($normalized === null || $normalized === '') {
                    continue;
                }

                // Handle format 73.000 or 73,000 etc.
                $normalized = str_replace('.', '', $normalized);
                $normalized = str_replace(',', '.', $normalized);

                if (is_numeric($normalized)) {
                    return (float) $normalized;
                }
            }

            return null;
        }

        protected function formatRupiah(float $amount): string
        {
            return 'Rp' . number_format($amount, 0, ',', '.');
        }

        protected function formatBiteshipDeliveryStatusLabel(string $trackingStatus, Order $order): string
        {
            if (in_array($trackingStatus, ['delivered', 'done', 'completed'], true)) {
                return 'Berhasil Dikirim';
            }

            return $order->status_label;
        }

    /**
     * Show receipt/invoice for order
     */
    public function receipt(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Only show receipt for paid orders
        if (!in_array($order->status, [
            Order::STATUS_PROCESSING,
            Order::STATUS_READY_TO_SHIP,
            Order::STATUS_SHIPPED,
            Order::STATUS_ASSIGNED,
            Order::STATUS_PICKED_UP,
            Order::STATUS_ON_DELIVERY,
            Order::STATUS_DELIVERED,
            Order::STATUS_COMPLETED
        ])) {
            return back()->with('error', 'Resi belum tersedia. Silakan lakukan pembayaran terlebih dahulu.');
        }

        $order->load('items.product', 'user');

        return view('customer.orders.receipt', compact('order'));
    }

    /**
     * Upload payment proof
     */
    public function uploadPayment(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$order->canUploadPaymentProof()) {
            return back()->with('error', 'Tidak dapat mengupload bukti pembayaran untuk pesanan ini.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'payment_proof.required' => 'Bukti pembayaran wajib diupload.',
            'payment_proof.image' => 'File harus berupa gambar.',
            'payment_proof.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $path = $request->file('payment_proof')->store('payments', 'public');

        $order->update([
            'payment_proof' => $path,
            'payment_status' => Order::PAYMENT_PENDING,
        ]);

        // Notify admin (database notification)
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new PaymentUploadedNotification($order));

        // Send push notification to admins
        try {
            $webPush = app(WebPushService::class);
            $webPush->sendToAdmins(
                '💳 Bukti Pembayaran Baru',
                "Customer {$order->user->name} mengupload bukti pembayaran untuk pesanan #{$order->order_number}",
                route('admin.orders.show', $order),
                'payment_uploaded'
            );
        } catch (\Exception $e) {
            \Log::error('Push notification failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }

    /**
     * Cancel order
     * Customer can only cancel when status is 'processing'
     * Refund requires admin approval - tidak otomatis
     */
    public function cancel(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$order->canBeCancelled()) {
            if ($order->status === Order::STATUS_CANCELLED) {
                return back()->with('error', 'Pesanan sudah dibatalkan.');
            }
            if ($order->status === Order::STATUS_COMPLETED) {
                return back()->with('error', 'Pesanan sudah selesai.');
            }
            if (in_array($order->status, [Order::STATUS_READY_TO_SHIP, Order::STATUS_SHIPPED, Order::STATUS_DELIVERED])) {
                return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah dalam proses pengiriman.');
            }
            if ($order->status === Order::STATUS_PENDING_PAYMENT) {
                return back()->with('error', 'Pesanan dengan status menunggu pembayaran akan otomatis dibatalkan setelah 24 jam.');
            }
            return back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }

        $reason = $request->input('cancel_reason', 'Dibatalkan oleh customer');

        // Cancel di Biteship jika ada
        $biteshipCancelStatus = null;
        $biteshipCancelStage  = null;
        $biteshipCancelAuditNote = null;
        $biteshipTargetId = !empty($order->biteship_order_id)
            ? (string) $order->biteship_order_id
            : (!empty($order->biteship_draft_order_id) ? (string) $order->biteship_draft_order_id : '');

        if ($biteshipTargetId !== '') {
            $biteship = app(BiteshipService::class);
            $cancelBiteship = $biteship->cancelOrder($biteshipTargetId, $reason);

            if (!($cancelBiteship['success'] ?? false)) {
                return back()->with('error', 'Pesanan belum dapat dibatalkan karena gagal sinkron ke Biteship. ' . ($cancelBiteship['message'] ?? ''));
            }

            $biteshipCancelStatus = strtolower(trim((string) ($cancelBiteship['status'] ?? data_get($cancelBiteship, 'data.status') ?? 'cancel_requested')));
            if ($biteshipCancelStatus === '') $biteshipCancelStatus = 'cancel_requested';
            $biteshipCancelStage = Order::normalizeBiteshipStage($biteshipCancelStatus) ?: Order::BITESHIP_STAGE_RETURN;
            $biteshipCancelAuditNote = 'biteship_cancel_status=' . $biteshipCancelStatus . '; reason=' . trim((string) $reason);
        }

        try {
            DB::beginTransaction();

            // Restore stock
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->restoreStock($item->quantity);
                }
            }

            // Cancel order
            $order->cancelOrder($reason);

            // Jika sudah bayar via gateway, set refund PENDING (butuh approval admin)
            $needsRefund = $order->requiresRefund();
            if ($needsRefund) {
                $order->update([
                    'refund_status' => Order::REFUND_PENDING,
                    'refund_amount' => $order->total,
                    'refund_at'     => now(),
                    'refund_note'   => 'Pembatalan oleh customer: ' . $reason,
                ]);
            }

            if ($biteshipCancelAuditNote !== null) {
                $order->fill([
                    'biteship_tracking_status' => $biteshipCancelStatus,
                    'biteship_status_stage'    => $biteshipCancelStage,
                    'delivery_notes'           => trim((string) (($order->delivery_notes ? $order->delivery_notes . "\n" : '') . $biteshipCancelAuditNote)),
                ])->saveQuietly();
            }

            // Notify admins
            $admins = User::where('role', 'admin')->get();
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new OrderCancelledNotification($order, $reason, $needsRefund ? (float) $order->total : null));
            }
            auth()->user()->notify(new OrderCancelledNotification($order, $reason, $needsRefund ? (float) $order->total : null));

            try {
                $webPush = app(WebPushService::class);
                $pushMsg = "Pesanan #{$order->order_number} dari {$order->user->name} telah dibatalkan";
                if ($needsRefund) $pushMsg .= ' - Menunggu proses refund: ' . $order->formatted_total;
                $webPush->sendToAdmins('❌ Pesanan Dibatalkan', $pushMsg, route('admin.orders.show', $order), 'order_cancelled');
            } catch (\Exception $e) {
                \Log::error('Push notification failed: ' . $e->getMessage());
            }

            DB::commit();

            $message = 'Pesanan berhasil dibatalkan.';
            if ($needsRefund) {
                $message .= ' Pengembalian dana sebesar ' . $order->formatted_total . ' akan diproses oleh admin dalam 1-3 hari kerja.';
            }

            return redirect()->route('customer.orders.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Cancel order error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membatalkan pesanan.');
        }
    }

    /**
     * Customer request refund setelah barang diterima
     * Harus japri admin dulu - ini hanya submit request, bukan proses refund langsung
     */
    public function requestRefund(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Hanya bisa request refund jika order sudah delivered atau completed
        if (!in_array($order->status, [Order::STATUS_DELIVERED, Order::STATUS_COMPLETED])) {
            return back()->with('error', 'Refund hanya bisa diajukan setelah barang diterima.');
        }

        // Cek apakah sudah ada refund request sebelumnya
        if ($order->refund_status) {
            return back()->with('error', 'Permintaan refund sudah pernah diajukan. Status: ' . $order->refund_status);
        }

        // Cek apakah sudah bayar
        if ($order->payment_status !== Order::PAYMENT_PAID) {
            return back()->with('error', 'Refund hanya bisa diajukan untuk pesanan yang sudah dibayar.');
        }

        $request->validate([
            'refund_reason' => 'required|string|min:20|max:500',
        ], [
            'refund_reason.required' => 'Alasan refund wajib diisi.',
            'refund_reason.min'      => 'Alasan refund minimal 20 karakter.',
        ]);

        // Set refund request - PENDING, butuh approval admin
        $order->update([
            'refund_status' => Order::REFUND_PENDING,
            'refund_amount' => $order->total,
            'refund_at'     => now(),
            'refund_note'   => $request->refund_reason,
        ]);

        // Notify admins
        $admins = User::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new OrderCancelledNotification($order, 'Refund request: ' . $request->refund_reason, (float) $order->total));
        }

        try {
            $webPush = app(WebPushService::class);
            $webPush->sendToAdmins(
                '🔄 Request Refund Baru',
                "Customer {$order->user->name} mengajukan refund untuk pesanan #{$order->order_number} - " . $order->formatted_total,
                route('admin.orders.show', $order),
                'refund_requested'
            );
        } catch (\Exception $e) {
            \Log::error('Push notification failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Permintaan refund berhasil diajukan. Admin akan menghubungi Anda dalam 1x24 jam untuk proses pengembalian dana.');
    }

    /**
     * Process refund - dipanggil oleh ADMIN, bukan customer
     * Ini yang benar-benar kirim refund ke Paylabs
     */
    protected function processRefund(Order $order): array
    {
        try {
            $refundAmount = (float) $order->total;

            $order->update([
                'refund_status' => Order::REFUND_PROCESSING,
            ]);

            // Refund via Paylabs jika payment gateway paylabs
            // Gunakan paylabs_transaction_id (field yang benar)
            if ($order->payment_gateway === 'paylabs' && !empty($order->paylabs_transaction_id)) {
                $paylabs = app(\App\Services\PaylabsService::class);
                $result = $paylabs->refundTransaction(
                    $order->paylabs_transaction_id,
                    $refundAmount,
                    'Order cancelled - refund by admin'
                );

                if ($result['success']) {
                    $order->update([
                        'refund_status'         => Order::REFUND_COMPLETED,
                        'refund_transaction_id' => $result['data']['refund_id'] ?? null,
                    ]);

                    \Log::info("Paylabs refund completed for order #{$order->order_number}", [
                        'refund_id' => $result['data']['refund_id'] ?? null,
                        'amount'    => $refundAmount,
                    ]);

                    return ['success' => true, 'message' => 'Refund berhasil diproses via Paylabs'];
                }

                \Log::error("Paylabs refund failed for order #{$order->order_number}", [
                    'error' => $result['message'] ?? 'Unknown error',
                ]);

                $order->update(['refund_status' => Order::REFUND_FAILED]);
                return ['success' => false, 'message' => $result['message'] ?? 'Refund gagal'];
            }

            // Untuk payment manual / transfer bank - admin proses manual
            $order->update(['refund_status' => Order::REFUND_COMPLETED]);
            return ['success' => true, 'message' => 'Refund manual berhasil ditandai selesai'];

        } catch (\Exception $e) {
            \Log::error("Refund error for order #{$order->order_number}: " . $e->getMessage());
            $order->update(['refund_status' => Order::REFUND_FAILED]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Check cancel status (AJAX)
     * Returns info about whether order can still be cancelled
     */
    public function checkCancelStatus(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $canCancel = $order->canBeCancelled();
        
        // Reason why cannot cancel
        $reason = null;
        if (!$canCancel) {
            if ($order->status === Order::STATUS_CANCELLED) {
                $reason = 'Pesanan sudah dibatalkan';
            } elseif ($order->status === Order::STATUS_COMPLETED) {
                $reason = 'Pesanan sudah selesai';
            } elseif (in_array($order->status, [Order::STATUS_READY_TO_SHIP, Order::STATUS_SHIPPED, Order::STATUS_DELIVERED])) {
                $reason = 'Pesanan sudah dalam proses pengiriman';
            } elseif ($order->status === Order::STATUS_PENDING_PAYMENT) {
                $reason = 'Pesanan menunggu pembayaran';
            } else {
                $reason = 'Pesanan hanya bisa dibatalkan saat status "Pesanan Diproses"';
            }
        }

        return response()->json([
            'can_cancel' => $canCancel,
            'status' => $order->status,
            'status_label' => $order->status_label,
            'requires_refund' => $order->requiresRefund(),
            'refund_amount' => $order->requiresRefund() ? $order->total : 0,
            'formatted_refund_amount' => $order->requiresRefund() ? $order->formatted_total : 'Rp 0',
            'is_cod' => $order->isCod(),
            'reason' => $reason,
        ]);
    }

    /**
     * Confirm order received
     */
    public function confirmReceived(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Can confirm if status is delivered or on_delivery
        if (!in_array($order->status, [Order::STATUS_DELIVERED, Order::STATUS_ON_DELIVERY])) {
            return back()->with('error', 'Pesanan belum sampai.');
        }

        // Complete the order
        $order->completeOrder();

        return back()->with('success', 'Pesanan dikonfirmasi selesai. Terima kasih telah berbelanja!');
    }

    /**
     * Get tracking data for order (AJAX) - Biteship Tracking
     */
    public function getTracking(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!$order->waybill_id) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor resi belum tersedia',
            ]);
        }

        $biteship = app(\App\Services\BiteshipService::class);
        $result = $biteship->trackOrder($order->waybill_id);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data tracking',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $result['data'],
        ]);
    }

    /**
     * Get courier location tracking (for internal courier)
     * With simulation for demo/testing
     */
    public function getCourierLocation(Order $order)
    {
        // Check if user is the order owner
        if ($order->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Allow tracking when order is shipped or on_delivery
        if (!in_array($order->status, [Order::STATUS_SHIPPED, Order::STATUS_ON_DELIVERY, Order::STATUS_DELIVERED])) {
            return response()->json([
                'success' => false,
                'message' => 'Tracking hanya tersedia saat pesanan sedang dikirim',
            ]);
        }

        // Try to get real courier location
        $location = null;
        
        if ($order->courier_id) {
            $location = CourierLocation::where('order_id', $order->id)
                ->where('is_active', true)
                ->latest()
                ->first();

            if (!$location) {
                // Try to get courier's last known location
                $location = CourierLocation::where('user_id', $order->courier_id)
                    ->where('is_active', true)
                    ->latest()
                    ->first();
            }
        }

        // If no real location, simulate for demo (like Shopee)
        if (!$location) {
            // Get store and destination coordinates
            $storeLat = (float) config('branding.store_latitude', -7.278417);
            $storeLng = (float) config('branding.store_longitude', 112.632583);
            $destLat = (float) $order->shipping_latitude;
            $destLng = (float) $order->shipping_longitude;
            
            // Calculate progress based on order created time
            // Simulate courier moving from store to destination over time
            $orderAge = now()->diffInMinutes($order->updated_at ?? $order->created_at);
            $estimatedDuration = $order->delivery_distance_minutes ?? 60; // default 60 minutes
            $progress = min($orderAge / $estimatedDuration, 0.95); // Max 95% to keep moving
            
            // Calculate current position along the route
            $currentLat = $storeLat + ($destLat - $storeLat) * $progress;
            $currentLng = $storeLng + ($destLng - $storeLng) * $progress;
            
            // Add small random offset for realistic movement
            $randomOffset = 0.0005; // ~50 meters
            $currentLat += (rand(-100, 100) / 100) * $randomOffset;
            $currentLng += (rand(-100, 100) / 100) * $randomOffset;
            
            // Calculate heading (direction)
            $heading = $this->calculateBearing($currentLat, $currentLng, $destLat, $destLng);
            
            // Simulate speed (km/h)
            $speed = $progress < 0.9 ? rand(20, 40) : rand(5, 15); // Slower when near destination
            
            return response()->json([
                'success' => true,
                'simulated' => true,
                'location' => [
                    'latitude' => $currentLat,
                    'longitude' => $currentLng,
                    'accuracy' => 10,
                    'speed' => $speed,
                    'heading' => $heading,
                    'updated_at' => now()->toISOString(),
                    'updated_ago' => 'Baru saja',
                ],
                'destination' => [
                    'latitude' => $destLat,
                    'longitude' => $destLng,
                    'address' => $order->shipping_address,
                ],
                'store' => [
                    'latitude' => $storeLat,
                    'longitude' => $storeLng,
                ],
                'courier' => [
                    'name' => $order->courier_driver_name ?? 'Kurir',
                    'phone' => $order->courier_driver_phone ?? '-',
                    'avatar' => $order->courier_driver_photo ?? null,
                ],
                'progress' => round($progress * 100, 1),
            ]);
        }

        // Return real location data
        return response()->json([
            'success' => true,
            'simulated' => false,
            'location' => [
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'accuracy' => $location->accuracy,
                'speed' => $location->speed,
                'heading' => $location->heading,
                'updated_at' => $location->updated_at->toISOString(),
                'updated_ago' => $location->updated_at->diffForHumans(),
            ],
            'destination' => [
                'latitude' => (float) $order->shipping_latitude,
                'longitude' => (float) $order->shipping_longitude,
                'address' => $order->shipping_address,
            ],
            'store' => [
                'latitude' => (float) config('branding.store_latitude', -7.278417),
                'longitude' => (float) config('branding.store_longitude', 112.632583),
            ],
            'courier' => [
                'name' => $order->courier->name ?? $order->courier_driver_name,
                'phone' => $order->courier->phone ?? $order->courier_driver_phone,
                'avatar' => $order->courier->avatar_url ?? $order->courier_driver_photo,
            ],
        ]);
    }
    
    /**
     * Calculate bearing between two coordinates
     */
    private function calculateBearing($lat1, $lng1, $lat2, $lng2)
    {
        $lat1 = deg2rad($lat1);
        $lng1 = deg2rad($lng1);
        $lat2 = deg2rad($lat2);
        $lng2 = deg2rad($lng2);
        
        $dLng = $lng2 - $lng1;
        
        $y = sin($dLng) * cos($lat2);
        $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($dLng);
        
        $bearing = atan2($y, $x);
        $bearing = rad2deg($bearing);
        $bearing = ($bearing + 360) % 360;
        
        return round($bearing);
    }
}
