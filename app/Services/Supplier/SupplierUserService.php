<?php

namespace App\Services\Supplier;

use App\Models\Permission\UserRole;
use App\Models\Supplier\SupplierUser;
use App\Services\Auth\UserLoginPwdService;
use App\Services\BaseService;
use Carbon\Carbon;
use Urland\Exceptions\Client;
use Urland\Exceptions\Client\BadRequestException;

/**
 * Class SupplierUserService
 *
 * @package App\Services\Logistics
 */
class SupplierUserService extends BaseService
{
    /**
     * 创建供应商管理员
     *
     * @param $supplierUUID
     * @param $userType
     * @param $userPhone
     * @param $password
     * @param array $userData
     * @return SupplierUser|\Illuminate\Database\Eloquent\Model
     */
    public static function store($supplierUUID, $userType, $userPhone, $password, $userData = [])
    {
        $exists = SupplierUser::where('user_phone', $userPhone)->exists();
        if ($exists) {
            throw new BadRequestException('该手机号码已注册管理员');
        }
        unset($userData['phone']);
        $adminUserData              = array_merge($userData, [
            'supplier_uuid' => $supplierUUID,
            'user_type'     => $userType,
            'user_phone'    => $userPhone,
            'is_open'       => true,
        ]);
        $supplierUser               = SupplierUser::create($adminUserData);
        // 插入密码记录
        UserLoginPwdService::create(cons('user.login.type.phone'), $userPhone, cons('user.group.supplier'),
            $supplierUser->user_uuid, $password);

        // 如果是超级管理员，则插入超级菜单权限
        if ($userType === cons('user.type.super')) {
            UserRole::create([
                'user_uuid' => $supplierUser->user_uuid,
                'role_id'   => config('node.super_role_id'),
            ]);
        }
        return $supplierUser;
    }

    /**
     * 更新用户信息
     *
     * @param SupplierUser $supplierUser
     * @param array $supplierUserData
     * @return SupplierUser
     */
    public static function update(SupplierUser $supplierUser, $supplierUserData = [])
    {
        $supplierUser->fill($supplierUserData)->save();
        return $supplierUser;
    }
}
