<?php

namespace App\Http\Controllers\EnterpriseApi\Permission;

use App\Http\Controllers\EnterpriseApi\BaseController;
use App\Http\Requests\EnterpriseApi\Request;
use App\Http\Resources\EnterpriseApi\Permission\UserRoleResource;
use App\Models\Enterprise\EnterpriseUser;
use App\Models\Permission\UserRole;
use Illuminate\Support\Facades\Auth;

/**
 * 用户权限管理
 * Class UserRoleController
 *
 * @package App\Http\Controllers\EnterpriseApi\Permission
 */
class UserRoleController extends BaseController
{
    /**
     * 获取用户的菜单列表
     *
     * @param Request $request
     * @param string  $userUUID
     *
     * @return \App\Http\Resources\EnterpriseApi\Permission\UserRoleResource[]
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
        return EnterpriseUser::where('enterprise_uuid', Auth::user()->enterprise_uuid)->where('user_uuid',
            $userUUID)->firstOrFail();
    }
}