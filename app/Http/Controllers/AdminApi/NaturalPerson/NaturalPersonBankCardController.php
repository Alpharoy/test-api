<?php

namespace App\Http\Controllers\AdminApi\NaturalPerson;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\NaturalPerson\NaturalPersonBankCardCreateRequest;
use App\Http\Requests\AdminApi\NaturalPerson\NaturalPersonBankCardUpdateRequest;
use App\Http\Requests\AdminApi\Request;
use App\Http\Resources\AdminApi\NaturalPerson\NaturalPersonBankCardResource;
use App\Http\Resources\EmptyResource;
use App\Models\NaturalPerson\NaturalPersonBankCard;
use App\Services\NaturalPerson\NaturalPersonBankCardService;

/**
 * 自然人银行卡管理
 *
 * Class NaturalPersonBankCardController
 *
 * @package App\Http\Controllers\AdminApi\NaturalPerson
 */
class NaturalPersonBankCardController extends BaseController
{
    /**
     * 银行卡列表
     *
     * @param Request $request
     * @param         $userUUID
     *
     * @return NaturalPersonBankCardResource[]
     */
    public function index(Request $request, $userUUID)
    {
        $query = NaturalPersonBankCard::query();
        $query->where('user_uuid', $userUUID);
        $query->orderBy('is_default', 'desc');
        $bankCard = $query->get();
        return NaturalPersonBankCardResource::collection($bankCard);
    }

    /**
     * 银行卡信息
     *
     * @param Request $request
     * @param         $bankCardUUID
     * @param         $userUUID
     *
     * @return NaturalPersonBankCardResource
     */
    public function show(Request $request, $userUUID, $bankCardUUID)
    {
        $naturalPersonBankCard = $this->permission($userUUID, $bankCardUUID);
        return new NaturalPersonBankCardResource($naturalPersonBankCard);
    }

    /**
     * 添加银行卡
     *
     * @param NaturalPersonBankCardCreateRequest $request
     * @param                                    $userUUID
     *
     * @return NaturalPersonBankCardResource
     */
    public function store(NaturalPersonBankCardCreateRequest $request, $userUUID)
    {
        $inputs                = $request->validated();
        $inputs['is_verified'] = false; // 设置为没通过三要素
        $naturalPersonBankCard = NaturalPersonBankCardService::store($userUUID, $inputs);
        return new NaturalPersonBankCardResource($naturalPersonBankCard);
    }

    /**
     * 更新银行卡
     *
     * @param \App\Http\Requests\AdminApi\NaturalPerson\NaturalPersonBankCardUpdateRequest $request
     * @param                                                                              $userUUID
     * @param                                                                              $bankCardUUID
     *
     * @return \App\Http\Resources\AdminApi\NaturalPerson\NaturalPersonBankCardResource
     */
    public function update(NaturalPersonBankCardUpdateRequest $request, $userUUID, $bankCardUUID)
    {
        $naturalPersonBankCard = $this->permission($userUUID, $bankCardUUID);
        $inputs                = $request->validated();
        $naturalPersonBankCard = NaturalPersonBankCardService::update($naturalPersonBankCard, $inputs);
        return new NaturalPersonBankCardResource($naturalPersonBankCard);
    }

    /**
     * 删除银行卡
     *
     * @param \App\Http\Requests\AdminApi\Request $request
     * @param                                     $userUUID
     * @param                                     $bankCardUUID
     *
     * @return \App\Http\Resources\EmptyResource
     * @throws \Exception
     */
    public function destroy(Request $request, $userUUID, $bankCardUUID)
    {
        $naturalPersonBankCard = $this->permission($userUUID, $bankCardUUID);
        NaturalPersonBankCardService::delete($naturalPersonBankCard);
        return new EmptyResource();
    }

    /**
     * 资源权限
     *
     * @param $userUUID
     * @param $bankCardUUID
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function permission($userUUID, $bankCardUUID)
    {
        $naturalPersonBankCard = NaturalPersonBankCard::where('bank_card_uuid', $bankCardUUID)
            ->where('user_uuid', $userUUID)->firstOrFail();
        return $naturalPersonBankCard;
    }

}