<?php

namespace App\Models\Permission;

use App\Models\Model;

class Menu extends Model
{
    protected $table = 'menus';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '菜单';

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
        'parent_id',
        'name',
        'description',
        'group',
    ];

    /**
     * 是否能更新或删除
     *
     * @return bool
     */
    public function getCanModifyAttribute()
    {
        // 超级角色和超级角色（只读）不允许修改
        return $this->id > 2;
    }
}