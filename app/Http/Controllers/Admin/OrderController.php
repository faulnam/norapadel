<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderStatusChanged;
use App\Notifications\CourierAssigned;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Display orders list
     */
    public function index(Request $request)
    {
        $query = Order::with('user', 'items');

        // Search by order number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show order detail
     */
    public function show(Order $order)
    {
        $order->load('user', 'items.product', 'courier');
        
        // Get available couriers for assignment
        $couriers = User::where('role', 'courier')
            ->where('is_active', true)
            ->get();
        
        return view('admin.orders.show', compact('order', 'couriers'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending_payment,paid,assigned,picked_up,on_delivery,delivered,completed,cancelled',
            'cancel_reason' => 'required_if:status,cancelled|nullable|string|max:500',
        ]);

        $oldStatus = $order->status;
        $order->status = $validated['status'];

        // Handle status-specific logic
        if ($validated['status'] === 'completed') {
            $order->completed_at = now();
        } elseif ($validated['status'] === 'cancelled') {
            $order->cancel_reason = $validated['cancel_reason'];
            // Restore stock when order is cancelled
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->restoreStock($item->quantity);
                }
            }
        }

        $order->save();

        // Send notification to customer
        $order->user->notify(new OrderStatusChanged($order, $oldStatus));

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Verify payment - Status menjadi 'paid', siap untuk assign kurir
     */
    public function verifyPayment(Order $order)
    {
        $order->update([
            'payment_status' => 'paid',
            'payment_verified_at' => now(),
            'status' => Order::STATUS_PAID, // Siap untuk ditugaskan ke kurir
        ]);

        // Send notification
        $order->user->notify(new OrderStatusChanged($order, 'Pembayaran Anda sudah diverifikasi. Pesanan sedang dipersiapkan.'));

        return back()->with('success', 'Pembayaran berhasil diverifikasi. Silakan tugaskan kurir.');
    }

    /**
     * Reject payment
     */
    public function rejectPayment(Request $request, Order $order)
    {
        $order->update([
            'payment_status' => 'unpaid',
            'payment_proof' => null,
        ]);

        return back()->with('success', 'Bukti pembayaran ditolak. Customer dapat mengupload ulang.');
    }

    /**
     * Update shipping info
     */
    public function updateShipping(Request $request, Order $order)
    {
        $validated = $request->validate([
            'courier_name' => 'required|string|max:100',
            'courier_service' => 'required|string|max:100',
            'tracking_number' => 'required|string|max:100',
        ], [
            'courier_name.required' => 'Nama kurir wajib diisi.',
            'courier_service.required' => 'Jasa pengiriman wajib diisi.',
            'tracking_number.required' => 'Nomor resi wajib diisi.',
        ]);

        $order->update($validated);

        return back()->with('success', 'Informasi pengiriman berhasil diperbarui.');
    }

    /**
     * Print receipt
     */
    public function printReceipt(Order $order)
    {
        $order->load('user', 'items.product', 'courier');

        $pdf = PDF::loadView('admin.orders.receipt', compact('order'));
        
        return $pdf->download('resi-' . $order->order_number . '.pdf');
    }

    /**
     * View receipt in browser
     */
    public function viewReceipt(Order $order)
    {
        $order->load('user', 'items.product', 'courier');
        return view('admin.orders.receipt', compact('order'));
    }

    /**
     * Assign courier to order
     */
    public function assignCourier(Request $request, Order $order)
    {
        $validated = $request->validate([
            'courier_id' => 'required|exists:users,id',
        ], [
            'courier_id.required' => 'Kurir harus dipilih.',
            'courier_id.exists' => 'Kurir tidak valid.',
        ]);

        // Verify courier role
        $courier = User::where('id', $validated['courier_id'])
            ->where('role', 'courier')
            ->where('is_active', true)
            ->first();

        if (!$courier) {
            return back()->with('error', 'Kurir tidak valid atau tidak aktif.');
        }

        // Check if order can be assigned
        if (!$order->canAssignCourier()) {
            return back()->with('error', 'Pesanan ini tidak dapat ditugaskan ke kurir.');
        }

        // Assign courier - pass courier ID, not the object
        $order->assignCourier($courier->id);

        // Notify courier
        $courier->notify(new CourierAssigned($order));

        // Notify customer
        $order->user->notify(new OrderStatusChanged($order, 'Pesanan Anda sedang dipersiapkan untuk pengiriman.'));

        return back()->with('success', 'Kurir berhasil ditugaskan untuk pesanan ini.');
    }

    /**
     * Get list of couriers for AJAX
     */
    public function getCouriers()
    {
        $couriers = User::where('role', 'courier')
            ->where('is_active', true)
            ->withCount(['activeDeliveries'])
            ->get()
            ->map(function ($courier) {
                return [
                    'id' => $courier->id,
                    'name' => $courier->name,
                    'phone' => $courier->phone,
                    'active_deliveries' => $courier->active_deliveries_count,
                ];
            });

        return response()->json($couriers);
    }
}
