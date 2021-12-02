<?php

namespace Bit\Skeleton\Concepts;

use Illuminate\Support\Facades\App;

abstract class Feature
{
    /**
     * Run a job.
     * 
     * @param  string  $job
     * @param  mixed  $args,...
     * @return void
     */
    public function run($job, ...$args)
    {
        return App::call([new $job(...$args), 'handle']);
    }
}