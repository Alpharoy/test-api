<?php

namespace App\Models\Permission;

use App\Models\Model;

class Role extends Model
{
    protected $table = 'roles';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '角色';

    /**
     * 真删除
     *
     * @var bool
     */
    protected $forceDeleting = true;

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'group',
        'use_object_uuid',

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
     * 是否能更新或删除
     *
     * @return bool
     */
    public function getCanModifyAttribute()
    {
        // 超级角色不允许修改
        return $this->id > 2;
    }
}