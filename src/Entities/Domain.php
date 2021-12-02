<?php

namespace Bit\Skeleton\Entities;

use Bit\Skeleton\Entities\Job;
use Bit\Skeleton\Entities\Entity;
use Illuminate\Filesystem\Filesystem;

class Domain extends Entity
{
    /**
     * Jobs belongs to the domain.
     * 
     * @var \Illuminate\Support\Collection
     */
    protected $jobs;

    /**
     * Create a new domain.
     * 
     * @param  string  $name
     * @param  string  $path
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->path = domain_path($name);

        $this->loadJobs();
    }

    /**
     * Get all jobs belongs to the domain.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function jobs()
    {
        return $this->jobs->all();
    }

    /**
     * Load all jobs for the domain.
     * 
     * @return void
     */
    protected function loadJobs(): void
    {
        $this->jobs = collect();
        $jobPath = domain_path($this->name, 'Jobs');

        if (!(new Filesystem)->exists($jobPath)) return;

        $jobFiles = (new Filesystem)->allFiles($jobPath);

        foreach ($jobFiles as $file) {
            $this->jobs->push(Job::make(
                name: basename($file->getFileName(), '.'.$file->getExtension()),
                domain: $this->name
            ));
        }
    }

    /**
     * Determine if the job belongs to the domain.
     * 
     * @param  string  $name
     * @return bool
     */
    public function hasJob(string $name): bool
    {
        return (bool) $this->jobs->filter(fn($job) => $job->name === $name)
            ->first();
    }

    /**
     * Serilize the domain to array.
     * 
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'path' => $this->path,
            'jobs' => $this->jobs(),
        ];
    }
}