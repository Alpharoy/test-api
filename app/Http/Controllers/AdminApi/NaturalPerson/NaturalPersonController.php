<?php

namespace App\Http\Controllers\AdminApi\NaturalPerson;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\NaturalPerson\NaturalPersonCreateRequest;
use App\Http\Requests\AdminApi\NaturalPerson\NaturalPersonUpdateRequest;
use App\Http\Requests\AdminApi\Request;
use App\Http\Resources\AdminApi\NaturalPerson\NaturalPersonResource;
use App\Models\NaturalPerson\NaturalPerson;
use App\Services\NaturalPerson\NaturalPersonService;
use App\Services\SqlBuildService;
use Illuminate\Support\Arr;

/**
 * 自然人
 *
 * Class NaturalPersonController
 *
 * @package App\Http\Controllers\AdminApi\NaturalPerson
 */
class NaturalPersonController extends BaseController
{
    /**
     * 自然人列表
     *
     * @param Request $request
     *
     * @return NaturalPersonResource[]
     */
    public function index(Request $request)
    {
        $query  = NaturalPerson::query();
        $inputs = $request->input();

        $query = SqlBuildService::buildLikeQuery($query, $inputs, [
            'id_card_number' => 'id_card_number',
            'user_name'      => 'user_name',
            'user_phone'     => 'user_phone',
        ]);

        $query = SqlBuildService::buildEqualQuery($query, $inputs, [
            'status' => 'audit_status',
        ]);

        $query->orderBy('id', 'desc');
        $naturalPersons = $query->paginate();
        return NaturalPersonResource::collection($naturalPersons);
    }

    /**
     * 平台新增自然人
     *
     * @param NaturalPersonCreateRequest $request
     *
     * @return NaturalPersonResource
     */
    public function store(NaturalPersonCreateRequest $request)
    {
        $inputs = $request->validated();

        $userPhone = Arr::pull($inputs, 'user_phone');
        $password  = Arr::pull($inputs, 'password');

        $inputs['source_from']      = cons('common.source_from.insert');
        $inputs['is_name_verified'] = false;
        $inputs['status']           = cons('common.audit_status.unaudited'); // 默认未审核

        $naturalPerson = NaturalPersonService::store($userPhone, $password, $inputs);
        return new NaturalPersonResource($naturalPerson);
    }

    /**
     * 后台修改自然人
     *
     * @param NaturalPersonUpdateRequest $request
     * @param                            $userUUID
     *
     * @return NaturalPersonResource
     */
    public function update(NaturalPersonUpdateRequest $request, $userUUID)
    {
        $inputs        = $request->validated();
        $naturalPerson = $this->permission($userUUID);
        $naturalPerson = NaturalPersonService::update($naturalPerson, $inputs);
        return new NaturalPersonResource($naturalPerson);
    }

    /**
     * 自然人审核
     *
     * @param Request $request
     * @param         $userUUID
     *
     * @return NaturalPersonResource
     */
    public function changeAuditStatus(Request $request, $userUUID)
    {
        $auditStatus   = $request->input('audit_status');
        $naturalPerson = $this->permission($userUUID);
        $naturalPerson = NaturalPersonService::changeAuditStatus($naturalPerson, $auditStatus);
        return new NaturalPersonResource($naturalPerson);
    }

    /**
     * 自然人详情
     *
     * @param Request $request
     * @param         $userUUID
     *
     * @return NaturalPersonResource
     */
    public function show(Request $request, $userUUID)
    {
        $naturalPerson = $this->permission($userUUID);
        return new NaturalPersonResource($naturalPerson);
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
        $naturalPerson = NaturalPerson::where('user_uuid', $userUUID)->firstOrFail();
        return $naturalPerson;
    }

}