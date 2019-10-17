<?php

namespace App\Services\Admin;

use App\Models\Admin\Admin;
use App\Models\Admin\AdminUser;
use App\Services\BaseService;
use Urland\Exceptions\Client\BadRequestException;
use Urland\Exceptions\Client\ForbiddenException;

class AdminService extends BaseService
{
    /**
     * 创建管理公司
     *
     * @param array $adminData
     * @param array $adminUserData
     *
     * @return \App\Models\Admin\Admin|\Illuminate\Database\Eloquent\Model
     */
    public static function store($adminData = [], $adminUserData = [])
    {
        $exists = AdminUser::where('user_phone', $adminUserData['user_phone'])->exists();
        if ($exists) {
            throw new BadRequestException('管理员已存在');
        }
        $adminData                = self::fillData($adminData);
        $admin                    = Admin::create($adminData);
        $adminUserData['is_open'] = true;
        AdminUserService::store($admin->admin_uuid, cons('user.type.super'), $adminUserData['user_phone'],
            $adminUserData['password'], $adminUserData);
        return $admin;
    }

    /**
     * 更新公司信息
     *
     * @param \App\Models\Admin\Admin $admin
     * @param array                   $adminData
     *
     * @return \App\Models\Admin\Admin
     */
    public static function update(Admin $admin, $adminData = [])
    {
        $adminData = self::fillData($adminData, $admin);
        $admin->fill($adminData)->save();
        return $admin;
    }

    /**
     * 数据判断
     *
     * @param                              $adminData
     * @param \App\Models\Admin\Admin|null $originData
     *
     * @return array
     */
    public static function fillData($adminData, Admin $originData = null)
    {
        $originArray = [];
        if (!is_null($originData)) {
            $originArray = $originData->toArray();
        }
        $adminData = array_merge($originArray, $adminData);

        // 检测名称是否重复
        $admin = Admin::query();
        $admin->where('admin_name', $adminData['admin_name']);
        if (!is_null($originData)) {
            $admin->where('id', '<>', $originData->id);
        }
        if ($admin->exists()) {
            throw new ForbiddenException('已有相同名称的管理公司');
        }
        return $adminData;
    }
}