<?php

namespace App\Http\Controllers\AdminApi\Enterprise;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\Enterprise\EnterpriseUserCreateRequest;
use App\Http\Requests\AdminApi\Enterprise\EnterpriseUserUpdateRequest;
use App\Http\Requests\AdminApi\Request;
use App\Http\Resources\AdminApi\Admin\LoginLogResource;
use App\Http\Resources\AdminApi\Enterprise\EnterpriseUserResource;
use App\Models\Auth\LoginLog;
use App\Models\Enterprise\EnterpriseUser;
use App\Services\Enterprise\EnterpriseUserService;
use App\Services\Permission\UserRoleService;
use Illuminate\Support\Arr;

/**
 * 企业管理员模块
 *
 * Class EnterpriseUserController
 *
 * @package App\Http\Controllers\AdminApi\Enterprise
 */
class EnterpriseUserController extends BaseController
{

    /**
     * 企业管理员列表
     *
     * @param \App\Http\Requests\AdminApi\Request $request
     * @param string                              $enterpriseUUID
     *
     * @return \App\Http\Resources\AdminApi\Enterprise\EnterpriseUserResource[]
     */
    public function index(Request $request, $enterpriseUUID)
    {
        $query = EnterpriseUser::query();
        $query->where('enterprise_uuid', $enterpriseUUID);
        $query->orderBy('id', 'asc');
        $enterpriseUsers = $query->get();
        $enterpriseUsers->load('userLoginPwd');
        return EnterpriseUserResource::collection($enterpriseUsers);
    }

    /**
     * 新增企业管理员
     *
     * @param EnterpriseUserCreateRequest $request
     * @param string                      $enterpriseUUID
     *
     * @return EnterpriseUserResource
     */
    public function store(EnterpriseUserCreateRequest $request, $enterpriseUUID)
    {
        $inputs         = $request->validated();
        $roleIds        = Arr::pull($inputs, 'role_ids');
        $enterpriseUser = EnterpriseUserService::store($enterpriseUUID, cons('user.type.normal'),
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
     * @param \App\Http\Requests\AdminApi\Request $request
     * @param string                              $enterpriseUUID
     * @param string                              $userUUID
     *
     * @return \App\Http\Resources\AdminApi\Enterprise\EnterpriseUserResource
     */
    public function show(Request $request, $enterpriseUUID, $userUUID)
    {
        $enterpriseUser = $this->permission($enterpriseUUID, $userUUID);
        $enterpriseUser->load('userLoginPwd');
        return new EnterpriseUserResource($enterpriseUser);
    }

    /**
     * 更新管理员
     *
     * @param \App\Http\Requests\AdminApi\Enterprise\EnterpriseUserUpdateRequest $request
     * @param                                                                    $enterpriseUUID
     * @param                                                                    $userUUID
     *
     * @return \App\Http\Resources\AdminApi\Enterprise\EnterpriseUserResource
     */
    public function update(EnterpriseUserUpdateRequest $request, $enterpriseUUID, $userUUID)
    {
        $inputs         = $request->validated();
        $enterpriseUser = $this->permission($enterpriseUUID, $userUUID);
        $roleIds        = Arr::pull($inputs, 'role_ids');
        $enterpriseUser = EnterpriseUserService::update($enterpriseUser, $inputs);
        if ($roleIds && $enterpriseUser->can_update_role) {
            UserRoleService::updateUserRole($userUUID, $roleIds);
        }
        return new EnterpriseUserResource($enterpriseUser);
    }

    /**
     * 登录历史
     *
     * @param Request $request
     * @param string  $enterpriseUUID
     * @param string  $userUUID
     *
     * @return LoginLogResource[]
     */
    public function loginLog(Request $request, $enterpriseUUID, $userUUID)
    {
        $this->permission($enterpriseUUID, $userUUID);
        $query = LoginLog::query();
        $query->where('user_uuid', $userUUID);
        $query->orderBy('id', 'desc');
        return LoginLogResource::collection($query->paginate());
    }

    /**
     * 资源权限
     *
     * @param string $enterpriseUUID
     * @param string $userUUID
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function permission($enterpriseUUID, $userUUID)
    {
        $enterpriseUser = EnterpriseUser::where('enterprise_uuid', $enterpriseUUID)->where('user_uuid',
            $userUUID)->firstOrFail();
        return $enterpriseUser;
    }
}