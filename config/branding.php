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

    'name' => env('BRAND_NAME', 'Nora Padel'),

    /*
    |--------------------------------------------------------------------------
    | Brand Tagline
    |--------------------------------------------------------------------------
    |
    | Tagline brand
    |
    */

    'tagline' => env('BRAND_TAGLINE', 'Performa Maksimal, Game Makin Total'),

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

    'logo' => env('BRAND_LOGO', 'images/nora-padel-logo.svg'),
    
    'logo_dark' => env('BRAND_LOGO_DARK', 'images/nora-padel-logo.svg'),
    
    'logo_white' => env('BRAND_LOGO_WHITE', 'images/nora-padel-logo.svg'),
    
    'favicon' => env('BRAND_FAVICON', 'images/nora-padel-favicon.svg'),

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

    'email' => env('BRAND_EMAIL', 'hello@norapadel.id'),
    'phone' => env('BRAND_PHONE', '+62 812 7788 9900'),
    'address' => env('BRAND_ADDRESS', 'Jl. Padel Arena No. 21, Surabaya'),

    /*
    |--------------------------------------------------------------------------
    | Store Location
    |--------------------------------------------------------------------------
    |
    | Koordinat lokasi toko untuk perhitungan ongkos kirim
    | Lokasi: Kec. Tarik, Kab. Sidoarjo, Jawa Timur
    |
    */

    'store_latitude' => env('STORE_LATITUDE', -7.4674),
    'store_longitude' => env('STORE_LONGITUDE', 112.5274),

    /*
    |--------------------------------------------------------------------------
    | Social Media
    |--------------------------------------------------------------------------
    */

    'social' => [
        'instagram' => env('BRAND_INSTAGRAM', '@norapadel.id'),
        'facebook' => env('BRAND_FACEBOOK', ''),
        'whatsapp' => env('BRAND_WHATSAPP', '6281277889900'),
    ],

];
