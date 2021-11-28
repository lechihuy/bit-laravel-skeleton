<?php

namespace Bit\Skeleton\Entities;

use Bit\Skeleton\Entities\Entity;
use Bit\Skeleton\Support\Service;
use Bit\Skeleton\Exceptions\EntityNotFoundException;

class Feature extends Entity
{
    /**
     * The name of feature.
     * 
     * @var string
     */
    public $name;

    /**
     * The storage path of feature.
     * 
     * @var string
     */
    public $path;

    /**
     * The service that owns the feature.
     * 
     * @var string
     */
    public $service;

    /**
     * Create a new feature.
     * 
     * @param  string  $name
     * @param  string  $path
     * @return void
     * 
     * @throws \Bit\Skeleton\Exceptions\EntityNotFoundException
     */
    public function __construct($name, $service)
    {
        if (Service::doesntHave($service))
            throw new EntityNotFoundException("Service [{$service}] does not exist!");

        $this->name = $name;
        $this->path = service_path($service, 'Features', $name.'.php');
        $this->service = $service;
    }

    /**
     * Determine if the service is enabled.
     * 
     * @return bool
     */
    public function enabled()
    {
        return true;
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
            'service' => $this->service
        ];
    }
}