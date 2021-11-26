<?php

namespace Bit\Skeleton\Console\Commands;

use Illuminate\Support\Str;
use Bit\Skeleton\Entities\Service;
use Bit\Skeleton\Console\Commands\GeneratorCommand;

class ServiceMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bit.service:make {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service.';

    /**
     * The name of the service.
     * 
     * @var string
     */
    protected $name;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->name = $this->argument('name');
        $this->basepath = app_path("Services/{$this->name}");

        if (Service::has($this->name)) {
            return $this->error('Service already exists!');
        }

        $this->makeServiceDirectory();
        $this->registerServiceProviders();
        $this->makeFeatureDirectory();
        $this->registerRoutes();

        $this->info('Service created successfully!');
    }

    /**
     * Make the service directory.
     * 
     * @return void
     */
    protected function makeServiceDirectory()
    {
        $this->files->makeDirectory($this->basepath());
    }

    /**
     * Make the feature directory for the service.
     * 
     * @return void
     */
    protected function makeFeatureDirectory()
    {
        $this->files->makeDirectory($this->basepath('Features'));
    }

    /**
     * Register the service providers for the service.
     * 
     * @return void
     */
    protected function registerServiceProviders()
    {
        $name = $this->name;

        $this->files->makeDirectory($this->basepath('Providers'));

        $this->files->put(
            $this->basepath("Providers/{$name}ServiceProvider.php"), 
            $this->getStub('services/service-provider.stub', [
                'service' => $name
            ])
        );

        $this->files->put(
            $this->basepath("Providers/RouteServiceProvider.php"), 
            $this->getStub('services/route-service-provider.stub', [
                'service' => $name
            ])
        );
    }

    /**
     * Register the providers for the service.
     * 
     * @return void
     */
    protected function registerRoutes()
    {
        $name = $this->name;
        $kebabName = Str::kebab($name);

        $this->files->makeDirectory($this->basepath('routes'));

        $this->files->put(
            $this->basepath("routes/web.php"), 
            $this->getStub('services/web-route.stub', [
                'kebab:service' => $kebabName,
                'service' => $name
            ])
        );

        $this->files->put(
            $this->basepath("routes/api.php"), 
            $this->getStub('services/api-route.stub', [
                'kebab:service' => $kebabName,
                'service' => $name
            ])
        );
    }
}
