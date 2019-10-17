<?php

if (!function_exists('oss_client')) {
    /**
     * OSS API client
     *
     * @return \Urland\ApiClient\Client|null
     */
    function oss_client()
    {
        try {
            return app('api-client')->service('oss-api');
        } catch (\Throwable $e) {
            return null;
        }
    }
}

if (!function_exists('oss_public_client')) {
    /**
     * OSS Public API client
     *
     * @return \Urland\ApiClient\Client|null
     */
    function oss_public_client()
    {
        try {
            return app('api-client')->service('oss-public-api');
        } catch (\Throwable $e) {
            return null;
        }
    }
}


if (!function_exists('pay56_client')) {
    /**
     * OSS API client
     *
     * @return \UTMS\Pay56\Pay56Client
     */
    function pay56_client()
    {
        return app('pay56-client');
    }
}

if (!function_exists('validate')) {
    /**
     * 检查某个值是否符合某个规则
     *
     * @param mixed  $data
     * @param string $rule
     *
     * @return bool
     */
    function validate($data, $rule)
    {
        return !app('validator')->make(['temp' => $data], ['temp' => $rule])->fails();
    }
}

if (!function_exists('global_data')) {

    /**
     * 设置 / 获取全局变量
     *
     * @param null $key
     * @param null $value
     *
     * @return array|bool|mixed|void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    function global_data($key = null, $value = null)
    {
        if (is_array($key)) {
            //当 key 为数组时, 批量设置全局变量
            return app('cache')->store('array')->setMultiple($key, 100 * 60);
        } elseif ($key === null) {
            //当 key 为 null 时，返回全局所有变量
            return app('cache')->store('array')->getStore()->many(cons('misc.global_data'));
        }
        //value 不为 null 则设置变量, 否则获取变量
        if ($value !== null) {
            return app('cache')->store('array')->forever($key, $value);
        }
        return app('cache')->store('array')->get($key);
    }
}
