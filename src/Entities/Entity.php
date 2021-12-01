<?php

namespace Bit\Skeleton\Entities;

use Illuminate\Contracts\Support\Arrayable;

abstract class Entity implements Arrayable
{
    /**
     * The name of entity.
     * 
     * @var string
     */
    public $name;

    /**
     * The storage path of entity.
     * 
     * @var string
     */
    public $path;

    /**
     * Create a new entity.
     * 
     * @param  mixed  ...$args
     * @return void
     */
    public static function make(...$args)
    {
        return new static(...$args);
    }
}