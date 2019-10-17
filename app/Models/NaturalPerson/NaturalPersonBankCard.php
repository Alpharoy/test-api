<?php

namespace App\Models\NaturalPerson;

use App\Models\Model;
use Carbon\Carbon;
use UTMS\UUID\UUID;

/**
 * Class NaturalPersonBankCard
 *
 * @package App\Models\NaturalPerson
 */
class NaturalPersonBankCard extends Model
{
    protected $table = 'natural_person_bank_cards';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '自然人与银行卡绑定';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'user_uuid',
        'bank_identity',
        'bank_name',
        'card_number',
        'card_holder',
        'card_holder_phone',
        'is_default',
        'is_verified',
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
     * 应该被转换成原生类型的属性
     *
     * @var array
     */
    protected $casts = [
        'is_default'  => 'bool',
        'is_verified' => 'bool',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (NaturalPersonBankCard $naturalPersonBankCard) {
            //先设置删除标志,等待UUID填充后，清除删除标志
            $naturalPersonBankCard->setAttribute('delete_time', Carbon::now());
        });
        static::created(function (NaturalPersonBankCard $naturalPersonBankCard) {
            $naturalPersonBankCard->syncOriginal();
            $UUID = UUID::buildById(cons('uuid.bank_card'), $naturalPersonBankCard->id);
            $data = [
                'bank_card_uuid' => $UUID,
                'delete_time'    => null,
            ];
            $naturalPersonBankCard->forceFill($data)->save();
        });
    }
}