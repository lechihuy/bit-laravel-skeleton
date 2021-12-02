<?php

namespace Bit\Skeleton\Generators;

use Exception;
use Illuminate\Support\Str;
use Bit\Skeleton\Support\Domain;
use Bit\Skeleton\Generators\Generator;
use Bit\Skeleton\Exceptions\EntityAlreadyExistsException;

class DomainGenerator extends Generator
{
    /**
     * Execute the generate command.    
     * 
     * @param  string  $name
     * @return void
     */
    public function generate($name)
    {
        $this->name = $name;
        $this->basepath = domain_path($this->name);

        if (Domain::has($name))
            throw new EntityAlreadyExistsException('Domain already exists!');

        $this->makeDomainDirectory();

        if (app()->runningUnitTests())
            Domain::reboot();
    }

     /**
     * Make the domain directory.
     * 
     * @return void
     */
    protected function makeDomainDirectory()
    {
        $this->files->makeDirectory($this->basepath());
    }
}