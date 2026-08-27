<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'cpbl' => [
        'base_url' => env('CPBL_BASE_URL', 'https://www.cpbl.com.tw'),
        'timeout' => env('CPBL_TIMEOUT', 20),
        'connect_timeout' => env('CPBL_CONNECT_TIMEOUT', 5),
        'retry_times' => env('CPBL_RETRY_TIMES', 3),
    ],

    'mlb' => [
        'base_url' => env('MLB_BASE_URL', 'https://statsapi.mlb.com'),
        'timeout' => env('MLB_TIMEOUT', 20),
        'connect_timeout' => env('MLB_CONNECT_TIMEOUT', 5),
        'retry_times' => env('MLB_RETRY_TIMES', 3),
    ],

];
