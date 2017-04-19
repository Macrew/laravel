<?php

/*
 * This file is part of Laravel Instagram.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vinkla\Instagram;

use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Larabros\Elogram\Client;
use Laravel\Lumen\Application as LumenApplication;

/**
 * This is the Instagram service provider class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
class InstagramServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/instagram.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('instagram.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('instagram');
        }

        $this->mergeConfigFrom($source, 'instagram');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFactory();
        $this->registerManager();
        $this->registerBindings();
    }

    /**
     * Register the factory class.
     *
     * @return void
     */
    protected function registerFactory()
    {
        $this->app->singleton('instagram.factory', function () {
            return new InstagramFactory();
        });

        $this->app->alias('instagram.factory', InstagramFactory::class);
    }

    /**
     * Register the manager class.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->singleton('instagram', function (Container $app) {
            $config = $app['config'];
            $factory = $app['instagram.factory'];

            return new InstagramManager($config, $factory);
        });

        $this->app->alias('instagram', InstagramManager::class);
    }

    /**
     * Register the bindings.
     *
     * @return void
     */
    protected function registerBindings()
    {
        $this->app->bind('instagram.connection', function (Container $app) {
            $manager = $app['instagram'];

            return $manager->connection();
        });

        $this->app->alias('instagram.connection', Client::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'instagram',
            'instagram.factory',
            'instagram.connection',
        ];
    }
}
