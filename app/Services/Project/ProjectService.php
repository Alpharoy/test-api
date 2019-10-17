<?php

namespace App\Services\Project;

use App\Models\Contract\Contract;
use App\Models\Enterprise\Enterprise;
use App\Models\Project\Project;
use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierSubject;
use App\Services\BaseService;
use Carbon\Carbon;
use Urland\Exceptions\Client\BadRequestException;
use Urland\Exceptions\Client\ForbiddenException;
use Urland\Exceptions\Client\NotFoundException;

/**
 * Class ProjectService
 *
 * @package App\Services\Project
 */
class ProjectService extends BaseService
{

    /**
     * @param       $enterpriseUUID
     * @param       $supplierUUID
     * @param array $projectData
     *
     * @return \App\Models\Project\Project|\Illuminate\Database\Eloquent\Model
     */
    public static function store($enterpriseUUID, $supplierUUID, $projectData = [])
    {
        // 检查合同是否有效
        $contract = Contract::where('enterprise_uuid', $enterpriseUUID)->where('supplier_uuid',
            $supplierUUID)->orderBy('id', 'desc')->first();
        if (!$contract) {
            throw new ForbiddenException('当前未与该供应商签订合约');
        }
        if ($contract->status !== cons('common.audit_status.passed') || $contract->valid_time < Carbon::now()) {
            throw new ForbiddenException('当前与该供应商签订的合约未审核通过或者已过期');
        }

        $enterprise                     = Enterprise::where('enterprise_uuid', $enterpriseUUID)->firstOrFail();
        $projectData['enterprise_uuid'] = $enterpriseUUID;
        $projectData['enterprise_name'] = $enterprise->enterprise_name;

        $supplier                     = Supplier::where('supplier_uuid', $supplierUUID)->firstOrFail();
        $projectData['supplier_uuid'] = $supplierUUID;
        $projectData['supplier_name'] = $supplier->supplier_name;

        $projectData['contract_uuid'] = $contract->contract_uuid;
        $projectData['contract_no']   = $contract->contract_no;
        $projectData['contract_name'] = $contract->contract_name;

        // 状态新增时统一为未审核
        $projectData['status']                = cons('common.audit_status.unaudited');
        $projectData['is_industry_type_open'] = true;
        $projectData                          = self::fillData($projectData);
        $project                              = Project::create($projectData);
        return $project;
    }

    /**
     * 修改项目
     *
     * @param Project $project
     * @param array   $projectData
     *
     * @return Project
     */
    public static function update(Project $project, $projectData = [])
    {
        // 填充项目数据
        $projectData = self::fillData($projectData, $project);
        // 更新项目
        $project->update($projectData);
        return $project;
    }

    /**
     * 填充数据
     *
     * @param              $projectData
     * @param Project|null $originData
     *
     * @return mixed
     */
    protected static function fillData($projectData, Project $originData = null)
    {
        $originArray = [];
        if (!is_null($originData)) {
            $originArray = $originData->toArray();
        }
        $projectData = array_merge($originArray, $projectData);

        // 项目的行业类型数值来源于对应供应商维护的业务类型中的行业类型
        // 行业类型
        if (is_null($originData) || $originData->industry_type_code != $projectData['industry_type_code']) {
            $supplierSubject = SupplierSubject::where('supplier_uuid', $projectData['supplier_uuid'])->where('is_open',
                true)->first();
            if (!$supplierSubject) {
                throw new BadRequestException('该供应商没有启用该行业类型');
            }
            $projectData['industry_type_code'] = $supplierSubject['industry_type_code'];
            $projectData['industry_type_name'] = $supplierSubject['industry_type_name'];
        }

        // 用工类型
        if (is_null($originData) || $originData->employment_type_code != $projectData['employment_type_code']) {
            $projectData['employment_type_name'] = cons()->valueLang('common.employee_type',
                $projectData['employment_type_code']);
            if (empty($projectData['employment_type_code'])) {
                throw new ForbiddenException('用工类型选择错误');
            }
        }

        // 根据 address_code 获取 address_name
        if (!empty($projectData['address_code'])) {
            if (is_null($originData) || $originData->location_code != $projectData['address_code']) {
                $area                        = area($projectData['address_code']);
                $projectData['address_name'] = $area->getFullName();
            }
        } else {
            $projectData['address_code'] = null;
            $projectData['address_name'] = null;
        }

        // 权限判断
        $permission    = cons('project.permission');
        $allPermission = 0;
        foreach ($permission as $val) {
            $allPermission = $allPermission | $val;
        }
        if ($projectData['permission'] < 0 || $projectData['permission'] > $allPermission) {
            throw new ForbiddenException('权限设置错误');
        }

        return $projectData;
    }

    /**
     * 修改服务费率
     *
     * @param \App\Models\Project\Project $project
     * @param                             $serviceCharge
     *
     * @return \App\Models\Project\Project
     */
    public static function updateServiceCharge(Project $project, $serviceCharge)
    {
        if ($project->service_charge === $serviceCharge) {
            return $project;
        }
        if (!$project->can_update_service_charge) {
            throw new ForbiddenException('当前项目禁止修改服务费率');
        }
        $project->update(['service_charge' => $serviceCharge]);
        return $project;
    }

    /**
     * 审核项目
     *
     * @param \App\Models\Project\Project $project
     * @param int                         $auditStatus
     * @param int                         $serviceCharge
     *
     * @return \App\Models\Project\Project
     */
    public static function changeAuditStatus(Project $project, $auditStatus, $serviceCharge)
    {
        // 状态一致，无需切换
        if ($project->status === $auditStatus) {
            return $project;
        }

        // 审核通过禁止再次审核
        if ($project->status === cons('common.audit_status.passed')) {
            throw new ForbiddenException('项目已审核通过，禁止再次审核');
        }

        // 校验审核状态
        if (cons()->hasValue('common.audit_status', $auditStatus) === false) {
            throw new NotFoundException('审核状态有误');
        }

        $allow = false;
        switch ($auditStatus) {
            case cons('common.audit_status.unaudited'):
                $allow = $project->can_reverse_audit;
                break;
            case cons('common.audit_status.failed'):
                $allow = $project->can_audit_failed;
                break;
            case cons('common.audit_status.passed'):
                $allow = $project->can_audit_passed;
                break;
            default:
        }
        if (!$allow) {
            throw new ForbiddenException('审核状态有误');
        }
        $project->update(['status' => $auditStatus, 'service_charge' => $serviceCharge]);
        // 抛出审核通过的事件
        if ($auditStatus === cons('common.audit_status.passed')) {
            //            event(new AuditPassedEvent($project));
        }
        return $project;
    }

    /**
     * 项目删除
     *
     * @param \App\Models\Project\Project $project
     *
     * @return |null
     * @throws \Exception
     */
    public static function delete(Project $project)
    {
        if (!$project->can_delete) {
            throw new ForbiddenException('项目状态禁止删除');
        }
        $project->delete();
        return null;
    }
}