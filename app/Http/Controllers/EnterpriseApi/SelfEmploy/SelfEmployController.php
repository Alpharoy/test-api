<?php

namespace App\Http\Controllers\EnterpriseApi\SelfEmploy;

use App\Http\Controllers\EnterpriseApi\BaseController;
use App\Http\Requests\EnterpriseApi\Request;
use App\Http\Resources\EnterpriseApi\Enterprise\EnterpriseRelationSelfEmployResource;
use App\Models\Enterprise\EnterpriseRelationSelfEmploy;
use App\Services\SqlBuildService;
use Illuminate\Support\Facades\Auth;

/**
 * 个体户管理
 * Class SelfEmployController
 *
 * @package App\Http\Controllers\EnterpriseApi\SelfEmploy
 */
class SelfEmployController extends BaseController
{
    /**
     *企业端个体户列表
     *
     * @param Request $request
     *
     * @return EnterpriseRelationSelfEmployResource[]
     */
    public function index(Request $request)
    {
        $query  = EnterpriseRelationSelfEmploy::query();
        $inputs = $request->input();

        $query->where('enterprise_uuid', Auth::user()->enterprise_uuid);

        $query = SqlBuildService::buildLikeQuery($query, $inputs, [
            'self_employ_name' => 'self_employ_name',
            'usci_number'      => 'usci_number',
        ], 'selfEmploy');

        $query = SqlBuildService::buildTimeQuery($query, $inputs, 'create_time', 'create_time', 'selfEmploy');

        $query = SqlBuildService::buildEqualQuery($query, $inputs, [
            'status' => 'audit_status',
        ], 'selfEmploy');

        $query->orderBy('id', 'desc');
        $relationSelfEmploys = $query->paginate();
        $relationSelfEmploys->load('selfEmploy');
        return EnterpriseRelationSelfEmployResource::collection($relationSelfEmploys);
    }

    /**
     * 详情
     *
     * @param \App\Http\Requests\EnterpriseApi\Request $request
     * @param                                          $selfEmployUUID
     *
     * @return \App\Http\Resources\EnterpriseApi\Enterprise\EnterpriseRelationSelfEmployResource
     */
    public function show(Request $request, $selfEmployUUID)
    {
        $relationSelfEmploy = $this->permission($selfEmployUUID);
        $relationSelfEmploy->load('selfEmploy');
        return new EnterpriseRelationSelfEmployResource($relationSelfEmploy);

    }

    /**
     * 资源权限
     *
     * @param $selfEmployUUID
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function permission($selfEmployUUID)
    {
        $relationSelfEmploy = EnterpriseRelationSelfEmploy::where('self_employ_uuid',
            $selfEmployUUID)->where('enterprise_uuid', Auth::user()->enterprise_uuid)->firstOrFail();
        return $relationSelfEmploy;
    }

}