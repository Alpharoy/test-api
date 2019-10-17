<?php

namespace App\Services\Auth;

use App\Models\Auth\UserLoginPwd;
use App\Models\Auth\UserLogin;
use App\Services\BaseService;
use Carbon\Carbon;

/**
 * Class UserLoginPwdService
 *
 * @package App\Services\Auth
 */
class UserLoginPwdService extends BaseService
{
    /**
     * 创建登录密码
     *
     * @param int    $loginType  登录值标志
     * @param string $loginValue 登录值
     * @param int    $userGroup  用户组别
     * @param string $userUUID   用户UUID
     * @param string $password   密码
     *
     * @return bool
     */
    public static function create($loginType, $loginValue, $userGroup, $userUUID, $password)
    {
        $pwdType = cons('user.login.pwd_type.password_hash');
        $pwd     = UserLoginPwd::createPwd($password, $pwdType);
        UserLoginPwd::create([
            'user_uuid' => $userUUID,
            'pwd_type'  => $pwdType,
            'pwd_stat'  => 0,
            'log_pwd'   => $pwd['log_pwd'],
            'salt_pwd'  => $pwd['salt_pwd'],
            'init_pwd'  => 1,
            'cha_pwd'   => 1,
        ]);

        // 创建登录表
        UserLogin::create([
            'user_group'  => $userGroup,
            'user_uuid'   => $userUUID,
            'login_type'  => $loginType,
            'login_value' => $loginValue,
        ]);

        return true;
    }

    /**
     * 锁定用户登录
     *
     * @param string $userUUID
     * @param string $lockDay    锁定天数
     * @param string $lockReason 锁定原因
     *
     * @return null
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \InvalidArgumentException
     */
    public static function lock($userUUID, $lockDay, $lockReason)
    {
        $userLoginPwd = UserLoginPwd::where('user_uuid', $userUUID)->firstOrFail();
        $now          = Carbon::now();
        $unlockTime   = $now->copy()->addDays($lockDay);
        $maxTime      = Carbon::create(2037, 12, 31);
        if ($unlockTime->gt($maxTime)) {
            $unlockTime = $maxTime;
        }
        $saveData = [
            'lock_time'   => $now,
            'unlock_time' => $unlockTime,
            'lock_reason' => $lockReason,
        ];
        $userLoginPwd->fill($saveData)->save();

        // 清除登录信息
        TokenService::setTimeOutTokenByUUID($userUUID);

        return null;
    }

    /**
     * 解锁用户
     *
     * @param string $userUUID
     *
     * @return null
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function unlock($userUUID)
    {
        $userLoginPwd = UserLoginPwd::where('user_uuid', $userUUID)->firstOrFail();
        $userLoginPwd->fill(['unlock_time' => null])->save();
        return null;
    }
}