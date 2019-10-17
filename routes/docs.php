<?php

Route::get('/{any}', function ($name) {
    $providerName = str_replace('-', '_', $name);
    header('Access-Control-Allow-Origin: *');
    echo app('api-docs')->generate($providerName);
})->where('any', '.*');