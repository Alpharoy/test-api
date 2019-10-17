<?php

namespace App\Services\Permission;

use App\Models\Permission\Menu;
use App\Models\Permission\Role;
use App\Models\Permission\RoleMenu;
use App\Models\Permission\UserRole;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Urland\Exceptions\Client\ForbiddenException;

/**
 * 权限角色管理
 * Class RoleService
 *
 * @package App\Services\Permission
 */
class RoleService extends BaseService
{
    /**
     * 创建角色
     *
     * @param array $data
     * @param array $menuIds
     *
     * @return \App\Models\Permission\Role|\Illuminate\Database\Eloquent\Model
     * @throws \Urland\Exceptions\Client\ForbiddenException
     */
    public static function store($data = [], $menuIds = [])
    {
        // 检测是否唯一
        $where  = Arr::only($data, ['name', 'group', 'use_object_uuid']);
        $exists = Role::where($where)->exists();
        if ($exists) {
            throw new ForbiddenException('已存在相同名称的角色');
        }
        $data['last_modified_time'] = Carbon::now();
        $role                       = Role::create($data);
        self::updateRoleMenu($role, $menuIds);
        return $role;
    }

    /**
     * 更新角色
     *
     * @param \App\Models\Permission\Role $role
     * @param array                       $data
     * @param array                       $menuIds
     *
     * @return \App\Models\Permission\Role
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     * @throws \Urland\Exceptions\Client\ForbiddenException
     */
    public static function update(Role $role, $data = [], $menuIds = [])
    {
        if (!$role->can_modify) {
            throw new ForbiddenException('该角色不允许编辑');
        }
        $where                    = Arr::only($data, ['name']);
        $where['group']           = $role->group;
        $where['use_object_uuid'] = $role->use_object_uuid;

        $exists = Role::where($where)->where('id', '<>', $role->id)->exists();
        if ($exists) {
            throw new ForbiddenException('已存在相同名称的角色');
        }
        $data['last_modified_time'] = Carbon::now();
        $role->fill($data)->save();
        self::updateRoleMenu($role, $menuIds);
        // 清空受影响用户权限的缓存
        UserRoleService::clearCacheByRoleId($role->id);
        return $role;
    }

    /**
     * 更新角色菜单
     *
     * @param \App\Models\Permission\Role $role
     * @param array                       $menuIds
     *
     * @return bool
     */
    protected static function updateRoleMenu(Role $role, $menuIds = [])
    {
        RoleMenu::where('role_id', $role->id)->forceDelete();
        if (empty($menuIds)) {
            return true;
        }
        $menus     = Menu::whereIn('id', $menuIds)->where('group', $role->group)->get(['id']);
        $roleMenus = [];
        foreach ($menus as $menu) {
            $roleMenus[] = [
                'role_id' => $role->id,
                'menu_id' => $menu->id,
            ];
        }
        RoleMenu::insert($roleMenus);
        return true;
    }

    /**
     * 删除角色
     *
     * @param \App\Models\Permission\Role $role
     *
     * @return null
     */
    public static function delete(Role $role)
    {
        if (!$role->can_modify) {
            throw new ForbiddenException('该角色不允许删除');
        }
        // 删除角色
        $role->forceDelete();
        // 删除角色菜单
        RoleMenu::where('role_id', $role->id)->forceDelete();
        // 清空受影响用户权限的缓存
        UserRoleService::clearCacheByRoleId($role->id);
        UserRole::where('role_id', $role->id)->forceDelete();
        return null;
    }
}