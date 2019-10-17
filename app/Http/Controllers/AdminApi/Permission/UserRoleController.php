<?php

namespace App\Http\Controllers\AdminApi\Permission;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\Request;
use App\Http\Resources\AdminApi\Permission\UserRoleResource;
use App\Models\Permission\UserRole;

/**
 * 用户权限管理
 * Class UserRoleController
 *
 * @package App\Http\Controllers\AdminApi\Permission
 */
class UserRoleController extends BaseController
{
    /**
     * 获取用户的菜单列表
     *
     * @param Request $request
     * @param string  $userUUID
     *
     * @return \App\Http\Resources\AdminApi\Permission\UserRoleResource[]
     */
    public function getUserRoles(Request $request, $userUUID)
    {
        $userRoles = UserRole::where('user_uuid', $userUUID)->get();
        return UserRoleResource::collection($userRoles);
    }
}