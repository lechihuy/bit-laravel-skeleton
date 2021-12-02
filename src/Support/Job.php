<?php

namespace Bit\Skeleton\Support;

use Bit\Skeleton\Support\Domain;
use Bit\Skeleton\Entities\Job as Entity;
use Bit\Skeleton\Generators\JobGenerator;

class Job
{
    /**
     * Generate a new job with the given name.
     * 
     * @param  string  $name
     * @param  string  $domain
     * @return void
     */
    public static function generate(string $name, string $domain): void
    {
        app(JobGenerator::class)->generate($name, $domain);
    }

    /**
     * Determine if the job already exist.
     * 
     * @param  string  $name
     * @param  string  $domain
     * @return bool
     */
    public static function has(string $name, string $domain): bool
    {
        return Domain::name($domain)->hasJob($name);
    }
}