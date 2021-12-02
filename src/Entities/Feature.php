<?php

namespace Bit\Skeleton\Entities;

use Bit\Skeleton\Entities\Entity;
use Bit\Skeleton\Support\Service;

class Feature extends Entity
{
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
     * @param  string  $service
     * @return void
     */
    public function __construct($name, $service)
    {
        $this->name = $name;
        $this->path = service_path($service, 'Features', $name.'.php');
        $this->service = $service;
    }

    /**
     * Serilize the feature to array.
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