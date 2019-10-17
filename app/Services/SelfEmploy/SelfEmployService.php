<?php


namespace App\Services\SelfEmploy;


use App\Models\SelfEmploy\SelfEmploy;
use App\Models\SelfEmploy\SelfEmployUser;
use App\Services\BaseService;
use Urland\Exceptions\Client\BadRequestException;
use Urland\Exceptions\Client\ForbiddenException;
use Urland\Exceptions\Client\NotFoundException;

class SelfEmployService extends BaseService
{

    /**
     * 创建工商户和工商户管理员
     *
     * @param array $selfEmployData
     * @param array $selfEmployUserData
     * @return SelfEmploy|\Illuminate\Database\Eloquent\Model
     */
    public static function store($selfEmployData = [], $selfEmployUserData = [])
    {
        $exists = SelfEmployUser::where('user_phone', $selfEmployUserData['user_phone'])->exists();
        if ($exists) {
            throw new BadRequestException('企业公司管理员已存在');
        }
        $selfEmployData                = self::fillData($selfEmployData);
        $selfEmploy                    = SelfEmploy::create($selfEmployData);
        $enterpriseUserData['is_open'] = true;
        SelfEmployUserService::store($selfEmploy->self_employ_uuid, cons('user.type.super'),
            $selfEmployUserData['user_phone'],
            $selfEmployUserData['password'], $selfEmployUserData);
        return $selfEmploy;
    }

    /**
     * 更新工商户信息
     *
     * @param SelfEmploy $selfEmploy
     * @param array $selfEmployData
     * @return SelfEmploy
     */
    public static function update(SelfEmploy $selfEmploy, $selfEmployData = [])
    {
        // 填充数据
        $selfEmployData = self::fillData($selfEmployData, $selfEmploy);
        // 更新
        $selfEmploy->fill($selfEmployData)->save();

        return $selfEmploy;
    }

    /**
     * 填充数据
     *
     * @param                 $selfEmployData
     * @param SelfEmploy|null $originData
     *
     * @return mixed
     */
    protected static function fillData($selfEmployData, SelfEmploy $originData = null)
    {
        // 创建时需验证唯一性
        if (is_null($originData)) {
            $uniqueKey = [
                'self_employ_name' => '企业名称',
                'usci_number'     => '企业统一信用代码',
            ];
            foreach ($uniqueKey as $field => $fieldName) {
                $query = SelfEmploy::query()->where($field, $selfEmployData[$field]);
                if (!is_null($originData)) {
                    $query = $query->where('self_employ_uuid', '<>', $originData->self_employ_uuid);
                }
                if ($query->exists()) {
                    throw new BadRequestException($fieldName . '已存在');
                }
            }
        } else {
            unset($selfEmployData['self_employ_name'], $selfEmployData['usci_number']);
        }

        // 行业类型
        if (!empty($selfEmployData['industry_type_code'])) {
            if (is_null($originData) || $originData->industry_type_code != $selfEmployData['industry_type_code']) {
                $industryType = app('file-db')->load('industry_types')->firstWhere('code',
                    $selfEmployData['industry_type_code']);
                if (!$industryType) {
                    throw new BadRequestException('行业类型选择错误');
                }
                $selfEmployData['industry_type_code'] = $industryType['code'];
                $selfEmployData['industry_type_name'] = $industryType['name'];
            }
        } else {
            $selfEmployData['industry_type_code'] = null;
            $selfEmployData['industry_type_name'] = null;
        }

        // 证件类型
        if (!empty($selfEmployData['artificial_person_certificate_type_code'])) {
            if (is_null($originData) || $originData->artificial_person_certificate_type_code != $selfEmployData['artificial_person_certificate_type_code']) {
                $selfEmployData['artificial_person_certificate_type_name'] = cons()->valueLang('common.certificate_type',
                    $selfEmployData['artificial_person_certificate_type_code']);
                if (empty($selfEmployData['artificial_person_certificate_type_name'])) {
                    throw new ForbiddenException('法人证件类型选择错误');
                }
                // TODO: 当选择身份证时，要不要检验身份证正确性
            }
        } else {
            // 证件号码不必清空也没什么影响
            $selfEmployData['artificial_person_certificate_type_code'] = null;
        }

        // 根据 address_code 获取 address_name
        if (!empty($selfEmployData['location_code'])) {
            if (is_null($originData) || $originData->location_code != $selfEmployData['location_code']) {
                $area                             = area($selfEmployData['location_code']);
                $selfEmployData['location_name'] = $area->getFullName();
            }
        } else {
            $selfEmployData['location_code'] = null;
            $selfEmployData['location_name'] = null;
        }
        return $selfEmployData;
    }

    /**
     * 更改审核状态
     *
     * @param SelfEmploy $selfEmploy
     * @param $auditStatus
     *
     * @return SelfEmploy
     */
    public static function changeAuditStatus(SelfEmploy $selfEmploy, $auditStatus)
    {
        // 状态一致，无需切换
        if ($selfEmploy->status === $auditStatus) {
            return $selfEmploy;
        }

        // 审核通过禁止再次审核
        if ($selfEmploy->status === cons('common.audit_status.passed')) {
            throw new ForbiddenException('个体工商已审核通过，禁止再次审核');
        }

        // 校验审核状态
        if (cons()->hasValue('common.audit_status', $auditStatus) === false) {
            throw new NotFoundException('审核状态有误');
        }

        $allow = false;
        switch ($auditStatus) {
            case cons('common.audit_status.unaudited'):
                $allow = $selfEmploy->can_reverse_audit;
                break;
            case cons('common.audit_status.failed'):
                $allow = $selfEmploy->can_audit_failed;
                break;
            case cons('common.audit_status.passed'):
                $allow = $selfEmploy->can_audit_passed;
                break;
            default:
        }
        if (!$allow) {
            throw new ForbiddenException('审核状态有误');
        }

        $selfEmploy->update(['status' => $auditStatus]);

        return $selfEmploy;
    }

}