<?php


namespace App\Http\Controllers\AdminApi\Supplier;


use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\Request;
use App\Http\Requests\AdminApi\Supplier\SupplierUserCreateRequest;
use App\Http\Requests\AdminApi\Supplier\SupplierUserUpdateRequest;
use App\Http\Resources\AdminApi\Admin\LoginLogResource;
use App\Http\Resources\AdminApi\Supplier\SupplierUserResource;
use App\Models\Auth\LoginLog;
use App\Models\Supplier\SupplierUser;
use App\Services\Permission\UserRoleService;
use App\Services\Supplier\SupplierUserService;
use Illuminate\Support\Arr;

/**
 * 供应商管理员管理
 * Class SupplierUserController
 *
 * @package App\Http\Controllers\AdminApi\Supplier
 */
class SupplierUserController extends BaseController
{
    /**
     * 供应商管理员列表
     *
     * @param Request $request
     * @param         $supplierUUID
     *
     * @return SupplierUserResource[]
     */
    public function index(Request $request, $supplierUUID)
    {
        $query = SupplierUser::query();
        $query->where('supplier_uuid', $supplierUUID);
        $query->orderBy('id', 'asc');
        $supplierUsers = $query->get();
        $supplierUsers->load('userLoginPwd');
        return SupplierUserResource::collection($supplierUsers);
    }

    /**
     * 新增供应商管理员
     *
     * @param SupplierUserCreateRequest $request
     * @param                           $supplierUUID
     *
     * @return SupplierUserResource
     */
    public function store(SupplierUserCreateRequest $request, $supplierUUID)
    {
        $inputs       = $request->validated();
        $roleIds      = Arr::pull($inputs, 'role_ids', []);
        $supplierUser = SupplierUserService::store($supplierUUID, cons('user.type.normal'), $inputs['user_phone'],
            $inputs['password'], $inputs);
        if ($roleIds) {
            UserRoleService::updateUserRole($supplierUser->user_uuid, $roleIds);
        }
        return new SupplierUserResource($supplierUser);
    }


    /**
     * 管理员详情
     *
     * @param \App\Http\Requests\AdminApi\Request $request
     * @param string                              $supplierUUID
     * @param string                              $userUUID
     *
     * @return \App\Http\Resources\AdminApi\Supplier\SupplierUserResource
     */
    public function show(Request $request, $supplierUUID, $userUUID)
    {
        $supplierUser = $this->permission($supplierUUID, $userUUID);
        $supplierUser->load('userLoginPwd');
        return new SupplierUserResource($supplierUser);
    }


    /**
     * 更新管理员
     *
     * @param \App\Http\Requests\AdminApi\Supplier\SupplierUserUpdateRequest     $request
     * @param                                                                    $supplierUUID
     * @param                                                                    $userUUID
     *
     * @return \App\Http\Resources\AdminApi\Supplier\SupplierUserResource
     */
    public function update(SupplierUserUpdateRequest $request, $supplierUUID, $userUUID)
    {
        $inputs       = $request->validated();
        $supplierUser = $this->permission($supplierUUID, $userUUID);
        $roleIds      = Arr::pull($inputs, 'role_ids');
        $supplierUser = SupplierUserService::update($supplierUser, $request->validated());
        if ($roleIds && $supplierUser->can_update_role) {
            UserRoleService::updateUserRole($userUUID, $roleIds);
        }
        return new SupplierUserResource($supplierUser);
    }


    /**
     * 登录历史
     *
     * @param Request $request
     * @param         $supplierUUID
     * @param         $userUUID
     *
     * @return LoginLogResource[]
     */
    public function loginLog(Request $request, $supplierUUID, $userUUID)
    {
        $this->permission($supplierUUID, $userUUID);
        $query = LoginLog::query();
        $query->where('user_uuid', $userUUID);
        $query->orderBy('id', 'desc');
        return LoginLogResource::collection($query->paginate());
    }

    /**
     * 资源权限
     *
     * @param $supplierUUID
     * @param $userUUID
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function permission($supplierUUID, $userUUID)
    {
        $adminUser = SupplierUser::where('supplier_uuid', $supplierUUID)->where('user_uuid', $userUUID)->firstOrFail();
        return $adminUser;
    }

}