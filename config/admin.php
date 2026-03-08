<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Email Admin
    |--------------------------------------------------------------------------
    |
    | Email de l'administrateur pour recevoir les notifications
    | (nouvelles commandes, messages contact, etc.)
    |
    */
    'email' => env('ADMIN_EMAIL', 'admin@mbacolcommunication.sn'),
    
    /*
    |--------------------------------------------------------------------------
    | Nom Admin
    |--------------------------------------------------------------------------
    */
    'name' => env('ADMIN_NAME', 'Administration Mbacol'),
];