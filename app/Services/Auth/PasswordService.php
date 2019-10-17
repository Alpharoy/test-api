<?php

namespace App\Services\Auth;

use App\Models\Auth\UserLoginPwd;
use App\Services\BaseService;
use Urland\Exceptions\Client;
use Urland\Exceptions\Server;

/**
 * Class PasswordService
 *
 * @package App\Services\Auth
 */
class PasswordService extends BaseService
{
    /**
     * 根据旧密码修改密码
     *
     * @param string $userUUID
     * @param string $oldPassword
     * @param string $newPassword
     *
     * @return bool
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Urland\Exceptions\Client\BadRequestException
     * @throws \Urland\Exceptions\Server\InternalServerException
     */
    public static function updateByOldPassword($userUUID, $oldPassword, $newPassword)
    {
        if ($oldPassword === $newPassword) {
            throw new Client\BadRequestException('旧密码和新密码相同，无需更改');
        }

        $userLoginPwd = UserLoginPwd::where('user_uuid', $userUUID)->firstOrFail();

        // 校验旧密码
        if (!$userLoginPwd->verify($oldPassword)) {
            throw new Client\BadRequestException('原密码错误');
        }

        self::directPassword($userLoginPwd, $newPassword);

        return TokenService::setTimeOutTokenByUUID($userUUID);

    }

    /**
     * 直接修改用户密码，**调用之前应已检验过能直接修改**
     *
     * @param UserLoginPwd $userLoginPwd
     * @param string       $newPassword
     *
     * @return null
     * @throws Server\InternalServerException
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public static function directPassword(UserLoginPwd $userLoginPwd, $newPassword)
    {
        // 更新新密码
        $pwdType = cons('user.login.pwd_type.password_hash');
        $pwd     = UserLoginPwd::createPwd($newPassword, $pwdType);
        $update  = [
            'pwd_type' => $pwdType,
            'log_pwd'  => $pwd['log_pwd'],
            'salt_pwd' => $pwd['salt_pwd'],
            'init_pwd' => 0,
            'cha_pwd'  => 0,
        ];
        if (!$userLoginPwd->fill($update)->save()) {
            throw new Server\InternalServerException('更新密码失败');
        }

        return null;
    }
}