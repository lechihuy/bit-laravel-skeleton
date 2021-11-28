<?php

namespace Bit\Skeleton\Support;

use Bit\Skeleton\Support\Service;
use Bit\Skeleton\Entities\Feature as Entity;
use Bit\Skeleton\Generators\FeatureGenerator;

class Feature
{
    /**
     * Generate a new feature with the given name.
     * 
     * @param  string  $name
     * @param  string  $service
     * @return void
     */
    public static function generate(string $name, string $service): void
    {
        app(FeatureGenerator::class)->generate($name, $service);
    }

    /**
     * Determine if the feature already exist.
     * 
     * @param  string  $name
     * @param  string  $service
     * @return bool
     */
    public static function has(string $name, string $service): bool
    {
        return Service::name($service)->hasFeature($name);
    }
}