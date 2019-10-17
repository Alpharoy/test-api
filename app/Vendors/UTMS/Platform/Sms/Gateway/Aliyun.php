<?php

namespace UTMS\Platform\Sms\Gateway;

use Urland\Exceptions\Client\ForbiddenException;

class Aliyun
{
    private static $templateList = [
        // 企业注册
        'enterprise_register' => [
            'content'  => '企业注册短信内容待完善',
            'template' => '',
            'data'     => [

            ],
        ],

        // 供应商注册
        'supplier_register'   => [
            'content'  => '供应商注册短信内容待完善',
            'template' => '',
            'data'     => [
            ],
        ],
    ];

    /**
     * 获取短信内容配置
     *
     * @param string $templateName 短信模版名称
     * @param array  $data
     *
     * @return array
     * @throws ForbiddenException
     */
    public static function format($templateName, $data = [])
    {
        if (!isset(self::$templateList[$templateName])) {
            throw new ForbiddenException('短信模版未找到');
        }
        $template = self::$templateList[$templateName];

        return [
            'content'  => $template['content'],
            'template' => $template['template'],
            'data'     => $data,
        ];
    }

    /**
     * 格式化短信内容
     *
     * @param string $content
     * @param array  $data
     *
     * @return mixed
     */
    protected static function formatContent($content, $data = [])
    {
        foreach ($data as $key => $value) {
            $content = str_replace('${' . $key . '}', $data[$key], $content);
        }
        return $content;
    }
}