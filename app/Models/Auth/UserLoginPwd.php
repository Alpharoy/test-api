<?php

namespace App\Models\Auth;

use App\Models\Model;
use Carbon\Carbon;
use Urland\Exceptions\Server;

/**
 * Class UserLoginPwd
 *
 * @package App\Models\Auth
 */
class UserLoginPwd extends Model
{
    protected $table = 'user_login_pwd';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '登录密码';

    /**
     * 返回该字段自动设置为 Carbon 对象
     *
     * @var array
     */
    protected $dates = ['lock_time', 'unlock_time', 'last_modified_time'];

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'user_uuid',
        'pwd_type',
        'pwd_stat',
        'log_pwd',
        'salt_pwd',
        'init_pwd',
        'cha_pwd',
        'lock_time',
        'unlock_time',
        'lock_reason',
        'last_modified_time',
    ];

    /**
     * 生成密码加密结果
     *
     * @param string $password 明文密码
     * @param int    $pwdType  加密类型
     *
     * @return array|null
     * @throws Server\InternalServerException
     */
    public static function createPwd($password, $pwdType)
    {
        $pwdTypeList = cons('user.login.pwd_type');
        switch ($pwdType) {
            case $pwdTypeList['password_hash']:
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                // 使用空盐值，password_hash 会自动生成盐值
                $salt = '';
                break;

            default:
                throw new Server\InternalServerException();
        }
        return [
            'log_pwd'  => $passwordHash,
            'salt_pwd' => $salt,
        ];
    }

    /**
     * 校验密码
     *
     * @param string $password 明文密码
     *
     * @return bool
     */
    public function verify($password)
    {
        if (!$this->exists) {
            return false;
        }
        $pwdTypeList = cons('user.login.pwd_type');
        switch ($this->pwd_type) {
            case $pwdTypeList['password_hash']:
                return password_verify($password, $this->log_pwd);
            default:
        }
        return false;
    }

    /**
     * 是否可解锁
     *
     * @return bool
     */
    public function getCanUnlockAttribute()
    {
        return $this->unlock_time > Carbon::now();
    }
}