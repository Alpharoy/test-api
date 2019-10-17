<?php

namespace App\Services\Enterprise;

use App\Models\Enterprise\EnterpriseUser;
use App\Models\Permission\UserRole;
use App\Services\Auth\UserLoginPwdService;
use App\Services\BaseService;
use Urland\Exceptions\Client\BadRequestException;

/**
 * Class EnterpriseUserService
 *
 * @package App\Services\Enterprise
 */
class EnterpriseUserService extends BaseService
{

    /**
     * 创建公司管理员
     *
     * @param       $enterpriseUUID
     * @param       $userType
     * @param       $userPhone
     * @param       $password
     * @param array $userData
     *
     * @return EnterpriseUser|\Illuminate\Database\Eloquent\Model
     */
    public static function store($enterpriseUUID, $userType, $userPhone, $password, $userData = [])
    {
        $exists = EnterpriseUser::where('user_phone', $userPhone)->exists();
        if ($exists) {
            throw new BadRequestException('该手机号码已注册管理员');
        }
        $adminUserData  = array_merge($userData, [
            'enterprise_uuid' => $enterpriseUUID,
            'user_type'       => $userType,
            'user_phone'      => $userPhone,
            'is_open'         => true,
        ]);
        $enterpriseUser = EnterpriseUser::create($adminUserData);
        // 插入密码记录
        UserLoginPwdService::create(cons('user.login.type.phone'), $userPhone, cons('user.group.enterprise'),
            $enterpriseUser->user_uuid, $password);

        if ($userType === cons('user.type.super')) {
            // 如果是超级管理员，则插入超级菜单权限
            UserRole::create([
                'user_uuid' => $enterpriseUser->user_uuid,
                'role_id'   => config('node.super_role_id'),
            ]);
        } elseif ($userType === cons('user.type.hidden')) {
            // 如果是隐藏管理员，则插入只读菜单权限
            UserRole::create([
                'user_uuid' => $enterpriseUser->user_uuid,
                'role_id'   => config('node.readonly_role_id'),
            ]);
        }
        return $enterpriseUser;
    }

    /**
     * 更新用户信息
     *
     * @param EnterpriseUser $enterpriseUser
     * @param array          $enterpriseUserData
     *
     * @return EnterpriseUser
     */
    public static function update(EnterpriseUser $enterpriseUser, $enterpriseUserData = [])
    {
        $enterpriseUser->fill($enterpriseUserData)->save();
        return $enterpriseUser;
    }
}
