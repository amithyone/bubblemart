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

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'telegram' => [
        'bot_token' => env('TELEGRAM_BOT_TOKEN'),
        'chat_id' => env('TELEGRAM_CHAT_ID'),
        'chat_id_2' => env('TELEGRAM_CHAT_ID_2'),
        'chat_id_3' => env('TELEGRAM_CHAT_ID_3'),
        'chat_id_4' => env('TELEGRAM_CHAT_ID_4'),
        'chat_id_5' => env('TELEGRAM_CHAT_ID_5'),
        'chat_ids' => [
            env('TELEGRAM_CHAT_ID'),
            env('TELEGRAM_CHAT_ID_2'),
            env('TELEGRAM_CHAT_ID_3'),
            env('TELEGRAM_CHAT_ID_4'),
            env('TELEGRAM_CHAT_ID_5'),
        ],
    ],

];
