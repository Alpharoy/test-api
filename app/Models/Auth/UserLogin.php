<?php

namespace App\Models\Auth;

use App\Models\Model;

/**
 * Class UserLogin
 *
 * @package App\Models\Auth
 */
class UserLogin extends Model
{
    protected $table = 'user_logins';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '登录标志';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'user_group',
        'user_uuid',
        'login_type',
        'login_value',
    ];

}