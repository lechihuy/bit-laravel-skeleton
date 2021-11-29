<?php

namespace Bit\Skeleton\Support;

use Bit\Skeleton\Generators\ControllerGenerator;

class Controller
{
    /**
     * Generate a new controller with the given name.
     * 
     * @param  string  $name
     * @param  string  $service
     * @return void
     */
    public static function generate(string $name, string $service): void
    {
        app(ControllerGenerator::class)->generate($name, $service);
    }

    /**
     * Determine if the controller already exist.
     * 
     * @param  string  $name
     * @param  string  $service
     * @return bool
     */
    public static function has(string $name, string $service): bool
    {
        return Service::name($service)->hasController($name);
    }
}