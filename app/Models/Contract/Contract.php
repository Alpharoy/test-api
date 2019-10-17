<?php

namespace App\Models\Contract;

use App\Models\Enterprise\Enterprise;
use App\Models\Model;
use App\Models\Supplier\Supplier;
use Carbon\Carbon;
use UTMS\UUID\UUID;

/**
 * Class Contracts
 *
 * @package App\Models\Contracts
 */
class Contract extends Model
{
    protected $table = 'contracts';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '合同记录';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'enterprise_uuid',
        'enterprise_name',

        'supplier_uuid',
        'supplier_name',

        'self_employ_uuid',
        'self_employ_name',

        'user_uuid',
        'user_name',

        'contract_name',
        'contract_no',
        'applicant_name',
        'valid_time',

        'group',
        'status',

        'attachment',
        'introduce',

        'is_valid',
    ];

    /**
     * 返回该字段自动设置未 Carbon 对象
     *
     * @var array
     */
    protected $dates = [
        'valid_time',
    ];

    /**
     * 转化为原生类型的字段
     *
     * @var array
     */
    protected $casts = [
        'is_valid'   => 'bool',
        'attachment' => 'array',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Contract $contract) {
            //先设置删除标志,等待UUID填充后，清除删除标志
            $contract->setAttribute('delete_time', Carbon::now());
        });

        static::created(function (Contract $contract) {
            $contract->syncOriginal();
            $UUID = UUID::buildById(cons('uuid.contract'), $contract->id);
            $data = [
                'contract_uuid' => $UUID,
                'delete_time'   => null,
            ];
            $contract->forceFill($data)->save();
        });
    }

    /**
     * 定义和企业的关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_uuid', 'enterprise_uuid');
    }

    /**
     * 定义和供应商的关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'enterprise_uuid', 'enterprise_uuid');
    }

    /**
     * 能否审核不通过
     *
     * @return bool
     */
    public function getCanAuditFailedAttribute()
    {
        return $this->status === cons('common.audit_status.unaudited');
    }

    /**
     * 能否审核通过
     *
     * @return bool
     */
    public function getCanAuditPassedAttribute()
    {
        return $this->status === cons('common.audit_status.unaudited');
    }

    /**
     * 能否撤销审核
     *
     * @return bool
     */
    public function getCanReverseAuditAttribute()
    {
        return $this->status === cons('common.audit_status.failed');
    }

    /**
     * 能否续签
     *
     * @return bool
     */
    public function getCanRenewAttribute()
    {
        // 审核通过并且过了有效期
        return $this->status === cons('common.audit_status.passed') && $this->valid_time < Carbon::now();
    }

    /**
     * 能否删除
     *
     * @return bool
     */
    public function getCanDeleteAttribute()
    {
        return in_array($this->status, [
            cons('common.audit_status.unaudited'),
            cons('common.audit_status.failed'),
        ]);
    }

    /**
     * 能否更新
     *
     * @return bool
     */
    public function getCanUpdateAttribute()
    {
        return in_array($this->status, [
            cons('common.audit_status.unaudited'),
            cons('common.audit_status.failed'),
        ]);
    }

}