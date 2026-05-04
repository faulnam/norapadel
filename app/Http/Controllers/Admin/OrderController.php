<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Services\PaylabsService;
use Illuminate\Http\Request;
use App\Notifications\OrderStatusChanged;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Display orders list
     */
    public function index(Request $request)
    {
        $query = Order::with('user', 'items')
            ->withoutBiteshipOrder();

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
            'status' => 'required|in:pending_payment,processing,ready_to_ship,shipped,delivered,completed,cancelled',
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
     * Verify payment - Status menjadi 'processing', pesanan sedang diproses
     */
    public function verifyPayment(Order $order)
    {
        $order->update([
            'payment_status' => 'paid',
            'payment_verified_at' => now(),
            'paid_at' => now(),
            'status' => Order::STATUS_PROCESSING, // Pesanan sedang diproses
        ]);

        // Send notification
        $order->user->notify(new OrderStatusChanged($order, 'Pembayaran Anda sudah diverifikasi. Pesanan sedang dipersiapkan.'));

        return back()->with('success', 'Pembayaran berhasil diverifikasi. Pesanan sedang diproses, silakan siapkan barang.');
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
     * Update shipping info (manual input resi jika tidak pakai Biteship)
     */
    public function updateShipping(Request $request, Order $order)
    {
        $validated = $request->validate([
            'waybill_id' => 'required|string|max:100',
        ], [
            'waybill_id.required' => 'Nomor resi wajib diisi.',
        ]);

        $order->update([
            'waybill_id' => $validated['waybill_id'],
            'status' => Order::STATUS_SHIPPED,
        ]);
    }

    /**
     * Print receipt
     */
    public function printReceipt(Order $order)
    {
        $order->load('user', 'items.product', 'courier');
        
        // Gunakan label_url dari database jika tersedia
        $biteshipLabel = $order->label_url;

    $pdf = Pdf::loadView('admin.orders.receipt', compact('order', 'biteshipLabel'));
        
        return $pdf->download('resi-' . $order->order_number . '.pdf');
    }

    /**
     * View receipt in browser
     */
    public function viewReceipt(Order $order)
    {
        $order->load('user', 'items.product', 'courier');
        
        // Gunakan label_url dari database jika tersedia
        $biteshipLabel = $order->label_url;
        
        return view('admin.orders.receipt', compact('order', 'biteshipLabel'));
    }

    /**
     * Manual check Paylabs payment status
     */
    public function checkPaylabsStatus(Order $order, PaylabsService $paylabs)
    {
        if ($order->payment_gateway !== 'paylabs' || !$order->paylabs_transaction_id) {
            return back()->with('error', 'Order ini bukan menggunakan Paylabs atau tidak memiliki transaction ID.');
        }

        $result = $paylabs->checkStatus($order->paylabs_transaction_id);

        if (!$result['success']) {
            return back()->with('error', 'Gagal mengecek status: ' . $result['message']);
        }

        $status = $result['data']['status'] ?? 'pending';
        $rawStatus = $result['data']['raw_status'] ?? $status;

        if (in_array($status, ['paid', 'success']) || $status === '02') {
            $order->update([
                'payment_status' => Order::PAYMENT_PAID,
                'paid_at' => now(),
                'status' => Order::STATUS_PROCESSING,
            ]);

            return back()->with('success', "Status pembayaran berhasil diupdate menjadi PAID (status dari Paylabs: {$rawStatus})");
        }

        return back()->with('info', "Status pembayaran di Paylabs: {$rawStatus} (belum paid)");
    }


}
