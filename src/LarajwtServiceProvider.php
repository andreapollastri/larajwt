<?php

namespace Andr3a\Larajwt;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Andr3a\Larajwt\Http\Middleware\JwtAuth;

class LarajwtServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('larajwt.php'),
            ], 'larajwt-config');

            if (! class_exists('JwtController')) {
                $this->publishes([
                    __DIR__.'/../stubs/controller.stub' => app_path('Http/Controllers/JwtController.php'),
                ], 'larajwt-controllers');
            }

            if (! class_exists('CreateTokensTable')) {
                $this->publishes([
                  __DIR__ . '/../database/migrations/create_tokens_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_tokens_table.php'),
                ], 'larajwt-migrations');
            }
        }

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('jwt', JwtAuth::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'larajwt');

        $this->app->singleton('larajwt', function () {
            return new Larajwt();
        });
    }
}
