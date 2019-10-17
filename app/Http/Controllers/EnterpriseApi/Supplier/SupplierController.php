<?php

namespace App\Http\Controllers\EnterpriseApi\Supplier;

use App\Http\Controllers\EnterpriseApi\BaseController;
use App\Http\Requests\EnterpriseApi\Request;
use App\Http\Resources\EnterpriseApi\Supplier\SupplierResource;
use App\Models\Supplier\Supplier;
use App\Services\SqlBuildService;
use Illuminate\Support\Facades\Auth;

/**
 * 供应商
 * Class SupplierController
 *
 * @package App\Http\Controllers\EnterpriseApi\Supplier
 */
class SupplierController extends BaseController
{
    /**
     * 供应商列表
     *
     * @param \App\Http\Requests\EnterpriseApi\Request $request
     *
     * @return \App\Http\Resources\EnterpriseApi\Supplier\SupplierResource[]
     */
    public function index(Request $request)
    {
        $user   = Auth::user();
        $query  = Supplier::query();
        $inputs = $request->input();

        $query = SqlBuildService::buildLikeQuery($query, $inputs, [
            'supplier_name' => 'supplier_name',
        ]);

        $query = SqlBuildService::buildEqualQuery($query, $inputs, [
            'status' => 'audit_status',
        ]);

        $query->orderBy('id', 'desc');
        $suppliers = $query->paginate();

        $withContract = $request->input('with_contract', false);
        // 是否附带合约信息
        if ($withContract) {
            $suppliers->load([
                'contract' => function ($query) use ($user) {
                    $query->where('enterprise_uuid', $user->enterprise_uuid)->where('is_valid', true);
                },
            ]);
        }

        return SupplierResource::collection($suppliers);
    }
}