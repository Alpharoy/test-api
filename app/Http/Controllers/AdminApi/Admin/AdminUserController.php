<?php

namespace App\Http\Controllers\AdminApi\Admin;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\Admin\AdminUserCreateRequest;
use App\Http\Requests\AdminApi\Admin\AdminUserUpdateRequest;
use App\Http\Requests\AdminApi\Admin\AdminUserLockRequest;
use App\Http\Requests\AdminApi\Admin\ResetPasswordRequest;
use App\Http\Requests\AdminApi\Request;
use App\Http\Resources\AdminApi\Admin\AdminUserResource;
use App\Http\Resources\AdminApi\Admin\LoginLogResource;
use App\Http\Resources\EmptyResource;
use App\Models\Admin\AdminUser;
use App\Models\Auth\LoginLog;
use App\Models\Auth\UserLoginPwd;
use App\Services\Admin\AdminUserService;
use App\Services\Auth\PasswordService;
use App\Services\Auth\TokenService;
use App\Services\Auth\UserLoginPwdService;
use App\Services\Permission\UserRoleService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Urland\Exceptions\Client\BadRequestException;
use Urland\Exceptions\Client\ForbiddenException;

/**
 * 管理公司管理员模块
 * Class AdminUserController
 *
 * @package App\Http\Controllers\AdminApi\Admin
 */
class AdminUserController extends BaseController
{
    /**
     * 管理员列表
     *
     * @return \App\Http\Resources\AdminApi\Admin\AdminUserResource[]
     */
    public function index()
    {
        $query = AdminUser::query();
        $query->orderBy('id', 'asc');
        $adminUsers = $query->get();
        $adminUsers->load('userLoginPwd');
        return AdminUserResource::collection($adminUsers);
    }

    /**
     * 新增管理员
     *
     * @param \App\Http\Requests\AdminApi\Admin\AdminUserCreateRequest $request
     *
     * @return \App\Http\Resources\AdminApi\Admin\AdminUserResource
     */
    public function store(AdminUserCreateRequest $request)
    {
        $inputs    = $request->validated();
        $roleIds   = Arr::pull($inputs, 'role_ids');
        $adminUser = AdminUserService::store(Auth::user()->admin_uuid, cons('user.type.normal'), $inputs['user_phone'],
            $inputs['password'], $inputs);
        if ($roleIds) {
            UserRoleService::updateUserRole($adminUser->user_uuid, $roleIds);
        }
        return new AdminUserResource($adminUser);
    }

    /**
     * 管理员详情
     *
     * @param \App\Http\Requests\AdminApi\Request $request
     * @param                                     $userUUID
     *
     * @return \App\Http\Resources\AdminApi\Admin\AdminUserResource
     */
    public function show(Request $request, $userUUID)
    {
        $adminUser = $this->permission($userUUID);
        $adminUser->load('userLoginPwd');
        return new AdminUserResource($adminUser);
    }

    /**
     * 更新管理员
     *
     * @param \App\Http\Requests\AdminApi\Admin\AdminUserUpdateRequest $request
     * @param                                                          $userUUID
     *
     * @return \App\Http\Resources\AdminApi\Admin\AdminUserResource
     */
    public function update(AdminUserUpdateRequest $request, $userUUID)
    {
        $inputs    = $request->validated();
        $roleIds   = Arr::pull($inputs, 'role_ids');
        $adminUser = $this->permission($userUUID);
        $adminUser = AdminUserService::update($adminUser, $inputs);
        if ($roleIds && $adminUser->can_update_role) {
            UserRoleService::updateUserRole($userUUID, $roleIds);
        }
        return new AdminUserResource($adminUser);
    }

    /**
     * 锁定管理员
     *
     * @param \App\Http\Requests\AdminApi\Admin\AdminUserLockRequest $request
     * @param                                                        $userUUID
     *
     * @return \App\Http\Resources\EmptyResource
     */
    public function lock(AdminUserLockRequest $request, $userUUID)
    {
        $inputs = $request->validated();
        if ($userUUID === Auth::user()->user_uuid) {
            throw new BadRequestException('不能锁定当前登录的账号');
        }
        $adminUser = $this->permission($userUUID);
        if (!$adminUser->can_lock) {
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
     * @param \App\Http\Requests\AdminApi\Request $request
     * @param                                     $userUUID
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
     * @param \App\Http\Requests\AdminApi\Admin\ResetPasswordRequest $request
     * @param                                                        $userUUID
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
     * @param \App\Http\Requests\AdminApi\Request $request
     * @param                                     $userUUID
     *
     * @return \App\Http\Resources\AdminApi\Admin\LoginLogResource[]
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
        $adminUser = AdminUser::where('user_uuid', $userUUID)->firstOrFail();
        return $adminUser;
    }
}