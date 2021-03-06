<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

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

        $this->oauth();
    }

    protected function oauth()
    {
        Passport::routes();

        Passport::tokensExpireIn(now()->addDays(15));

        Passport::refreshTokensExpireIn(now()->addDays(30));
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        // 面向用户
        $this->mapUsersRoutes();
        // 面向客户端
        $this->mapClientsRoutes();

        $this->mapWebRoutes();

        //
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


    protected function mapUsersRoutes()
    {
        Route::namespace($this->namespace)
            ->group(base_path('routes/user.php'));
    }


    protected function mapClientsRoutes()
    {
        Route::namespace($this->namespace)
            ->group(base_path('routes/client.php'));
    }
}
