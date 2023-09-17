<?php 

return [

    /*
    |--------------------------------------------------------------------------
    | SMS API Integration Configuration File
    |--------------------------------------------------------------------------
    |
    | List of configuration options used for SMS API integration.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Environment Endpoints
    |--------------------------------------------------------------------------
    */
    'staging_url'    => env('SMS_STAGING_URL', 'https://devapi.globelabs.com.ph'),
    'production_url' => env('SMS_PRODUCTION_URL', 'https://devapi.globelabs.com.ph'),

    /*
    |--------------------------------------------------------------------------
    | API Credentials
    |---------------------------------------------------g-----------------------
    */
    'credentials' => [
        'app_id'     => env('SMS_APP_ID', 'eoezSz6MMeCb5cpd5gTMnGC8koGXSyGM'),
        'app_secret' => env('SMS_APP_SECRET', '0ccceeeb78eeb95c58e6440510f957c20d480a7ac49e8ea5c670a8387e2a80ca'),
    ],

];