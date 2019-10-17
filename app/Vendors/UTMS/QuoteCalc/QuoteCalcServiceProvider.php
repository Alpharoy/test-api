<?php

namespace UTMS\QuoteCalc;

use ChrisKonnertz\StringCalc\Container\Container;
use Illuminate\Support\ServiceProvider;
use UTMS\QuoteCalc\Container\ServiceProviderRegistry;

class QuoteCalcServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application urland constant.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('quote-calc.container', function ($app) {
            $serviceRegistry = new ServiceProviderRegistry();
            return new Container($serviceRegistry);
        });

        $this->app->singleton('quote-calc', function ($app) {
            return new QuoteCalc($app['quote-calc.container']);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'quote-calc',
            'quote-calc.container',
        ];
    }
}