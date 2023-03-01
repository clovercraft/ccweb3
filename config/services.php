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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'discord' => [
        'guild'             => env('DISCORD_GUILD', ''),
        'client_id'         => env('DISCORD_CLIENT_ID', ''),
        'client_secret'     => env('DISCORD_CLIENT_SECRET', ''),
        'bot_token'         => env('DISCORD_BOT_TOKEN', ''),
        'intro_channel'     => '790028088565432340',
        'whitelist_channel' => '801512347235254283',
        'redirect'          => env('DISCORD_REDIRECT_URI', ''),
    ],

    'minecraft' => [
        'serverip'          => env('MINECRAFT_SERVER_ADDR', ''),
        'denizen_secret'    => env('MINECRAFT_DENIZEN_SECRET', ''),
    ]

];
