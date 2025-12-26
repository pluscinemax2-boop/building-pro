<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Razorpay Configuration
    |--------------------------------------------------------------------------
    |
    | Razorpay API credentials for payment processing
    | Get these from https://dashboard.razorpay.com/app/credentials
    |
    */

    'key_id' => env('RAZORPAY_KEY_ID', 'rzp_test_RrWrMmtNfNmu6m'),

    'key_secret' => env('RAZORPAY_KEY_SECRET', '860L8VxOAk6XnaZkTFlIdoiX'),

    /*
    |--------------------------------------------------------------------------
    | Razorpay Account Details
    |--------------------------------------------------------------------------
    */

    'account_name' => env('RAZORPAY_ACCOUNT_NAME', 'Building Manager Pro'),

    'account_email' => env('RAZORPAY_ACCOUNT_EMAIL', 'support@buildingmanagerpro.com'),

    'account_contact' => env('RAZORPAY_ACCOUNT_CONTACT', '9999999999'),

    /*
    |--------------------------------------------------------------------------
    | Webhook Secret
    |--------------------------------------------------------------------------
    | Used to verify webhook signatures from Razorpay
    */

    'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Currency and Settings
    |--------------------------------------------------------------------------
    */

    'currency' => 'INR',

    'timezone' => 'Asia/Kolkata',

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    | Set to 'live' for production, 'test' for testing
    */

    'environment' => env('RAZORPAY_ENVIRONMENT', 'test'),

    /*
    |--------------------------------------------------------------------------
    | Payment Methods
    |--------------------------------------------------------------------------
    | Enabled payment methods for Razorpay checkout
    */

    'enabled_methods' => [
        'card' => true,           // Credit/Debit cards
        'netbanking' => true,     // Internet Banking
        'upi' => true,            // UPI payments
        'wallet' => true,         // Mobile wallets
        'emi' => false,           // EMI (disabled)
    ],
];
