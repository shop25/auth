<?php

namespace S25\Auth;

use Illuminate\Support\ServiceProvider;
use S25\Auth\Console\UpdateRolesCommand;

class ThroughAuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->extendAuthManager();
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->publishes(
            [
                __DIR__ . 'Config/through.php' => config_path('through.php'),
            ]
        );
    }

    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, RedisUserRepository::class);
    }

    protected function extendAuthManager()
    {
        if ($this->app->bound('auth')) {
            $this->app->make('auth')->provider(
                'redis',
                function ($app, $config) {
                    return new RedisUserProvider(
                        app()->make(UserRepositoryInterface::class)
                    );
                }
            );
        }
    }
}
