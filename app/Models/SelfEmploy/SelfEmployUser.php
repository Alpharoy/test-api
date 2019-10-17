<?php


namespace App\Models\SelfEmploy;


use App\Models\Auth\UserTrait;
use App\Models\Model;
use Carbon\Carbon;
use UTMS\UUID\UUID;

class SelfEmployUser extends Model
{
    use UserTrait;

    protected $table = 'self_employ_users';
    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '个体工商用户';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable
        = [
            'self_employ_uuid',
            'user_uuid',
            'user_name',
            'user_phone',
            'user_type',
            'is_open',
        ];

    /**
     * 返回该字段自动设置未 Carbon 对象
     *
     * @var array
     */
    protected $dates
        = [
            'last_modified_time',
        ];

    /**
     * 应该被转换成原生类型的属性
     *
     * @var array
     */
    protected $casts
        = [
            'is_open' => 'bool',
        ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (SelfEmployUser $selfEmployUser) {
            //先设置删除标志,等待UUID填充后，清除删除标志
            $selfEmployUser->setAttribute('delete_time', Carbon::now());
        });

        static::created(function (SelfEmployUser $selfEmployUser) {
            $selfEmployUser->syncOriginal();
            $UUID = UUID::buildById(cons('uuid.self_employ_user'), $selfEmployUser->id);
            $data = [
                'user_uuid'   => $UUID,
                'delete_time' => null,
            ];
            $selfEmployUser->forceFill($data)->save();
        });
    }

}