<?php

namespace App\Services\Contract;

use App\Models\Contract\Contract;
use App\Models\Enterprise\Enterprise;
use App\Models\NaturalPerson\NaturalPerson;
use App\Models\SelfEmploy\SelfEmploy;
use App\Models\Supplier\Supplier;
use App\Services\BaseService;
use Carbon\Carbon;
use Urland\Exceptions\Client\BadRequestException;
use Urland\Exceptions\Client\ForbiddenException;
use Urland\Exceptions\Client\NotFoundException;
use Urland\Exceptions\Server\InternalServerException;

class ContractService extends BaseService
{
    /**
     * 申请签约
     *
     * @param string $group
     * @param string $objectUUID
     * @param array  $contractData
     *
     * @return \App\Models\Contract\Contract|\Illuminate\Database\Eloquent\Model
     */
    public static function store($group, $objectUUID, $contractData = [])
    {
        $query = Contract::where('supplier_uuid', $contractData['supplier_uuid']);
        $query->where('group', $group);
        switch ($group) {
            case cons('contract.group.enterprise'):
                $query->where('enterprise_uuid', $objectUUID);
                break;
            case cons('contract.group.natural_person'):
                $query->where('user_uuid', $objectUUID);
                break;
            case cons('contract.group.self_employ'):
                $query->where('self_employ_uuid', $objectUUID);
                break;
            default:
                throw new InternalServerException('未知签约分组');
        }
        $lastContract = $query->orderBy('id', 'desc')->first();
        if ($lastContract) {
            if ($lastContract !== cons('common.audit_status.passed')) {
                throw new ForbiddenException('当前合约未审核通过，禁止再次签订合约');
            }
            if ($lastContract->valid_time >= Carbon::now()) {
                throw new ForbiddenException('当前合约尚未过期，禁止再次签订合约');
            }
        }

        // 企业和个体户 是与 供应商 签约
        if ($group === cons('contract.group.enterprise') || $group === cons('contract.group.self_employ')) {
            $supplier                      = Supplier::where('supplier_uuid',
                $contractData['supplier_uuid'])->firstOrFail();
            $contractData['supplier_name'] = $supplier->supplier_name;
        }

        switch ($group) {
            case cons('contract.group.enterprise'):
                $enterprise = Enterprise::where('enterprise_uuid', $objectUUID)->firstOrFail();
                if ($enterprise->status !== cons('common.audit_status.passed')) {
                    throw new ForbiddenException('企业未审核通过，禁止和供应商签约');
                }
                $contractData['enterprise_uuid'] = $objectUUID;
                $contractData['enterprise_name'] = $enterprise->enterprise_name;
                break;
            case cons('contract.group.natural_person'):
                $naturalPerson = NaturalPerson::where('user_uuid', $objectUUID)->firstOrFail();
                if ($naturalPerson->status !== cons('common.audit_status.passed') || $naturalPerson->is_name_verified) {
                    throw new ForbiddenException('自然人未实名或审核通过，禁止签约');
                }
                $contractData['user_uuid'] = $naturalPerson->user_uuid;
                $contractData['user_name'] = $naturalPerson->user_name;
                break;
            case cons('contract.group.self_employ'):
                $selfEmploy = SelfEmploy::where('self_employ_uuid', $objectUUID)->firstOrFail();
                if ($selfEmploy->status !== cons('common.audit_status.passed')) {
                    throw new ForbiddenException('个体工商户未审核通过，禁止和供应商签约');
                }
                $contractData['self_employ_uuid'] = $selfEmploy->self_employ_uuid;
                $contractData['self_employ_name'] = $selfEmploy->self_employ_name;
                break;
        }

        $contractData['group']    = $group;
        $contractData['is_valid'] = true;
        $contractData             = self::fillData($contractData);
        // 创建合同
        $contract = Contract::create($contractData);

        if ($lastContract) {
            // 将上条合同置为无效
            $lastContract->fill(['is_valid' => false])->save();
        }
        return $contract;
    }

    /**
     * 更新合同
     *
     * @param Contract $contract
     * @param array    $contractData
     *
     * @return Contract
     */
    public static function update(Contract $contract, $contractData = [])
    {
        if (!$contract->can_update) {
            throw new ForbiddenException('合同状态禁止修改');
        }
        $contractData = self::fillData($contractData, $contract);
        $contract->fill($contractData)->save();
        return $contract;
    }

    /**
     * 填充数据处理
     *
     * @param                                    $contractData
     * @param \App\Models\Contract\Contract|null $originData
     *
     * @return array
     */
    protected static function fillData($contractData, Contract $originData = null)
    {
        $originArray = [];
        if (!is_null($originData)) {
            $originArray = $originData->toArray();
        }
        $contractData = array_merge($originArray, $contractData);

        if ($contractData['valid_time'] < Carbon::now()) {
            throw new ForbiddenException('合约有效期已过期');
        }
        return $contractData;
    }

    /**
     * 合约删除
     *
     * @param \App\Models\Contract\Contract $contract
     *
     * @return |null
     * @throws \Exception
     */
    public static function delete(Contract $contract)
    {
        if (!$contract->can_delete) {
            throw new ForbiddenException('合约状态禁止删除');
        }

        // 找到上一个合约，置为有效
        $query = Contract::where('group', $contract->group);
        switch ($contract->group) {
            case cons('contract.group.enterprise'):
                $query->where('supplier_uuid', $contract->supplier_uuid);
                $query->where('enterprise_uuid', $contract->enterprise_uuid);
                break;
            case cons('contract.group.natural_person'):
                $query->where('user_uuid', $contract->user_uuid);
                break;
            case cons('contract.group.self_employ'):
                $query->where('supplier_uuid', $contract->supplier_uuid);
                $query->where('self_employ_uuid', $contract->self_employ_uuid);
                break;
            default:
                return null;
        }
        $lastContract = $query->orderBy('id', 'desc')->first();
        if ($lastContract) {
            $lastContract->fill(['is_valid' => true])->save();
        }
        $contract->delete();
        return null;
    }

    /**
     * 更改签约状态
     *
     * @param \App\Models\Contract\Contract $contract
     * @param                               $auditStatus
     *
     * @return \App\Models\Contract\Contract
     */
    public static function changeAuditStatus(Contract $contract, $auditStatus)
    {
        // 状态一致，无需切换
        if ($contract->status === $auditStatus) {
            return $contract;
        }
        // 审核通过禁止再次审核
        if ($contract->status === cons('common.audit_status.passed')) {
            throw new ForbiddenException('已申请通过，禁止再次审核');
        }

        // 校验审核状态
        if (cons()->hasValue('common.audit_status', $auditStatus) === false) {
            throw new NotFoundException('审核状态有误');
        }

        $allow = false;
        switch ($auditStatus) {
            case cons('common.audit_status.unaudited'):
                $allow = $contract->can_reverse_audit;
                break;
            case cons('common.audit_status.failed'):
                $allow = $contract->can_audit_failed;
                break;
            case cons('common.audit_status.passed'):
                $allow = $contract->can_audit_passed;
                break;
            default:
        }
        if (!$allow) {
            throw new ForbiddenException('审核状态有误');
        }
        $contract->update(['status' => $auditStatus]);
        return $contract;
    }

}