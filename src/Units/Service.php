<?php

namespace Bit\Skeleton\Units;

use Bit\Skeleton\Units\Unit;
use Illuminate\Support\ServiceProvider;

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
     * Determine if the service is enabled.
     * 
     * @return bool
     */
    public function enabled()
    {
        return $this->getProvider();
    }

    /**
     * Get the provider of the service.
     * 
     * @param  string|null  $path
     * @return \Illuminate\Support\ServiceProvider|null
     */
    public function getProvider()
    {
        return app()->getProvider("App\\Services\\{$this->name}\\Providers\\{$this->name}ServiceProvider");
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
}