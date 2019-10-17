<?php

namespace App\Models\Auth;

use App\Models\Model;

/**
 * Class UserToken
 *
 * @package App\Models\Auth
 */
class UserToken extends Model
{
    protected $table = 'user_tokens';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '登录后凭证';

    /**
     * 返回该字段自动设置为 Carbon 对象
     *
     * @var array
     */
    protected $dates = ['last_activity_time'];

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'user_group',
        'user_uuid',
        'token',
        'last_activity_time',
        'token_group',
    ];
}