<?php

namespace App\Http\Controllers\EnterpriseApi\Permission;

use App\Http\Controllers\EnterpriseApi\BaseController;
use App\Http\Requests\EnterpriseApi\Request;
use App\Http\Resources\EnterpriseApi\Permission\RoleResource;
use App\Models\Permission\Role;

/**
 * 权限角色管理
 * Class RoleController
 *
 * @package App\Http\Controllers\EnterpriseApi\Permission
 */
class RoleController extends BaseController
{
    /**
     * 角色列表
     *
     * @param \App\Http\Requests\EnterpriseApi\Request $request
     *
     * @return \App\Http\Resources\EnterpriseApi\Permission\RoleResource[]
     */
    public function index(Request $request)
    {
        $query = Role::query();
        $query->where('group', cons('user.group.enterprise'));
        $query->orderBy('id', 'asc');
        $roles = $query->get();
        return RoleResource::collection($roles);
    }
}