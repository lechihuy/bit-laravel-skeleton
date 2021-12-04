<?php

namespace Bit\Skeleton\Concepts;

use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Bus\Dispatchable;

abstract class Feature
{
    use Dispatchable;

    /**
     * Run a job.
     * 
     * @param  string  $job
     * @param  mixed  $args,...
     * @return void
     */
    public function run($job, ...$args)
    {
        return $job::dispatch(...$args);
    }
}