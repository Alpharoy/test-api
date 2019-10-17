<?php

namespace App\Http\Controllers\SupplierApi\Permission;

use App\Http\Controllers\SupplierApi\BaseController;
use App\Http\Requests\SupplierApi\Request;
use App\Http\Resources\SupplierApi\Permission\RoleResource;
use App\Models\Permission\Role;

/**
 * 权限角色管理
 * Class RoleController
 *
 * @package App\Http\Controllers\SupplierApi\Permission
 */
class RoleController extends BaseController
{
    /**
     * 角色列表
     *
     * @param \App\Http\Requests\SupplierApi\Request $request
     *
     * @return \App\Http\Resources\SupplierApi\Permission\RoleResource[]
     */
    public function index(Request $request)
    {
        $query = Role::query();
        $query->where('group', cons('user.group.supplier'));
        $query->orderBy('id', 'asc');
        $roles = $query->get();
        return RoleResource::collection($roles);
    }

}