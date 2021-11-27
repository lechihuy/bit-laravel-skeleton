<?php

namespace Bit\Skeleton\Entities;

use Bit\Skeleton\Entities\Entity;
use Illuminate\Filesystem\Filesystem;
use Bit\Skeleton\Units\Service as Unit;
use Illuminate\Support\Facades\Storage;
use Bit\Skeleton\Generators\ServiceGenerator;

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
        static::$services = collect();

        (new Filesystem)->ensureDirectoryExists(service_path());
        $paths = (new Filesystem)->directories(service_path());

        foreach ($paths as $path) {
            $name = (new Filesystem)->basename($path);

            static::add(compact('name', 'path'));
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

    /**
     * Determine if not any available services.
     * 
     * @return bool
     */
    public static function isEmpty()
    {
        return static::$services->isEmpty();
    }

    /**
     * Re-booting all services for the application
     * 
     * @return void
     */
    public static function reboot()
    {
        static::boot();
    }

    /**
     * Generate a new service with the given name.
     * 
     * @param  string  $name
     * @return void
     */
    public static function generate($name)
    {
        $path = service_path($name);

        app(ServiceGenerator::class)->generate($name);
        static::add(compact('name', 'path'));
    }

    /**
     * Add the service to the services collection.
     * 
     * @param  array  $service
     * @return void
     */
    public static function add($service)
    {
        static::$services->push(new Unit(...$service));
    }
}