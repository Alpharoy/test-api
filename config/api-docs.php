<?php

return [

    'build_path' => resource_path('docs'),

    'providers' => [
        'app_logistics_api' => [
            'driver'  => 'open_api',
            'uri'     => 'app/logistics-api/v1',
            'options' => [
                'schema'        => [
                    'remove_prefix' => 'App\Http\Resources\AppLogisticsApi\V1',
                    'remove_suffix' => 'Resource',
                ],
                'info'          => [
                    'title'       => 'DLMS物流公司App接口',
                    'version'     => '1.0.0',
                    'description' => '请求接口地址：' . rtrim(env('APP_URL'), '/') . '/app/logistics-api/v1/',
                ],
                'external_docs' => [
                    'description' => '接口接入规范文档',
                    'url'         => 'https://gitlab.come56.com/php-packages/laravel-api/wikis/api-standard',
                ],
            ],
        ],
    ],
];