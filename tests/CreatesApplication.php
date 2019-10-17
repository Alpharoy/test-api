<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    static $firstStart = true;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $this->checkAppEnv($app);

        $this->migrateFresh($app);

        return $app;
    }

    /**
     * 检查环境变量
     *
     * @param \Illuminate\Foundation\Application $app
     */
    private function checkAppEnv($app)
    {
        if ($app['config']['app.env'] !== 'testing') {
            dd('环境变量:APP_ENV 为非测试环境，请指定配置文件 phpunit.xml 后再使用');
        }
    }

    /**
     * 刷新数据库
     *
     * @param \Illuminate\Foundation\Application $app
     */
    private function migrateFresh($app)
    {
        if (self::$firstStart) {
            $app[Kernel::class]->call('migrate:fresh');
            self::$firstStart = false;
        }
    }
}
