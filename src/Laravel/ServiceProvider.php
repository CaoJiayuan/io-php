<?php
/**
 * Created by PhpStorm.
 * User: cjy
 * Date: 2018/5/22
 * Time: 下午6:14
 */

namespace CaoJiayuan\Io\Laravel;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;

class ServiceProvider extends BaseServiceProvider
{

    public function register()
    {
        $source = realpath(__DIR__.'/config.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('io-php.php')], 'io-php');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('io-php');
        }

        $this->mergeConfigFrom($source, 'io-php');

    }

    public function registerClient()
    {
        $this->app->singleton("io-php.client", function ($app) {



            return $app;
        });
    }
}
