<?php

namespace App\Http\Controllers\SupplierApi\Permission;

use App\Http\Controllers\SupplierApi\BaseController;
use App\Http\Requests\SupplierApi\Request;
use App\Http\Resources\SupplierApi\Permission\UserRoleResource;
use App\Models\Permission\UserRole;
use App\Models\Supplier\SupplierUser;
use Illuminate\Support\Facades\Auth;

/**
 * 用户权限管理
 * Class UserRoleController
 *
 * @package App\Http\Controllers\SupplierApi\Permission
 */
class UserRoleController extends BaseController
{
    /**
     * 获取用户的菜单列表
     *
     * @param Request $request
     * @param string  $userUUID
     *
     * @return \App\Http\Resources\SupplierApi\Permission\UserRoleResource[]
     */
    public function getUserRoles(Request $request, $userUUID)
    {
        $this->permission($userUUID);
        $userRoles = UserRole::where('user_uuid', $userUUID)->get();
        return UserRoleResource::collection($userRoles);
    }

    /**
     * 资源权限
     *
     * @param string $userUUID
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function permission($userUUID)
    {
        return SupplierUser::where('supplier_uuid', Auth::user()->supplier_uuid)->where('user_uuid',
            $userUUID)->firstOrFail();
    }
}