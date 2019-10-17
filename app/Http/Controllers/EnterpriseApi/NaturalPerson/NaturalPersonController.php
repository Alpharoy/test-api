<?php

namespace App\Http\Controllers\EnterpriseApi\NaturalPerson;

use App\Http\Controllers\EnterpriseApi\BaseController;
use App\Http\Requests\EnterpriseApi\Request;
use App\Http\Resources\EnterpriseApi\Enterprise\EnterpriseRelationNaturalPersonResource;
use App\Models\Enterprise\EnterpriseRelationNaturalPerson;
use App\Services\SqlBuildService;
use Illuminate\Support\Facades\Auth;

/**
 * 自然人
 *
 * Class NaturalPersonController
 *
 * @package App\Http\Controllers\EnterpriseApi\NaturalPerson
 */
class NaturalPersonController extends BaseController
{

    /**
     * 自然人
     *
     * @param Request $request
     *
     * @return EnterpriseRelationNaturalPersonResource[]
     */
    public function index(Request $request)
    {
        $query  = EnterpriseRelationNaturalPerson::query();
        $inputs = $request->input();

        $query->where('enterprise_uuid', Auth::user()->enterprise_uuid);

        $query = SqlBuildService::buildLikeQuery($query, $inputs, [
            'id_card_number' => 'id_card_number',
            'user_name'      => 'user_name',
            'user_phone'     => 'user_phone',
        ], 'naturalPerson');

        $query = SqlBuildService::buildEqualQuery($query, $inputs, [
            'status' => 'audit_status',
        ], 'naturalPerson');

        $query->orderBy('id', 'desc');
        $enterpriseRelationNaturalPersons = $query->paginate();
        $enterpriseRelationNaturalPersons->load('naturalPerson');
        return EnterpriseRelationNaturalPersonResource::collection($enterpriseRelationNaturalPersons);
    }

    /**
     * 自然人详情
     *
     * @param Request $request
     * @param         $userUUID
     *
     * @return EnterpriseRelationNaturalPersonResource
     */
    public function show(Request $request, $userUUID)
    {
        $enterpriseRelationNaturalPerson = $this->permission($userUUID);
        $enterpriseRelationNaturalPerson->load('naturalPerson');
        return new EnterpriseRelationNaturalPersonResource($enterpriseRelationNaturalPerson);
    }

    /**
     * 权限
     *
     * @param $userUUID
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function permission($userUUID)
    {
        $enterpriseRelationNaturalPerson = EnterpriseRelationNaturalPerson::where('user_uuid', $userUUID)
            ->where('enterprise_uuid', Auth::user()->enterprise_uuid)->firstOrFail();
        return $enterpriseRelationNaturalPerson;
    }
}