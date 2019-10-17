<?php

namespace App\Models\Initial;

use App\Models\Model;


class SmsLog extends Model
{
    protected $table = 'sms_logs';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '短信发送记录';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'template',
        'data',
        'receive_phone',
        'send_status',
        'gateway',
        'result',
    ];

    /**
     * 应该被转换成原生类型的属性
     *
     * @var array
     */
    protected $casts = [
        'data' => 'json',
    ];

}
