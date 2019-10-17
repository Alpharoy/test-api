<?php

namespace App\Services\Permission;

use App\Models\Permission\Menu;
use App\Models\Permission\MenuNode;
use App\Models\Permission\Role;
use App\Models\Permission\RoleMenu;
use App\Models\Permission\UserRole;
use App\Services\BaseService;
use Illuminate\Support\Facades\Cache;

/**
 * 用户对应权限菜单管理
 * Class UserRoleService
 *
 * @package App\Services\Permission
 */
class UserRoleService extends BaseService
{
    /**
     * 清空拥有某角色ID的用户权限缓存
     *
     * @param int $roleId
     *
     * @return bool
     */
    public static function clearCacheByRoleId($roleId)
    {
        $userRoles = UserRole::where('role_id', $roleId)->get(['id', 'user_uuid']);
        foreach ($userRoles as $userRole) {
            self::removeCache($userRole->user_uuid);
        }
        return true;
    }

    /**
     * 更新用户权限
     *
     * @param string $userUUID
     * @param array  $roleIds
     *
     * @return bool
     */
    public static function updateUserRole($userUUID, $roleIds = [])
    {
        // 删除用户的角色
        UserRole::where('user_uuid', $userUUID)->forceDelete();

        $roles     = Role::whereIn('id', $roleIds)->get(['id']);
        $userRoles = [];
        foreach ($roles as $role) {
            $userRoles[] = [
                'user_uuid' => $userUUID,
                'role_id'   => $role->id,
            ];
        }
        UserRole::insert($userRoles);
        // 删除缓存
        self::removeCache($userUUID);
        return true;
    }

    /**
     * 获取用户权限节点列表
     *
     * @param string $userUUID
     * @param array  $nodeTypes 所属类型
     * @param bool   $update    是否强制更新
     *
     * @return \App\Models\Permission\MenuNode[]|bool|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public static function fetchUserNodes($userUUID, $nodeTypes = [], $update = false)
    {
        $nodeTypes[] = config('node.super_node_group');

        $nodes = Cache::get(self::cacheKey($userUUID));
        if (!is_null($nodes) && !$update) {
            return $nodes->whereIn('node_type', $nodeTypes);
        }

        // 获取用户角色
        $roleIds = UserRole::where(['user_uuid' => $userUUID])->pluck('role_id');
        if ($roleIds->isEmpty()) {
            return self::addCache($userUUID, collect([]));
        }

        // 获取角色菜单
        $menuIds = RoleMenu::whereIn('role_id', $roleIds)->pluck('menu_id');
        if ($menuIds->isEmpty()) {
            return self::addCache($userUUID, collect([]));
        }
        // 递归获取上级菜单
        $menuIds = self::recursionGetMenuId($menuIds->toArray());
        $nodes   = MenuNode::whereIn('menu_id', $menuIds)->get([
            'sign',
            'node_type',
        ]);
        if ($nodes->isEmpty()) {
            $nodes = collect([]);
        }
        self::addCache($userUUID, $nodes);
        return $nodes->whereIn('node_type', $nodeTypes);
    }

    /**
     * 递归获取角色组的上级角色ID
     *
     * @param $menuIds
     *
     * @return RoleMenu[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    protected static function recursionGetMenuId($menuIds)
    {
        if (empty($menuIds)) {
            return [];
        }
        // 获取这些角色的上级
        $roles = Menu::whereIn('id', $menuIds)->get(['parent_id']);
        if ($roles->isEmpty()) {
            return [];
        }
        $parendIds = $roles->pluck('parent_id')->unique()->toArray();
        return array_merge($menuIds, $parendIds);
    }

    /**
     * 清除缓存
     *
     * @param string $userUUID 管理员UUID
     *
     * @return null
     */
    public static function removeCache($userUUID)
    {
        Cache::forget(self::cacheKey($userUUID));
        return null;
    }

    /**
     * 存储缓存
     *
     * @param string $userUUID 用户UUID
     * @param        $nodeList
     *
     * @return bool
     */
    protected static function addCache($userUUID, $nodeList)
    {
        Cache::forever(self::cacheKey($userUUID), $nodeList);
        return $nodeList;
    }

    /**
     * 获取适用于token的缓存key
     *
     * @param string $userUUID 管理员UUID
     *
     * @return string
     */
    protected static function cacheKey($userUUID)
    {
        return 'user:user_role:' . $userUUID;
    }
}
