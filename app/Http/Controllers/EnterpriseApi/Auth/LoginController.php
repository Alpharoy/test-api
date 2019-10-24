<?php

namespace App\Http\Controllers\EnterpriseApi\Auth;

use App\Http\Controllers\EnterpriseApi\BaseController;
use App\Http\Requests\EnterpriseApi\Auth\LoginRequest;
use App\Http\Resources\EnterpriseApi\Auth\LoginResource;
use App\Http\Resources\EmptyResource;
use App\Models\Enterprise\Enterprise;
use App\Models\Enterprise\EnterpriseUser;
use App\Services\Auth\LoginService;
use App\Services\Auth\TokenService;
use App\Services\Auth\VerifyCodeService;
use App\Services\Permission\UserRoleService;
use Illuminate\Support\Facades\Auth;
use Urland\Exceptions\Client\ForbiddenException;

/**
 * 认证服务
 * Class LoginController
 *
 * @package App\Http\Controllers\EnterpriseApi\Auth
 */
class LoginController extends BaseController
{

    /**
     * 登录逻辑
     *
     * @param \App\Http\Requests\EnterpriseApi\Auth\LoginRequest $request
     *
     * @return \App\Http\Resources\EnterpriseApi\Auth\LoginResource
     */
    public function login(LoginRequest $request)
    {
        $account  = $request->input('account');
        $password = $request->input('password');

        // 校验验证码是否正确
        VerifyCodeService::verify($request->header('X-Api-Token'), $request->input('verify_code'));

        $userGroup = cons('user.group.enterprise');
        $login     = LoginService::login($userGroup, $account, $password);

        // 获取管理员信息
        $enterpriseUser = EnterpriseUser::where('user_uuid', $login['user_uuid'])->firstOrFail();

        // 获取当前企业信息
        $enterprise = Enterprise::where('enterprise_uuid', $enterpriseUser->enterprise_uuid)->firstOrFail();
        if ($enterprise->status !== cons('common.audit_status.passed')) {
            throw new ForbiddenException('当前所在企业未审核通过，禁止登录');
        }

        // 更新权限信息
        UserRoleService::fetchUserNodes($login['user_uuid'], [config('node.enterprise.web.type')],
            true);

        return new LoginResource(['token' => $login['token'], 'user' => $enterpriseUser]);
    }

    /**
     * 退出登录
     *
     * @return \App\Http\Resources\EmptyResource
     */
    public function logout()
    {
        $enterpriseUser = Auth::user();
        if ($enterpriseUser) {
            /* @var \App\Models\Enterprise\EnterpriseUser $enterpriseUser */
            UserRoleService::removeCache($enterpriseUser->user_uuid);
            TokenService::setTimeOutTokenByUUID($enterpriseUser->user_uuid, 'web');
        }
        return new EmptyResource();
    }

}