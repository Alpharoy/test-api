<?php


namespace App\Models\Project;


use App\Models\Contract\Contract;
use App\Models\Enterprise\Enterprise;
use App\Models\Model;
use App\Models\Supplier\Supplier;
use Carbon\Carbon;
use UTMS\UUID\UUID;

/**
 * Class Project
 *
 * @package App\Models\Project
 */
class Project extends Model
{
    protected $table = 'projects';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '项目记录';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'supplier_uuid',
        'supplier_name',

        'enterprise_uuid',
        'enterprise_name',

        'contract_uuid',
        'contract_name',
        'contract_no',

        'project_name',

        'charge_person_name',
        'charge_person_phone_number',

        'industry_type_code',
        'industry_type_name',

        'employment_type_code',
        'employment_type_name',

        'service_charge',

        'status',
        'permission',

        'address_code',
        'address_name',
        'address_detail',

        'introduce',
        'attachment',

        'is_open',
        'is_industry_type_open',
    ];

    /**
     * 应该被转换成原生类型的属性
     *
     * @var array
     */
    protected $casts = [
        'is_open'               => 'bool',
        'is_industry_type_open' => 'bool',
        'attachment'            => 'array',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Project $project) {
            //先设置删除标志,等待UUID填充后，清除删除标志
            $project->setAttribute('delete_time', Carbon::now());
        });

        static::created(function (Project $project) {
            $project->syncOriginal();
            $UUID = UUID::buildById(cons('uuid.project'), $project->id);
            $data = [
                'project_uuid' => $UUID,
                'delete_time'  => null,
            ];
            $project->forceFill($data)->save();
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
     * 定义和合约的关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_uuid', 'contract_uuid');
    }

    /**
     * 是否自动接单
     *
     * @return bool
     */
    public function getIsAutoAcceptAttribute()
    {
        $autoAcceptPermission = cons('project.permission.auto_accept');
        return ($this->permission & $autoAcceptPermission) === $autoAcceptPermission;
    }

    /**
     * 是否自动完成
     *
     * @return bool
     */
    public function getIsAutoCompleteAttribute()
    {
        $autoCompletePermission = cons('project.permission.auto_complete');
        return ($this->permission & $autoCompletePermission) === $autoCompletePermission;
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
     * 是否可更改服务费率
     *
     * @return bool
     */
    public function getCanUpdateServiceChargeAttribute()
    {
        return $this->status === cons('common.audit_status.passed');
    }

    /**
     * 是否已审核通过
     *
     * @return bool
     */
    public function getIsAuditPassedAttribute()
    {
        return $this->status === cons('common.audit_status.passed');
    }
}