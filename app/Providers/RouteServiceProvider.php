<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapDocsRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        // 公共调用接口
        Route::middleware('api')
            ->prefix('common-api')
            ->namespace($this->namespace . '\CommonApi')
            ->group(base_path('routes/common-api.php'));

        // 管理后台调用接口
        Route::middleware('api')
            ->prefix('admin-api')
            ->namespace($this->namespace . '\AdminApi')
            ->group(base_path('routes/admin-api.php'));

        // 企业公司后台调用接口
        Route::middleware('api')
            ->prefix('enterprise-api')
            ->namespace($this->namespace . '\EnterpriseApi')
            ->group(base_path('routes/enterprise-api.php'));

        // 供应商后台调用接口
        Route::middleware('api')
            ->prefix('supplier-api')
            ->namespace($this->namespace . '\SupplierApi')
            ->group(base_path('routes/supplier-api.php'));
    }

    /**
     * Define the "docs" routes for the application.
     *
     * @return void
     */
    protected function mapDocsRoutes()
    {
        if ($this->app->make('config')->get('app.env') !== 'production') {
            Route::prefix('docs')->group(base_path('routes/docs.php'));
        }
    }
}
