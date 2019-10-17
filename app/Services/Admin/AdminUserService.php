<?php

namespace App\Services\Admin;

use App\Models\Admin\AdminUser;
use App\Models\Permission\UserRole;
use App\Services\Auth\UserLoginPwdService;
use App\Services\BaseService;
use Urland\Exceptions\Client\BadRequestException;

class AdminUserService extends BaseService
{
    /**
     * 创建管理员
     *
     * @param string $adminUUID
     * @param int    $userType
     * @param string $userPhone
     * @param string $password
     * @param array  $adminUserData
     *
     * @return \App\Models\Admin\AdminUser|\Illuminate\Database\Eloquent\Model
     */
    public static function store($adminUUID, $userType, $userPhone, $password, $adminUserData = [])
    {
        $exists = AdminUser::where('user_phone', $userPhone)->exists();
        if ($exists) {
            throw new BadRequestException('该手机号码已注册管理员');
        }
        $adminUserData = array_merge($adminUserData, [
            'admin_uuid' => $adminUUID,
            'user_phone' => $userPhone,
            'user_type'  => $userType,
        ]);

        $adminUser = AdminUser::create($adminUserData);

        // 插入密码记录
        UserLoginPwdService::create(cons('user.login.type.phone'), $userPhone, cons('user.group.admin'),
            $adminUser->user_uuid, $password);

        // 如果是超级管理员，则插入超级菜单权限
        if ($userType === cons('user.type.super')) {
            UserRole::create([
                'user_uuid' => $adminUser->user_uuid,
                'role_id'   => config('node.super_role_id'),
            ]);
        }

        return $adminUser;
    }

    /**
     * 更新用户信息
     *
     * @param \App\Models\Admin\AdminUser $adminUser
     * @param array                       $adminUserData
     *
     * @return \App\Models\Admin\AdminUser
     */
    public static function update(AdminUser $adminUser, $adminUserData = [])
    {
        $adminUser->fill($adminUserData)->save();
        return $adminUser;
    }
}