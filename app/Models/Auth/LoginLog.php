<?php

namespace App\Models\Auth;

use App\Models\Model;

/**
 * Class LoginLog
 *
 * @package App\Models\Auth
 */
class LoginLog extends Model
{
    protected $table = 'login_logs';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '登录日志';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'user_uuid',
        'ip',
        'login_type',
        'login_group',
    ];
}