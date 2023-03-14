<?php

namespace S25\Auth;

use Illuminate\Support\ServiceProvider;
use S25\Auth\Console\UpdateRolesCommand;
use S25\Auth\UserProvider\CachedUserProvider;
use S25\Auth\UserProvider\UserProviderInterface;

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
                __DIR__ . '/Config/through.php' => config_path('through.php'),
            ]
        );
    }

    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, CachedUserRepository::class);
        $this->app->bind(UserProviderInterface::class, CachedUserProvider::class);
    }

    protected function extendAuthManager()
    {
        if ($this->app->bound('auth')) {
            $this->app->make('auth')->provider(
                'redis',
                static function ($app, $config) {
                    return new CachedUserProvider(
                        app()->make(UserRepositoryInterface::class)
                    );
                }
            );
        }
    }
}
