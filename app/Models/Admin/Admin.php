<?php

namespace App\Models\Admin;

use App\Models\Model;
use Carbon\Carbon;
use UTMS\UUID\UUID;

/**
 * Class Admin
 *
 * @package App\Models\Admin
 */
class Admin extends Model
{
    protected $table = 'admins';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '管理公司';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'admin_name',
    ];

    /**
     * 返回该字段自动设置未 Carbon 对象
     *
     * @var array
     */
    protected $dates = [
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Admin $admin) {
            //先设置删除标志,等待UUID填充后，清除删除标志
            $admin->setAttribute('delete_time', Carbon::now());
        });

        static::created(function (Admin $admin) {
            $admin->syncOriginal();
            $UUID = UUID::buildById(cons('uuid.admin'), $admin->id);
            $data = [
                'admin_uuid'  => $UUID,
                'delete_time' => null,
            ];
            $admin->forceFill($data)->save();
        });
    }
}
