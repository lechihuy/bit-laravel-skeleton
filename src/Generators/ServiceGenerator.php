<?php

namespace Bit\Skeleton\Generators;

use Exception;
use Illuminate\Support\Str;
use Bit\Skeleton\Support\Service;
use Bit\Skeleton\Generators\Generator;
use Bit\Skeleton\Exceptions\EntityAlreadyExistsException;

class ServiceGenerator extends Generator
{
    /**
     * Execute the generate command.    
     * 
     * @param  string  $name
     * @return void
     */
    public function generate($name)
    {
        $this->name = $name;
        $this->basepath = service_path($this->name);

        if (Service::has($name))
            throw new EntityAlreadyExistsException('Service already exists!');

        $this->makeServiceDirectory();
        $this->registerServiceProviders();
        $this->makeFeatureDirectory();
        $this->registerRoutes();
        $this->makeHttpDirectory();

        if (app()->runningUnitTests())
            Service::reboot();
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

    /**
     * Make the HTTP directory for the service.
     * 
     * @return void
     */
    protected function makeHttpDirectory()
    {
        $this->files->makeDirectory($this->basepath('Http'));
        $this->files->makeDirectory($this->basepath('Http/Controllers'));
        $this->files->makeDirectory($this->basepath('Http/Middleware'));
    }
}