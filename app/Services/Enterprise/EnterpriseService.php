<?php

namespace App\Services\Enterprise;

use App\Events\Enterprise\AuditSuccessEvent;
use App\Events\Enterprise\CreateEvent;
use App\Models\Enterprise\Enterprise;
use App\Models\Enterprise\EnterpriseUser;
use App\Services\BaseService;
use Urland\Exceptions\Client;
use Urland\Exceptions\Client\BadRequestException;

/**
 * Class EnterprisesService
 *
 * @package App\Services\EnterprisesController
 */
class EnterpriseService extends BaseService
{
    /**
     * 创建企业公司和企业公司超级管理员
     *
     * @param array $enterpriseData
     * @param array $enterpriseUserData
     *
     * @return Enterprise|\Illuminate\Database\Eloquent\Model
     */
    public static function store($enterpriseData = [], $enterpriseUserData = [])
    {
        $exists = EnterpriseUser::where('user_phone', $enterpriseUserData['user_phone'])->exists();
        if ($exists) {
            throw new BadRequestException('企业公司管理员已存在');
        }
        $enterpriseData                = self::fillData($enterpriseData);
        $enterprise                    = Enterprise::create($enterpriseData);
        $enterpriseUserData['is_open'] = true;
        EnterpriseUserService::store($enterprise->enterprise_uuid, cons('user.type.super'),
            $enterpriseUserData['user_phone'],
            $enterpriseUserData['password'], $enterpriseUserData);

        event(new CreateEvent($enterprise));
        return $enterprise;
    }

    /**
     * 更新企业信息
     *
     * @param \App\Models\Enterprise\Enterprise $enterprise
     * @param array                             $enterprisesData
     *
     * @return \App\Models\Enterprise\Enterprise
     */
    public static function update(Enterprise $enterprise, $enterprisesData = [])
    {
        // 填充企业数据
        $enterprisesData = self::fillData($enterprisesData, $enterprise);
        // 更新企业
        $enterprise->fill($enterprisesData)->save();

        return $enterprise;
    }

    /**
     * 填充数据
     *
     * @param                 $enterprisesData
     * @param Enterprise|null $originData
     *
     * @return mixed
     */
    protected static function fillData($enterprisesData, Enterprise $originData = null)
    {
        // 创建时需验证唯一性
        // TODO: 未考虑允许编辑的情况
        if (is_null($originData)) {
            $uniqueKey = [
                'enterprise_name' => '企业名称',
                'usci_number'     => '企业统一信用代码',
            ];
            foreach ($uniqueKey as $field => $fieldName) {
                $query = Enterprise::query()->where($field, $enterprisesData[$field]);
                if (!is_null($originData)) {
                    $query = $query->where('enterprise_uuid', '<>', $originData->enterprise_uuid);
                }
                if ($query->exists()) {
                    throw new Client\BadRequestException($fieldName . '已存在');
                }
            }
        } else {
            unset($enterprisesData['enterprise_name'], $enterprisesData['usci_number']);
        }

        // 行业类型
        if (!empty($enterprisesData['industry_type_code'])) {
            if (is_null($originData) || $originData->industry_type_code != $enterprisesData['industry_type_code']) {
                $industryType = app('file-db')->load('industry_types')->firstWhere('code',
                    $enterprisesData['industry_type_code']);
                if (!$industryType) {
                    throw new BadRequestException('行业类型选择错误');
                }
                $enterprisesData['industry_type_code'] = $industryType['code'];
                $enterprisesData['industry_type_name'] = $industryType['name'];
            }
        } else {
            $enterprisesData['industry_type_code'] = null;
            $enterprisesData['industry_type_name'] = null;
        }

        // 证件类型
        if (!empty($enterprisesData['artificial_person_certificate_type_code'])) {
            if (is_null($originData) || $originData->artificial_person_certificate_type_code != $enterprisesData['artificial_person_certificate_type_code']) {
                $enterprisesData['artificial_person_certificate_type_name'] = cons()->valueLang('common.certificate_type',
                    $enterprisesData['artificial_person_certificate_type_code']);
                if (empty($enterprisesData['artificial_person_certificate_type_name'])) {
                    throw new Client\ForbiddenException('法人证件类型选择错误');
                }
                // TODO: 当选择身份证时，要不要检验身份证正确性
            }
        } else {
            // 证件号码不必清空也没什么影响
            $enterprisesData['artificial_person_certificate_type_code'] = null;
        }

        // 根据 address_code 获取 address_name
        if (!empty($enterprisesData['location_code'])) {
            if (is_null($originData) || $originData->location_code != $enterprisesData['location_code']) {
                $area                             = area($enterprisesData['location_code']);
                $enterprisesData['location_name'] = $area->getFullName();
            }
        } else {
            $enterprisesData['location_code'] = null;
            $enterprisesData['location_name'] = null;
        }
        return $enterprisesData;
    }


    /**
     * 更改审核状态
     *
     * @param \App\Models\Enterprise\Enterprise $enterprise
     * @param                                   $auditStatus
     *
     * @return \App\Models\Enterprise\Enterprise
     */
    public static function changeAuditStatus(Enterprise $enterprise, $auditStatus)
    {
        // 状态一致，无需切换
        if ($enterprise->status === $auditStatus) {
            return $enterprise;
        }

        // 审核通过禁止再次审核
        if ($enterprise->status === cons('common.audit_status.passed')) {
            throw new Client\ForbiddenException('企业已审核通过，禁止再次审核');
        }

        // 校验审核状态
        if (cons()->hasValue('common.audit_status', $auditStatus) === false) {
            throw new Client\NotFoundException('审核状态有误');
        }

        $allow = false;
        switch ($auditStatus) {
            case cons('common.audit_status.unaudited'):
                $allow = $enterprise->can_reverse_audit;
                break;
            case cons('common.audit_status.failed'):
                $allow = $enterprise->can_audit_failed;
                break;
            case cons('common.audit_status.passed'):
                $allow = $enterprise->can_audit_passed;
                break;
            default:
        }
        if (!$allow) {
            throw new Client\ForbiddenException('审核状态有误');
        }

        $enterprise->update(['status' => $auditStatus]);

        // 抛出审核通过的事件
        if ($auditStatus === cons('common.audit_status.passed')) {
            event(new AuditSuccessEvent($enterprise));
        }

        return $enterprise;
    }
}
