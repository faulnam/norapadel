<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Brand Name
    |--------------------------------------------------------------------------
    |
    | Nama brand yang ditampilkan di seluruh aplikasi
    |
    */

    'name' => env('BRAND_NAME', 'PATAH'),

    /*
    |--------------------------------------------------------------------------
    | Brand Tagline
    |--------------------------------------------------------------------------
    |
    | Tagline brand
    |
    */

    'tagline' => env('BRAND_TAGLINE', 'Kerupuk Pakcoy & Tahu'),

    /*
    |--------------------------------------------------------------------------
    | Logo Settings
    |--------------------------------------------------------------------------
    |
    | Path logo relatif dari folder public/
    | Taruh file logo di public/images/
    |
    | Contoh: jika logo ada di public/images/logo.png
    | maka isi dengan 'images/logo.png'
    |
    */

    'logo' => env('BRAND_LOGO', 'images/logo.png'),
    
    'logo_dark' => env('BRAND_LOGO_DARK', 'images/logo-dark.png'),
    
    'logo_white' => env('BRAND_LOGO_WHITE', 'images/logo-white.png'),
    
    'favicon' => env('BRAND_FAVICON', 'images/favicon.ico'),

    /*
    |--------------------------------------------------------------------------
    | Logo Sizes
    |--------------------------------------------------------------------------
    |
    | Ukuran default logo dalam pixel
    |
    */

    'logo_height' => [
        'navbar' => 40,
        'sidebar' => 32,
        'footer' => 36,
        'receipt' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Contact Information
    |--------------------------------------------------------------------------
    */

    'email' => env('BRAND_EMAIL', 'hello@patah.id'),
    'phone' => env('BRAND_PHONE', '+62 812 3456 7890'),
    'address' => env('BRAND_ADDRESS', 'Surabaya, Jawa Timur'),

    /*
    |--------------------------------------------------------------------------
    | Social Media
    |--------------------------------------------------------------------------
    */

    'social' => [
        'instagram' => env('BRAND_INSTAGRAM', '@patah.id'),
        'facebook' => env('BRAND_FACEBOOK', ''),
        'whatsapp' => env('BRAND_WHATSAPP', '6281234567890'),
    ],

];
