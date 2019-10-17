<?php

namespace App\Http\Controllers\EnterpriseApi\Enterprise;

use App\Http\Controllers\EnterpriseApi\BaseController;
use App\Http\Requests\EnterpriseApi\Enterprise\UpdatePasswordRequest;
use App\Http\Requests\EnterpriseApi\Enterprise\EnterpriseUserUpdateRequest;
use App\Http\Resources\EmptyResource;
use App\Http\Resources\EnterpriseApi\Enterprise\EnterpriseUserResource;
use App\Services\Auth\PasswordService;
use App\Services\Enterprise\EnterpriseUserService;
use Illuminate\Support\Facades\Auth;

class MeController extends BaseController
{
    /**
     * 个人信息
     *
     * @return EnterpriseUserResource
     */
    public function show()
    {
        return new EnterpriseUserResource(Auth::user());
    }

    /**
     * 更新个人信息
     *
     * @param EnterpriseUserUpdateRequest $request
     * @return EnterpriseUserResource
     */
    public function update(EnterpriseUserUpdateRequest $request)
    {
        $adminUser = EnterpriseUserService::update(Auth::user(), $request->validated());
        return new EnterpriseUserResource($adminUser);
    }


    /**
     * 修改密码
     *
     * @param UpdatePasswordRequest $request
     * @return EmptyResource
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $inputs = $request->validated();
        PasswordService::updateByOldPassword(Auth::user()->user_uuid, $inputs['old_password'], $inputs['new_password']);
        return new EmptyResource();
    }


}