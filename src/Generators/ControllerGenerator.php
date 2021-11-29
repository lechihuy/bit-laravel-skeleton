<?php

namespace Bit\Skeleton\Generators;

use Bit\Skeleton\Support\Service;
use Bit\Skeleton\Support\Controller;
use Bit\Skeleton\Generators\Generator;
use Bit\Skeleton\Exceptions\EntityNotFoundException;
use Bit\Skeleton\Exceptions\EntityAlreadyExistsException;

class ControllerGenerator extends Generator
{
    /**
     * The service that owns the feature.
     * 
     * @var string
     */
    protected $service;

    /**
     * Execute the generate command.   
     * 
     * @param  string  $name
     * @param  string  $service
     * @return void
     */
    public function generate(string $name, string $service): void
    {
        $this->name = $name;
        $this->service = $service;
        $this->basepath = service_path($service, 'Http/Controllers');



        if (Service::doesntHave($service))
            throw new EntityNotFoundException("Service [{$service}] does not exist!");

        if (Controller::has($name, $service))
            throw new EntityAlreadyExistsException("Controller already exists!");

        $this->makeControllerFile();

        if (app()->runningUnitTests())
            Service::reboot();
    }

    /**
     * Make the feature class file.
     * 
     * @return void
     */
    protected function makeControllerFile()
    {
        $this->files->ensureDirectoryExists($this->basepath());

        $this->files->put(
            $this->basepath($this->name.'.php'),
            $this->getstub('services/controller.stub', [
                'service' => $this->service,
                'controller' => $this->name,
            ])
        );
    }
}