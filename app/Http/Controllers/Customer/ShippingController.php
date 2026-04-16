<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\BiteshipService;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    protected $biteship;

    public function __construct(BiteshipService $biteship)
    {
        $this->biteship = $biteship;
    }

    /**
     * Get shipping rates from Biteship
     */
    public function getRates(Request $request)
    {
        $request->validate([
            'destination_latitude' => 'required|numeric',
            'destination_longitude' => 'required|numeric',
        ]);

        // Get cart items from authenticated user
        $cartItems = auth()->user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang belanja kosong',
            ], 400);
        }

        // Prepare items for Biteship API
        $items = $cartItems->map(function ($cartItem) {
            return [
                'name' => $cartItem->product->name,
                'value' => $cartItem->product->final_price,
                'weight' => $cartItem->product->weight ?? 500, // Default 500g if not set
                'quantity' => $cartItem->quantity,
            ];
        })->toArray();

        $result = $this->biteship->getRates([
            'destination_latitude' => $request->destination_latitude,
            'destination_longitude' => $request->destination_longitude,
            'items' => $items,
        ]);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Gagal mengambil data ongkir',
            ], 400);
        }

        // Filter only supported couriers
        $supportedCouriers = array_keys(config('biteship.couriers'));
        $pricing = collect($result['data']['pricing'] ?? [])
            ->filter(function ($rate) use ($supportedCouriers) {
                return in_array($rate['courier_code'], $supportedCouriers);
            })
            ->map(function ($rate) {
                return [
                    'courier_code'         => $rate['courier_code'],
                    'courier_name'         => $rate['courier_name'],
                    'courier_service_name' => $rate['courier_service_name'],
                    'duration'             => $rate['duration'] ?? '',
                    'service_type'         => $rate['service_type'] ?? '',
                    'price'                => $rate['price'],
                    'zone'                 => $rate['zone'] ?? '',
                    'weight_kg'            => $rate['weight_kg'] ?? '',
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'rates' => $pricing,
        ]);
    }
}
