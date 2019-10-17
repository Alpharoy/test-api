<?php

/*
 |--------------------------------------------------------------------------
 | 授权模块 Auth
 |--------------------------------------------------------------------------
 */
Route::namespace('Auth')->group(function () {
    // 通讯token
    Route::post('tokens', 'LoginController@getToken');

    // 验证码
    Route::get('verify-code', 'LoginController@verifyCode');
});

Route::namespace('OSS')->group(function () {
    // 上传图片token
    Route::post('image-tokens', 'OSSController@storeImageToken');

    // 上传文件token
    Route::post('file-tokens', 'OSSController@storeFileToken');
});

Route::prefix('callback')->namespace('Callback')->group(function () {

    Route::post('pay56', 'Pay56Controller@store');
});

Route::apiFallback();
