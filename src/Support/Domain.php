<?php

namespace Bit\Skeleton\Support;

use Illuminate\Filesystem\Filesystem;
use Bit\Skeleton\Entities\Domain as Entity;
use Bit\Skeleton\Generators\DomainGenerator;

class Domain
{
    /**
     * All domains of the application.
     * 
     * @return \Illuminate\Support\Collection
     */
    protected static $domains;

    /**
     * Booting all domains for the application
     * 
     * @return void
     */
    public static function boot()
    {
        static::$domains = collect();
        (new Filesystem)->ensureDirectoryExists(domain_path());
        $domainPaths = (new Filesystem)->directories(domain_path());

        foreach ($domainPaths as $path) {
            $name = class_basename($path);

            static::add(Entity::make($name));
        }
    }

    /**
     * Determine if the domain already exists.
     * 
     * @param  string  $name
     * @return bool
     */
    public static function has(string $name): bool
    {
        return (bool) static::name($name);
    }

    /**
     * Determine if the domain does not exist.
     * 
     * @param  string  $name
     * @return bool
     */
    public static function doesntHave(string $name): bool
    {
        return !static::has($name);
    }

    /**
     * Delete a domain with the given name.
     * 
     * @param  string  $name
     * @return void
     */
    public static function delete($name)
    {
        (new Filesystem)->deleteDirectory(domain_path($name));
    }

    /**
     * Determine if not any available domains.
     * 
     * @return bool
     */
    public static function isEmpty()
    {
        return static::$domains->isEmpty();
    }

    /**
     * Re-booting all domains for the application
     * 
     * @return void
     */
    public static function reboot()
    {
        static::boot();
    }

    /**
     * Generate a new domain with the given name.
     * 
     * @param  string  $name
     * @return void
     */
    public static function generate($name)
    {
        app(DomainGenerator::class)->generate($name);
    }

    /**
     * Get the domain collection of the application.
     * 
     * @return \Illuminate\Support\Collection
     */
    public static function list()
    {
        return static::$domains;
    }

    /**
     * Add a domain to the services collection.
     * 
     * @param  \Bit\Skeleton\Entities\Domain  $domain
     * @return void
     */
    protected static function add($domain)
    {
        static::$domains->push($domain);
    }

    /**
     * Get the domain entity with the given name.
     * 
     * @param  string  $name
     * @return \Bit\Skeleton\Entities\Domain
     */
    public static function name(string $name)
    {
        return static::$domains->filter(fn($domain) => $domain->name === $name)
            ->first();
    }
}