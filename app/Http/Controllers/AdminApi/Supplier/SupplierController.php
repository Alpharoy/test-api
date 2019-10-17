<?php

namespace App\Http\Controllers\AdminApi\Supplier;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\Request;
use App\Http\Requests\AdminApi\Supplier\SupplierCreateRequest;
use App\Http\Requests\AdminApi\Supplier\SupplierUpdateRequest;
use App\Http\Resources\AdminApi\Supplier\SupplierResource;
use App\Models\Supplier\Supplier;
use App\Services\SqlBuildService;
use App\Services\Supplier\SupplierService;

/**
 * 供应商管理
 *
 * Class SuppliersController
 *
 * @package App\Http\Controllers\AdminApi\SuppliersController
 */
class SupplierController extends BaseController
{
    /**
     * 供应商列表
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $query  = Supplier::query();
        $inputs = $request->input();

        $query = SqlBuildService::buildLikeQuery($query, $inputs, [
            'supplier_name'             => 'supplier_name',
            'usci_number'               => 'usci_number',
            'artificial_person_name'    => 'artificial_person_name',
            'tax_identification_number' => 'tax_identification_number',
        ]);

        $query = SqlBuildService::buildTimeQuery($query, $inputs);

        $query = SqlBuildService::buildEqualQuery($query, $inputs, [
            'status' => 'audit_status',
        ]);

        $query->orderBy('id', 'desc');
        $suppliers = $query->paginate();
        return SupplierResource::collection($suppliers);
    }

    /**
     * 新增企业
     *
     * @param SupplierCreateRequest $request
     *
     * @return SupplierResource
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function store(SupplierCreateRequest $request)
    {
        $inputs                            = $request->validated();
        $inputs['supplier']['source_from'] = cons('common.source_from.insert');
        $inputs['supplier']['status']      = cons('common.audit_status.passed');  // 后台注册默认审核通过
        $supplier                          = SupplierService::store($inputs['supplier'], $inputs['user']);
        return new SupplierResource($supplier);
    }

    /**
     * 获取企业信息
     *
     * @param string $supplierUUID
     *
     * @return \App\Http\Resources\AdminApi\Supplier\SupplierResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show($supplierUUID)
    {
        $supplier = $this->permission($supplierUUID);
        return new SupplierResource($supplier);
    }

    /**
     * 更新供应商
     *
     * @param SupplierUpdateRequest $request
     * @param                       $supplierUUID
     *
     * @return SupplierResource
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function update(SupplierUpdateRequest $request, $supplierUUID)
    {
        $inputs   = $request->validated();
        $supplier = $this->permission($supplierUUID);
        $supplier = SupplierService::update($supplier, $inputs);
        return new SupplierResource($supplier);
    }

    /**
     * 供应商审核
     *
     * @param Request $request
     * @param         $supplierUUID
     *
     * @return SupplierResource
     */
    public function changeAuditStatus(Request $request, $supplierUUID)
    {
        $auditStatus = $request->input('audit_status');
        $supplier    = $this->permission($supplierUUID);
        $supplier    = SupplierService::changeAuditStatus($supplier, $auditStatus);
        return new SupplierResource($supplier);
    }

    /**
     * 资源权限
     *
     * @param $supplierUUID
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function permission($supplierUUID)
    {
        $supplier = Supplier::where('supplier_uuid', $supplierUUID)->firstOrFail();
        return $supplier;
    }

}