<?php

namespace App\Models\Permission;

use App\Models\Model;

class UserRole extends Model
{
    protected $table = 'user_role';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '用户角色';

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
        'user_uuid',
        'role_id',
    ];
}