<?php

return [
    'api_key' => env('BITESHIP_API_KEY'),
    'sandbox' => env('BITESHIP_SANDBOX', true),
    'base_url' => 'https://api.biteship.com/v1',
    
    // Origin address (your store)
    'origin' => [
        'latitude' => env('BRANDING_STORE_LATITUDE', -7.4674),
        'longitude' => env('BRANDING_STORE_LONGITUDE', 112.5274),
        'postal_code' => env('BRANDING_STORE_POSTAL_CODE', '61219'),
    ],
    
    // Supported couriers
    'couriers' => [
        'jne' => 'JNE',
        'jnt' => 'J&T Express',
        'anteraja' => 'AnterAja',
        'spx' => 'Shopee Express',
        'paxel' => 'Paxel',
        'gosend' => 'GoSend',
        'grabexpress' => 'GrabExpress',
    ],
];
