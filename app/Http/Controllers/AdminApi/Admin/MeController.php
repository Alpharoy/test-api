<?php

namespace App\Http\Controllers\AdminApi\Admin;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\Admin\AdminUserUpdateRequest;
use App\Http\Requests\AdminApi\Admin\UpdatePasswordRequest;
use App\Http\Resources\AdminApi\Admin\AdminUserResource;
use App\Http\Resources\AdminApi\Permission\NodeSignResource;
use App\Http\Resources\EmptyResource;
use App\Services\Admin\AdminUserService;
use App\Services\Auth\PasswordService;
use App\Services\Permission\UserRoleService;
use Illuminate\Support\Facades\Auth;

/**
 * 个人资料
 * Class MeController
 *
 * @package App\Http\Controllers\AdminApi\Admin
 */
class MeController extends BaseController
{
    /**
     * 个人信息
     *
     * @return \App\Http\Resources\AdminApi\Admin\AdminUserResource
     */
    public function show()
    {
        return new AdminUserResource(Auth::user());
    }

    /**
     * 更新个人信息
     *
     * @param \App\Http\Requests\AdminApi\Admin\AdminUserUpdateRequest $request
     *
     * @return \App\Http\Resources\AdminApi\Admin\AdminUserResource
     */
    public function update(AdminUserUpdateRequest $request)
    {
        $adminUser = AdminUserService::update(Auth::user(), $request->validated());
        return new AdminUserResource($adminUser);
    }

    /**
     * 修改密码
     *
     * @param \App\Http\Requests\AdminApi\Admin\UpdatePasswordRequest $request
     *
     * @return \App\Http\Resources\EmptyResource
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $inputs = $request->validated();
        PasswordService::updateByOldPassword(Auth::user()->user_uuid, $inputs['old_password'], $inputs['new_password']);
        return new EmptyResource();
    }

    /**
     * 获取个人权限节点
     *
     * @return \App\Http\Resources\AdminApi\Permission\NodeSignResource[]
     */
    public function getRoleNode()
    {
        $nodes = UserRoleService::fetchUserNodes(Auth::user()->user_uuid, [config('node.admin.web.type')]);
        return NodeSignResource::collection($nodes);
    }
}