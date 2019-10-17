<?php

namespace App\Services\Auth;

use App\Models\Auth\LoginLog;
use App\Services\BaseService;
use App\Models\Auth\UserLoginPwd;
use App\Models\Auth\UserLogin;
use Carbon\Carbon;
use Urland\Exceptions\Client;
use Urland\Exceptions\Server;

/**
 * Class LoginService
 *
 * @package App\Services\Auth
 */
class LoginService extends BaseService
{
    /**
     * 用户登录逻辑
     *
     * @param int    $userGroup  用户类型
     * @param string $account    用户账号
     * @param string $password   用户密码
     * @param string $loginGroup 登录分组
     *
     * @return array
     * @throws Client\BadRequestException
     * @throws \RuntimeException
     */
    public static function login($userGroup, $account, $password, $loginGroup = 'web')
    {
        // 找出对应用户
        $userLogin = UserLogin::where('user_group', $userGroup)->where('login_value', $account)->first([
            'user_uuid',
            'login_type',
        ]);
        if (empty($userLogin)) {
            throw new Client\BadRequestException('账号或密码错误');
        }

        // 找出登录凭证
        $userLoginPwd = UserLoginPwd::where('user_uuid', $userLogin->user_uuid)->first();
        if (empty($userLoginPwd)) {
            throw new Client\BadRequestException('账号或密码错误');
        }

        // 判断账号是否已被禁用
        if (!is_null($userLoginPwd->unlock_time)) {
            if ($userLoginPwd->unlock_time > Carbon::now()) {
                $lockReason = '该账号已被禁止登录，';
                if ($userLoginPwd->lock_reason) {
                    $lockReason .= '禁止原因：' . $userLoginPwd->lock_reason . '。';
                }
                $lockReason .= ' 解禁时间 ' . $userLoginPwd->unlock_time->format('Y-m-d H:i');
                throw new Client\BadRequestException($lockReason);
            } else {
                $userLoginPwd->fill(['unlock_time' => null])->save();
            }
        }

        // 验证密码是否正确
        if (!$userLoginPwd->verify($password)) {
            throw new Client\BadRequestException('账号或密码错误');
        }

        // 更新token
        $token = TokenService::updateToken($userGroup, $userLogin->user_uuid, $loginGroup);

        // 记录登录历史
        LoginLog::create([
            'user_uuid'   => $userLogin->user_uuid,
            'ip'          => request()->ip(),
            'login_type'  => '密码登录',
            'login_group' => $loginGroup,
        ]);

        return ['token' => $token, 'user_uuid' => $userLogin->user_uuid];
    }

    /**
     * 隐藏管理员登陆
     *
     * @param \App\Models\Logistics\Logistics $logistics
     *
     * @return string
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \RuntimeException
     */
    /*public  static function hiddenOtherUserLogin(Logistics $logistics)
    {
        $logisticsUser = LogisticsUser::where('logistics_uuid', $logistics->logistics_uuid)
            ->where('type', cons('user.type.hidden'))->firstOrFail();

        $group    = 'web';
        $type     = '后台切换';
        $userType = cons('user.group.logistics');

        // 有效期只为1个小时
        $token = TokenService::updateToken($userType, $logisticsUser->logistics_user_uuid,
            $group, 3600);

        LoginLog::create([
            'user_uuid' => $logisticsUser->logistics_user_uuid,
            'ip'        => request()->ip(),
            'login_type'      => $type,
            'login_group'     => $group,
        ]);

        return $token;
    }*/
}