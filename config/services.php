<?php

return [

    /*


     'facebook' => [
        'client_id' => '472784043251359',
        'client_secret' => 'a0efff62b3d92d79308b056e3708ef28',
        'redirect' => 'http://localhost:8000/auth/facebook/callback',
    ],
    'twitter' => [
        'client_id' => '4b2Kmh7err7SrneHVJkWjnNxh',
        'client_secret' => 'wbmhvMJSwEqqr9l6ejAHYXGQELaR8OZZQ7J8qyaAPjadFtCNQH',
        'redirect' => 'http://localhost:8000/auth/twitter/callback',
    ],
     'google' => [
        'client_id' => '263324683356-dsjekqbujlfd10864ip2u88t041b0i9f.apps.googleusercontent.com',
        'client_secret' => 'gUoU9bH8yAcZluQdRViIS7gb',
        'redirect' => 'http://localhost:8000/auth/googleplus/callback',
    ],


      'paypal' => [
        'client_id'     =>   'AQcBzjSXKBx8DfeyDb-1BSjqRnoxI08CmAkMb_4tV0yWgwXd6YbwgmIdsxYUSLQA2JomXLsWErw4OzQP',
        'secret'        =>   'EJoEJ3eTTkyGSKBv7q8zWbx3s7rj5DLJOeA2ve-JQJG3CWdBr41m5cmjUdCdpx_8gbQ2jRcgWpcZtUSa',
        ]


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
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],
     'facebook' => [
        'client_id' => '',
        'client_secret' => '',
        'redirect' => '',
    ],
    'twitter' => [
        'client_id' => '',
        'client_secret' => '',
        'redirect' => '',
    ],
     'google' => [
        'client_id' => '',
        'client_secret' => '',
        'redirect' => '',
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
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],
     'authorize_net' => [
        'key'           =>   '',
        'secret'        =>   '',
    ],
    'paypal' => [
        'client_id'     =>   '',
        'secret'        =>   '',
        'settings' => [
        'mode' => 'sandbox',
        'http.ConnectionTimeOut' => 1000,   
        ],
    ],
    'easypost' => [
        'api_key' => 'y4HNPR7IVaSFphhKI2Ye3Q',
    ]
    

];
