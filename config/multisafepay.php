<?php

// config for Modular-Middleware/ModularMiddlewareMultiSafepay
return [
    'apiUrl' => [
        'test' => env('MULTISAFEPAY_TEST_API_URL', 'https://testapi.multisafepay.com/v1/json/'),
        'dev' => env('MULTISAFEPAY_DEV_API_URL', 'https://devapi.multisafepay.com/v1/json/'),
        'live' => env('MULTISAFEPAY_LIVE_API_URL', 'https://api.multisafepay.com/v1/json/'),
    ],
    'teams_Webhook' => env("TEAMS_WEBHOOK"),
];
