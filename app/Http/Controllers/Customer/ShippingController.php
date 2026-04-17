<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\BiteshipService;
use App\Helpers\EstimationHelper;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    protected $biteship;

    public function __construct(BiteshipService $biteship)
    {
        $this->biteship = $biteship;
    }

    /**
     * Get shipping rates from Biteship API
     */
    public function getRates(Request $request)
    {
        try {
            $request->validate([
                'destination_postal_code' => 'nullable|string',
                'destination_latitude' => 'nullable|numeric',
                'destination_longitude' => 'nullable|numeric',
                'destination_city' => 'nullable|string',
                'destination_province' => 'nullable|string',
            ]);

            $cartItems = auth()->user()->cart()->with('product')->get();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Keranjang belanja kosong',
                ], 400);
            }

            $items = $cartItems->map(function ($cartItem) {
                return [
                    'name' => $cartItem->product->name,
                    'value' => (int) $cartItem->product->discounted_price,
                    'weight' => (int) ($cartItem->product->weight ?? 500),
                    'quantity' => $cartItem->quantity,
                ];
            })->toArray();

            $result = $this->biteship->getRates([
                'destination_latitude' => $request->destination_latitude ?? -7.2575,
                'destination_longitude' => $request->destination_longitude ?? 112.7521,
                'items' => $items,
            ]);

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Gagal mengambil data ongkir',
                ], 400);
            }

            $pricing = $result['data']['pricing'] ?? [];
            
            // Detect zone via reverse geocoding
            $originCity = 'Surabaya';
            $originProvince = 'Jawa Timur';
            $destCity = $request->destination_city ?? null;
            $destProvince = $request->destination_province ?? null;
            
            // Reverse geocode jika city/province tidak dikirim
            if (!$destCity || !$destProvince) {
                $lat = $request->destination_latitude;
                $lng = $request->destination_longitude;
                $geo = $this->reverseGeocode($lat, $lng);
                $destCity = $geo['city'] ?? 'Surabaya';
                $destProvince = $geo['province'] ?? 'Jawa Timur';
            }
            
            $zone = EstimationHelper::detectZone($originCity, $originProvince, $destCity, $destProvince);
            
            // Process each rate
            $processedRates = [];
            foreach ($pricing as $rate) {
                $serviceType = $rate['service_type'];
                
                // Filter: Skip instant/sameday for long distance
                if (!EstimationHelper::isServiceAvailable($serviceType, $zone)) {
                    continue;
                }
                
                // Adjust ETD based on zone
                list($minDays, $maxDays) = EstimationHelper::adjustETD(
                    $rate['duration'] ?? '2-3',
                    $zone,
                    $serviceType
                );
                
                // Convert to date range
                $estimatedDate = EstimationHelper::convertToDateRange($minDays, $maxDays);
                $etdText = EstimationHelper::formatETDText($minDays, $maxDays, $serviceType);
                
                $processedRates[] = [
                    'courier_code' => $rate['courier_code'],
                    'courier_name' => $rate['courier_name'],
                    'courier_service_name' => $rate['courier_service_name'],
                    'service_type' => $serviceType,
                    'price' => $rate['price'],
                    'etd_original' => $rate['duration'] ?? '2-3',
                    'etd_adjusted' => $etdText,
                    'estimated_date' => $estimatedDate,
                    'min_days' => $minDays,
                    'max_days' => $maxDays,
                    'duration_minutes' => $rate['duration_minutes'] ?? 0,
                    'zone' => $zone,
                    'zone_label' => EstimationHelper::getZoneLabel($zone),
                ];
            }
            
            // Sort by price (cheapest first)
            usort($processedRates, function($a, $b) {
                if ($a['price'] === $b['price']) {
                    return $a['min_days'] <=> $b['min_days'];
                }
                return $a['price'] <=> $b['price'];
            });
            
            // Add labels
            if (!empty($processedRates)) {
                $cheapestPrice = min(array_column($processedRates, 'price'));
                $fastestDays = min(array_column($processedRates, 'min_days'));
                
                foreach ($processedRates as $index => $rate) {
                    $processedRates[$index]['is_cheapest'] = ($rate['price'] === $cheapestPrice);
                    $processedRates[$index]['is_fastest'] = ($rate['min_days'] === $fastestDays);
                    $processedRates[$index]['label'] = '';
                    
                    if ($rate['price'] === $cheapestPrice) {
                        $processedRates[$index]['label'] = '💸 Termurah';
                    }
                    if ($rate['min_days'] === $fastestDays) {
                        $processedRates[$index]['label'] = '⚡ Tercepat';
                    }
                }
            }

            return response()->json([
                'success' => true,
                'rates' => $processedRates,
                'zone' => $zone,
                'zone_label' => EstimationHelper::getZoneLabel($zone),
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Shipping rates error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function reverseGeocode($lat, $lng): array
    {
        try {
            $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$lat}&lon={$lng}&addressdetails=1";
            $ctx = stream_context_create(['http' => ['header' => 'User-Agent: NoraPadel/1.0']]);
            $json = @file_get_contents($url, false, $ctx);

            if (!$json) return [];

            $data = json_decode($json, true);
            $addr = $data['address'] ?? [];

            $city = $addr['city'] ?? $addr['town'] ?? $addr['village'] ?? $addr['county'] ?? null;
            $province = $addr['state'] ?? null;

            return ['city' => $city, 'province' => $province];
        } catch (\Exception $e) {
            return [];
        }
    }
}
