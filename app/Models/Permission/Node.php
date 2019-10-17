<?php

namespace App\Models\Permission;

use App\Models\Model;

class Node extends Model
{
    protected $table = 'nodes';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '节点';

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
        'method',
        'uri',
        'module_name',
        'function_name',
        'sign',
        'type',
        'type_name',
        'group',
    ];
}