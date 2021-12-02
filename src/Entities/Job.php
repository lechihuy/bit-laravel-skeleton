<?php

namespace Bit\Skeleton\Entities;

use Bit\Skeleton\Entities\Entity;

class Job extends Entity
{
    /**
     * The domain that owns the job.
     * 
     * @var string
     */
    public $domain;

    /**
     * Create a new job.
     * 
     * @param  string  $name
     * @param  string  $domain
     * @return void
     */
    public function __construct($name, $domain)
    {
        $this->name = $name;
        $this->path = domain_path($domain, 'Jobs', $name.'.php');
        $this->domain = $domain;
    }

    /**
     * Serilize the job to array.
     * 
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'path' => $this->path,
            'domain' => $this->domain
        ];
    }
}