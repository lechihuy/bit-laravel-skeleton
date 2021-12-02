<?php

namespace Bit\Skeleton\Entities;

use Bit\Skeleton\Entities\Entity;
use Bit\Skeleton\Support\Service;

class Controller extends Entity
{
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
     */
    public function __construct($name, $service)
    {
        $this->name = $name;
        $this->path = service_path($service, 'Http/Controllers', $name.'.php');
        $this->service = $service;
    }

    /**
     * Serilize the controller to array.
     * 
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'path' => $this->path,
            'service' => $this->service
        ];
    }
}