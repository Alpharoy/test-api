<?php

namespace App\Models\Auth;

Trait UserTrait
{
    /**
     * 定义用户和密码表的关系
     *
     * @return mixed
     */
    public function userLoginPwd()
    {
        return $this->hasOne(UserLoginPwd::class, 'user_uuid', 'user_uuid')->select([
            'user_uuid',
            'lock_time',
            'unlock_time',
            'lock_reason',
        ]);
    }

    /**
     * 获取能否锁定权限
     *
     * @return bool
     */
    public function getCanLockAttribute()
    {
        return !in_array($this->user_type, [cons('user.type.super'), cons('user.type.hidden')]);
    }

    /**
     * 能否更改权限
     *
     * @return bool
     */
    public function getCanUpdateRoleAttribute()
    {
        return !in_array($this->user_type, [cons('user.type.super'), cons('user.type.hidden')]);
    }

    /**
     * 是否为隐藏管理员
     *
     * @return bool
     */
    public function getIsHiddenAttribute()
    {
        return $this->user_type === cons('user.type.hidden');
    }
}