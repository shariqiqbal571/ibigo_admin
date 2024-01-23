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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'twilio' => [
        'twilio_username' => env('TWILIO_USERNAME', null),
        'twilio_password' => env('TWILIO_PASSWORD', null),
        'twilio_sid' => env('TWILIO_SID'),
        'twilio_token' => env('TWILIO_TOKEN'),
        'twilio_number' => env('TWILIO_NUMBER'),
    ],

    // along with other services
    "msg91" => [
      'key' => env("Msg91_KEY"),
    ],

    'facebook' => [
        'client_id' => '956914064903282',
        'client_secret' => 'cb66f8b5216af3dcf5883ce15d4d5d02',
        'redirect' => '//localhost:8000/callback',
    ],

];
