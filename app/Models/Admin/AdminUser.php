<?php

namespace App\Models\Admin;

use App\Models\Auth\UserTrait;
use App\Models\Model;
use Carbon\Carbon;
use UTMS\UUID\UUID;

/**
 * Class Admin
 *
 * @package App\Models\Admin
 */
class AdminUser extends Model
{
    use UserTrait;

    protected $table = 'admin_users';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '管理员';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'admin_uuid',
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
    protected $dates = [
    ];

    /**
     * 应该被转换成原生类型的属性
     *
     * @var array
     */
    protected $casts = [
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

        static::creating(function (AdminUser $adminUser) {
            //先设置删除标志,等待UUID填充后，清除删除标志
            $adminUser->setAttribute('delete_time', Carbon::now());
        });

        static::created(function (AdminUser $adminUser) {
            $adminUser->syncOriginal();
            $UUID = UUID::buildById(cons('uuid.admin_user'), $adminUser->id);
            $data = [
                'user_uuid'   => $UUID,
                'delete_time' => null,
            ];
            $adminUser->forceFill($data)->save();
        });
    }
}
