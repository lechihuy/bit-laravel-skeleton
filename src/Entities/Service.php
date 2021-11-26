<?php

namespace Bit\Skeleton\Entities;

use Bit\Skeleton\Entities\Entity;
use Bit\Skeleton\Units\Service as Unit;
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
            $name = (new Filesystem)->basename($path);

            static::$services->push(new Unit($name, $path));
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
        return static::$services->filter(function($service) use ($name) {
            return $service->name === $name;
        })->first();
    }

    /**
     * Get all services of the application
     * 
     * @return \Illuminate\Support\Collection
     */
    public static function all()
    {
        return static::$services;
    }

    /**
     * Delete a service with the given name.
     * 
     * @param  string  $name
     * @return void
     */
    public static function delete($name)
    {
        (new Filesystem)->deleteDirectory(service_path($name));
    }
}