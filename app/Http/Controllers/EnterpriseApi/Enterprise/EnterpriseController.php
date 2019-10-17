<?php


namespace App\Http\Controllers\EnterpriseApi\Enterprise;

use App\Http\Controllers\EnterpriseApi\BaseController;
use App\Http\Requests\EnterpriseApi\Enterprise\EnterpriseUpdateRequest;
use App\Http\Requests\EnterpriseApi\Request;
use App\Http\Resources\EnterpriseApi\Enterprise\EnterpriseResource;
use App\Models\Enterprise\Enterprise;
use App\Services\Enterprise\EnterpriseService;
use Illuminate\Support\Facades\Auth;

/**
 * 企业管理
 *
 * Class EnterpriseController
 *
 * @package App\Http\Controllers\EnterpriseApi\Enterprise
 */
class EnterpriseController extends BaseController
{
    /**
     * 企业列表
     *
     * @param Request $request
     *
     * @return EnterpriseResource[]
     */
    public function index(Request $request)
    {
        $query = Enterprise::query();
        $query->where('enterprise_uuid', Auth::user()->enterprise_uuid);
        $query->orderBy('id', 'asc');
        $enterprises = $query->get();
        return EnterpriseResource::collection($enterprises);
    }

    /**
     * 获取企业信息
     *
     * @param \App\Http\Requests\EnterpriseApi\Request $request
     *
     * @return \App\Http\Resources\EnterpriseApi\Enterprise\EnterpriseResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show(Request $request)
    {
        $enterprise = $this->permission(Auth::user()->enterprise_uuid);
        return new EnterpriseResource($enterprise);
    }

    /**
     * 更新企业
     *
     * @param \App\Http\Requests\EnterpriseApi\Enterprise\EnterpriseUpdateRequest $request
     *
     * @return \App\Http\Resources\EnterpriseApi\Enterprise\EnterpriseResource
     */
    public function update(EnterpriseUpdateRequest $request)
    {
        $inputs      = $request->validated();
        $enterprise  = $this->permission(Auth::user()->enterprise_uuid);
        $enterprises = EnterpriseService::update($enterprise, $inputs);
        return new EnterpriseResource($enterprises);
    }

    /**
     * 资源权限
     *
     * @param $enterpriseUUID
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function permission($enterpriseUUID)
    {
        $enterprise = Enterprise::where('enterprise_uuid', $enterpriseUUID)->firstOrFail();
        return $enterprise;
    }

}