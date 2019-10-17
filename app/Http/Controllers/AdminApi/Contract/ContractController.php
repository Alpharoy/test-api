<?php

namespace App\Http\Controllers\AdminApi\Contract;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\Request;
use App\Http\Resources\AdminApi\Contract\ContractResource;
use App\Models\Contract\Contract;
use App\Services\SqlBuildService;

/**
 * 签约管理
 * Class ContractController
 *
 * @package App\Http\Controllers\AdminApi\Contract
 */
class ContractController extends BaseController
{
    /**
     * 签约列表
     *
     * @param \App\Http\Requests\AdminApi\Request $request
     *
     * @return \App\Http\Resources\AdminApi\Contract\ContractResource[]
     */
    public function index(Request $request)
    {
        $query  = Contract::query();
        $inputs = $request->input();

        $query = SqlBuildService::buildLikeQuery($query, $inputs, [
            'contract_no'     => 'contract_no',
            'contract_name'   => 'contract_name',
            'supplier_name'   => 'supplier_name',
            'enterprise_name' => 'enterprise_name',
        ]);

        $query = SqlBuildService::buildEqualQuery($query, $inputs, [
            'group'  => 'group',
            'status' => 'audit_status',
        ]);

        $query->orderBy('id', 'desc');
        $contracts = $query->paginate();
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
        $contract = Contract::where('contract_uuid', $contractUUID)->firstOrFail();
        return $contract;
    }

}