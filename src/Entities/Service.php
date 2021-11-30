<?php

namespace Bit\Skeleton\Entities;

use Bit\Skeleton\Entities\Entity;
use Bit\Skeleton\Entities\Controller;
use Illuminate\Filesystem\Filesystem;

class Service extends Entity
{
    /**
     * The name of service.
     * 
     * @var string
     */
    public $name;

    /**
     * The storage path of service.
     * 
     * @var string
     */
    public $path;

    /**
     * Features belongs to the service.
     * 
     * @var \Illuminate\Support\Collection
     */
    protected $features;

    /**
     * Controllers belongs to the service.
     * 
     * @var \Illuminate\Support\Collection
     */
    protected $controllers;

    /**
     * Create a new service.
     * 
     * @param  string  $name
     * @param  string  $path
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->path = service_path($name);

        $this->loadFeatures();
        $this->loadControllers();
    }

    /**
     * Determine if the service is enabled.
     * 
     * @return bool
     */
    public function enabled(): bool
    {
        return (bool) $this->getProvider();
    }

    /**
     * Get the provider of the service.
     * 
     * @param  string|null  $path
     * @return \Illuminate\Support\ServiceProvider|null
     */
    public function getProvider()
    {
        return app()->getProvider(
            service_classname($this->name, 'Providers', $this->name.'ServiceProvider')
        );
    }

    /**
     * Get all features belongs to the service.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function features()
    {
        return $this->features->all();
    }

    /**
     * Get all controllers belongs to the service.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function controllers()
    {
        return $this->controllers->all();
    }

    /**
     * Load all features for the service.
     * 
     * @return void
     */
    protected function loadFeatures(): void
    {
        $this->features = collect();
        $featurePath = service_path($this->name, 'Features');

        (new Filesystem)->ensureDirectoryExists($featurePath);
        $featureFiles = (new Filesystem)->allFiles($featurePath);

        foreach ($featureFiles as $file) {
            $this->features->push(new Feature(
                name: basename($file->getFileName(), '.'.$file->getExtension()),
                service: $this->name
            ));
        }
    }

    /**
     * Load all controllers for the service.
     * 
     * @return void
     */
    protected function loadControllers(): void
    {
        $this->controllers = collect();
        $controllerPath = service_path($this->name, 'Http/Controllers');

        (new Filesystem)->ensureDirectoryExists($controllerPath);
        $controllerFiles = (new Filesystem)->allFiles($controllerPath);

        foreach ($controllerFiles as $file) {
            $this->controllers->push(new Controller(
                name: basename($file->getFileName(), '.'.$file->getExtension()),
                service: $this->name
            ));
        }
    }

    /**
     * Determine if the feature belongs to the service.
     * 
     * @param  string  $name
     * @return bool
     */
    public function hasFeature(string $name): bool
    {
        return (bool) $this->features->filter(fn($feature) => $feature->name === $name)
            ->first();
    }

    /**
     * Determine if the controller belongs to the service.
     * 
     * @param  string  $name
     * @return bool
     */
    public function hasController(string $name): bool
    {
        return (bool) $this->controllers->filter(fn($controller) => $controller->name === $name)
            ->first();
    }

    /**
     * Serilize the service to array.
     * 
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'path' => $this->path,
            'enabled' => $this->enabled(),
            'features' => $this->features(),
            'controllers' => $this->controllers(),
        ];
    }
}