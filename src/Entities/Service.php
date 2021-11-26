<?php

namespace Bit\Skeleton\Entities;

use Bit\Skeleton\Entities\Entity;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class Service extends Entity
{
    /**
     * All services of the application.
     * 
     * @return \Illuminate\Support\Collection
     */
    protected static $services;

    /**
     * Booting all services for the application
     * 
     * @return void
     */
    public static function boot()
    {
        $paths = (new Filesystem)->directories(service_path());
        static::$services = collect();

        foreach ($paths as $path) {
            $service = (new Filesystem)->basename($path);
            static::$services->push(compact('service', 'path'));
        }
    }

    /**
     * Determine if the service exists.
     * 
     * @param  string  $name
     * @return bool
     */
    public static function has($name)
    {
        return static::$services->has(compact('name'));
    }
}