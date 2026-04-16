<?php

return [
    'merchant_id' => env('PAYLABS_MERCHANT_ID'),
    'api_key' => env('PAYLABS_API_KEY'),
    'sandbox' => env('PAYLABS_SANDBOX', true),
    
    // API URLs
    'base_url' => env('PAYLABS_SANDBOX', true) 
        ? 'https://sandbox.paylabs.co.id/api' 
        : 'https://api.paylabs.co.id/api',
    
    // Payment Methods
    'payment_methods' => [
        'va' => [
            'bca' => 'BCA Virtual Account',
            'bni' => 'BNI Virtual Account',
            'bri' => 'BRI Virtual Account',
            'mandiri' => 'Mandiri Virtual Account',
            'permata' => 'Permata Virtual Account',
            'cimb' => 'CIMB Niaga Virtual Account',
        ],
        'qris' => 'QRIS',
        'ewallet' => [
            'ovo' => 'OVO',
            'dana' => 'DANA',
            'gopay' => 'GoPay',
            'shopeepay' => 'ShopeePay',
            'linkaja' => 'LinkAja',
        ],
        'retail' => [
            'alfamart' => 'Alfamart',
            'indomaret' => 'Indomaret',
        ],
    ],
    
    // Callback URLs
    'callback_url' => env('APP_URL') . '/webhook/paylabs',
    'return_url' => env('APP_URL') . '/customer/payment/{order_id}/callback',
];
