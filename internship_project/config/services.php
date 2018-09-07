<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'google' => [
        'client_id' => '447233711378-3vr1os5ra68bh01rklkj2picg32qm10k.apps.googleusercontent.com',
        'client_secret' => 'QgYtxaA7FESxAQFfbB1zXNZj',
        'redirect' => 'http://localhost:8000/auth/google/callback',
    ],
    
    'facebook' => [
        'client_id' => '259800081423152',
        'client_secret' => 'c94a53d83b03e6ae932c6d78f4d2bcf4',
        'redirect' => 'https://localhost:8000/auth/facebook/callbacks',
    ],

];
