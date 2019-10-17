<?php

namespace App\Http\Controllers\AdminApi\SelfEmploy;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\Request;
use App\Http\Requests\AdminApi\SelfEmploy\SelfEmployCreateRequest;
use App\Http\Requests\AdminApi\SelfEmploy\SelfEmployUpdateRequest;
use App\Http\Resources\AdminApi\SelfEmploy\SelfEmployResource;
use App\Models\SelfEmploy\SelfEmploy;
use App\Services\SelfEmploy\SelfEmployService;
use App\Services\SqlBuildService;

/**
 * 个体户管理
 * Class SelfEmployController
 *
 * @package App\Http\Controllers\AdminApi\SelfEmploy
 */
class SelfEmployController extends BaseController
{
    /**
     * 个体工商列表
     *
     * @param Request $request
     *
     * @return SelfEmployResource[]
     */
    public function index(Request $request)
    {
        $query  = SelfEmploy::query();
        $inputs = $request->input();

        $query = SqlBuildService::buildLikeQuery($query, $inputs, [
            'self_employ_name'          => 'self_employ_name',
            'usci_number'               => 'usci_number',
            'artificial_person_name'    => 'artificial_person_name',
            'tax_identification_number' => 'tax_identification_number',
        ]);

        $query = SqlBuildService::buildTimeQuery($query, $inputs);

        $query = SqlBuildService::buildEqualQuery($query, $inputs, [
            'status' => 'audit_status',
        ]);

        $query->orderBy('id', 'desc');
        $selfEmploys = $query->paginate();
        return SelfEmployResource::collection($selfEmploys);
    }

    /**
     * 新增工商户
     *
     * @param SelfEmployCreateRequest $request
     *
     * @return SelfEmployResource
     */
    public function store(SelfEmployCreateRequest $request)
    {
        $inputs                               = $request->validated();
        $inputs['self_employ']['source_from'] = cons('common.source_from.insert');
        $inputs['self_employ']['status']      = cons('common.audit_status.passed');
        $selfEmploy                           = SelfEmployService::store($inputs['self_employ'], $inputs['user']);
        return new SelfEmployResource($selfEmploy);

    }

    /**
     * 修改工商户
     *
     * @param SelfEmployUpdateRequest $request
     * @param                         $selfEmployUUID
     *
     * @return SelfEmployResource
     */
    public function update(SelfEmployUpdateRequest $request, $selfEmployUUID)
    {
        $inputs     = $request->validated();
        $selfEmploy = $this->permission($selfEmployUUID);
        $selfEmploy = SelfEmployService::update($selfEmploy, $inputs);
        return new SelfEmployResource($selfEmploy);
    }

    /**
     * 个体工商审核
     *
     * @param Request $request
     * @param         $selfEmployUUID
     *
     * @return SelfEmployResource
     */
    public function changeAuditStatus(Request $request, $selfEmployUUID)
    {
        $auditStatus = $request->input('audit_status');
        $selfEmploy  = $this->permission($selfEmployUUID);
        $selfEmploy  = SelfEmployService::changeAuditStatus($selfEmploy, $auditStatus);
        return new SelfEmployResource($selfEmploy);
    }

    /**
     * 个体工商详情
     *
     * @param $selfEmployUUID
     *
     * @return SelfEmployResource
     */
    public function show($selfEmployUUID)
    {
        $selfEmploy = $this->permission($selfEmployUUID);
        return new SelfEmployResource($selfEmploy);
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
        $selfEmploy = SelfEmploy::where('self_employ_uuid', $selfEmployUUID)->firstOrFail();
        return $selfEmploy;
    }
}