<?php


namespace App\Http\Controllers\EnterpriseApi\Contract;


use App\Http\Controllers\EnterpriseApi\BaseController;
use App\Http\Requests\EnterpriseApi\Contract\ContractCreateRequest;
use App\Http\Requests\EnterpriseApi\Contract\ContractUpdateRequest;
use App\Http\Requests\EnterpriseApi\Request;
use App\Http\Resources\EmptyResource;
use App\Http\Resources\EnterpriseApi\Contract\ContractResource;
use App\Models\Contract\Contract;
use App\Services\Contract\ContractService;
use App\Services\SqlBuildService;
use Illuminate\Support\Facades\Auth;

/**
 * 合同管理(企业端)
 *
 * Class ContractController
 *
 * @package App\Http\Controllers\EnterpriseApi\Contract
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

        // 获取自己企业的签约列表
        $query->where('enterprise_uuid', Auth::user()->enterprise_uuid);

        $query = SqlBuildService::buildLikeQuery($query, $inputs, [
            'contract_no'   => 'contract_no',
            'contract_name' => 'contract_name',
            'supplier_name' => 'supplier_name',
        ]);

        $query = SqlBuildService::buildEqualQuery($query, $inputs, [
            'status'   => 'audit_status',
            'is_valid' => 'is_valid',
        ]);

        $query->orderBy('id', 'desc');
        $contracts = $query->paginate();
        return ContractResource::collection($contracts);

    }

    /**
     * 申请签约
     *
     * @param ContractCreateRequest $request
     *
     * @return ContractResource
     */
    public function store(ContractCreateRequest $request)
    {
        $inputs   = $request->validated();
        $contract = ContractService::store(cons('contract.group.enterprise'), Auth::user()->enterprise_uuid, $inputs);
        return new ContractResource($contract);
    }

    /**
     * 更新合同
     *
     * @param ContractUpdateRequest $request
     * @param                       $contractUUID
     *
     * @return ContractResource
     */
    public function update(ContractUpdateRequest $request, $contractUUID)
    {
        $inputs   = $request->validated();
        $contract = $this->permission($contractUUID);
        $contract = ContractService::update($contract, $inputs);
        return new ContractResource($contract);
    }

    /**
     * 签约详情
     *
     * @param \App\Http\Requests\EnterpriseApi\Request $request
     * @param                                          $contractUUID
     *
     * @return \App\Http\Resources\EnterpriseApi\Contract\ContractResource
     */
    public function show(Request $request, $contractUUID)
    {
        $contract = $this->permission($contractUUID);
        return new ContractResource($contract);
    }

    /**
     * 删除签约
     *
     * @param \App\Http\Requests\EnterpriseApi\Request $request
     * @param                                          $contractUUID
     *
     * @return \App\Http\Resources\EmptyResource
     * @throws \Exception
     */
    public function destroy(Request $request, $contractUUID)
    {
        $contract = $this->permission($contractUUID);
        ContractService::delete($contract);
        return new EmptyResource();
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
        $contract = Contract::where('contract_uuid', $contractUUID)->where('enterprise_uuid',
            Auth::user()->enterprise_uuid)->firstOrFail();
        return $contract;
    }

}