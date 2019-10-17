<?php

namespace App\Http\Controllers\AdminApi\SelfEmploy;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\Request;
use App\Http\Requests\AdminApi\SelfEmploy\SelfEmployUserUpdateRequest;
use App\Http\Resources\AdminApi\SelfEmploy\SelfEmployUserResource;
use App\Models\SelfEmploy\SelfEmployUser;
use App\Services\SelfEmploy\SelfEmployUserService;


/**
 * 个体户管理员管理
 *
 * Class SelfEmployUserController
 *
 * @package App\Http\Controllers\AdminApi\SelfEmploy
 */
class SelfEmployUserController extends BaseController
{
    /**
     * 个体工商用户列表
     *
     * @param Request $request
     * @param         $selfEmployUUID
     *
     * @return SelfEmployUserResource[]
     */
    public function index(Request $request, $selfEmployUUID)
    {
        $query = SelfEmployUser::query();
        $query->where('self_employ_uuid', $selfEmployUUID);
        $query->orderBy('id', 'asc');
        $selfEmployUsers = $query->get();
        $selfEmployUsers->load('userLoginPwd');
        return SelfEmployUserResource::collection($selfEmployUsers);
    }

    /**
     * 更新个体工商管理员信息
     *
     * @param SelfEmployUserUpdateRequest $request
     * @param                             $selfEmployUUID
     * @param                             $userUUID
     *
     * @return SelfEmployUserResource
     */
    public function update(SelfEmployUserUpdateRequest $request, $selfEmployUUID, $userUUID)
    {
        $inputs         = $request->validated();
        $selfEmployUser = $this->permission($selfEmployUUID, $userUUID);
        $selfEmployUser = SelfEmployUserService::update($selfEmployUser, $inputs);
        return new SelfEmployUserResource($selfEmployUser);
    }

    /**
     * 管理员权限
     *
     * @param Request $request
     * @param         $selfEmployUUID
     * @param         $userUUID
     *
     * @return SelfEmployUserResource
     */
    public function show(Request $request, $selfEmployUUID, $userUUID)
    {
        $selfEmployUser = $this->permission($selfEmployUUID, $userUUID);
        $selfEmployUser->load('userLoginPwd');
        return new SelfEmployUserResource($selfEmployUser);
    }

    /**
     * 资源权限
     *
     * @param $selfEmployUUID
     * @param $userUUID
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function permission($selfEmployUUID, $userUUID)
    {
        $selfEmployUser = SelfEmployUser::where('self_employ_uuid', $selfEmployUUID)
            ->where('user_uuid', $userUUID)->firstOrFail();
        return $selfEmployUser;
    }

}