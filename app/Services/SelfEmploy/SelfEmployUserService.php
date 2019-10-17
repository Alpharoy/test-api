<?php

namespace App\Services\SelfEmploy;

use App\Models\SelfEmploy\SelfEmployUser;
use App\Services\Auth\UserLoginPwdService;
use App\Services\BaseService;
use Urland\Exceptions\Client\BadRequestException;

class SelfEmployUserService extends BaseService
{
    /**
     * 工商户管理员
     *
     * @param       $selfEmployUUID
     * @param       $userType
     * @param       $userPhone
     * @param       $password
     * @param array $userData
     *
     * @return SelfEmployUser|\Illuminate\Database\Eloquent\Model
     */
    public static function store($selfEmployUUID, $userType, $userPhone, $password, $userData = [])
    {
        $exists = SelfEmployUser::where('user_phone', $userPhone)->exists();
        if ($exists) {
            throw new BadRequestException('该手机号码已注册管理员');
        }
        $adminUserData  = array_merge($userData, [
            'self_employ_uuid' => $selfEmployUUID,
            'user_type'        => $userType,
            'user_phone'       => $userPhone,
            'is_open'          => true,
        ]);
        $selfEmployUser = SelfEmployUser::create($adminUserData);
        // 插入密码记录
        UserLoginPwdService::create(cons('user.login.type.phone'), $userPhone, cons('user.group.self_employ'),
            $selfEmployUser->user_uuid, $password);
        return $selfEmployUser;
    }

    /**
     * 更新用户信息
     *
     * @param SelfEmployUser $selfEmployUser
     * @param array          $selfEmployUserData
     *
     * @return SelfEmployUser
     */
    public static function update(SelfEmployUser $selfEmployUser, $selfEmployUserData = [])
    {
        $selfEmployUser->fill($selfEmployUserData)->save();
        return $selfEmployUser;
    }

}