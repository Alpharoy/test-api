<?php

namespace App\Services\Permission;

use App\Models\Permission\Menu;
use App\Models\Permission\MenuNode;
use App\Models\Permission\Node;
use App\Models\Permission\RoleMenu;
use App\Services\BaseService;
use Urland\Exceptions\Client\BadRequestException;
use Urland\Exceptions\Client\ForbiddenException;

/**
 * 菜单管理
 * Class MenuService
 *
 * @package App\Services\Permission
 */
class MenuService extends BaseService
{
    /**
     * 创建菜单
     *
     * @param array $data
     * @param array $allowNodes
     *
     * @return \App\Models\Permission\Role|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Urland\Exceptions\Client\ForbiddenException
     */
    public static function store($data = [], $allowNodes = [])
    {
        // 检测是否重复菜单
        $exists = Menu::where('parent_id', $data['parent_id'])->where('name', $data['name'])->where('group',
            $data['group'])->exists();
        if ($exists) {
            throw new ForbiddenException('已有同名菜单');
        }
        if ($data['parent_id']) {
            Menu::where('id', $data['parent_id'])->where('group', $data['group'])->firstOrFail();
        } else {
            $data['parent_id'] = null;
        }

        // 添加菜单
        $menu = Menu::create($data);

        // 如果不是菜单，则需要添加节点
        self::updateMenuNode($menu, $allowNodes);
        return $menu;
    }

    /**
     * 更新菜单
     *
     * @param \App\Models\Permission\Menu $menu
     * @param array                       $data
     * @param array                       $allowNodes
     *
     * @return \App\Models\Permission\Menu
     */
    public static function update(Menu $menu, $data = [], $allowNodes = [])
    {
        if (!$menu->can_modify) {
            throw new ForbiddenException('该菜单不允许修改');
        }

        $exists = Menu::where('parent_id', $menu->parent_id)->where('group', $menu->group)->where('name',
            $data['name'])->where('id', '<>', $menu->id)->exists();
        if ($exists) {
            throw new ForbiddenException('已有同名菜单');
        }
        $menu->fill($data)->save();
        self::updateMenuNode($menu, $allowNodes);

        // 清空受影响用户权限的缓存
        $userRoleService = new UserRoleService();
        $roleMenus       = RoleMenu::where('menu_id', $menu->id)->get(['id', 'role_id']);
        foreach ($roleMenus as $roleMenu) {
            $userRoleService->clearCacheByRoleId($roleMenu->role_id);
        }
        return $menu;
    }

    /**
     * 删除菜单
     *
     * @param \App\Models\Permission\Menu $menu
     *
     * @return bool
     */
    public static function delete(Menu $menu)
    {
        $exist = Menu::where('parent_id', $menu->id)->exists();
        if ($exist) {
            throw new BadRequestException('含有子菜单不能删除');
        }
        if (!$menu->can_modify) {
            throw new ForbiddenException('该菜单不允许删除');
        }
        // 删除菜单
        $menu->forceDelete();
        // 删除菜单节点
        MenuNode::where('menu_id', $menu->id)->forceDelete();

        $userRoleService = new UserRoleService();
        $roleMenus       = RoleMenu::where('menu_id', $menu->id)->get(['id', 'role_id']);
        foreach ($roleMenus as $roleMenu) {
            $userRoleService->clearCacheByRoleId($roleMenu->role_id);
            $roleMenu->forceDelete();
        }
        return true;
    }

    /**
     * 菜单配置节点权限
     *
     * @param Menu  $menu
     * @param array $allowNodes
     *
     * @return bool
     */
    protected static function updateMenuNode(Menu $menu, $allowNodes = [])
    {
        // 删除原有权限
        MenuNode::where('menu_id', $menu->id)->forceDelete();
        $allowNodeIds = array_column($allowNodes, 'id');
        if (empty($allowNodeIds)) {
            return true;
        }

        $nodes     = Node::whereIn('id', $allowNodeIds)->where('group', $menu->group)->get();
        $menuNodes = [];
        foreach ($nodes as $node) {
            $menuNodes[] = [
                'menu_id'   => $menu->id,
                'node_id'   => $node->id,
                'sign'      => $node->sign,
                'node_type' => $node->type,
            ];
        }
        MenuNode::insert($menuNodes);
        return true;
    }
}
