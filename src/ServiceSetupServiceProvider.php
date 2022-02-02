<?php 


namespace Ibrodev\Servicesetup;

use Ibrodev\Servicesetup\Commands\InitializeCommand;
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
