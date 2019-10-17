<?php

namespace App\Http\Controllers\SupplierApi\Auth;

use App\Http\Controllers\SupplierApi\BaseController;
use App\Http\Requests\SupplierApi\Auth\LoginRequest;
use App\Http\Resources\SupplierApi\Auth\LoginResource;
use App\Http\Resources\EmptyResource;
use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierUser;
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
 * @package App\Http\Controllers\SupplierApi\Auth
 */
class LoginController extends BaseController
{

    /**
     * 登录逻辑
     *
     * @param \App\Http\Requests\SupplierApi\Auth\LoginRequest $request
     *
     * @return \App\Http\Resources\SupplierApi\Auth\LoginResource
     */
    public function login(LoginRequest $request)
    {
        $account  = $request->input('account');
        $password = $request->input('password');

        // 校验验证码是否正确
        VerifyCodeService::verify($request->header('X-Api-Token'), $request->input('verify_code'));

        $userGroup = cons('user.group.supplier');
        $login     = LoginService::login($userGroup, $account, $password);

        // 获取管理员信息
        $supplierUser = SupplierUser::where('user_uuid', $login['user_uuid'])->firstOrFail();

        // 获取所属供应商信息
        $supplier = Supplier::where('supplier_uuid', $supplierUser->supplier_uuid)->firstOrFail();
        if ($supplier->status !== cons('common.audit_status.passed')) {
            throw new ForbiddenException('当前所在供应商未审核通过，禁止登录');
        }

        // 更新权限信息
        UserRoleService::fetchUserNodes($login['user_uuid'], [config('node.supplier.web.type')],
            true);

        return new LoginResource(['token' => $login['token'], 'user' => $supplierUser]);
    }

    /**
     * 退出登录
     *
     * @return \App\Http\Resources\EmptyResource
     */
    public function logout()
    {
        $supplierUser = Auth::user();
        if ($supplierUser) {
            /* @var \App\Models\Supplier\SupplierUser $supplierUser */
            UserRoleService::removeCache($supplierUser->user_uuid);
            TokenService::setTimeOutTokenByUUID($supplierUser->user_uuid, 'web');
        }
        return new EmptyResource();
    }

}