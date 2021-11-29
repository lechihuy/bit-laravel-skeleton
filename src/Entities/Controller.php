<?php

namespace Bit\Skeleton\Entities;

use Bit\Skeleton\Entities\Entity;
use Bit\Skeleton\Exceptions\EntityNotFoundException;

class Controller extends Entity
{
    /**
     * The name of controller.
     * 
     * @var string
     */
    public $name;

    /**
     * The storage path of controller.
     * 
     * @var string
     */
    public $path;

    /**
     * The service that owns the controller.
     * 
     * @var string
     */
    public $service;

    /**
     * Create a new controller.
     * 
     * @param  string  $name
     * @param  string  $service
     * @return void
     * 
     * @throws \Bit\Skeleton\Exceptions\EntityNotFoundException
     */
    public function __construct($name, $service)
    {
        if (Service::doesntHave($service))
            throw new EntityNotFoundException("Service [{$service}] does not exist!");

        $this->name = $name;
        $this->path = service_path($service, 'Http/Controllers', $name.'.php');
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