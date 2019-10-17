<?php

namespace App\Http\Controllers\SupplierApi\Supplier;

use App\Http\Controllers\SupplierApi\BaseController;
use App\Http\Requests\SupplierApi\Supplier\UpdatePasswordRequest;
use App\Http\Requests\SupplierApi\Supplier\SupplierUserUpdateRequest;
use App\Http\Resources\EmptyResource;
use App\Http\Resources\SupplierApi\Supplier\SupplierUserResource;
use App\Services\Auth\PasswordService;
use App\Services\Supplier\SupplierUserService;
use Illuminate\Support\Facades\Auth;

class MeController extends BaseController
{
    /**
     * 个人信息
     *
     * @return SupplierUserResource
     */
    public function show()
    {
        return new SupplierUserResource(Auth::user());
    }

    /**
     * 更新个人信息
     *
     * @param SupplierUserUpdateRequest $request
     *
     * @return SupplierUserResource
     */
    public function update(SupplierUserUpdateRequest $request)
    {
        $adminUser = SupplierUserService::update(Auth::user(), $request->validated());
        return new SupplierUserResource($adminUser);
    }


    /**
     * 修改密码
     *
     * @param UpdatePasswordRequest $request
     *
     * @return EmptyResource
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $inputs = $request->validated();
        PasswordService::updateByOldPassword(Auth::user()->user_uuid, $inputs['old_password'], $inputs['new_password']);
        return new EmptyResource();
    }

}