<?php

namespace Bit\Skeleton\Generators;

use Exception;
use Bit\Skeleton\Support\Feature;
use Bit\Skeleton\Support\Service;
use Bit\Skeleton\Generators\Generator;
use Bit\Skeleton\Exceptions\EntityNotFoundException;
use Bit\Skeleton\Exceptions\EntityAlreadyExistsException;

class FeatureGenerator extends Generator
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
        $this->basepath = service_path($service, 'Features');

        if (Service::doesntHave($service))
            throw new EntityNotFoundException("Service [{$service}] does not exist!");

        if (Feature::has($name, $service))
            throw new EntityAlreadyExistsException("Feature already exists!");

        $this->makeFeatureFile();

        if (app()->runningUnitTests())
            Service::reboot();
    }

    /**
     * Make the feature class file.
     * 
     * @return void
     */
    protected function makeFeatureFile()
    {
        $this->files->ensureDirectoryExists($this->basepath());
        $this->files->put(
            $this->basepath($this->name.'.php'),
            $this->getStub('services/feature.stub', [
                'service' => $this->service,
                'feature' => $this->name,
            ])
        );
    }
}