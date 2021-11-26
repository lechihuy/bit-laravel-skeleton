<?php

namespace Bit\Skeleton\Providers;

use Bit\Skeleton\Entities\Service;
use Illuminate\Support\ServiceProvider;

class SkeletonServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Service::boot();
        
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
        }
    }

    /**
     * Register the commands of the package.
     * 
     * @return void
     */ 
    protected function registerCommands()
    {
        $this->commands([
            \Bit\Skeleton\Console\Commands\ServiceMakeCommand::class,
            \Bit\Skeleton\Console\Commands\ServiceListCommand::class,
        ]);
    }
}
