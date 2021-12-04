<?php

namespace Bit\Skeleton\Concepts;

use Illuminate\Support\Facades\App;

abstract class Controller
{
    /**
     * Serve a feature.
     * 
     * @param  string  $feature
     * @param  mixed  $args,...
     * @return mixed
     */
    protected function serve(string $feature, ...$args)
    {
        return $feature::dispatch(...$args);
    }
}