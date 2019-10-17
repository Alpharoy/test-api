<?php

namespace App\Http\Controllers\AdminApi\Permission;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\Permission\MenuCreateRequest;
use App\Http\Requests\AdminApi\Permission\MenuUpdateRequest;
use App\Http\Requests\AdminApi\Request;
use App\Http\Resources\AdminApi\Permission\MenuDetailResource;
use App\Http\Resources\AdminApi\Permission\MenuResource;
use App\Http\Resources\EmptyResource;
use App\Models\Permission\Menu;
use App\Models\Permission\MenuNode;
use App\Models\Permission\Node;
use App\Services\Permission\MenuService;
use App\Services\SqlBuildService;
use Illuminate\Support\Arr;

/**
 * 权限菜单管理
 * Class MenuController
 *
 * @package App\Http\Controllers\AdminApi\Permission
 */
class MenuController extends BaseController
{
    /**
     * 获取菜单列表
     *
     * @param Request $request
     *
     * @return \App\Http\Resources\AdminApi\Permission\MenuResource[]
     */
    public function index(Request $request)
    {
        $query  = Menu::query();
        $inputs = $request->input();
        $query  = SqlBuildService::buildEqualQuery($query, $inputs, [
            'group' => 'group',
        ]);
        $query->orderBy('id', 'asc');
        return MenuResource::collection($query->get());
    }

    /**
     * 显示菜单详情
     *
     * @param int $menuId
     *
     * @return \App\Http\Resources\AdminApi\Permission\MenuDetailResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show($menuId)
    {
        // 角色信息
        $menu = $this->permission($menuId);

        // 包含节点列表
        $menuNodes         = MenuNode::where('menu_id', $menuId)->get(['node_id']);
        $menu->allow_nodes = Node::whereIn('id', $menuNodes->pluck('node_id'))->get();

        return new MenuDetailResource($menu);
    }

    /**
     * 创建菜单
     *
     * @param \App\Http\Requests\AdminApi\Permission\MenuCreateRequest $request
     *
     * @return \App\Http\Resources\EmptyResource
     * @throws \Urland\Exceptions\Client\ForbiddenException
     */
    public function store(MenuCreateRequest $request)
    {
        $inputs     = $request->validated();
        $allowNodes = Arr::pull($inputs, 'allow_nodes', []);
        MenuService::store($inputs, $allowNodes);
        return new EmptyResource();
    }

    /**
     * 更新菜单
     *
     * @param MenuUpdateRequest $request
     * @param int               $menuId
     *
     * @return EmptyResource
     * @throws \Urland\Exceptions\Client\ForbiddenException
     */
    public function update(MenuUpdateRequest $request, $menuId)
    {
        $inputs     = $request->validated();
        $allowNodes = Arr::pull($inputs, 'allow_nodes', []);
        $menu       = $this->permission($menuId);
        MenuService::update($menu, $inputs, $allowNodes);
        return new EmptyResource();
    }

    /**
     * 删除菜单
     *
     * @param Request $request
     * @param int     $menuId
     *
     * @return \App\Http\Resources\EmptyResource
     * @throws \Urland\Exceptions\Client\BadRequestException
     * @throws \Urland\Exceptions\Client\ForbiddenException
     */
    public function destroy(Request $request, $menuId)
    {
        $menu = $this->permission($menuId);
        MenuService::delete($menu);
        return new EmptyResource();
    }

    /**
     * 资源权限
     *
     * @param $menuId
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function permission($menuId)
    {
        return Menu::where('id', $menuId)->firstOrFail();
    }
}
