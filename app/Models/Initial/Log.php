<?php

namespace App\Models\Initial;

use App\Models\Model;

class Log extends Model
{
    protected $table = 'logs';

    const MODEL_NAME = '日志记录表';

    protected $fillable = [
        'group',
        'user_uuid',
        'ip',
        'method',
        'url',
        'request',
        'use_time',
        'route_uri',
    ];

    /**
     * 应该被转换成原生类型的属性
     *
     * @var array
     */
    protected $casts = [
        'request' => 'json',
    ];
}