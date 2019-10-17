<?php

namespace App\Services\Supplier;

use App\Events\Supplier\AuditSuccessEvent;
use App\Events\Supplier\CreateEvent;
use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierUser;
use App\Services\BaseService;
use Urland\Exceptions\Client;
use Urland\Exceptions\Client\BadRequestException;

/**
 * Class LogisticsService
 *
 * @package App\Services\Logistics
 */
class SupplierService extends BaseService
{
    /**
     * 创建供应商和供应商超级管理员
     *
     * @param array $supplierData
     * @param array $supplierUserData
     *
     * @return \App\Models\Supplier\Supplier|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function store($supplierData = [], $supplierUserData = [])
    {
        $exists = SupplierUser::where('user_phone', $supplierUserData['user_phone'])->exists();
        if ($exists) {
            throw new Client\BadRequestException('企业公司管理员已存在');
        }
        $supplierData                = self::fillData($supplierData);
        $supplier                    = Supplier::create($supplierData);
        $supplierUserData['is_open'] = true;
        SupplierUserService::store($supplier->supplier_uuid, cons('user.type.super'), $supplierUserData['user_phone'],
            $supplierUserData['password'], $supplierUserData);

        event(new CreateEvent($supplier));
        return $supplier;
    }

    /**
     * 更新供应商信息
     *
     * @param \App\Models\Supplier\Supplier $supplier
     * @param array                         $suppliersData
     *
     * @return \App\Models\Supplier\Supplier
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function update(Supplier $supplier, $suppliersData = [])
    {
        // 填充供应商数据
        $supplierData = self::fillData($suppliersData, $supplier);
        // 更新供应商
        $supplier->fill($supplierData)->save();
        return $supplier;
    }

    /**
     * 填充数据
     *
     * @param array                              $suppliersData
     * @param \App\Models\Supplier\Supplier|null $originData
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected static function fillData($suppliersData, Supplier $originData = null)
    {
        // 创建或未审核时变更需验证唯一性
        if (is_null($originData)) {
            $uniqueKey = [
                'supplier_name' => '供应商名称',
                'usci_number'   => '供应商统一信用代码',
            ];
            foreach ($uniqueKey as $field => $fieldName) {
                $query = Supplier::query()->where($field, $suppliersData[$field]);
                if (!is_null($originData)) {
                    $query = $query->where('supplier_uuid', '<>', $originData->supplier_uuid);
                }
                if ($query->exists()) {
                    throw new Client\BadRequestException($fieldName . '已存在');
                }
            }
        } else {
            unset($suppliersData['supplier_name'], $suppliersData['usci_number']);
        }

        // 行业类型
        if (!empty($suppliersData['industry_type_code'])) {
            if (is_null($originData) || $originData->industry_type_code != $suppliersData['industry_type_code']) {
                $industryType = app('file-db')->load('industry_types')->firstWhere('code',
                    $suppliersData['industry_type_code']);
                if (!$industryType) {
                    throw new BadRequestException('行业类型选择错误');
                }
                $suppliersData['industry_type_code'] = $industryType['code'];
                $suppliersData['industry_type_name'] = $industryType['name'];
            }
        } else {
            $suppliersData['industry_type_code'] = null;
            $suppliersData['industry_type_name'] = null;
        }

        // 证件类型
        if (!empty($suppliersData['artificial_person_certificate_type_code'])) {
            if (is_null($originData) || $originData->artificial_person_certificate_type_code != $suppliersData['artificial_person_certificate_type_code']) {
                $suppliersData['artificial_person_certificate_type_name'] = cons()->valueLang('common.certificate_type',
                    $suppliersData['artificial_person_certificate_type_code']);
                if (empty($suppliersData['artificial_person_certificate_type_name'])) {
                    throw new Client\ForbiddenException('法人证件类型选择错误');
                }
                // TODO: 当选择身份证时，要不要检验身份证正确性
            }
        } else {
            // 证件号码不必清空也没什么影响
            $suppliersData['artificial_person_certificate_type_code'] = null;
        }
        // 根据 address_code 获取 address_name
        if (!empty($suppliersData['location_code'])) {
            if (is_null($originData) || $originData->location_code != $suppliersData['location_code']) {
                $area                           = area($suppliersData['location_code']);
                $suppliersData['location_name'] = $area->getFullName();
            }
        } else {
            $suppliersData['location_code'] = null;
            $suppliersData['location_name'] = null;
        }
        return $suppliersData;
    }


    /**
     * 更改审核状态
     *
     * @param \App\Models\Supplier\Supplier   $supplier
     * @param                                 $auditStatus
     *
     * @return \App\Models\Supplier\Supplier
     */
    public static function changeAuditStatus(Supplier $supplier, $auditStatus)
    {
        // 状态一致，无需切换
        if ($supplier->status === $auditStatus) {
            return $supplier;
        }

        // 审核通过禁止再次审核
        if ($supplier->status === cons('common.audit_status.passed')) {
            throw new Client\ForbiddenException('供应商已审核通过，禁止再次审核');
        }

        // 校验审核状态
        if (cons()->hasValue('common.audit_status', $auditStatus) === false) {
            throw new Client\NotFoundException('审核状态有误');
        }

        $allow = false;
        switch ($auditStatus) {
            case cons('common.audit_status.unaudited'):
                $allow = $supplier->can_reverse_audit;
                break;
            case cons('common.audit_status.failed'):
                $allow = $supplier->can_audit_failed;
                break;
            case cons('common.audit_status.passed'):
                $allow = $supplier->can_audit_passed;
                break;
            default:
        }
        if (!$allow) {
            throw new Client\ForbiddenException('审核状态有误');
        }

        $supplier->update(['status' => $auditStatus]);
        // 抛出审核通过的事件
        if ($auditStatus === cons('common.audit_status.passed')) {
            event(new AuditSuccessEvent($supplier));
        }
        return $supplier;
    }
}
