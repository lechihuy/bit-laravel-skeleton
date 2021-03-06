<?php

namespace Bit\Skeleton\Providers;

use Bit\Skeleton\Support\Domain;
use Bit\Skeleton\Support\Service;
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
        Domain::boot();

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
            \Bit\Skeleton\Console\Commands\ServiceDeleteCommand::class,

            \Bit\Skeleton\Console\Commands\FeatureMakeCommand::class,

            \Bit\Skeleton\Console\Commands\ControllerMakeCommand::class,

            \Bit\Skeleton\Console\Commands\DomainMakeCommand::class,

            \Bit\Skeleton\Console\Commands\JobMakeCommand::class,
        ]);
    }
}
