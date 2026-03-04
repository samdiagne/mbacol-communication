<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Mode PayDunya
    |--------------------------------------------------------------------------
    | 
    | Mode de fonctionnement : 'test' ou 'live'
    | En test, utilisez les credentials sandbox
    |
    */
    'mode' => env('PAYDUNYA_MODE', 'test'),

    /*
    |--------------------------------------------------------------------------
    | Credentials API
    |--------------------------------------------------------------------------
    |
    | Obtenez vos credentials sur : https://app.paydunya.com
    | Dashboard → API Keys
    |
    */
    'master_key' => env('PAYDUNYA_MASTER_KEY', ''),
    'private_key' => env('PAYDUNYA_PRIVATE_KEY', ''),
    'token' => env('PAYDUNYA_TOKEN', ''),

    /*
    |--------------------------------------------------------------------------
    | Informations Marchand
    |--------------------------------------------------------------------------
    */
    'store_name' => env('PAYDUNYA_STORE_NAME', 'Mbacol Communication'),
    'store_tagline' => env('PAYDUNYA_STORE_TAGLINE', 'E-commerce Sénégal'),
    'store_url' => env('PAYDUNYA_STORE_URL', env('APP_URL')),
    'store_logo' => env('PAYDUNYA_STORE_LOGO', ''),

    /*
    |--------------------------------------------------------------------------
    | URLs de Callback
    |--------------------------------------------------------------------------
    |
    | Ces URLs doivent être accessibles publiquement
    | Le webhook DOIT être en POST sans CSRF
    |
    */
    'urls' => [
        'return_url' => env('APP_URL') . '/payment/paydunya/return',
        'cancel_url' => env('APP_URL') . '/payment/paydunya/cancel',
        'callback_url' => env('APP_URL') . '/payment/webhook/paydunya',
    ],

    /*
    |--------------------------------------------------------------------------
    | Configuration Avancée
    |--------------------------------------------------------------------------
    */
    'currency' => 'XOF', // Franc CFA
    'timeout' => 30, // Secondes
    'verify_ssl' => env('PAYDUNYA_VERIFY_SSL', true),
    
    /*
    |--------------------------------------------------------------------------
    | Logs & Debug
    |--------------------------------------------------------------------------
    */
    'log_requests' => env('PAYDUNYA_LOG_REQUESTS', true),
    'log_channel' => 'daily',
];
