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
});

/*
 |--------------------------------------------------------------------------
 | auth:xxx 中间件，需要登录权限
 |--------------------------------------------------------------------------
 */
Route::middleware('auth:admin')->group(function () {

    Route::get('me', 'Admin\MeController@show');
    Route::put('me', 'Admin\MeController@update');
    // 获取我的权限节点列表
    Route::get('me/nodes', 'Admin\MeController@getRoleNode');
    // 更新密码
    Route::patch('me/password', 'Admin\MeController@updatePassword')->middleware('hidden_request');

    /*
    |--------------------------------------------------------------------------
    | permission:xxx 中间件，需要权限验证
    |--------------------------------------------------------------------------
    */
    Route::middleware('permission:admin.web')->group(function () {
        /*
        |--------------------------------------------------------------------------
        | 管理公司模块 Admin
        |--------------------------------------------------------------------------
        */
        Route::apiResource('admins', 'Admin\AdminController', [
            'parameters' => ['admins' => 'adminUUID'],
            'only'       => ['index', 'show', 'update'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | 管理公司管理员模块 AdminUser
        |--------------------------------------------------------------------------
        */
        Route::apiResource('admin-users', 'Admin\AdminUserController', [
            'parameters' => ['admin-users' => 'userUUID'],
            'only'       => ['index', 'store', 'show', 'update'],
        ]);
        Route::prefix('admin-users/{userUUID}')->group(function () {
            // 登录历史
            Route::get('login-logs', 'Admin\AdminUserController@loginLog');
            // 禁用与解禁用户
            Route::patch('lock', 'Admin\AdminUserController@lock');
            Route::patch('unlock', 'Admin\AdminUserController@unlock');
            // 重置密码
            Route::patch('reset-password', 'Admin\AdminUserController@resetPassword')->middleware('hidden_request');
            // 权限
            Route::get('roles', 'Permission\UserRoleController@getUserRoles');
        });

        /*
        |--------------------------------------------------------------------------
        | 企业管理员模块 EnterpriseUser
        |--------------------------------------------------------------------------
        */
        Route::prefix('enterprises/{enterpriseUUID}')->group(function () {
            Route::apiResource('enterprise-users', 'Enterprise\EnterpriseUserController', [
                'parameters' => ['enterprise-users' => 'userUUID'],
                'only'       => ['index', 'store', 'show', 'update'],
            ]);
            Route::prefix('enterprise-users/{userUUID}')->group(function () {
                // 登录历史
                Route::get('login-logs', 'Enterprise\EnterpriseUserController@loginLog');
                // 权限
                Route::get('roles', 'Permission\UserRoleController@getUserRoles');
            });
        });

        /*
        |--------------------------------------------------------------------------
        | 供应商管理员模块 SupplierUser
        |--------------------------------------------------------------------------
        */
        Route::prefix('suppliers/{supplierUUID}')->group(function () {
            Route::apiResource('supplier-users', 'Supplier\SupplierUserController', [
                'parameters' => ['supplier-users' => 'userUUID'],
                'only'       => ['index', 'store', 'show', 'update'],
            ]);
            Route::prefix('supplier-users/{userUUID}')->group(function () {
                // 登录历史
                Route::get('login-logs', 'Supplier\SupplierUserController@loginLog');
                // 权限
                Route::get('roles', 'Permission\UserRoleController@getUserRoles');
            });
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
                'only'       => ['index', 'store', 'show', 'update', 'destroy'],
            ]);
            // 菜单管理
            Route::apiResource('menus', 'MenuController', [
                'parameters' => ['menus' => 'id'],
                'only'       => ['index', 'store', 'show', 'update', 'destroy'],
            ]);
            // 节点列表
            Route::get('nodes', 'NodeController@index');
        });

        /*
        |--------------------------------------------------------------------------
        | 企业模块 Enterprise
        |--------------------------------------------------------------------------
        */
        Route::prefix('enterprises')->namespace('Enterprise')->group(function () {
            // 企业审核
            Route::post('{enterpriseUUID}/audit-status', 'EnterpriseController@changeAuditStatus');
            // 企业资源CURD
            Route::apiResource('', 'EnterpriseController', [
                'parameters' => ['' => 'enterpriseUUID'],
                'only'       => ['index', 'show', 'update', 'store'],
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | 供应商模块 Supplier
        |--------------------------------------------------------------------------
        */
        Route::prefix('suppliers')->namespace('Supplier')->group(function () {
            // 供应商审核
            Route::post('{supplierUUID}/audit-status', 'SupplierController@changeAuditStatus');
            // 供应商资源CURD
            Route::apiResource('', 'SupplierController', [
                'parameters' => ['' => 'supplierUUID'],
                'only'       => ['index', 'show', 'update', 'store'],
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
                'only'       => ['index', 'show'],
            ]);
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
                'only'       => ['index', 'show'],
            ]);
        });
        /*
        |--------------------------------------------------------------------------
        | 个体工商模块 SelfEmploy
        |--------------------------------------------------------------------------
        */
        Route::prefix('self-employs')->namespace('SelfEmploy')->group(function () {
            // 个体工商审核
            Route::post('{selfEmployUUID}/audit-status', 'SelfEmployController@changeAuditStatus');
            // 个体工商资源CURD
            Route::apiResource('', 'SelfEmployController', [
                'parameters' => ['' => 'selfEmployUUID'],
                'only'       => ['index', 'show', 'update', 'store'],
            ]);
        });
        /*
       |--------------------------------------------------------------------------
       | 个体工商管理员模块 SelfEmployUser
       |--------------------------------------------------------------------------
       */
        Route::prefix('self-employs/{selfEmployUUID}')->group(function () {
            Route::apiResource('self-employ-users', 'SelfEmploy\SelfEmployUserController', [
                'parameters' => ['self-employ-users' => 'userUUID'],
                'only'       => ['index', 'show', 'update'],
            ]);
        });


        /*
        |--------------------------------------------------------------------------
        | 自然人模块 NaturalPerson
        |--------------------------------------------------------------------------
         */
        Route::prefix('natural-persons')->namespace('NaturalPerson')->group(function () {
            // 自然人审核
            Route::post('{userUUID}/audit-status', 'NaturalPersonController@changeAuditStatus');
            // 自然人资源CURD
            Route::apiResource('', 'NaturalPersonController', [
                'parameters' => ['' => 'userUUID'],
                'only'       => ['index', 'show', 'update', 'store'],
            ]);
        });

        /*
      |--------------------------------------------------------------------------
      | 自然人银行卡模块 NaturalPersonBankCard
      |--------------------------------------------------------------------------
      */
        Route::prefix('natural-persons/{userUUID}')->group(function () {
            Route::apiResource('bank-cards', 'NaturalPerson\NaturalPersonBankCardController', [
                'parameters' => ['bank-cards' => 'bankCardUUID'],
                'only'       => ['index', 'show', 'update', 'store', 'destroy'],
            ]);
        });
    });
});

Route::apiFallback();
