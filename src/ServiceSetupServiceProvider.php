<?php 


namespace Neo\Servicesetup;

use Neo\Servicesetup\Commands\InitializeCommand;
use Neo\Servicesetup\Middlewares\DecryptionMiddleware;
use Neo\Servicesetup\Middlewares\EncryptionMiddleware;
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
