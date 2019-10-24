<?php

namespace App\Services\NaturalPerson;

use App\Events\NaturalPerson\CreateEvent;
use App\Models\NaturalPerson\NaturalPerson;
use App\Services\Auth\UserLoginPwdService;
use App\Services\BaseService;
use Carbon\Carbon;
use Urland\Exceptions\Client\BadRequestException;
use Urland\Exceptions\Client\ForbiddenException;
use Urland\Exceptions\Client\NotFoundException;
use UTMS\Validator\IDCard;

class NaturalPersonService extends BaseService
{
    /**
     * 添加自然人
     *
     * @param string $userPhone
     * @param string $password
     * @param array  $naturalPersonData
     *
     * @return \App\Models\NaturalPerson\NaturalPerson|\Illuminate\Database\Eloquent\Model
     */
    public static function store($userPhone, $password, $naturalPersonData = [])
    {
        $exists = NaturalPerson::where('user_phone', $userPhone)->exists();
        if ($exists) {
            throw new BadRequestException('该手机号码已注册自然人');
        }

        $naturalPersonData = array_merge($naturalPersonData, [
            'user_phone' => $userPhone,
        ]);

        $naturalPersonData = self::fillData($naturalPersonData);
        $naturalPerson     = NaturalPerson::create($naturalPersonData);

        // 插入密码记录
        UserLoginPwdService::create(cons('user.login.type.phone'), $userPhone, cons('user.group.natural_person'),
            $naturalPerson->user_uuid, $password);

        event(new CreateEvent($naturalPerson));
        return $naturalPerson;
    }

    /**
     * 平台修改自然人
     *
     * @param NaturalPerson $naturalPerson
     * @param array         $naturalPersonData
     *
     * @return NaturalPerson
     */
    public static function update(NaturalPerson $naturalPerson, $naturalPersonData = [])
    {
        $naturalPersonData = self::fillData($naturalPersonData, $naturalPerson);
        $naturalPerson->fill($naturalPersonData)->save();
        return $naturalPerson;
    }

    /**
     * 数据填充
     *
     * @param array              $naturalPersonData
     * @param NaturalPerson|null $originData
     *
     * @return mixed
     */
    protected static function fillData($naturalPersonData, NaturalPerson $originData = null)
    {
        $originArray = [];
        if (!is_null($originData)) {
            $originArray = $originData->toArray();
        }
        $naturalPersonData = array_merge($originArray, $naturalPersonData);

        if (is_null($originData) || $originData->id_card_number !== $naturalPersonData['id_card_number']) {
            if (!IDCard::validateIDCard($naturalPersonData['id_card_number'])) {
                throw new BadRequestException('请输入正确的身份证号码');
            }
            // 拆解出性别
            if (substr($naturalPersonData['id_card_number'], -2, 1) % 2) {
                $naturalPersonData['sex'] = cons('common.sex.male');
            } else {
                $naturalPersonData['sex'] = cons('common.sex.female');
            }
            // 拆解出生年月日
            $naturalPersonData['birthday'] = Carbon::create(substr($naturalPersonData['id_card_number'], 6, 4),
                substr($naturalPersonData['id_card_number'], 10, 2),
                substr($naturalPersonData['id_card_number'], 12, 2));
        }

        return $naturalPersonData;
    }

    /**
     * 自然人审核
     *
     * @param NaturalPerson $naturalPerson
     * @param               $auditStatus
     *
     * @return NaturalPerson
     */
    public static function changeAuditStatus(NaturalPerson $naturalPerson, $auditStatus)
    {
        // 状态一致，无需切换
        if ($naturalPerson->status === $auditStatus) {
            return $naturalPerson;
        }

        // 审核通过禁止再次审核
        if ($naturalPerson->status === cons('common.audit_status.passed')) {
            throw new ForbiddenException('自然人已审核通过，禁止再次审核');
        }

        // 校验审核状态
        if (cons()->hasValue('common.audit_status', $auditStatus) === false) {
            throw new NotFoundException('审核状态有误');
        }

        $allow = false;
        switch ($auditStatus) {
            case cons('common.audit_status.unaudited'):
                $allow = $naturalPerson->can_reverse_audit;
                break;
            case cons('common.audit_status.failed'):
                $allow = $naturalPerson->can_audit_failed;
                break;
            case cons('common.audit_status.passed'):
                $allow = $naturalPerson->can_audit_passed;
                if (!$naturalPerson->is_name_verified) {
                    throw new ForbiddenException('未通过实名认证，禁止审核通过');
                }
                break;
            default:
        }
        if (!$allow) {
            throw new ForbiddenException('审核状态有误');
        }
        $naturalPerson->update(['status' => $auditStatus]);
        return $naturalPerson;
    }

}