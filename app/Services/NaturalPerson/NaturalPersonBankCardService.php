<?php

namespace App\Services\NaturalPerson;

use App\Events\NaturalPerson\NaturalPersonBankCard\CreateEvent;
use App\Events\NaturalPerson\NaturalPersonBankCard\UpdateEvent;
use App\Models\NaturalPerson\NaturalPerson;
use App\Models\NaturalPerson\NaturalPersonBankCard;
use App\Services\BaseService;
use Illuminate\Support\Arr;
use Urland\Exceptions\Client\BadRequestException;
use Urland\Exceptions\Client\ForbiddenException;
use UTMS\Validator\LuhnVerify;

class NaturalPersonBankCardService extends BaseService
{
    /**
     * 绑定银行卡
     *
     * @param       $userUUID
     * @param array $bankCardData
     *
     * @return NaturalPersonBankCard|\Illuminate\Database\Eloquent\Model
     */
    public static function store($userUUID, $bankCardData = [])
    {
        $naturalPerson = NaturalPerson::where('user_uuid', $userUUID)->firstOrFail();
        if (!$naturalPerson->is_name_verified) {
            throw new ForbiddenException('未通过实名认证，禁止绑定银行卡');
        }
        $bankCardData = array_merge($bankCardData, [
            'user_uuid'   => $userUUID,
            'card_holder' => $naturalPerson->user_name,
        ]);

        $bankCardData          = self::fillData($bankCardData);
        $naturalPersonBankCard = NaturalPersonBankCard::create($bankCardData);

        if ($naturalPersonBankCard->is_default) {
            self::setDefault($userUUID, $naturalPersonBankCard->bank_card_uuid);
        }

        event(new CreateEvent($naturalPersonBankCard));
        return $naturalPersonBankCard;
    }

    /**
     * 更新银行卡信息
     *
     * @param NaturalPersonBankCard $naturalPersonBankCard
     * @param array                 $bankCardData
     *
     * @return NaturalPersonBankCard
     */
    public static function update(NaturalPersonBankCard $naturalPersonBankCard, $bankCardData = [])
    {
        // 如银行卡已通过三要素，则部分信息不能更改
        // 银行卡三要素 银行卡卡号、持卡人姓名、持卡人身份证
        // 银行卡四要素 银行卡卡号、持卡人姓名、持卡人身份证、银行预留手机号码
        if ($naturalPersonBankCard->is_verified) {
            $bankCardData = Arr::only($bankCardData, ['is_default']);
        }

        $bankCardData = self::fillData($bankCardData, $naturalPersonBankCard);
        $naturalPersonBankCard->fill($bankCardData)->save();

        if ($naturalPersonBankCard->is_default) {
            self::setDefault($naturalPersonBankCard->user_uuid, $naturalPersonBankCard->bank_card_uuid);
        }

        event(new UpdateEvent($naturalPersonBankCard));
        return $naturalPersonBankCard;
    }

    /**
     * 设置银行卡为默认卡
     *
     * @param string $userUUID
     * @param string $bankCardUUID
     *
     * @return bool
     */
    public static function setDefault($userUUID, $bankCardUUID)
    {
        $naturalPersonBankCards = NaturalPersonBankCard::where('user_uuid', $userUUID)->get();
        foreach ($naturalPersonBankCards as $naturalPersonBankCard) {
            $naturalPersonBankCard->fill(['is_default' => $naturalPersonBankCard->bank_card_uuid === $bankCardUUID ? true : false])->save();
        }
        return true;
    }

    /**
     * 删除银行卡
     *
     * @param \App\Models\NaturalPerson\NaturalPersonBankCard $naturalPersonBankCard
     *
     * @return |null
     * @throws \Exception
     */
    public static function delete(NaturalPersonBankCard $naturalPersonBankCard)
    {
        $naturalPersonBankCard->delete();
        return null;
    }

    /**
     * 填充数据
     *
     * @param                                                      $bankCardData
     * @param \App\Models\NaturalPerson\NaturalPersonBankCard|null $originData
     *
     * @return array
     */
    protected static function fillData($bankCardData, NaturalPersonBankCard $originData = null)
    {
        $originArray = [];
        if (!is_null($originData)) {
            $originArray = $originData->toArray();
        }
        $bankCardData = array_merge($originArray, $bankCardData);

        // 银行卡卡号检测
        if (is_null($originData) || $originData->card_number !== $bankCardData['card_number']) {
            if (!LuhnVerify::validateBankCardNo($bankCardData['card_number'])) {
                throw new BadRequestException('不是有效的银行卡卡号');
            }
        }

        // 银行名称检测
        if (is_null($originData) || $originData->bank_identity !== $bankCardData['bank_identity']) {
            $bank = app('file-db')->load('banks')->firstWhere('identity',
                $bankCardData['bank_identity']);
            if (!$bank) {
                throw new BadRequestException('银行选择错误');
            }
            $bankCardData['bank_identity'] = $bank['identity'];
            $bankCardData['bank_name']     = $bank['name'];
        }

        return $bankCardData;
    }

}