<?php

namespace App\Http\Controllers\AdminApi\Auth;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\Auth\LoginRequest;
use App\Http\Resources\AdminApi\Auth\LoginResource;
use App\Http\Resources\EmptyResource;
use App\Models\Admin\AdminUser;
use App\Services\Auth\LoginService;
use App\Services\Auth\TokenService;
use App\Services\Auth\VerifyCodeService;
use App\Services\Permission\UserRoleService;
use Illuminate\Support\Facades\Auth;

/**
 * 认证服务
 * Class LoginController
 *
 * @package App\Http\Controllers\AdminApi\Auth
 */
class LoginController extends BaseController
{

    /**
     * 登录逻辑
     *
     * @param \App\Http\Requests\AdminApi\Auth\LoginRequest $request
     *
     * @return \App\Http\Resources\AdminApi\Auth\LoginResource
     */
    public function login(LoginRequest $request)
    {
        $account  = $request->input('account');
        $password = $request->input('password');

        // 校验验证码是否正确
        VerifyCodeService::verify($request->header('X-Api-Token'), $request->input('verify_code'));

        $userGroup = cons('user.group.admin');
        $login     = LoginService::login($userGroup, $account, $password);

        // 获取管理员信息
        $adminUser = AdminUser::where('user_uuid', $login['user_uuid'])->firstOrFail();

        // 更新权限信息
        UserRoleService::fetchUserNodes($login['user_uuid'], [config('node.admin.web.type')],
            true);

        return new LoginResource(['token' => $login['token'], 'user' => $adminUser]);
    }

    /**
     * 退出登录
     *
     * @return \App\Http\Resources\EmptyResource
     */
    public function logout()
    {
        $adminUser = Auth::user();
        if ($adminUser) {
            /* @var \App\Models\Admin\AdminUser $adminUser */
            UserRoleService::removeCache($adminUser->user_uuid);
            TokenService::setTimeOutTokenByUUID($adminUser->user_uuid, 'web');
        }
        return new EmptyResource();
    }

}