<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-u2DgNJmMZF8F9PP1DKZLtQNb'),
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-Rmlon8-SFdL7DRF6'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),
];

