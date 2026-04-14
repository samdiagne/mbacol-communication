<?php

return [
    'meta' => [
        'defaults' => [
            'title' => 'Mbacol Communication - Électronique & Informatique au Sénégal',
            'titleBefore' => false, 
            'description' => 'Boutique en ligne d\'électronique, smartphones, ordinateurs et accessoires au Sénégal. Livraison rapide à Dakar. Paiement sécurisé Wave, Orange Money.',
            'separator' => ' | ', 
            'keywords' => ['électronique Sénégal', 'smartphone Dakar', 'ordinateur Sénégal', 'accessoires informatique', 'Mbacol Communication'],
            'canonical' => null,
            'robots' => 'index, follow',
        ],
    'webmaster_tags' => [
            'google' => null,
            'bing' => null,
            'alexa' => null,
            'pinterest' => null,
            'yandex' => null,
            'norton' => null,
        ],
    'add_notranslate_class' => false,
    ],
    'opengraph' => [
        'defaults' => [
            'title' => 'Mbacol Communication - Électronique au Sénégal',
            'description' => 'Smartphones, ordinateurs, accessoires. Livraison Dakar.',
            'url' => env('APP_URL', 'https://mbacol313.com'),
            'type' => 'website',
            'site_name' => 'Mbacol Communication',
            'images' => [env('APP_URL', 'https://mbacol313.com').'/images/logo.webp'],
        ],
    ],
    'twitter' => [
        'defaults' => [
            'card' => 'summary_large_image',
            'site' => '@MbacolComm', // Remplace si compte Twitter existe
        ],
    ],
    'json-ld' => [
        'defaults' => [
            'title' => 'Mbacol Communication',
            'description' => 'Électronique et informatique au Sénégal',
            'url' => env('APP_URL'),
            'type' => 'Store',
            'images' => [],
        ],
    ],
];