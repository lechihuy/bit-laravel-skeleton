<?php

namespace Bit\Skeleton\Entities;

use Bit\Skeleton\Entities\Entity;
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
        $this->features = collect();
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
     * Serilize the service to array.
     * 
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'path' => $this->path,
            'enabled' => $this->enabled(),
        ];
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
     * Register all features for the service.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function bootFeatures()
    {
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
}