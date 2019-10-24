<?php

namespace App\Http\Controllers\EnterpriseApi\Supplier;

use App\Http\Controllers\EnterpriseApi\BaseController;
use App\Http\Requests\EnterpriseApi\Request;
use App\Http\Resources\EnterpriseApi\Supplier\SupplierSubjectResource;
use App\Models\Supplier\SupplierSubject;
use App\Services\SqlBuildService;

/**
 * 供应商科目管理
 * Class SupplierSubjectController
 *
 * @package App\Http\Controllers\EnterpriseApi\Supplier
 */
class SupplierSubjectController extends BaseController
{
    /**
     * 供应商科目列表
     *
     * @param \App\Http\Requests\EnterpriseApi\Request $request
     * @param string                                   $supplierUUID
     *
     * @return \App\Http\Resources\EnterpriseApi\Supplier\SupplierSubjectResource[]
     */
    public function index(Request $request, $supplierUUID)
    {
        $query  = SupplierSubject::query();
        $inputs = $request->input();
        // 只获取启用的
        $inputs['is_open']       = true;
        $inputs['supplier_uuid'] = $supplierUUID;

        $query = SqlBuildService::buildEqualQuery($query, $inputs, [
            'supplier_uuid'      => 'supplier_uuid',
            'industry_type_code' => 'industry_type_code',
            'is_open'            => 'is_open',
        ]);

        $supplierSubjects = $query->get();
        return SupplierSubjectResource::collection($supplierSubjects);
    }
}