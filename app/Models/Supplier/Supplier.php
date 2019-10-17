<?php

namespace App\Models\Supplier;

use App\Models\Contract\Contract;
use App\Models\Model;
use Carbon\Carbon;
use UTMS\UUID\UUID;

/**
 * Class Supplier
 *
 * @package App\Models\Supplier
 */
class Supplier extends Model
{
    protected $table = 'suppliers';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '供应商';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'supplier_uuid',
        'supplier_name',
        'industry_type_code',
        'industry_type_name',
        'location_code',
        'location_name',
        'usci_number',

        'artificial_person_name',
        'artificial_person_phone_number',
        'artificial_person_certificate_type_code',
        'artificial_person_certificate_type_name',
        'artificial_person_certificate_number',

        'business_scope',
        'business_address',
        'telephone',
        'contact_name',
        'contact_phone_number',
        'introduce',
        'tax_identification_number',

        'invoice_title',
        'bank_name',
        'bank_account',
        'bank_reserve_mobile_number',
        'invoice_address',

        'artificial_person_certificate_photo_front',
        'artificial_person_certificate_photo_back',
        'business_license_photo',
        'status',
        'source_from',
        'email',

        'last_modified_time',
        'create_user_uuid',
        'create_user_name',
        'update_user_uuid',
        'update_user_name',

    ];

    /**
     * 返回该字段自动设置未 Carbon 对象
     *
     * @var array
     */
    protected $dates = [
        'last_modified_time',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Supplier $supplier) {
            //先设置删除标志,等待UUID填充后，清除删除标志
            $supplier->setAttribute('delete_time', Carbon::now());
        });

        static::created(function (Supplier $supplier) {
            $supplier->syncOriginal();
            $UUID = UUID::buildById(cons('uuid.supplier'), $supplier->id);
            $data = [
                'supplier_uuid' => $UUID,
                'delete_time'   => null,
            ];
            $supplier->forceFill($data)->save();
        });
    }

    /**
     * 定义和合约的关系
     * 注意：这里要配合过滤 Contract 模型的 enterprise_uuid 和 is_valid 字段使用
     * 任何企业在同一时间对于同一供应商，仅有一份合同对应关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contract()
    {
        return $this->hasOne(Contract::class, 'supplier_uuid', 'supplier_uuid');
    }

    /**
     * 获取本企业下的隐藏管理员账号
     *
     * @return string
     */
    public function getHiddenUserPhone()
    {
        return cons('uuid.supplier') . str_pad($this->id, 8, '0', STR_PAD_LEFT);
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
}