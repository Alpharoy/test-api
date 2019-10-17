<?php

namespace App\Services\Initial;

use App\Models\Initial\Log;
use App\Services\BaseService;

class LogService extends BaseService
{
    /**
     * 日志记录
     *
     * @param string $userUUID
     * @param string $group
     *
     * @return \App\Models\Initial\Log|\Illuminate\Database\Eloquent\Model
     */
    public static function store($userUUID, $group = '')
    {
        $request       = app('request');
        $hiddenRequest = self::hiddenRequest($request);

        $log = Log::create([
            'group'     => $group,
            'user_uuid' => $userUUID,
            'ip'        => $request->ip(),
            'method'    => $request->method(),
            'url'       => $request->fullUrl(),
            'request'   => $hiddenRequest ? [] : $request->all(),
            'use_time'  => microtime(true) - LARAVEL_START,
            'route_uri' => $request->route()->uri,
        ]);

        return $log;
    }

    /**
     * 是否需要隐藏请求体
     *
     * @param $request
     *
     * @return bool
     */
    protected static function hiddenRequest($request)
    {
        $route         = $request->route();
        $middlewares   = $route->getAction()['middleware'];
        $hiddenRequest = false;
        if (in_array('hidden_request', $middlewares)) {
            $hiddenRequest = true;
        }
        return $hiddenRequest;
    }
}