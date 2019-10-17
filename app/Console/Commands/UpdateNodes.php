<?php

namespace App\Console\Commands;

use App\Models\Permission\MenuNode;
use App\Models\Permission\Node;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlockFactory;

class UpdateNodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'node:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新权限节点';

    /**
     * @var DocBlockFactory
     */
    protected $docBlockFactory;

    /**
     * @var array
     */
    protected $nodeConfig = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->docBlockFactory = DocBlockFactory::createInstance();
        $this->nodeConfig      = config('node');
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \ReflectionException
     */
    public function handle()
    {
        $routeList  = [];
        $type       = [];
        $routes     = app()->make('router')->getRoutes();
        $userGroups = cons('user.group');

        foreach ($routes as $route) {
            // 跳过空调用和可执行函数
            $routeHandler = $route->getAction()['uses'];
            if (empty($routeHandler) || is_callable($routeHandler)) {
                continue;
            }

            // 跳过无需登录的节点
            $middlewares         = $route->getAction()['middleware'];
            $needLoginMiddleware = ['auth:admin', 'auth:enterprise', 'auth:supplier'];
            if (count(array_intersect($needLoginMiddleware, $middlewares)) === 0) {
                continue;
            }

            $permissionMiddlewarePrefix = 'permission:';

            foreach ($middlewares as $middleware) {
                // 只获取需要权限验证的节点
                if (!Str::startsWith($middleware, $permissionMiddlewarePrefix)) {
                    continue;
                }
                $middlewareGroup = substr($middleware, strlen($permissionMiddlewarePrefix));
                $config          = Arr::get($this->nodeConfig, $middlewareGroup);
                if (is_null($config)) {
                    continue;
                }

                // 获取节点所属分组
                $group = $userGroups[explode('.', $middlewareGroup)[0]];

                $routeList[$middlewareGroup][] = array_merge($this->getMethodDoc($route,
                    $config['uri_prefix'], $config['controller_prefix']),
                    ['type' => $config['type'], 'type_name' => $config['name'], 'group' => $group]);

                $type[] = $config['type'];
            }
        }

        $allName  = $this->nodeConfig['all_name'];
        $nodeList = [];
        foreach ($routeList as $groupKey => $group) {
            foreach ($group as $item) {
                if (!isset($nodeList[$groupKey][$item['controller']])) {
                    $nodeList[$groupKey][$item['controller']] = [];
                }
                $nodeList[$groupKey][$item['controller']][] = $item;
            }
        }

        // 清空旧节点
        Node::truncate();

        // 建立超级节点
        Node::create([
            'method'        => $allName,
            'uri'           => '',
            'module_name'   => '全部模块',
            'function_name' => '全部节点',
            'sign'          => $allName . ' ' . $allName,
            'type'          => 0,
            'type_name'     => '',
            'group'         => 0,
        ]);

        // 建立只读节点
        Node::create([
            'method'        => 'GET',
            'uri'           => '',
            'module_name'   => '全部模块',
            'function_name' => '全部节点（只读）',
            'sign'          => 'GET ' . $allName,
            'type'          => 0,
            'type_name'     => '',
            'group'         => 0,
        ]);

        $this->info('正在插入节点...');
        // 插入新节点
        foreach ($nodeList as $group) {
            foreach ($group as $module) {
                foreach ($module as $item) {
                    Node::create($item);
                }
            }
        }
        $this->info('插入节点成功...');

        $this->info('正在重新关联菜单节点...');
        // 重新关联 menu_node
        // 删除已经分配但已过期的菜单
        $type = array_unique($type);
        foreach ($type as $typeValue) {
            $nodes     = Node::where('type', $typeValue)->get(['id', 'sign']);
            $menuNodes = MenuNode::where('node_type', $typeValue)->get(['id', 'menu_id', 'node_id', 'sign']);
            foreach ($menuNodes as $menuNode) {
                $node = $nodes->where('sign', $menuNode->sign)->first();
                if (empty($node)) {
                    $menuNode->delete();
                } elseif ($node->id !== $menuNode->node_id) {
                    $menuNode->fill(['node_id' => $node->id])->save();
                }
            }
        }
        $this->info('重新关联菜单节点成功...');
    }

    /**
     * @param \Illuminate\Routing\Route $route
     * @param string                    $uriPrefix
     * @param string                    $controllerPrefix
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \ReflectionException
     */
    protected function getMethodDoc($route, $uriPrefix, $controllerPrefix)
    {
        echo $route->uri() . PHP_EOL;
        $node = [];

        $node['method'] = Arr::first($route->methods());
        $node['uri']    = substr($route->uri(), strlen($uriPrefix));

        $routeAction = $route->getAction();
        list($controllerClass, $method) = explode('@', $routeAction['uses']);
        $reflectionClass = new \ReflectionClass($controllerClass);

        // 获取类名注释
        $docBlock            = $this->docBlockFactory->create($reflectionClass->getDocComment());
        $controllerDesc      = $docBlock->getSummary();
        $node['module_name'] = Arr::first(explode("\n", $controllerDesc));

        // 获取方法注释
        $reflectionMethod      = $reflectionClass->getMethod($method);
        $docBlock              = $this->docBlockFactory->create($reflectionMethod->getDocComment());
        $node['function_name'] = $docBlock->getSummary();

        $node['sign'] = $node['method'] . ' ' . $node['uri'];

        $node['controller'] = substr($controllerClass, strlen($controllerPrefix));

        return $node;
    }


}
