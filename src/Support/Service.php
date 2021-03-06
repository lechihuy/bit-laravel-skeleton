<?php

namespace Bit\Skeleton\Support;

use Bit\Skeleton\Entities\Service as Entity;
use Illuminate\Filesystem\Filesystem;
use Bit\Skeleton\Generators\ServiceGenerator;

/**
 * Class Service
 * 
 * It's the Service management for your application.
 * It has a repository that stores all available services
 * It also offers several helper methods for you to manage all services.
 */
class Service
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
        $servicePaths = (new Filesystem)->directories(service_path());

        foreach ($servicePaths as $path) {
            $name = class_basename($path);

            static::add(Entity::make($name));
        }
    }

    /**
     * Determine if the service already exists.
     * 
     * @param  string  $name
     * @return bool
     */
    public static function has(string $name): bool
    {
        return (bool) static::name($name);
    }

    /**
     * Determine if the service does not exist.
     * 
     * @param  string  $name
     * @return bool
     */
    public static function doesntHave(string $name): bool
    {
        return !static::has($name);
    }

    /**
     * Get the service collection of the application.
     * 
     * @return \Illuminate\Support\Collection
     */
    public static function list()
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
        app(ServiceGenerator::class)->generate($name);
    }

    /**
     * Add a service to the services collection.
     * 
     * @param  \Bit\Skeleton\Entities\Service  $service
     * @return void
     */
    protected static function add($service)
    {
        static::$services->push($service);
    }

    /**
     * Get the service entity with the given name.
     * 
     * @param  string  $name
     * @return \Bit\Skeleton\Entities\Service
     */
    public static function name(string $name)
    {
        return static::$services->filter(fn($service) => $service->name === $name)
            ->first();
    }
}