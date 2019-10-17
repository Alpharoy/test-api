<?php

namespace App\Http\Controllers\SupplierApi\Supplier;

use App\Http\Controllers\SupplierApi\BaseController;
use App\Http\Requests\SupplierApi\Request;
use App\Http\Requests\SupplierApi\Supplier\SupplierSubject\SupplierSubjectCreateRequest;
use App\Http\Requests\SupplierApi\Supplier\SupplierSubject\SupplierSubjectUpdateRequest;
use App\Http\Resources\SupplierApi\Supplier\SupplierSubjectResource;
use App\Models\Supplier\SupplierSubject;
use App\Services\Supplier\SupplierSubjectService;
use Illuminate\Support\Facades\Auth;

/**
 * 业务类型科目管理
 * Class SupplierSubjectController
 *
 * @package App\Http\Controllers\SupplierApi\Supplier
 */
class SupplierSubjectController extends BaseController
{
    /**
     * 科目列表
     *
     * @param \App\Http\Requests\SupplierApi\Request $request
     *
     * @return \App\Http\Resources\SupplierApi\Supplier\SupplierSubjectResource[]
     */
    public function index(Request $request)
    {
        $query = SupplierSubject::query();
        $query->where('supplier_uuid', Auth::user()->supplier_uuid);

        $supplierSubjects = $query->paginate();
        return SupplierSubjectResource::collection($supplierSubjects);
    }

    /**
     * 新增科目
     *
     * @param \App\Http\Requests\SupplierApi\Supplier\SupplierSubject\SupplierSubjectCreateRequest $request
     *
     * @return \App\Http\Resources\SupplierApi\Supplier\SupplierSubjectResource
     */
    public function store(SupplierSubjectCreateRequest $request)
    {
        $supplierSubject = SupplierSubjectService::store(Auth::user()->supplier_uuid, $request->validated());
        return new SupplierSubjectResource($supplierSubject);
    }

    /**
     * 更新科目
     *
     * @param \App\Http\Requests\SupplierApi\Supplier\SupplierSubject\SupplierSubjectUpdateRequest $request
     * @param                                                                                      $supplierSubjectUUID
     *
     * @return \App\Http\Resources\SupplierApi\Supplier\SupplierSubjectResource
     */
    public function update(SupplierSubjectUpdateRequest $request, $supplierSubjectUUID)
    {
        $supplierSubject = $this->permission($supplierSubjectUUID);
        $supplierSubject = SupplierSubjectService::update($supplierSubject, $request->validated());
        return new SupplierSubjectResource($supplierSubject);
    }

    /**
     * 资源权限
     *
     * @param $supplierSubjectUUID
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function permission($supplierSubjectUUID)
    {
        $supplierSubject = SupplierSubject::where('supplier_subject_uuid', $supplierSubjectUUID)->where('supplier_uuid',
            Auth::user()->supplier_uuid)->firstOrFail();
        return $supplierSubject;
    }
}