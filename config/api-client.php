<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Options
    |--------------------------------------------------------------------------
    |
    | Api client global options.
    |
    */
    'options'  => [
        // 是否开启调试模式
        'debug'              => env('API_CLIENT_DEBUG', false),

        // 所有服务是否需要签名
        'api_sign'           => false,

        // 签名所用算法
        'api_sign_algorithm' => 'hmac-sha256',

        // 超时时间
        'timeout'            => 30.0,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Options
    |--------------------------------------------------------------------------
    |
    | Api client services options.
    |
    */
    'services' => [
        'area-api'        => [
            'api_sign'   => true,
            'api_key'    => env('API_CLIENT_AREA_API_KEY'),
            'api_secret' => env('API_CLIENT_AREA_API_SECRET'),
            'base_uri'   => env('API_CLIENT_AREA_API_BASE_URI') . '/api/v1/',
        ],
        'area-public-api' => [
            'base_uri' => env('API_CLIENT_AREA_PUBLIC_API_BASE_URI'),
        ],
        'oss-api'         => [
            'api_sign'   => true,
            'api_key'    => env('API_CLIENT_OSS_API_KEY'),
            'api_secret' => env('API_CLIENT_OSS_API_SECRET'),
            'base_uri'   => env('API_CLIENT_OSS_API_BASE_URI') . '/internal-api/v1/',
        ],
        'oss-public-api'  => [
            'base_uri' => env('API_CLIENT_OSS_PUBLIC_API_BASE_URI') . '/api/',
        ],
    ],
];
