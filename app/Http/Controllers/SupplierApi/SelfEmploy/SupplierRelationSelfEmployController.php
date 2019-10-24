<?php

namespace App\Http\Controllers\SupplierApi\SelfEmploy;

use App\Http\Controllers\SupplierApi\BaseController;
use App\Http\Requests\SupplierApi\Request;
use App\Http\Resources\SupplierApi\Supplier\SupplierRelationSelfEmployResource;
use App\Models\Supplier\SupplierRelationSelfEmploy;
use App\Services\SqlBuildService;
use Illuminate\Support\Facades\Auth;

/**
 * 个体户管理
 *
 * Class SelfEmployController
 *
 * @package App\Http\Controllers\SupplierApi\SelfEmploy
 */
class SupplierRelationSelfEmployController extends BaseController
{
    /**
     * 个体户列表
     *
     * @param Request $request
     *
     * @return SupplierRelationSelfEmployResource[]
     */
    public function index(Request $request)
    {
        $query  = SupplierRelationSelfEmploy::query();
        $inputs = $request->input();

        $query->where('supplier_uuid', Auth::user()->supplier_uuid);

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
        return SupplierRelationSelfEmployResource::collection($relationSelfEmploys);
    }

    /**
     * 个体户详情
     *
     * @param \App\Http\Requests\SupplierApi\Request $request
     * @param                                        $selfEmployUUID
     *
     * @return \App\Http\Resources\SupplierApi\Supplier\SupplierRelationSelfEmployResource
     */
    public function show(Request $request, $selfEmployUUID)
    {
        $relationSelfEmploy = $this->permission($selfEmployUUID);
        $relationSelfEmploy->load('selfEmploy');
        return new SupplierRelationSelfEmployResource($relationSelfEmploy);

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
        $relationSelfEmploy = SupplierRelationSelfEmploy::where('self_employ_uuid',
            $selfEmployUUID)->where('supplier_uuid', Auth::user()->supplier_uuid)->firstOrFail();
        return $relationSelfEmploy;
    }

}