<?php

namespace App\Http\Controllers\SupplierApi\NaturalPerson;

use App\Http\Controllers\SupplierApi\BaseController;
use App\Http\Requests\SupplierApi\Request;
use App\Http\Resources\SupplierApi\Supplier\SupplierRelationNaturalPersonResource;
use App\Models\Supplier\SupplierRelationNaturalPerson;
use App\Services\SqlBuildService;
use Illuminate\Support\Facades\Auth;

/**
 * 自然人
 *
 * Class NaturalPersonController
 *
 * @package App\Http\Controllers\SupplierApi\NaturalPerson
 */
class NaturalPersonController extends BaseController
{
    /**
     * 自然人列表
     *
     * @param Request $request
     *
     * @return SupplierRelationNaturalPersonResource[]
     */
    public function index(Request $request)
    {
        $query  = SupplierRelationNaturalPerson::query();
        $inputs = $request->input();

        $query->where('supplier_uuid', Auth::user()->supplier_uuid);

        $query = SqlBuildService::buildLikeQuery($query, $inputs, [
            'id_card_number' => 'id_card_number',
            'user_name'      => 'user_name',
            'user_phone'     => 'user_phone',
        ], 'naturalPerson');

        $query = SqlBuildService::buildEqualQuery($query, $inputs, [
            'status' => 'audit_status',
        ], 'naturalPerson');

        $query->orderBy('id', 'desc');
        $supplierRelationNaturalPersons = $query->paginate();
        $supplierRelationNaturalPersons->load('naturalPerson');
        return SupplierRelationNaturalPersonResource::collection($supplierRelationNaturalPersons);
    }


    /**
     * 自然人详情
     *
     * @param Request $request
     * @param         $userUUID
     *
     * @return SupplierRelationNaturalPersonResource
     */
    public function show(Request $request, $userUUID)
    {
        $supplierRelationNaturalPerson = $this->permission($userUUID);
        $supplierRelationNaturalPerson->load('naturalPerson');
        return new SupplierRelationNaturalPersonResource($supplierRelationNaturalPerson);
    }


    /**
     * 权限资源
     *
     * @param $userUUID
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function permission($userUUID)
    {
        $supplierRelationNaturalPerson = SupplierRelationNaturalPerson::where('user_uuid', $userUUID)
            ->where('supplier_uuid', Auth::user()->supplier_uuid)->firstOrFail();
        return $supplierRelationNaturalPerson;
    }
}