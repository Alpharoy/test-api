<?php

namespace App\Http\Middleware;

use App\Models\Permission\Node;
use App\Services\Permission\UserRoleService;
use Closure;
use Illuminate\Support\Arr;
use Urland\Exceptions\Client\ForbiddenException;

class Permission
{
    /**
     * 权限检测
     *
     * @param         $request
     * @param Closure $next
     * @param string  $group
     *
     * @return mixed
     * @throws ForbiddenException
     */
    public function handle($request, Closure $next, $group = '')
    {
        // TODO: 暂时返回
        return $next($request);

        if (empty($group)) {
            throw new ForbiddenException('找不到权限分组配置');
        }
        $nodeConfig      = config('node');
        $groupNodeConfig = Arr::get($nodeConfig, $group);
        if (is_null($groupNodeConfig)) {
            throw new ForbiddenException('找不到权限分组配置');
        }
        $route       = $request->route();
        $uri         = $route->uri();
        $method      = Arr::first($route->methods());
        $middlewares = $route->getAction()['middleware'];

        $user     = \Auth::user();
        $userUUID = $user->user_uuid;

        $sign = $method . ' ' . substr($uri, strlen($groupNodeConfig['uri_prefix']));

        // 当前用户的节点列表
        $roleNodes = (new UserRoleService())->fetchUserNodes($userUUID, [$groupNodeConfig['type']]);

        $signList = [
            // 全局允许
            $nodeConfig['all_name'] . ' ' . $nodeConfig['all_name'],
            $sign,
        ];

        if ($method === 'GET') {
            // 全局允许GET请求
            $signList[] = 'GET ' . $nodeConfig['all_name'];
        }
        $empty = $roleNodes->whereIn('sign', $signList)->isEmpty();
        if ($empty) {
            $node = Node::where('sign', $sign)->where('type', $groupNodeConfig['type'])->first();
            if (empty($node)) {
                $signName = '未更新的菜单';
            } else {
                $signName = $node->module_name . ' ' . $node->function_name;
            }
            throw new ForbiddenException('权限不足（' . $signName . '）');
        }

        return $next($request);
    }
}
