<?php

namespace App\Models\Permission;

use App\Models\Model;

class MenuNode extends Model
{
    protected $table = 'menu_node';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '菜单节点';

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
        'menu_id',
        'node_id',
        'sign',
        'node_type',
    ];
}