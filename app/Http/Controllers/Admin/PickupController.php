<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\BiteshipService;
use Illuminate\Http\Request;

class PickupController extends Controller
{
    protected $biteship;

    public function __construct(BiteshipService $biteship)
    {
        $this->biteship = $biteship;
    }

    /**
     * Request pickup dari Biteship
     */
    public function requestPickup(Order $order)
    {
        // Validasi order sudah bayar dan ada ekspedisi
        if ($order->payment_status !== 'paid') {
            return back()->with('error', 'Order belum dibayar. Tidak bisa request pickup.');
        }

        if (!$order->courier_code) {
            return back()->with('error', 'Order tidak memiliki data ekspedisi.');
        }

        if ($order->biteship_order_id) {
            return back()->with('error', 'Pickup sudah pernah direquest untuk order ini.');
        }

        // Prepare items
        $items = $order->items->map(function ($item) {
            return [
                'name' => $item->product->name,
                'description' => $item->product->description ?? '',
                'value' => $item->price,
                'quantity' => $item->quantity,
                'weight' => $item->product->weight ?? 500,
            ];
        })->toArray();

        // Request pickup ke Biteship
        $result = $this->biteship->createOrder([
            'destination_contact_name' => $order->shipping_name,
            'destination_contact_phone' => $order->shipping_phone,
            'destination_address' => $order->shipping_address,
            'destination_latitude' => $order->shipping_latitude,
            'destination_longitude' => $order->shipping_longitude,
            'courier_code' => $order->courier_code,
            'order_note' => 'Order #' . $order->order_number . ($order->notes ? ' - ' . $order->notes : ''),
            'items' => $items,
        ]);

        if (!$result['success']) {
            return back()->with('error', 'Gagal request pickup: ' . $result['message']);
        }

        // Update order dengan data dari Biteship
        $biteshipData = $result['data'];
        $order->update([
            'biteship_order_id' => $biteshipData['id'] ?? null,
            'waybill_id' => $biteshipData['courier']['waybill_id'] ?? null,
            'status' => 'assigned', // Update status ke assigned
        ]);

        return back()->with('success', 'Pickup berhasil direquest! Resi: ' . ($order->waybill_id ?? 'Menunggu'));
    }

    /**
     * Get tracking info
     */
    public function getTracking(Order $order)
    {
        if (!$order->waybill_id) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor resi belum tersedia',
            ]);
        }

        $result = $this->biteship->trackOrder($order->waybill_id);

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
     * Manual input resi (jika pickup dilakukan di luar sistem)
     */
    public function updateWaybill(Request $request, Order $order)
    {
        $request->validate([
            'waybill_id' => 'required|string|max:255',
        ]);

        $order->update([
            'waybill_id' => $request->waybill_id,
            'status' => 'picked_up',
        ]);

        return back()->with('success', 'Nomor resi berhasil disimpan!');
    }
}
