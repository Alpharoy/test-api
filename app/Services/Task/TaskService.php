<?php

namespace App\Services\Supplier;

use App\Events\Task\AcceptEvent;
use App\Events\Task\AssignEvent;
use App\Events\Task\CreateEvent;
use App\Events\Task\DeleteEvent;
use App\Events\Task\UpdateEvent;
use App\Models\Contract\Contract;
use App\Models\Enterprise\Enterprise;
use App\Models\NaturalPerson\NaturalPerson;
use App\Models\NaturalPerson\NaturalPersonBankCard;
use App\Models\Project\Project;
use App\Models\SelfEmploy\SelfEmploy;
use App\Models\Supplier\SupplierSubject;
use App\Models\Task\Task;
use App\Services\BaseService;
use Carbon\Carbon;
use Urland\Exceptions\Client\ForbiddenException;
use Urland\Exceptions\Client\NotFoundException;
use Urland\Exceptions\Server\InternalServerException;

class TaskService extends BaseService
{
    /**
     * 创建任务订单
     *
     * @param       $enterpriseUUID
     * @param array $taskData
     *
     * @return \App\Models\Task\Task|\Illuminate\Database\Eloquent\Model
     */
    public static function store($enterpriseUUID, $taskData = [])
    {
        $enterprise                  = Enterprise::where('enterprise_uuid', $enterpriseUUID)->firstOrFail();
        $taskData['enterprise_uuid'] = $enterprise->enterprise_uuid;
        $taskData['enterprise_name'] = $enterprise->enterprise_name;

        // 部分字段填充默认值
        $taskData = array_merge($taskData, [
            'pay_status'         => cons('common.pay_status.normality'),
            'handler_pay_status' => cons('common.pay_status.normality'),
            'status'             => cons('task.status.created'),
            'record_time'        => Carbon::now(),
        ]);

        $taskData = self::fillData($taskData);
        $task     = Task::create($taskData);

        event(new CreateEvent($task));
        return $task;
    }

    /**
     * 更新信息
     *
     * @param \App\Models\Task\Task $task
     * @param array                 $taskData
     *
     * @return \App\Models\Task\Task
     */
    public static function update(Task $task, $taskData = [])
    {
        // 已派单/已支付服务费/已支付/已完成的订单不允许变更项目、订单金额
        if (!$task->can_update_project) {
            unset($taskData['project_uuid'], $taskData['task_fees']);
        }

        // 已支付给个体时接单人不可以变更
        if (!$task->can_update_handler) {
            unset($taskData['handler_object_group'], $taskData['handler_object_uuid'], $taskData['handler_object_card_number']);
        }

        $taskData = self::fillData($taskData, $task);
        // 如果订单状态为拒绝接单，则编辑后状态修改为已创建
        if ($task->status === cons('task.status.reject')) {
            // TODO: fsm 接入
            $taskData['status'] = cons('task.status.created');
        }
        $task->fill($taskData)->save();
        event(new UpdateEvent($task));
        return $task;
    }

    /**
     * 接单
     *
     * @param \App\Models\Task\Task $task
     *
     * @return \App\Models\Task\Task
     */
    public static function accept(Task $task)
    {
        if (!$task->can_accept) {
            throw new ForbiddenException('当前任务订单暂不能接单');
        }
        $task->fill(['status' => cons('task.status.accept')])->save();

        event(new AcceptEvent($task));
        return $task;
    }

    /**
     * 派单给自然人或个体
     *
     * @param \App\Models\Task\Task $task
     * @param array                 $taskData
     *
     * @return \App\Models\Task\Task
     */
    public static function assign(Task $task, $taskData = [])
    {
        if (!$task->can_assign) {
            throw new ForbiddenException('当前任务订单暂不能派单');
        }

        // 已支付给个体时接单人不可以变更
        if (!$task->can_update_handler) {
            unset($taskData['handler_object_group'], $taskData['handler_object_uuid'], $taskData['handler_object_card_number']);
        }

        $taskData = self::fillData($taskData, $task);
        // TODO: fsm 接入
        $taskData['status'] = cons('task.status.assign');
        $task->fill($taskData)->save();
        event(new AssignEvent($task));
        return $task;
    }

