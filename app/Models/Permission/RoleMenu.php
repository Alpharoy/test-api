<?php

namespace App\Models\Permission;

use App\Models\Model;

class RoleMenu extends Model
{
    protected $table = 'role_menu';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '角色菜单';

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
        'role_id',
        'menu_id',
    ];
}