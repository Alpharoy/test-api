<?php


namespace App\Http\Controllers\SupplierApi\Supplier;


use App\Http\Controllers\SupplierApi\BaseController;
use App\Http\Requests\SupplierApi\Request;
use App\Http\Requests\SupplierApi\Supplier\SupplierUpdateRequest;
use App\Http\Resources\SupplierApi\Supplier\SupplierResource;
use App\Models\Supplier\Supplier;
use App\Services\Supplier\SupplierService;
use Illuminate\Support\Facades\Auth;

/**
 * 供应商管理
 * Class SupplierController
 *
 * @package App\Http\Controllers\SupplierApi\Supplier
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
        $query = Supplier::query();
        $query->where('supplier_uuid', Auth::user()->supplier_uuid);
        $query->orderBy('id', 'asc');
        $suppliers = $query->get();
        return SupplierResource::collection($suppliers);
    }

    /**
     * 供应商信息
     *
     * @param Request $request
     *
     * @return SupplierResource
     */
    public function show(Request $request)
    {
        $supplier = $this->permission(Auth::user()->supplier_uuid);
        return new SupplierResource($supplier);
    }

    /**
     * 更新供应商
     *
     * @param SupplierUpdateRequest $request
     *
     * @return SupplierResource
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function update(SupplierUpdateRequest $request)
    {
        $inputs   = $request->validated();
        $supplier = $this->permission(Auth::user()->supplier_uuid);
        $supplier = SupplierService::update($supplier, $inputs);
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