    /**
     * 拒绝接单
     *
     * @param \App\Models\Task\Task $task
     *
     * @return \App\Models\Task\Task
     */
    public static function reject(Task $task)
    {
        if (!$task->can_reject) {
            throw new ForbiddenException('当前任务订单暂不能拒绝接单');
        }
        // TODO: fsm 接入
        $task->fill(['status' => cons('task.status.reject')])->save();
        return $task;
    }

    /**
     * 任务订单删除
     *
     * @param \App\Models\Task\Task $task
     *
     * @return |null
     * @throws \Exception
     */
    public static function delete(Task $task)
    {
        if (!$task->can_delete) {
            throw new ForbiddenException('当前任务订单暂不能删除');
        }

        event(new DeleteEvent($task));
        $task->delete();
        return null;
    }

    /**
     * 数据填充
     *
     * @param array                      $taskData
     * @param \App\Models\Task\Task|null $originData
     *
     * @return array
     */
    protected static function fillData($taskData = [], Task $originData = null)
    {
        $originArray = [];
        if (!is_null($originData)) {
            $originArray = $originData->toArray();
        }
        $taskData = array_merge($originArray, $taskData);

        if ($taskData['end_time'] < $taskData['start_time']) {
            throw new ForbiddenException('任务结束时间不能比开始时间早');
        }

        // 地区
        if (is_null($originData) || $originData->address_code !== $taskData['address_code']) {
            $area                     = area($taskData['address_code']);
            $taskData['address_name'] = $area->getFullName();
        }

        // 项目
        if (is_null($originData) || $originData->project_uuid !== $taskData['project_uuid']) {
            $project = Project::where('project_uuid', $taskData['project_uuid'])->where('enterprise_uuid',
                $taskData['enterprise_uuid'])->first();
            if (empty($project)) {
                throw new NotFoundException('所选项目不存在');
            }
            if ($project->status !== cons('common.audit_status.passed')) {
                throw new ForbiddenException('所选项目供应商未审核通过');
            }
            if (!$project->is_open) {
                throw new ForbiddenException('所选项目供应商未启用');
            }
            if (!$project->is_industry_type_open) {
                throw new ForbiddenException('所选项目供应商行业类型未启用');
            }

            $taskData['project_uuid']           = $project->project_uuid;
            $taskData['project_name']           = $project->project_name;
            $taskData['supplier_uuid']          = $project->supplier_uuid;
            $taskData['supplier_name']          = $project->supplier_name;
            $taskData['industry_type_code']     = $project->industry_type_code;
            $taskData['industry_type_name']     = $project->industry_type_name;
            $taskData['is_auto_accept']         = $project->is_auto_accept;
            $taskData['is_auto_complete']       = $project->is_auto_complete;
            $taskData['project_service_charge'] = $project->service_charge;

            // 服务费
            $taskData['service_charge_fees'] = round($taskData['task_fees'] * $taskData['project_service_charge'] / 10000);
        }

        // 科目
        if (is_null($originData) || $originData->supplier_subject_uuid !== $taskData['supplier_subject_uuid']) {
            $supplierSubject = SupplierSubject::where('supplier_uuid',
                $taskData['supplier_uuid'])->where('industry_type_code',
                $taskData['industry_type_code'])->where('supplier_subject_uuid',
                $taskData['supplier_subject_uuid'])->first();
            if (empty($supplierSubject)) {
                throw new NotFoundException('所选科目不存在');
            }
            $taskData['supplier_subject_uuid'] = $supplierSubject->supplier_subject_uuid;
            $taskData['supplier_subject_name'] = $supplierSubject->supplier_subject_name;
        }

        // 接单人
        if (is_null($originData)
            || $originData->handler_object_group !== $taskData['handler_object_group']
            || $originData->handler_object_uuid !== $taskData['handler_object_uuid']) {

            if ($taskData['handler_object_group'] === cons('user.group.self_employ')) {
                throw new InternalServerException('暂不支持个体户接单');
                // 接单人类型为个体户
                $selfEmploy = SelfEmploy::where('self_employ_uuid', $taskData['handler_object_uuid'])->first();
                if (empty($selfEmploy)) {
                    throw new NotFoundException('接单个体工商户不存在');
                }
                if ($selfEmploy->status !== cons('common.audit_status.passed')) {
                    throw new ForbiddenException('接单个体工商户未审核通过');
                }
                $taskData['handler_object_group']              = cons('user.group.self_employ');
                $taskData['handler_object_uuid']               = $selfEmploy->self_employ_uuid;
                $taskData['handler_object_name']               = $selfEmploy->self_employ_name;
                $taskData['handler_object_phone']              = $selfEmploy->contact_phone_number;
                $taskData['handler_object_certificate_number'] = $selfEmploy->artificial_person_certificate_number;
                $taskData['handler_object_bank_identity']      = null;
                $taskData['handler_object_bank_name']          = $selfEmploy->bank_name;
                $taskData['handler_object_card_number']        = $selfEmploy->bank_account;
            } elseif ($taskData['handler_object_group'] === cons('user.group.natural_person')) {
                // 接单人类型为自然人
                $naturalPerson = NaturalPerson::where('user_uuid', $taskData['handler_object_uuid'])->first();
                if (empty($naturalPerson)) {
                    throw new NotFoundException('接单自然人不存在');
                }
                if (!$naturalPerson->is_name_verified) {
                    throw new ForbiddenException('接单自然人未通过实名认证');
                }
                if ($naturalPerson->status !== cons('common.audit_status.passed')) {
                    throw new ForbiddenException('接单自然人未审核通过');
                }

                // 自然人签约检测
                $contract = Contract::where('group', cons('contract.group.natural_person'))->where('user_uuid',
                    $taskData['handler_object_uuid'])->where('is_valid', true)->orderBy('id', 'desc')->first();
                if (!$contract) {
                    throw new ForbiddenException('接单自然人未签订协议');
                }
                if ($contract->status !== cons('common.audit_status.passed')) {
                    throw new ForbiddenException('接单自然人签订协议未审核通过');
                }
                if ($contract->valid_time < Carbon::now()) {
                    throw new ForbiddenException('接单自然人签订协议已过有效期');
                }

                // 限额处理
                $monthTotalTaskFees = Task::where('handler_object_group',
                    cons('user.group.natural_person'))->where('handler_object_uuid',
                    $taskData['handler_object_uuid'])->where('record_time', '>=',
                    $taskData['record_time']->startOfMonth())->where('record_time',
                    '<=', $taskData['record_time']->endOfMonth())->sum('task_fees');
                if ($monthTotalTaskFees + $taskData['task_fees'] > cons('task.limit.natural_person')) {
                    throw new ForbiddenException('接单人已超额，请重新选择');
                }
                $taskData['handler_object_group']              = cons('user.group.natural_person');
                $taskData['handler_object_uuid']               = $naturalPerson->user_uuid;
                $taskData['handler_object_name']               = $naturalPerson->user_name;
                $taskData['handler_object_phone']              = $naturalPerson->user_phone;
                $taskData['handler_object_certificate_number'] = $naturalPerson->id_card_number;
            } else {
                throw new ForbiddenException('未定义接单人类型');
            }
        }

        // 收款银行卡
        if (is_null($originData)
            || $originData->handler_object_card_number !== $taskData['handler_object_card_number']) {
            // 自然人才允许变更银行卡
            if ($taskData['handler_object_group'] === cons('user.group.natural_person')) {
                if ($taskData['handler_object_card_number']) {
                    $naturalPersonBankCard = NaturalPersonBankCard::where('user_uuid',
                        $taskData['handler_object_uuid'])->where('card_number',
                        $taskData['handler_object_card_number'])->first();
                    if (empty($naturalPersonBankCard)) {
                        throw new NotFoundException('自然人银行卡不存在');
                    }
                    if (!$naturalPersonBankCard->is_verified) {
                        throw new ForbiddenException('自然人银行卡未审核通过');
                    }
                    $taskData['handler_object_bank_identity'] = $naturalPersonBankCard->bank_identity;
                    $taskData['handler_object_bank_name']     = $naturalPersonBankCard->bank_name;
                    $taskData['handler_object_card_number']   = $naturalPersonBankCard->card_number;
                } else {
                    $taskData['handler_object_bank_identity'] = null;
                    $taskData['handler_object_bank_name']     = null;
                    $taskData['handler_object_card_number']   = null;
                }
            }
        }

        $taskData['total_fees'] = $taskData['task_fees'] + $taskData['service_charge_fees'];

        return $taskData;
    }
}