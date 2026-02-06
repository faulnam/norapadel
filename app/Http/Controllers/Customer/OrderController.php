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
use App\Notifications\PaymentUploadedNotification;
use App\Services\WebPushService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

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

        // Calculate subtotal with product discounts
        $subtotal = 0;
        $productDiscount = 0;
        
        foreach ($cartItems as $item) {
            $originalPrice = $item->product->price * $item->quantity;
            $discountedPrice = $item->product->discounted_price * $item->quantity;
            $subtotal += $originalPrice;
            $productDiscount += ($originalPrice - $discountedPrice);
        }

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

            // Calculate subtotal with product discounts
            $subtotal = 0;
            $productDiscount = 0;
            
            foreach ($cartItems as $item) {
                $originalPrice = $item->product->price * $item->quantity;
                $discountedPrice = $item->product->discounted_price * $item->quantity;
                $subtotal += $originalPrice;
                $productDiscount += ($originalPrice - $discountedPrice);
            }

            $shippingCost = (int) $validated['shipping_cost'];
            
            // Calculate shipping discount
            $shippingDiscount = 0;
            $activeShippingDiscount = ShippingDiscount::active()->first();
            if ($activeShippingDiscount) {
                $shippingDiscount = $activeShippingDiscount->calculateDiscount($shippingCost, $subtotal - $productDiscount);
            }

            // Calculate final total
            $total = $subtotal - $productDiscount + $shippingCost - $shippingDiscount;

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'subtotal' => $subtotal,
                'product_discount' => $productDiscount,
                'shipping_discount' => $shippingDiscount,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'shipping_name' => $validated['shipping_name'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_latitude' => $validated['shipping_latitude'],
                'shipping_longitude' => $validated['shipping_longitude'],
                'delivery_distance_km' => $validated['delivery_distance_km'] ?? null,
                'delivery_distance_minutes' => $validated['delivery_distance_minutes'],
                'delivery_date' => $validated['delivery_date'],
                'delivery_time_slot' => $validated['delivery_time_slot'],
                'notes' => $validated['notes'],
                'status' => Order::STATUS_PENDING_PAYMENT,
                'payment_status' => Order::PAYMENT_UNPAID,
            ]);

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

            // Redirect to payment page instead of order detail
            return redirect()->route('customer.payment.show', $order)
                ->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');

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

        $order->load('items.product');

        return view('customer.orders.show', compact('order'));
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
            Order::STATUS_PAID,
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
     */
    public function cancel(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$order->canBeCancelled()) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }

        // Restore stock
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->restoreStock($item->quantity);
            }
        }

        $order->update([
            'status' => Order::STATUS_CANCELLED,
            'cancel_reason' => 'Dibatalkan oleh customer',
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
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
     * Get tracking data for order (AJAX)
     */
    public function getTracking(Order $order)
    {
        // Check if user is the order owner
        if ($order->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Only allow tracking when order is being delivered
        if (!in_array($order->status, [Order::STATUS_ON_DELIVERY])) {
            return response()->json([
                'success' => false,
                'message' => 'Tracking hanya tersedia saat pesanan sedang dikirim',
            ]);
        }

        if (!$order->courier_id) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada kurir yang ditugaskan',
            ]);
        }

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

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi kurir belum tersedia',
            ]);
        }

        return response()->json([
            'success' => true,
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
                'latitude' => (float) config('branding.store_latitude', -7.4674),
                'longitude' => (float) config('branding.store_longitude', 112.5274),
            ],
            'courier' => [
                'name' => $order->courier->name,
                'phone' => $order->courier->phone,
                'avatar' => $order->courier->avatar_url,
            ],
        ]);
    }
}
