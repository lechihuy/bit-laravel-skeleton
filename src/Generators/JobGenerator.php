<?php

namespace Bit\Skeleton\Generators;

use Exception;
use Illuminate\Support\Str;
use Bit\Skeleton\Support\Job;
use Bit\Skeleton\Support\Domain;
use Bit\Skeleton\Generators\Generator;
use Bit\Skeleton\Exceptions\EntityNotFoundException;
use Bit\Skeleton\Exceptions\EntityAlreadyExistsException;

class JobGenerator extends Generator
{
    /**
     * The domain that owns the job.
     * 
     * @var string
     */
    protected $domain;

    /**
     * Execute the generate command.    
     * 
     * @param  string  $name
     * @param  string  $domain
     * @return void
     */
    public function generate($name, $domain)
    {
        $this->name = $name;
        $this->domain = $domain;
        $this->basepath = domain_path($this->domain, 'Jobs');

        if (Domain::doesntHave($domain))
            throw new EntityNotFoundException("Domain [{$domain}] does not exist!");

        if (Job::has($name, $domain))
            throw new EntityAlreadyExistsException('Job already exists!');

        $this->makeJobFile();

        if (app()->runningUnitTests())
            Domain::reboot();
    }

     /**
     * Make the job file.
     * 
     * @return void
     */
    protected function makeJobFile()
    {
        $this->files->ensureDirectoryExists($this->basepath());
        $this->files->put(
            $this->basepath("{$this->name}.php"),
            $this->getStub('domains/job.stub', [
                'domain' => $this->domain,
                'job' => $this->name
            ])
        );
    }
}