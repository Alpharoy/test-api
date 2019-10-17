<?php
/*
 |--------------------------------------------------------------------------
 | 授权模块 Auth 不需要登录权限
 |--------------------------------------------------------------------------
 */
Route::namespace('Auth')->group(function () {
    // 登入登出
    Route::post('login-tokens', 'LoginController@login')->middleware('hidden_request');
    Route::delete('login-tokens', 'LoginController@logout');

    Route::post('registers', 'RegisterController@store');
    Route::post('registers/send-sms', 'RegisterController@sendSms');
    Route::post('registers/verify-sms-code', 'RegisterController@verifySmsCode');
});

/*
 |--------------------------------------------------------------------------
 | auth:xxx 中间件，需要登录权限
 |--------------------------------------------------------------------------
 */
Route::middleware('auth:supplier')->group(function () {

    Route::get('me', 'Supplier\MeController@show');
    Route::put('me', 'Supplier\MeController@update');
    // 获取我的权限节点列表
    Route::get('me/nodes', 'Supplier\MeController@getRoleNode');
    // 更新密码
    Route::patch('me/password', 'Supplier\MeController@updatePassword')->middleware('hidden_request');

    /*
    |--------------------------------------------------------------------------
    | permission:xxx 中间件，需要权限验证
    |--------------------------------------------------------------------------
    */
    Route::middleware('permission:supplier.web')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | 供应商模块 Supplier
        |--------------------------------------------------------------------------
        */
        Route::prefix('suppliers')->namespace('Supplier')->group(function () {
            // 供应商资源CURD
            Route::apiResource('', 'SupplierController', [
                'parameters' => ['' => 'supplierUUID'],
                'only'       => ['index', 'show', 'update'],
            ]);
        });
        // 供应商业务类型（科目）
        Route::prefix('supplier-subjects')->namespace('Supplier')->group(function () {
            // 供应商资源CURD
            Route::apiResource('', 'SupplierSubjectController', [
                'parameters' => ['' => 'supplierSubjectUUID'],
                'only'       => ['index', 'store', 'update'],
            ]);
        });

        /*
         |--------------------------------------------------------------------------
         | 供应商管理员模块 SupplierUser
         |--------------------------------------------------------------------------
        */
        Route::apiResource('supplier-users', 'Supplier\SupplierUserController', [
            'parameters' => ['supplier-users' => 'userUUID'],
            'only'       => ['index', 'store', 'show', 'update'],
        ]);
        Route::prefix('supplier-users/{userUUID}')->group(function () {
            // 登录历史
            Route::get('login-logs', 'Supplier\SupplierUserController@loginLog');
            // 禁用与解禁用户
            Route::patch('lock', 'Supplier\SupplierUserController@lock');
            Route::patch('unlock', 'Supplier\SupplierUserController@unlock');
            // 重置密码
            Route::patch('reset-password',
                'Supplier\SupplierUserController@resetPassword')->middleware('hidden_request');
            // 权限
            Route::get('roles', 'Permission\UserRoleController@getUserRoles');
        });

        /*
        |--------------------------------------------------------------------------
        | 权限管理模块 Permission
        |--------------------------------------------------------------------------
       */
        Route::namespace('Permission')->group(function () {
            // 角色管理
            Route::apiResource('roles', 'RoleController', [
                'parameters' => ['roles' => 'id'],
                'only'       => ['index'],
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | 签约模块 Contract
        |--------------------------------------------------------------------------
        */
        Route::prefix('contracts')->namespace('Contract')->group(function () {
            // 签约资源CURD
            Route::apiResource('', 'ContractController', [
                'parameters' => ['' => 'contractUUID'],
                'only'       => ['index', 'show'],
            ]);
            //审核
            Route::post('{contractUUID}/audit-status', 'ContractController@changeAuditStatus');
        });

        /*
        |--------------------------------------------------------------------------
        | 项目模块 Project
        |--------------------------------------------------------------------------
        */
        Route::prefix('projects')->namespace('Project')->group(function () {
            //项目资源CURD
            Route::apiResource('', 'ProjectController', [
                'parameters' => ['' => 'projectUUID'],
                'only'       => ['index', 'show', 'update'],
            ]);
            //审核
            Route::post('{projectUUID}/audit-status', 'ProjectController@changeAuditStatus');
        });
        /*
             |--------------------------------------------------------------------------
             | 个体工商模块 SelfEmploy
             |--------------------------------------------------------------------------
             */
        Route::prefix('self-employs')->namespace('SelfEmploy')->group(function () {
            // 个体工商资源CURD
            Route::apiResource('', 'SelfEmployController', [
                'parameters' => ['' => 'selfEmployUUID'],
                'only'       => ['index', 'show',],
            ]);
        });

        /*
       |--------------------------------------------------------------------------
       | 自然人模块 NaturalPerson
       |--------------------------------------------------------------------------
        */
        Route::prefix('natural-persons')->namespace('NaturalPerson')->group(function () {
            // 个体工商资源CURD
            Route::apiResource('', 'NaturalPersonController', [
                'parameters' => ['' => 'userUUID'],
                'only'       => ['index', 'show'],
            ]);
        });
    });
});

Route::apiFallback();
