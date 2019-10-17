<?php


namespace App\Http\Controllers\SupplierApi\Supplier;


use App\Http\Controllers\SupplierApi\BaseController;
use App\Http\Requests\SupplierApi\Request;
use App\Http\Requests\SupplierApi\Supplier\ResetPasswordRequest;
use App\Http\Requests\SupplierApi\Supplier\SupplierUserCreateRequest;
use App\Http\Requests\SupplierApi\Supplier\SupplierUserLockRequest;
use App\Http\Requests\SupplierApi\Supplier\SupplierUserUpdateRequest;
use App\Http\Resources\SupplierApi\Supplier\LoginLogResource;
use App\Http\Resources\SupplierApi\Supplier\SupplierUserResource;
use App\Http\Resources\EmptyResource;
use App\Models\Auth\LoginLog;
use App\Models\Auth\UserLoginPwd;
use App\Models\Supplier\SupplierUser;
use App\Services\Auth\PasswordService;
use App\Services\Auth\TokenService;
use App\Services\Auth\UserLoginPwdService;
use App\Services\Permission\UserRoleService;
use App\Services\Supplier\SupplierUserService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Urland\Exceptions\Client\BadRequestException;
use Urland\Exceptions\Client\ForbiddenException;

/**
 * 供应商管理员
 *
 * Class SupplierUserController
 *
 * @package App\Http\Controllers\SupplierApi\Supplier
 */
class SupplierUserController extends BaseController
{
    /**
     * 供应商管理员
     *
     * @param Request $request
     *
     * @return SupplierUserResource[]
     */
    public function index(Request $request)
    {
        $query = SupplierUser::query();
        $query->where('supplier_uuid', Auth::user()->supplier_uuid);
        $query->orderBy('id', 'asc');
        $supplierUsers = $query->get();
        $supplierUsers->load('userLoginPwd');
        return SupplierUserResource::collection($supplierUsers);
    }

    /**
     * 新增供应商管理员
     *
     * @param SupplierUserCreateRequest $request
     *
     * @return SupplierUserResource
     */
    public function store(SupplierUserCreateRequest $request)
    {
        $inputs       = $request->validated();
        $roleIds      = Arr::pull($inputs, 'role_ids');
        $supplierUser = SupplierUserService::store(Auth::user()->supplier_uuid, cons('user.type.normal'),
            $inputs['user_phone'],
            $inputs['password'], $inputs);
        if ($roleIds) {
            UserRoleService::updateUserRole($supplierUser->user_uuid, $roleIds);
        }
        return new SupplierUserResource($supplierUser);
    }

    /**
     * 管理员详情
     *
     * @param Request $request
     * @param         $userUUID
     *
     * @return SupplierUserResource
     */
    public function show(Request $request, $userUUID)
    {
        $supplierUser = $this->permission($userUUID);
        $supplierUser->load('userLoginPwd');
        return new SupplierUserResource($supplierUser);
    }

    /**
     * 更新管理员
     *
     * @param SupplierUserUpdateRequest $request
     * @param                           $userUUID
     *
     * @return SupplierUserResource
     */
    public function update(SupplierUserUpdateRequest $request, $userUUID)
    {
        $supplierUser = $this->permission($userUUID);
        $supplierUser = SupplierUserService::update($supplierUser, $request->validated());
        return new SupplierUserResource($supplierUser);
    }

    /**
     * 登录历史
     *
     * @param Request $request
     * @param         $userUUID
     *
     * @return LoginLogResource[]
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
        $adminUser = SupplierUser::where('supplier_uuid', Auth::user()->supplier_uuid)->where('user_uuid',
            $userUUID)->firstOrFail();
        return $adminUser;
    }


    /**
     * 锁定
     *
     * @param SupplierUserLockRequest $request
     * @param                         $userUUID
     *
     * @return EmptyResource
     */
    public function lock(SupplierUserLockRequest $request, $userUUID)
    {
        $inputs = $request->validated();
        if ($userUUID === \Auth::user()->user_uuid) {
            throw new BadRequestException('不能锁定当前登录的账号');
        }
        $supplierUser = $this->permission($userUUID);
        if (!$supplierUser->can_lock) {
            throw new ForbiddenException('该管理员禁止锁定');
        }
        UserLoginPwdService::lock($userUUID, $inputs['lock_day'], $inputs['lock_reason']);
        // 清除登录
        TokenService::setTimeOutTokenByUUID($userUUID);
        return new EmptyResource();
    }

    /**
     * 解锁
     *
     * @param \App\Http\Requests\SupplierApi\Request $request
     * @param                                        $userUUID
     *
     * @return \App\Http\Resources\EmptyResource
     */
    public function unlock(Request $request, $userUUID)
    {
        $this->permission($userUUID);
        UserLoginPwdService::unlock($userUUID);
        return new EmptyResource();
    }

    /**
     * 重置管理员密码
     *
     * @param \App\Http\Requests\SupplierApi\Supplier\ResetPasswordRequest $request
     * @param                                                              $userUUID
     *
     * @return \App\Http\Resources\EmptyResource
     */
    public function resetPassword(ResetPasswordRequest $request, $userUUID)
    {
        if ($userUUID === \Auth::user()->user_uuid) {
            throw new BadRequestException('不能重置当前账号的密码');
        }
        $this->permission($userUUID);
        $userLoginPwd = UserLoginPwd::where('user_uuid', $userUUID)->firstOrFail();
        PasswordService::directPassword($userLoginPwd, $request->input('new_password'));
        // 清除登录
        TokenService::setTimeOutTokenByUUID($userUUID);
        return new EmptyResource();
    }

}