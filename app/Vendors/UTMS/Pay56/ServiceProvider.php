<?php

namespace UTMS\Pay56;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * 56PAY支付SDK 注册服务
 *
 * Class Pay56ServiceProvider
 *
 * @package UTMS\Pay56
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // 注册api client
        $this->app->singleton('pay56-client', function ($app) {
            return new Pay56Client(config('pay56'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['pay56-client'];
    }

}
