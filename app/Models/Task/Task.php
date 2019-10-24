<?php

namespace App\Models\Task;

use App\Models\Model;
use Carbon\Carbon;
use UTMS\UUID\UUID;

class Task extends Model
{
    protected $table = 'tasks';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '任务订单';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'task_name',

        'project_uuid',
        'project_name',
        'supplier_uuid',
        'supplier_name',

        'enterprise_uuid',
        'enterprise_name',

        'address_code',
        'address_name',
        'address_detail',
        'contact_name',
        'contact_phone_number',

        'introduce',

        'project_service_charge',
        'industry_type_code',
        'industry_type_name',
        'supplier_subject_uuid',
        'supplier_subject_name',

        'handler_object_group',
        'handler_object_uuid',
        'handler_object_name',
        'handler_object_phone',
        'handler_object_certificate_number',
        'handler_object_bank_identity',
        'handler_object_bank_name',
        'handler_object_card_number',

        'task_fees',
        'service_charge_fees',
        'total_fees',
        'pay_status',
        'pay_time',

        'handler_pay_status',
        'handler_pay_time',

        'is_auto_accept',
        'is_auto_complete',
        'record_time',

        'status',

        'attachment',
        'pictures',

        'source_from',
        'source_from_uuid',
    ];

    /**
     * 返回该字段自动设置未 Carbon 对象
     *
     * @var array
     */
    protected $dates = [
        'last_modified_time',
        'start_time',
        'end_time',

        'pay_time',
        'handler_pay_time',

        'record_time',
    ];

    /**
     * 应该被转换成原生类型的属性
     *
     * @var array
     */
    protected $casts = [
        'pictures'   => 'array',
        'attachment' => 'array',

        'is_auto_accept'   => 'bool',
        'is_auto_complete' => 'bool',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Task $task) {
            //先设置删除标志,等待UUID填充后，清除删除标志
            $task->setAttribute('delete_time', Carbon::now());
        });

        static::created(function (Task $task) {
            $task->syncOriginal();
            $UUID = UUID::buildById(cons('uuid.task'), $task->id);
            $data = [
                'task_uuid'   => $UUID,
                'delete_time' => null,
            ];
            $task->forceFill($data)->save();
        });
    }

    /**
     * 是否能接单
     *
     * @return bool
     */
    public function getCanAcceptAttribute()
    {
        return $this->status === cons('task.status.created');
    }

    /**
     * 是否能派单
     *
     * @return bool
     */
    public function getCanAssignAttribute()
    {
        return $this->status === cons('task.status.accept');
    }

    /**
     * 是否能拒绝接单
     *
     * @return bool
     */
    public function getCanRejectAttribute()
    {
        return $this->status === cons('task.status.created')
            && $this->pay_status === cons('common.pay_status.normality')
            && $this->handler_pay_status === cons('common.pay_status.normality');
    }

    /**
     * 是否能删除
     *
     * @return bool
     */
    public function getCanDeleteAttribute()
    {
        return in_array($this->status,
                [
                    cons('task.status.created'),
                    cons('task.status.accept'),
                    cons('task.status.reject'),
                ])
            && $this->pay_status === cons('common.pay_status.normality')
            && $this->handler_pay_status === cons('common.pay_status.normality');
    }

    /**
     * 能否更新接单人
     *
     * @return bool
     */
    public function getCanUpdateHandlerAttribute()
    {
        return in_array($this->status,
                [
                    cons('task.status.created'),
                    cons('task.status.accept'),
                    cons('task.status.assign'),
                    cons('task.status.reject'),
                ])
            && $this->handler_pay_status === cons('common.pay_status.normality');
    }

    /**
     * 能否更新项目
     *
     * @return bool
     */
    public function getCanUpdateProjectAttribute()
    {
        return in_array($this->status,
                [
                    cons('task.status.created'),
                    cons('task.status.accept'),
                    cons('task.status.reject'),
                ])
            && $this->pay_status === cons('common.pay_status.normality')
            && $this->handler_pay_status === cons('common.pay_status.normality');
    }
}