<?php

namespace App\Models\NaturalPerson;

use App\Models\Model;
use Carbon\Carbon;
use UTMS\UUID\UUID;

class NaturalPerson extends Model
{
    protected $table = 'natural_persons';
    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '自然人用户';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'user_name',
        'user_phone',
        'id_card_number',
        'sex',
        'birthday',
        'contact_address',
        'is_name_verified',
        'certificate_photo_front',
        'certificate_photo_back',
        'status',
        'source_from',
    ];

    /**
     * 返回该字段自动设置未 Carbon 对象
     *
     * @var array
     */
    protected $dates = [
        'last_modified_time',
        'birthday',
    ];

    /**
     * 应该被转换成原生类型的属性
     *
     * @var array
     */
    protected $casts = [
        'is_name_verified' => 'bool',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (NaturalPerson $naturalPerson) {
            //先设置删除标志,等待UUID填充后，清除删除标志
            $naturalPerson->setAttribute('delete_time', Carbon::now());
        });
        static::created(function (NaturalPerson $naturalPerson) {
            $naturalPerson->syncOriginal();
            $UUID = UUID::buildById(cons('uuid.natural_person'), $naturalPerson->id);
            $data = [
                'user_uuid'   => $UUID,
                'delete_time' => null,
            ];
            $naturalPerson->forceFill($data)->save();
        });
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
     * 定义自然人与银行卡关系
     * 自然人可以有多张银行卡
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function naturalPersonBankCards()
    {
        return $this->hasMany(NaturalPersonBankCard::class, 'user_uuid', 'user_uuid');
    }
}