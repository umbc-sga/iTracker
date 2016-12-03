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
        'region' => 'us-east-1',
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
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET')
    ],

    'basecamp' => [
        'openAccess' => env('BASECAMP_OPEN_ACCESS', false),
        'url' => 'https://3.basecampapi.com/'.env('BASECAMP_ID').'/',
        'id' => env('BASECAMP_CLIENT_ID'),
        'secret' => env('BASECAMP_CLIENT_SECRET'),
        'authUrl' => 'https://launchpad.37signals.com/authorization/new',
        'tokenUrl' => 'https://launchpad.37signals.com/authorization/token',
        'cachingEnabled' => env('BASECAMP_API_CACHING', true),
        'cacheAgeOff' => env('BASECAMP_API_CACHE_TIME', 60)
    ]

];
