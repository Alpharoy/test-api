<?php

namespace App\Http\Controllers\AdminApi\Permission;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\Request;
use App\Http\Resources\AdminApi\Permission\NodeResource;
use App\Models\Permission\Node;
use App\Services\SqlBuildService;

/**
 * 权限节点管理
 * Class NodeController
 *
 * @package App\Http\Controllers\AdminApi\Permission
 */
class NodeController extends BaseController
{
    /**
     * 获取全部节点列表
     *
     * @param Request $request
     *
     * @return \App\Http\Resources\AdminApi\Permission\NodeResource[]
     */
    public function index(Request $request)
    {
        $query  = Node::query();
        $inputs = $request->input();
        $query  = SqlBuildService::buildEqualQuery($query, $inputs, [
            'group' => 'group',
        ]);
        return NodeResource::collection($query->get());
    }
}