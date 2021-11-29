<?php

namespace Bit\Skeleton\Support;

use Bit\Skeleton\Entities\Service as Entity;
use Illuminate\Filesystem\Filesystem;
use Bit\Skeleton\Generators\ServiceGenerator;

/**
 * Service class is the Service management for your application.
 * 
 * It has a repository that stores all available services. 
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
            $entity = Entity::make($name);

            static::add($entity);
            $entity->bootFeatures();
            $entity->bootControllers();
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
    }

    /**
     * Add the service to the services collection.
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