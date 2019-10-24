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
Route::middleware('auth:enterprise')->group(function () {

    Route::get('me', 'Enterprise\MeController@show');
    Route::put('me', 'Enterprise\MeController@update');
    // 获取我的权限节点列表
    Route::get('me/nodes', 'Enterprise\MeController@getRoleNode');
    // 更新密码
    Route::patch('me/password', 'Enterprise\MeController@updatePassword')->middleware('hidden_request');

    /*
    |--------------------------------------------------------------------------
    | permission:xxx 中间件，需要权限验证
    |--------------------------------------------------------------------------
    */
    Route::middleware('permission:enterprise.web')->group(function () {
        /*
        |--------------------------------------------------------------------------
        | 企业模块 Enterprise
        |--------------------------------------------------------------------------
        */
        Route::prefix('enterprises')->namespace('Enterprise')->group(function () {
            // 企业资源CURD
            Route::apiResource('', 'EnterpriseController', [
                'parameters' => ['' => 'enterpriseUUID'],
                'only'       => ['index', 'show', 'update'],
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | 管理公司管理员模块 EnterpriseUser
        |--------------------------------------------------------------------------
        */
        Route::apiResource('enterprise-users', 'Enterprise\EnterpriseUserController', [
            'parameters' => ['enterprise-users' => 'userUUID'],
            'only'       => ['index', 'store', 'show', 'update'],
        ]);
        Route::prefix('enterprise-users/{userUUID}')->group(function () {
            // 登录历史
            Route::get('login-logs', 'Enterprise\EnterpriseUserController@loginLog');
            // 禁用与解禁用户
            Route::patch('lock', 'Enterprise\EnterpriseUserController@lock');
            Route::patch('unlock', 'Enterprise\EnterpriseUserController@unlock');
            // 重置密码
            Route::patch('reset-password',
                'Enterprise\EnterpriseUserController@resetPassword')->middleware('hidden_request');
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
            Route::apiResource('', 'ContractController', [
                'parameters' => ['' => 'contractUUID'],
                'only'       => ['index', 'show', 'update', 'store', 'destroy'],
            ]);
        });


        /*
        |--------------------------------------------------------------------------
        | 项目模块 Project
        |--------------------------------------------------------------------------
        */
        Route::prefix('projects')->namespace('Project')->group(function () {
            Route::apiResource('', 'ProjectController', [
                'parameters' => ['' => 'projectUUID'],
                'only'       => ['index', 'show', 'update', 'store', 'destroy'],
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | 供应商模块 Supplier
        |--------------------------------------------------------------------------
        */
        Route::prefix('suppliers')->namespace('Supplier')->group(function () {
            // 供应商行业类型
            Route::get('{supplierUUID}/supplier-subjects', 'SupplierSubjectController@index');
            Route::apiResource('', 'SupplierController', [
                'parameters' => ['' => 'supplierUUID'],
                'only'       => ['index'],
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | 个体工商模块 SelfEmploy
        |--------------------------------------------------------------------------
        */
        Route::namespace('SelfEmploy')->group(function () {
            Route::get('enterprises/self-employs', 'EnterpriseRelationSelfEmployController@index');
            Route::get('enterprises/self-employs/{selfEmployUUID}', 'EnterpriseRelationSelfEmployController@show');
            Route::get('self-employs', 'SelfEmployController@index');
        });

        /*
        |--------------------------------------------------------------------------
        | 自然人模块 NaturalPerson
        |--------------------------------------------------------------------------
        */
        Route::namespace('NaturalPerson')->group(function () {
            Route::get('enterprises/natural-persons', 'EnterpriseRelationNaturalPersonController@index');
            Route::get('enterprises/natural-persons/{userUUID}', 'EnterpriseRelationNaturalPersonController@show');
            Route::get('natural-persons', 'NaturalPersonController@index');
        });

        /*
        |--------------------------------------------------------------------------
        | 任务订单
        |--------------------------------------------------------------------------
        */
        Route::prefix('tasks')->namespace('Task')->group(function () {
            Route::apiResource('', 'TaskController', [
                'parameters' => ['' => 'taskUUID'],
                'only'       => ['index', 'show', 'update', 'store', 'destroy'],
            ]);
        });
    });
});

Route::apiFallback();
