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
    public function requestPickup(Request $request, Order $order)
    {
        // Validasi order sudah bayar dan ada ekspedisi
        if ($order->payment_status !== 'paid') {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Order belum dibayar. Tidak bisa request pickup.']);
            }
            return back()->with('error', 'Order belum dibayar. Tidak bisa request pickup.');
        }

        if (!$order->courier_code) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Customer belum memilih ekspedisi saat checkout.']);
            }
            return back()->with('error', 'Customer belum memilih ekspedisi saat checkout.');
        }

        if ($order->biteship_order_id) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Pickup sudah pernah direquest untuk order ini.']);
            }
            return back()->with('error', 'Pickup sudah pernah direquest untuk order ini.');
        }

        // Prepare items
        $items = $order->items->map(function ($item) {
            return [
                'name' => $item->product_name,
                'description' => $item->product_name,
                'value' => (int) $item->product_price,
                'quantity' => $item->quantity,
                'weight' => ($item->product->weight ?? 500) * $item->quantity,
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
            'courier_service_code' => strtolower($order->courier_service_name ?? 'reg'),
            'order_note' => 'Order #' . $order->order_number . ($order->notes ? ' - ' . $order->notes : ''),
            'items' => $items,
        ]);

        if (!$result['success']) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Gagal request pickup: ' . $result['message']]);
            }
            return back()->with('error', 'Gagal request pickup: ' . $result['message']);
        }

        // Update order dengan data dari Biteship
        $biteshipData = $result['data'];
        $courierInfo = $biteshipData['courier'] ?? [];
        
        $order->update([
            'biteship_order_id' => $biteshipData['id'] ?? null,
            'waybill_id' => $courierInfo['waybill_id'] ?? null,
            'status' => Order::STATUS_READY_TO_SHIP, // Siap pickup, menunggu kurir ambil
            'courier_driver_name' => $courierInfo['name'] ?? null,
            'courier_driver_phone' => $courierInfo['phone'] ?? null,
            'courier_driver_photo' => $courierInfo['photo'] ?? null,
            'courier_driver_rating' => $courierInfo['rating'] ?? null,
            'courier_driver_vehicle' => $courierInfo['vehicle_type'] ?? null,
            'courier_driver_vehicle_number' => $courierInfo['vehicle_number'] ?? null,
            'pickup_time' => $biteshipData['pickup_time'] ?? null,
        ]);

        // Notify customer
        $order->user->notify(new \App\Notifications\OrderStatusChanged(
            $order,
            'Pesanan Anda siap untuk pickup. Kurir ' . $order->courier_name . ' akan segera mengambil paket.'
        ));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pickup berhasil direquest! Kurir ' . ($order->courier_driver_name ?? $order->courier_name) . ' akan datang dalam 30 menit.',
                'data' => [
                    'courier_name' => $order->courier_driver_name,
                    'courier_phone' => $order->courier_driver_phone,
                    'pickup_time' => $order->pickup_time?->format('H:i'),
                ]
            ]);
        }

        return back()->with('success', 'Pickup berhasil direquest! Kurir ' . ($order->courier_driver_name ?? $order->courier_name) . ' akan datang dalam 30 menit.');
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
            'status' => Order::STATUS_SHIPPED,
        ]);

        // Notify customer
        $order->user->notify(new \App\Notifications\OrderStatusChanged(
            $order,
            'Pesanan Anda sedang dikirim dengan nomor resi: ' . $request->waybill_id
        ));

        return back()->with('success', 'Nomor resi berhasil disimpan!');
    }
}
