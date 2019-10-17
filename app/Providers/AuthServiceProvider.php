<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use UTMS\Auth\TokenGuard;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //token验证
        \Auth::extend('ojms.token', function ($app, $name, array $config) {
            return new TokenGuard(\Auth::createUserProvider($config['provider']), $app['request'],
                cons('user.group.' . $config['provider']));
        });
    }
}
