<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class DeliveryController extends Controller
{
    /**
     * Display list of assigned deliveries
     */
    public function index(Request $request)
    {
        $courier = auth()->user();
        $query = Order::where('courier_id', $courier->id)->with(['user', 'items']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default: show active deliveries
            $query->whereIn('status', [
                Order::STATUS_ASSIGNED,
                Order::STATUS_PICKED_UP,
                Order::STATUS_ON_DELIVERY,
                Order::STATUS_DELIVERED
            ]);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('delivery_date', $request->date);
        }

        $deliveries = $query->orderBy('delivery_date')
            ->orderBy('assigned_at')
            ->paginate(10);

        return view('courier.deliveries.index', compact('deliveries'));
    }

    /**
     * Show delivery detail
     */
    public function show(Order $order)
    {
        // Make sure this delivery belongs to the courier
        if ($order->courier_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pengiriman ini.');
        }

        $order->load(['user', 'items.product']);

        return view('courier.deliveries.show', compact('order'));
    }

    /**
     * Update delivery status - Pick up items (with photo)
     */
    public function pickUp(Request $request, Order $order)
    {
        if ($order->courier_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== Order::STATUS_ASSIGNED) {
            return back()->with('error', 'Status pesanan tidak valid untuk diambil.');
        }

        // Validate photo is required
        $request->validate([
            'pickup_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
        ], [
            'pickup_photo.required' => 'Foto pengambilan barang wajib disertakan.',
            'pickup_photo.image' => 'File harus berupa gambar.',
            'pickup_photo.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'pickup_photo.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        // Upload photo
        $photoPath = $request->file('pickup_photo')->store('delivery-photos/pickup', 'public');
        $order->pickup_photo = $photoPath;
        $order->save();

        $order->updateDeliveryStatus(Order::STATUS_PICKED_UP);

        // Notify customer
        $order->user->notify(new OrderStatusChanged($order, 'Barang pesanan Anda sudah diambil kurir dan sedang dipersiapkan.'));

        return back()->with('success', 'Status berhasil diupdate. Barang sudah diambil.');
    }

    /**
     * Update delivery status - Start delivery
     */
    public function startDelivery(Order $order)
    {
        if ($order->courier_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== Order::STATUS_PICKED_UP) {
            return back()->with('error', 'Status pesanan tidak valid.');
        }

        $order->updateDeliveryStatus(Order::STATUS_ON_DELIVERY);

        // Notify customer
        $order->user->notify(new OrderStatusChanged($order, 'Pesanan Anda sedang dalam perjalanan menuju alamat tujuan.'));

        return back()->with('success', 'Status berhasil diupdate. Pengiriman dimulai.');
    }

    /**
     * Update delivery status - Mark as delivered (with photo)
     */
    public function markDelivered(Request $request, Order $order)
    {
        if ($order->courier_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== Order::STATUS_ON_DELIVERY) {
            return back()->with('error', 'Status pesanan tidak valid.');
        }

        // Validate photo is required
        $request->validate([
            'delivery_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
            'delivery_notes' => 'nullable|string|max:500',
        ], [
            'delivery_photo.required' => 'Foto bukti pengiriman wajib disertakan.',
            'delivery_photo.image' => 'File harus berupa gambar.',
            'delivery_photo.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'delivery_photo.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        // Upload photo
        $photoPath = $request->file('delivery_photo')->store('delivery-photos/delivered', 'public');
        $order->delivery_photo = $photoPath;
        $order->save();

        $order->updateDeliveryStatus(Order::STATUS_DELIVERED, $request->delivery_notes);

        // Auto complete after delivery
        $order->updateDeliveryStatus(Order::STATUS_COMPLETED);

        // Notify customer
        $order->user->notify(new OrderStatusChanged($order, 'Pesanan Anda sudah sampai dan selesai! Terima kasih telah berbelanja di PATAH.'));

        return back()->with('success', 'Pesanan berhasil diantar dan selesai!');
    }

    /**
     * Display delivery history
     */
    public function history(Request $request)
    {
        $courier = auth()->user();
        $query = Order::where('courier_id', $courier->id)
            ->whereIn('status', [Order::STATUS_DELIVERED, Order::STATUS_COMPLETED])
            ->with('user');

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('delivered_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('delivered_at', '<=', $request->to_date);
        }

        $deliveries = $query->latest('delivered_at')->paginate(15);

        // Stats for this period
        $stats = Order::where('courier_id', $courier->id)
            ->whereIn('status', [Order::STATUS_DELIVERED, Order::STATUS_COMPLETED]);
        
        if ($request->filled('from_date')) {
            $stats->whereDate('delivered_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $stats->whereDate('delivered_at', '<=', $request->to_date);
        }

        $totalDelivered = $stats->count();
        $totalEarnings = $stats->sum('shipping_cost');

        return view('courier.deliveries.history', compact('deliveries', 'totalDelivered', 'totalEarnings'));
    }
}
