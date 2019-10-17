<?php

namespace App\Http\Controllers\EnterpriseApi\Enterprise;

use App\Http\Controllers\EnterpriseApi\BaseController;
use App\Http\Requests\EnterpriseApi\Enterprise\EnterpriseUserCreateRequest;
use App\Http\Requests\EnterpriseApi\Enterprise\EnterpriseUserLockRequest;
use App\Http\Requests\EnterpriseApi\Enterprise\EnterpriseUserUpdateRequest;
use App\Http\Requests\EnterpriseApi\Enterprise\ResetPasswordRequest;
use App\Http\Requests\EnterpriseApi\Request;
use App\Http\Resources\EmptyResource;
use App\Http\Resources\EnterpriseApi\Enterprise\EnterpriseUserResource;
use App\Http\Resources\EnterpriseApi\Enterprise\LoginLogResource;
use App\Models\Auth\LoginLog;
use App\Models\Auth\UserLoginPwd;
use App\Models\Enterprise\EnterpriseUser;
use App\Services\Auth\PasswordService;
use App\Services\Auth\TokenService;
use App\Services\Auth\UserLoginPwdService;
use App\Services\Enterprise\EnterpriseUserService;
use App\Services\Permission\UserRoleService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Urland\Exceptions\Client\BadRequestException;
use Urland\Exceptions\Client\ForbiddenException;

/**
 * 企业管理员
 * Class EnterpriseUserController
 *
 * @package App\Http\Controllers\EnterpriseApi\Enterprise
 */
class EnterpriseUserController extends BaseController
{
    /**
     * 管理员列表
     *
     * @param \App\Http\Requests\EnterpriseApi\Request $request
     *
     * @return \App\Http\Resources\EnterpriseApi\Enterprise\EnterpriseUserResource[]
     */
    public function index(Request $request)
    {
        $query = EnterpriseUser::query();
        $query->where('enterprise_uuid', Auth::user()->enterprise_uuid);
        $query->orderBy('id', 'asc');
        $enterpriseUsers = $query->get();
        $enterpriseUsers->load('userLoginPwd');
        return EnterpriseUserResource::collection($enterpriseUsers);
    }

    /**
     * 新增管理员
     *
     * @param EnterpriseUserCreateRequest $request
     *
     * @return EnterpriseUserResource
     */
    public function store(EnterpriseUserCreateRequest $request)
    {
        $inputs         = $request->validated();
        $roleIds        = Arr::pull($inputs, 'role_ids');
        $enterpriseUser = EnterpriseUserService::store(Auth::user()->enterprise_uuid, cons('user.type.normal'),
            $inputs['user_phone'],
            $inputs['password'], $inputs);
        if ($roleIds) {
            UserRoleService::updateUserRole($enterpriseUser->user_uuid, $roleIds);
        }
        return new EnterpriseUserResource($enterpriseUser);
    }

    /**
     * 管理员详情
     *
     * @param $userUUID
     *
     * @return EnterpriseUserResource
     */
    public function show($userUUID)
    {
        $enterpriseUser = $this->permission($userUUID);
        $enterpriseUser->load('userLoginPwd');
        return new EnterpriseUserResource($enterpriseUser);
    }


    /**
     * 更新管理员
     *
     * @param EnterpriseUserUpdateRequest $request
     * @param                             $userUUID
     *
     * @return EnterpriseUserResource
     */
    public function update(EnterpriseUserUpdateRequest $request, $userUUID)
    {
        $inputs         = $request->validated();
        $roleIds        = Arr::pull($inputs, 'role_ids');
        $enterpriseUser = $this->permission($userUUID);
        $enterpriseUser = EnterpriseUserService::update($enterpriseUser, $inputs);
        if ($roleIds && $enterpriseUser->can_update_role) {
            UserRoleService::updateUserRole($userUUID, $roleIds);
        }
        return new EnterpriseUserResource($enterpriseUser);
    }

    /**
     * 锁定管理员
     *
     * @param EnterpriseUserLockRequest $request
     * @param                           $userUUID
     *
     * @return EmptyResource
     */
    public function lock(EnterpriseUserLockRequest $request, $userUUID)
    {
        $inputs = $request->validated();
        if ($userUUID === Auth::user()->user_uuid) {
            throw new BadRequestException('不能锁定当前登录的账号');
        }
        $enterpriseUser = $this->permission($userUUID);
        if (!$enterpriseUser->can_lock) {
            throw new ForbiddenException('该管理员禁止锁定');
        }
        UserLoginPwdService::lock($userUUID, $inputs['lock_day'], $inputs['lock_reason']);
        // 清除登录
        TokenService::setTimeOutTokenByUUID($userUUID);
        return new EmptyResource();
    }

    /**
     * 解锁管理员
     *
     * @param \App\Http\Requests\EnterpriseApi\Request $request
     * @param                                          $userUUID
     *
     * @return \App\Http\Resources\EmptyResource
     */
    public function unlock(Request $request, $userUUID)
    {
        UserLoginPwdService::unlock($userUUID);
        return new EmptyResource();
    }

    /**
     * 重置管理员密码
     *
     * @param \App\Http\Requests\EnterpriseApi\Enterprise\ResetPasswordRequest $request
     * @param                                                                  $userUUID
     *
     * @return \App\Http\Resources\EmptyResource
     */
    public function resetPassword(ResetPasswordRequest $request, $userUUID)
    {
        if ($userUUID === Auth::user()->user_uuid) {
            throw new BadRequestException('不能重置当前账号的密码');
        }
        $this->permission($userUUID);
        $userLoginPwd = UserLoginPwd::where('user_uuid', $userUUID)->firstOrFail();
        PasswordService::directPassword($userLoginPwd, $request->input('new_password'));
        // 清除登录
        TokenService::setTimeOutTokenByUUID($userUUID);
        return new EmptyResource();
    }

    /**
     * 查看登录记录
     *
     * @param \App\Http\Requests\EnterpriseApi\Request $request
     * @param                                          $userUUID
     *
     * @return \App\Http\Resources\EnterpriseApi\Enterprise\LoginLogResource[]
     */
    public function loginLog(Request $request, $userUUID)
    {
        $this->permission($userUUID);
        $query = LoginLog::query();
        $query->where('user_uuid', $userUUID);
        $query->orderBy('id', 'desc');
        return LoginLogResource::collection($query->paginate());
    }

    /**
     * 资源权限
     *
     * @param $userUUID
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function permission($userUUID)
    {
        $enterpriseUser = EnterpriseUser::where('enterprise_uuid', Auth::user()->enterprise_uuid)->where('user_uuid',
            $userUUID)->firstOrFail();
        return $enterpriseUser;
    }

}