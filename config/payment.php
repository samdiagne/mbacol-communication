<?php

return [
    'sandbox_mode' => env('PAYMENT_SANDBOX', true),

    'wave' => [
        'api_url' => env('WAVE_API_URL', 'https://api.wave.com/v1'),
        'api_key' => env('WAVE_API_KEY', ''),
        'sandbox' => env('WAVE_SANDBOX', true),
    ],

    'orange' => [
        'api_url' => env('ORANGE_API_URL', 'https://api.orange.com'),
        'merchant_key' => env('ORANGE_MERCHANT_KEY', ''),
        'merchant_phone' => env('ORANGE_MERCHANT_PHONE', ''),
        'sandbox' => env('ORANGE_SANDBOX', true),
    ],

    'free' => [
        'api_url' => env('FREE_API_URL', ''),
        'merchant_id' => env('FREE_MERCHANT_ID', ''),
        'sandbox' => env('FREE_SANDBOX', true),
    ],

    'yass' => [
        'api_url' => env('YASS_API_URL', ''),
        'api_key' => env('YASS_API_KEY', ''),
        'sandbox' => env('YASS_SANDBOX', true),
    ],
];