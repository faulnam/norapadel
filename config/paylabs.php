<?php

return [
    'merchant_id' => env('PAYLABS_MERCHANT_ID'),
    'api_key' => env('PAYLABS_API_KEY'),
    'sandbox' => env('PAYLABS_SANDBOX', true),
    
    // API URLs
    'base_url' => env('PAYLABS_BASE_URL') ?: (env('PAYLABS_SANDBOX', true)
        ? 'https://sandbox.paylabs.co.id/api'
        : 'https://api.paylabs.co.id/api'),

    // HTTP Client Settings
    'timeout' => (int) env('PAYLABS_TIMEOUT', 30),
    'connect_timeout' => (int) env('PAYLABS_CONNECT_TIMEOUT', 10),
    'verify_ssl' => env('PAYLABS_VERIFY_SSL', true),
    'ca_bundle' => env('PAYLABS_CA_BUNDLE'),
    
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
    'callback_url' => env('PAYLABS_CALLBACK_URL', rtrim((string) env('APP_URL'), '/') . '/webhook/paylabs'),
    'return_url' => env('PAYLABS_RETURN_URL', rtrim((string) env('APP_URL'), '/') . '/customer/payment-paylabs/{order_id}/callback'),

    // Webhook Verification
    'webhook' => [
        'verify_signature' => env('PAYLABS_VERIFY_SIGNATURE', false),
        'signature_header' => env('PAYLABS_SIGNATURE_HEADER', 'X-Paylabs-Signature'),
        // Optional dedicated secret for webhook. Fallback to api_key when null.
        'secret' => env('PAYLABS_WEBHOOK_SECRET'),
    ],
];
