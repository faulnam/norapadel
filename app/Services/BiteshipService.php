<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BiteshipService
{
    protected $apiKey;
    protected $baseUrl;
    protected $sandbox;

    public function __construct()
    {
        $this->apiKey = config('biteship.api_key');
        $this->baseUrl = config('biteship.base_url');
        $this->sandbox = config('biteship.sandbox', true);
    }

    /**
     * Get shipping rates from Biteship
     * 
     * @param array $params
     * @return array
     */
    public function getRates(array $params)
    {
        // Hitung total berat
        $totalWeight = collect($params['items'] ?? [])->sum(function ($item) {
            return ($item['weight'] ?? 500) * ($item['quantity'] ?? 1);
        });
        $totalWeight = max($totalWeight, 1000); // minimum 1kg

        // Deteksi zona berdasarkan koordinat tujuan
        $zone = $this->detectZone(
            $params['destination_latitude'],
            $params['destination_longitude']
        );

        // Hitung jarak
        $storeLat = config('biteship.origin.latitude', -7.4674);
        $storeLng = config('biteship.origin.longitude', 112.5274);
        $distance = $this->haversine(
            $storeLat,
            $storeLng,
            $params['destination_latitude'],
            $params['destination_longitude']
        );

        // Hitung ongkir berdasarkan zona dan berat
        $rates = $this->calculateRates($zone, $totalWeight, $distance);

        return [
            'success' => true,
            'data' => ['pricing' => $rates],
        ];
    }

    private function detectZone(float $lat, float $lng): string
    {
        $storeLat = config('biteship.origin.latitude', -7.4674);
        $storeLng = config('biteship.origin.longitude', 112.5274);

        // Hitung jarak dari toko ke tujuan (km)
        $distance = $this->haversine($storeLat, $storeLng, $lat, $lng);

        if ($distance <= 30) return 'same_city';       // Dalam kota / sekitar
        if ($distance <= 150) return 'nearby';          // Kota tetangga
        if ($distance <= 500) return 'inter_city';      // Antar kota dalam pulau
        return 'inter_island';                          // Antar pulau
    }

    private function haversine(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $R = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng/2) * sin($dLng/2);
        return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    private function calculateRates(string $zone, int $weightGram, float $distance): array
    {
        // Harga dasar per kg per zona (dalam rupiah)
        $baseRates = [
            'same_city'    => ['regular' => 8000,  'express' => 14000, 'sameday' => 20000, 'instant' => 30000],
            'nearby'       => ['regular' => 12000, 'express' => 20000, 'sameday' => 35000, 'instant' => null],
            'inter_city'   => ['regular' => 15000, 'express' => 25000, 'sameday' => null,  'instant' => null],
            'inter_island' => ['regular' => 25000, 'express' => 40000, 'sameday' => null,  'instant' => null],
        ];

        $weightKg = max(1, ceil($weightGram / 1000));
        $base = $baseRates[$zone];

        $couriers = [
            [
                'courier_code'         => 'jnt',
                'courier_name'         => 'J&T Express',
                'services' => [
                    ['name' => 'EZ (Reguler)', 'type' => 'regular',  'multiplier' => 1.0],
                    ['name' => 'Express',      'type' => 'express',  'multiplier' => 1.1],
                ],
            ],
            [
                'courier_code'         => 'anteraja',
                'courier_name'         => 'AnterAja',
                'services' => [
                    ['name' => 'Reguler',      'type' => 'regular',  'multiplier' => 0.95],
                    ['name' => 'Same Day',     'type' => 'sameday',  'multiplier' => 1.0],
                ],
            ],
            [
                'courier_code'         => 'paxel',
                'courier_name'         => 'Paxel',
                'services' => [
                    ['name' => 'Regular',      'type' => 'regular',  'multiplier' => 1.05],
                    ['name' => 'Same Day',     'type' => 'sameday',  'multiplier' => 1.1],
                    ['name' => 'Instant',      'type' => 'instant',  'multiplier' => 1.0],
                ],
            ],
        ];

        $rates = [];
        foreach ($couriers as $courier) {
            foreach ($courier['services'] as $service) {
                $basePrice = $base[$service['type']] ?? null;
                if ($basePrice === null) continue; // layanan tidak tersedia di zona ini

                $price = (int) round($basePrice * $weightKg * $service['multiplier']);

                $durationMap = [
                    'regular'  => '2-4 hari',
                    'express'  => '1-2 hari',
                    'sameday'  => 'Hari ini',
                    'instant'  => '2-4 jam',
                ];

                // Estimasi durasi dalam menit (untuk validasi)
                $durationMinutes = [
                    'regular'  => 2880,  // 2 hari
                    'express'  => 1440,  // 1 hari
                    'sameday'  => 720,   // 12 jam
                    'instant'  => 180,   // 3 jam
                ];

                $rates[] = [
                    'courier_code'         => $courier['courier_code'],
                    'courier_name'         => $courier['courier_name'],
                    'courier_service_name' => $service['name'],
                    'service_type'         => $service['type'],
                    'duration'             => $durationMap[$service['type']],
                    'duration_minutes'     => $durationMinutes[$service['type']],
                    'price'                => $price,
                    'weight_kg'            => $weightKg,
                    'distance_km'          => round($distance, 2),
                    'zone'                 => $zone,
                ];
            }
        }

        return $rates;
    }

    /**
     * Create order in Biteship (Request Pickup)
     * 
     * @param array $orderData
     * @return array
     */
    public function createOrder(array $orderData)
    {
        // Jika sandbox mode, return mock data dengan kurir dummy
        if ($this->sandbox) {
            return $this->mockCreateOrder($orderData);
        }

        try {
            $payload = [
                'origin_contact_name' => $orderData['origin_contact_name'] ?? config('branding.name', 'NoraPadel'),
                'origin_contact_phone' => $orderData['origin_contact_phone'] ?? config('branding.phone', '081234567890'),
                'origin_address' => $orderData['origin_address'] ?? config('branding.address', 'Toko NoraPadel'),
                'origin_note' => $orderData['origin_note'] ?? 'Pickup dari toko',
                'origin_latitude' => $orderData['origin_latitude'] ?? config('biteship.origin.latitude'),
                'origin_longitude' => $orderData['origin_longitude'] ?? config('biteship.origin.longitude'),
                'origin_postal_code' => $orderData['origin_postal_code'] ?? config('biteship.origin.postal_code'),
                
                'destination_contact_name' => $orderData['destination_contact_name'],
                'destination_contact_phone' => $orderData['destination_contact_phone'],
                'destination_address' => $orderData['destination_address'],
                'destination_note' => $orderData['destination_note'] ?? '',
                'destination_latitude' => $orderData['destination_latitude'],
                'destination_longitude' => $orderData['destination_longitude'],
                'destination_postal_code' => $orderData['destination_postal_code'] ?? '61219',
                
                'courier_company' => $orderData['courier_code'],
                'delivery_type' => 'now',
                'order_note' => $orderData['order_note'] ?? '',
                'items' => $orderData['items'],
            ];

            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/orders", $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            Log::error('Biteship createOrder failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'payload' => $payload,
            ]);

            return [
                'success' => false,
                'message' => 'Failed to create pickup order: ' . ($response->json()['error'] ?? $response->body()),
                'error' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error('Biteship createOrder exception', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Mock create order untuk sandbox mode
     */
    private function mockCreateOrder(array $orderData)
    {
        // Simulasi delay scanning kurir
        sleep(2);

        // Data dummy kurir berdasarkan ekspedisi
        $courierData = $this->getDummyCourier($orderData['courier_code']);
        
        // Generate nomor resi sesuai format ekspedisi
        $waybillId = $this->generateWaybillNumber($orderData['courier_code']);

        return [
            'success' => true,
            'data' => [
                'id' => 'BITESHIP-' . strtoupper(uniqid()),
                'courier' => [
                    'waybill_id' => $waybillId,
                    'company' => $orderData['courier_code'],
                    'name' => $courierData['name'],
                    'phone' => $courierData['phone'],
                    'photo' => $courierData['photo'],
                    'rating' => $courierData['rating'],
                    'total_trips' => $courierData['total_trips'],
                    'vehicle_type' => $courierData['vehicle_type'],
                    'vehicle_number' => $courierData['vehicle_number'],
                ],
                'status' => 'confirmed',
                'pickup_time' => now()->addMinutes(30)->format('Y-m-d H:i:s'),
            ],
        ];
    }
    
    /**
     * Generate nomor resi sesuai format ekspedisi
     */
    private function generateWaybillNumber(string $courierCode): string
    {
        switch ($courierCode) {
            case 'jnt':
                // Format J&T: JT + 12 digit angka
                // Contoh: JT012345678901
                return 'JT' . str_pad(rand(0, 999999999999), 12, '0', STR_PAD_LEFT);
                
            case 'anteraja':
                // Format AnterAja: 10000 + 10 digit angka
                // Contoh: 100001234567890
                return '10000' . str_pad(rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
                
            case 'paxel':
                // Format Paxel: PXL + 8 digit angka + 2 huruf
                // Contoh: PXL12345678AB
                $letters = chr(rand(65, 90)) . chr(rand(65, 90));
                return 'PXL' . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT) . $letters;
                
            default:
                return strtoupper($courierCode) . '-' . time();
        }
    }

    /**
     * Get dummy courier data
     */
    private function getDummyCourier(string $courierCode)
    {
        $couriers = [
            'jnt' => [
                [
                    'name' => 'Budi Santoso',
                    'phone' => '081234567890',
                    'photo' => 'https://ui-avatars.com/api/?name=Budi+Santoso&background=EF4444&color=fff&size=200',
                    'rating' => 4.8,
                    'total_trips' => 1250,
                    'vehicle_type' => 'Motor',
                    'vehicle_number' => 'L 1234 AB',
                ],
                [
                    'name' => 'Ahmad Rizki',
                    'phone' => '081234567891',
                    'photo' => 'https://ui-avatars.com/api/?name=Ahmad+Rizki&background=EF4444&color=fff&size=200',
                    'rating' => 4.9,
                    'total_trips' => 980,
                    'vehicle_type' => 'Motor',
                    'vehicle_number' => 'L 5678 CD',
                ],
            ],
            'anteraja' => [
                [
                    'name' => 'Dedi Kurniawan',
                    'phone' => '081234567892',
                    'photo' => 'https://ui-avatars.com/api/?name=Dedi+Kurniawan&background=3B82F6&color=fff&size=200',
                    'rating' => 4.7,
                    'total_trips' => 850,
                    'vehicle_type' => 'Motor',
                    'vehicle_number' => 'L 9012 EF',
                ],
                [
                    'name' => 'Eko Prasetyo',
                    'phone' => '081234567893',
                    'photo' => 'https://ui-avatars.com/api/?name=Eko+Prasetyo&background=3B82F6&color=fff&size=200',
                    'rating' => 4.9,
                    'total_trips' => 1100,
                    'vehicle_type' => 'Motor',
                    'vehicle_number' => 'L 3456 GH',
                ],
            ],
            'paxel' => [
                [
                    'name' => 'Fajar Ramadhan',
                    'phone' => '081234567894',
                    'photo' => 'https://ui-avatars.com/api/?name=Fajar+Ramadhan&background=10B981&color=fff&size=200',
                    'rating' => 4.8,
                    'total_trips' => 720,
                    'vehicle_type' => 'Motor',
                    'vehicle_number' => 'L 7890 IJ',
                ],
                [
                    'name' => 'Gilang Pratama',
                    'phone' => '081234567895',
                    'photo' => 'https://ui-avatars.com/api/?name=Gilang+Pratama&background=10B981&color=fff&size=200',
                    'rating' => 4.9,
                    'total_trips' => 950,
                    'vehicle_type' => 'Motor',
                    'vehicle_number' => 'L 2345 KL',
                ],
            ],
        ];

        $courierList = $couriers[$courierCode] ?? $couriers['jnt'];
        return $courierList[array_rand($courierList)];
    }

    /**
     * Print label/resi dari Biteship
     * Endpoint: GET /v1/orders/{id}/label
     */
    public function printLabel(string $biteshipOrderId): array
    {
        if ($this->sandbox) {
            return [
                'success' => false,
                'sandbox' => true,
                'message' => 'Label resi hanya tersedia di mode production. Set BITESHIP_SANDBOX=false di .env untuk menggunakan label resmi ekspedisi.',
            ];
        }

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => $this->apiKey,
            ])->get("{$this->baseUrl}/orders/{$biteshipOrderId}/label");

            if ($response->successful()) {
                $contentType = $response->header('Content-Type');

                if (str_contains($contentType, 'application/pdf') || str_contains($contentType, 'image/')) {
                    return [
                        'success' => true,
                        'content' => $response->body(),
                        'content_type' => $contentType,
                    ];
                }

                $data = $response->json();
                return [
                    'success' => true,
                    'url' => $data['url'] ?? $data['label_url'] ?? null,
                    'data' => $data,
                ];
            }

            Log::error('Biteship printLabel failed', [
                'order_id' => $biteshipOrderId,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengambil label dari Biteship: ' . ($response->json()['error'] ?? $response->body()),
            ];
        } catch (\Exception $e) {
            Log::error('Biteship printLabel exception', ['message' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get order details from Biteship
     * 
     * @param string $orderId
     * @return array
     */
    public function getOrder(string $orderId)
    {
        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => $this->apiKey,
            ])->get("{$this->baseUrl}/orders/{$orderId}");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            Log::error('Biteship getOrder failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to get order',
                'error' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error('Biteship getOrder exception', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Track order from Biteship
     * 
     * @param string $waybillId
     * @return array
     */
    public function trackOrder(string $waybillId)
    {
        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => $this->apiKey,
            ])->get("{$this->baseUrl}/trackings/{$waybillId}/couriers");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to track order',
                'error' => $response->json(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
