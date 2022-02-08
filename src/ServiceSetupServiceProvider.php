<?php 


namespace Ibrodev\Crypto;

use Ibrodev\Crypto\Commands\InitializeCommand;
use Ibrodev\Crypto\Middlewares\DecryptionMiddleware;
use Ibrodev\Crypto\Middlewares\EncryptionMiddleware;
use Illuminate\Support\ServiceProvider;

class ServiceSetupServiceProvider extends ServiceProvider {

    public function boot() {

     

        if ($this->app->runningInConsole()) {
            $this->commands([
                InitializeCommand::class,
        
            ]);

            $this->publishes([
                __DIR__.'/config/config.php' => config_path('setuppackage.php'),
            ], 'config');
        }
    }

    public function register() {
        $this->mergeConfigFrom(__DIR__.'/config/config.php', 'setuppackage');
    }

}
