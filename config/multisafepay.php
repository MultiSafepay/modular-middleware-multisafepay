<?php

// config for Modular-Middleware/ModularMiddlewareMultiSafepay
return [
    'apiUrl' => env('MULTISAFEPAY_API_URL', 'https://api.multisafepay.com/v1/json/'),
    'teams_Webhook' => env("TEAMS_WEBHOOK"),
];
