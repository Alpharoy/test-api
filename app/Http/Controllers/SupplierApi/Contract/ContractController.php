<?php

namespace App\Http\Controllers\SupplierApi\Contract;

use App\Http\Controllers\SupplierApi\BaseController;
use App\Http\Requests\SupplierApi\Request;
use App\Http\Resources\SupplierApi\Contract\ContractResource;
use App\Models\Contract\Contract;
use App\Services\Contract\ContractService;
use App\Services\SqlBuildService;
use Illuminate\Support\Facades\Auth;

/**
 * 签约管理
 *
 * Class ContractController
 *
 * @package App\Http\Controllers\SupplierApi\Contract
 */
class ContractController extends BaseController
{

    /**
     * 签约列表
     *
     * @param Request $request
     *
     * @return ContractResource[]
     */
    public function index(Request $request)
    {
        $query  = Contract::query();
        $inputs = $request->input();

        $query->where('supplier_uuid', Auth::user()->supplier_uuid);

        $query = SqlBuildService::buildLikeQuery($query, $inputs, [
            'contract_no'               => 'contract_no',
            'contract_name'             => 'contract_name',
            'enterprise_name'           => 'enterprise_name',
            'tax_identification_number' => 'tax_identification_number',
        ]);

        $query = SqlBuildService::buildEqualQuery($query, $inputs, [
            'status' => 'audit_status',
        ]);

        $query->orderBy('id', 'desc');
        $contracts = $query->paginate();

        $withEnterprise = $request->input('with_enterprise', false);
        if ($withEnterprise) {
            $contracts->load('enterprise');
        }

        return ContractResource::collection($contracts);

    }

    /**
     * 签约详情
     *
     * @param $contractUUID
     *
     * @return ContractResource
     */
    public function show($contractUUID)
    {
        $contract = $this->permission($contractUUID);
        $contract->load('enterprise');
        return new ContractResource($contract);
    }

    /**
     * 更改签约状态
     *
     * @param \App\Http\Requests\SupplierApi\Request $request
     * @param                                        $contractUUID
     *
     * @return \App\Http\Resources\SupplierApi\Contract\ContractResource
     */
    public function changeAuditStatus(Request $request, $contractUUID)
    {
        $status   = $request->input('audit_status');
        $contract = $this->permission($contractUUID);
        $contract = ContractService::changeAuditStatus($contract, $status);
        return new ContractResource($contract);
    }

    /**
     * 资源权限
     *
     * @param $contractUUID
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function permission($contractUUID)
    {
        $contract = Contract::where('contract_uuid', $contractUUID)->where('supplier_uuid',
            Auth::user()->supplier_uuid)->firstOrFail();
        return $contract;
    }

}