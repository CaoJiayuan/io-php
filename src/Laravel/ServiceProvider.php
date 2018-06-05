<?php
/**
 * Created by PhpStorm.
 * User: cjy
 * Date: 2018/5/22
 * Time: 下午6:14
 */

namespace CaoJiayuan\Io\Laravel;


use CaoJiayuan\Io\Client;
use CaoJiayuan\Io\Http\SimpleRequester;
use CaoJiayuan\Io\Laravel\Console\GenerateClientId;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;

class ServiceProvider extends BaseServiceProvider
{

    public function register()
    {
        $source = realpath(__DIR__.'/config.php');

        if ($this->app instanceof LaravelApplication) {
            if ($this->app->runningInConsole()) {
                $this->publishes([$source => config_path('io-php.php')], 'io-php');
            }
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('io-php');
        }

        $this->mergeConfigFrom($source, 'io-php');

        $this->registerClient();

        $this->registerCommand();
    }

    protected function registerCommand()
    {
        if ($this->app->runningInConsole()) {
            $this->app->singleton('io-php.cmd.id', function () {
                return new GenerateClientId;
            });

            $this->commands(['io-php.cmd.id']);
        }
    }

    protected function registerClient()
    {
        $this->app->singleton("io-php.client", function ($app) {
            $host = $app['config']->get('io-php.host', 'http://127.0.0.1:3003');
            $credentials = $app['config']->get('io-php.credentials', []);

            $requester = new SimpleRequester($host);
            $client = new Client($requester);

            $client->setTokenProvider(new TokenProvider($requester));
            $client->setCredentials($credentials);

            return $client;
        });
    }

    public function boot()
    {
        if ($this->app instanceof LaravelApplication) {
            require __DIR__.'/routes/laravel.php';
        } elseif ($this->app instanceof LumenApplication) {
            $app = $this->app;

            if (property_exists($app, 'router')) {
                $app->router->group(['namespace' => 'CaoJiayuan\Io\Laravel'], function ($app) {
                    require __DIR__ . '/routes/lumen.php';
                });
            } else {
                $app->group(['namespace' => 'CaoJiayuan\Io\Laravel'], function ($app) {
                    require __DIR__ . '/routes/lumen.php';
                });
            }
        }
    }
}
