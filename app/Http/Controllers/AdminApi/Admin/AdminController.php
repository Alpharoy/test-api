<?php

namespace App\Http\Controllers\AdminApi\Admin;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\Admin\AdminUpdateRequest;
use App\Http\Requests\AdminApi\Request;
use App\Http\Resources\AdminApi\Admin\AdminResource;
use App\Models\Admin\Admin;
use App\Services\Admin\AdminService;

/**
 * 管理公司模块
 * Class AdminController
 *
 * @package App\Http\Controllers\AdminApi\Admin
 */
class AdminController extends BaseController
{
    /**
     * 获取管理公司列表
     *
     * @param \App\Http\Requests\AdminApi\Request $request
     *
     * @return \App\Http\Resources\AdminApi\Admin\AdminResource[]
     * @throws \InvalidArgumentException
     */
    public function index(Request $request)
    {
        $query = Admin::query();
        $query->orderBy('id', 'asc');
        $admins = $query->get();
        return AdminResource::collection($admins);
    }

    /**
     * 获取公司信息
     *
     * @param Request $request
     * @param string  $adminUUID
     *
     * @return AdminResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show(Request $request, $adminUUID)
    {
        $admin = $this->permission($adminUUID);
        return new AdminResource($admin);
    }

    /**
     * 更新管理公司
     *
     * @param AdminUpdateRequest $request
     * @param string             $adminUUID
     *
     * @return AdminResource
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update(AdminUpdateRequest $request, $adminUUID)
    {
        $inputs = $request->validated();
        $admin  = $this->permission($adminUUID);
        $admins = AdminService::update($admin, $inputs);
        return new AdminResource($admins);
    }

    /**
     * 资源权限
     *
     * @param $adminUUID
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function permission($adminUUID)
    {
        $admin = Admin::where('admin_uuid', $adminUUID)->firstOrFail();
        return $admin;
    }

}