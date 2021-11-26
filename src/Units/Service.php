<?php

namespace Bit\Skeleton\Units;

use Bit\Skeleton\Units\Unit;

class Service extends Unit
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
     * Create a new service.
     * 
     * @param  string  $name
     * @param  string  $path
     * @return void
     */
    public function __construct($name, $path)
    {
        $this->name = $name;
        $this->path = $path;
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
        ];
    }
}