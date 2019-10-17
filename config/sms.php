<?php
return [
    // HTTP 请求的超时时间（秒）
    'timeout'  => 10.0,

    // 默认发送配置
    'default'  => [
        // 网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        // 默认可用的发送网关
        'gateways' => [
            'aliyun',
        ],
    ],
    // 可用的网关配置
    'gateways' => [
        'errorlog'     => [
            'file' => storage_path('logs/easy-sms.log'),
        ],
        'aliyun'       => [
            'access_key_id'     => env('SMS_ALIYUN_ACCESS_KEY_ID', ''),
            'access_key_secret' => env('SMS_ALIYUN_ACCESS_KEY_SECRET', ''),
            'sign_name'         => 'DLMS',
        ],
        'aliyunrest'   => [
            'app_key'        => '',
            'app_secret_key' => '',
            'sign_name'      => '',
        ],
        'yunpian'      => [
            'api_key'   => '',
            'signature' => '【默认签名】', // 内容中无签名时使用
        ],
        'submail'      => [
            'app_id'  => '',
            'app_key' => '',
            'project' => '', // 默认 project，可在发送时 data 中指定
        ],
        'luosimao'     => [
            'api_key' => '',
        ],
        'yuntongxun'   => [
            'app_id'         => '',
            'account_sid'    => '',
            'account_token'  => '',
            'is_sub_account' => false,
        ],
        'huyi'         => [
            'api_id'  => '',
            'api_key' => '',
        ],
        'juhe'         => [
            'app_key' => '',
        ],
        'sendcloud'    => [
            'sms_user'  => '',
            'sms_key'   => '',
            'timestamp' => false, // 是否启用时间戳
        ],
        'baidu'        => [
            'ak'        => '',
            'sk'        => '',
            'invoke_id' => '',
            'domain'    => '',
        ],
        'huaxin'       => [
            'user_id'  => '',
            'password' => '',
            'account'  => '',
            'ip'       => '',
            'ext_no'   => '',
        ],
        'chuanglan'    => [
            'account'     => '',
            'password'    => '',

            // \Overtrue\EasySms\Gateways\ChuanglanGateway::CHANNEL_VALIDATE_CODE  => 验证码通道（默认）
            // \Overtrue\EasySms\Gateways\ChuanglanGateway::CHANNEL_PROMOTION_CODE => 会员营销通道
            'channel'     => \Overtrue\EasySms\Gateways\ChuanglanGateway::CHANNEL_VALIDATE_CODE,

            // 会员营销通道 特定参数。创蓝规定：api提交营销短信的时候，需要自己加短信的签名及退订信息
            'sign'        => '【通讯云】',
            'unsubscribe' => '回TD退订',
        ],
        'rongcloud'    => [
            'app_key'    => '',
            'app_secret' => '',
        ],
        'tianyiwuxian' => [
            'username' => '', //用户名
            'password' => '', //密码
            'gwid'     => '', //网关ID
        ],
        'twilio'       => [
            'account_sid' => '', // sid
            'from'        => '', // 发送的号码 可以在控制台购买
            'token'       => '', // apitoken
        ],
        'qcloud'       => [
            'sdk_app_id' => '', // SDK APP ID
            'app_key'    => '', // APP KEY
            'sign_name'  => '', // 短信签名，如果使用默认签名，该字段可缺省（对应官方文档中的sign）
        ],
        'avatardata'   => [
            'app_key' => '', // APP KEY
        ],
    ],
];