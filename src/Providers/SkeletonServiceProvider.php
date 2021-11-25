<?php

namespace Bit\Skeleton\Providers;

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
        ]);
    }
}
