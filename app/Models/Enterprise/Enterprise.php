<?php


namespace App\Models\Enterprise;


use App\Models\Model;
use Carbon\Carbon;
use UTMS\UUID\UUID;


/**
 * Class Enterprise
 *
 * @package App\Models\Enterprise
 */
class Enterprise extends Model
{
    protected $table = 'enterprises';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '企业';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'enterprise_uuid',
        'enterprise_name',

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

        'email',

        'business_license_photo',
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

        'status',
        'source_from',

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
        static::creating(function (Enterprise $enterprise) {
            //先设置删除标志,等待UUID填充后，清除删除标志
            $enterprise->setAttribute('delete_time', Carbon::now());
        });

        static::created(function (Enterprise $enterprise) {
            $enterprise->syncOriginal();
            $UUID = UUID::buildById(cons('uuid.enterprise'), $enterprise->id);
            $data = [
                'enterprise_uuid' => $UUID,
                'delete_time'     => null,
            ];
            $enterprise->forceFill($data)->save();
        });
    }

    /**
     * 获取本企业下的隐藏管理员账号
     *
     * @return string
     */
    public function getHiddenUserPhone()
    {
        return cons('uuid.enterprise') . str_pad($this->id, 8, '0', STR_PAD_LEFT);
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