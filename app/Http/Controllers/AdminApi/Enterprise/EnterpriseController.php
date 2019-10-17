<?php

namespace App\Http\Controllers\AdminApi\Enterprise;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\Enterprise\EnterpriseCreateRequest;
use App\Http\Requests\AdminApi\Request;
use App\Http\Requests\AdminApi\Enterprise\EnterpriseUpdateRequest;
use App\Http\Resources\AdminApi\Enterprise\EnterpriseResource;
use App\Models\Enterprise\Enterprise;
use App\Services\Enterprise\EnterpriseService;
use App\Services\SqlBuildService;

/**
 * 企业管理
 * Class EnterpriseController
 *
 * @package App\Http\Controllers\AdminApi\Enterprise
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
        $query  = Enterprise::query();
        $inputs = $request->input();

        $query = SqlBuildService::buildLikeQuery($query, $inputs, [
            'enterprise_name'           => 'enterprise_name',
            'usci_number'               => 'usci_number',
            'artificial_person_name'    => 'artificial_person_name',
            'tax_identification_number' => 'tax_identification_number',
        ]);

        $query = SqlBuildService::buildTimeQuery($query, $inputs);

        $query = SqlBuildService::buildEqualQuery($query, $inputs, [
            'status' => 'audit_status',
        ]);

        $query->orderBy('id', 'desc');
        $enterprises = $query->paginate();

        return EnterpriseResource::collection($enterprises);
    }

    /**
     * 新增企业
     *
     * @param EnterpriseCreateRequest $request
     *
     * @return EnterpriseResource
     * @throws \Urland\Exceptions\Client\BadRequestException
     * @throws \Urland\Exceptions\Client\NotFoundException
     * @throws \Urland\Exceptions\Server\InternalServerException
     */
    public function store(EnterpriseCreateRequest $request)
    {
        $inputs                              = $request->validated();
        $inputs['enterprise']['source_from'] = cons('common.source_from.insert');
        $inputs['enterprise']['status']      = cons('common.audit_status.passed');  // 后台注册默认审核通过
        $enterprise                          = EnterpriseService::store($inputs['enterprise'], $inputs['user']);
        return new EnterpriseResource($enterprise);
    }

    /**
     * 获取企业信息
     *
     * @param \App\Http\Requests\AdminApi\Request $request
     * @param string                              $enterprisesUUID
     *
     * @return \App\Http\Resources\AdminApi\Enterprise\EnterpriseResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show(Request $request, $enterprisesUUID)
    {
        $enterprise = $this->permission($enterprisesUUID);
        return new EnterpriseResource($enterprise);
    }

    /**
     * 更新企业
     *
     * @param EnterpriseUpdateRequest $request
     * @param                         $enterprisesUUID
     *
     * @return EnterpriseResource
     */
    public function update(EnterpriseUpdateRequest $request, $enterprisesUUID)
    {
        $inputs      = $request->validated();
        $enterprise  = $this->permission($enterprisesUUID);
        $enterprises = EnterpriseService::update($enterprise, $inputs);
        return new EnterpriseResource($enterprises);
    }

    /**
     * 企业审核
     *
     * @param Request $request
     * @param         $enterpriseUUID
     *
     * @return EnterpriseResource
     */
    public function changeAuditStatus(Request $request, $enterpriseUUID)
    {
        $auditStatus = $request->input('audit_status');
        $enterprise  = $this->permission($enterpriseUUID);
        $enterprise  = EnterpriseService::changeAuditStatus($enterprise, $auditStatus);
        return new EnterpriseResource($enterprise);
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