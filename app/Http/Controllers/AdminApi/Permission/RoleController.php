<?php

namespace App\Http\Controllers\AdminApi\Permission;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\Permission\RoleCreateRequest;
use App\Http\Requests\AdminApi\Permission\RoleUpdateRequest;
use App\Http\Requests\AdminApi\Request;
use App\Http\Resources\AdminApi\Permission\RoleResource;
use App\Http\Resources\EmptyResource;
use App\Models\Permission\Role;
use App\Models\Permission\RoleMenu;
use App\Services\Permission\RoleService;
use App\Services\SqlBuildService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

/**
 * 权限角色管理
 * Class RoleController
 *
 * @package App\Http\Controllers\AdminApi\Permission
 */
class RoleController extends BaseController
{
    /**
     * 角色列表
     *
     * @param \App\Http\Requests\AdminApi\Request $request
     *
     * @return \App\Http\Resources\AdminApi\Permission\RoleResource[]
     */
    public function index(Request $request)
    {
        $query  = Role::query();
        $inputs = $request->input();
        $query  = SqlBuildService::buildEqualQuery($query, $inputs, [
            'group' => 'group',
        ]);
        $query->orderBy('id', 'asc');
        $roles = $query->get();
        return RoleResource::collection($roles);
    }

    /**
     * 创建角色
     *
     * @param \App\Http\Requests\AdminApi\Permission\RoleCreateRequest $request
     *
     * @return \App\Http\Resources\AdminApi\Permission\RoleResource
     * @throws \Urland\Exceptions\Client\ForbiddenException
     */
    public function store(RoleCreateRequest $request)
    {
        $inputs  = $request->validated();
        $menuIds = Arr::pull($inputs, 'menu_ids', []);
        /** @var \App\Models\Admin\AdminUser $user */
        $user = Auth::user();

        $inputs['use_object_uuid']  = '';
        $inputs['create_user_uuid'] = $user->user_uuid;
        $inputs['create_user_name'] = $user->user_name;

        $role = RoleService::store($inputs, $menuIds);

        return new RoleResource($role);
    }

    /**
     * 获取角色详情
     *
     * @param \App\Http\Requests\AdminApi\Request $request
     * @param string                              $roleId
     *
     * @return \App\Http\Resources\AdminApi\Permission\RoleResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show(Request $request, $roleId)
    {
        $role = $this->permission($roleId);
        // 获取角色的菜单ID
        $role->menu_ids = RoleMenu::where('role_id', $roleId)->pluck('menu_id')->toArray();
        return new RoleResource($role);
    }

    /**
     * 更新角色
     *
     * @param \App\Http\Requests\AdminApi\Permission\RoleUpdateRequest $request
     * @param int                                                      $roleId
     *
     * @return \App\Http\Resources\AdminApi\Permission\RoleResource
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Urland\Exceptions\Client\ForbiddenException
     */
    public function update(RoleUpdateRequest $request, $roleId)
    {
        $inputs = $request->validated();

        $role    = $this->permission($roleId);
        $menuIds = Arr::pull($inputs, 'menu_ids', []);

        /** @var \App\Models\Admin\AdminUser $user */
        $user = Auth::user();

        $inputs['update_user_uuid'] = $user->user_uuid;
        $inputs['update_user_name'] = $user->user_name;

        $role = RoleService::update($role, $inputs, $menuIds);

        return new RoleResource($role);
    }

    /**
     * 删除角色
     *
     * @param \App\Http\Requests\AdminApi\Request $request
     * @param int                                 $roleId
     *
     * @return \App\Http\Resources\EmptyResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Urland\Exceptions\Client\ForbiddenException
     */
    public function destroy(Request $request, $roleId)
    {
        $role = $this->permission($roleId);
        RoleService::delete($role);
        return new EmptyResource();
    }

    /**
     * 资源权限
     *
     * @param $roleId
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function permission($roleId)
    {
        return Role::where('id', $roleId)->firstOrFail();
    }
}