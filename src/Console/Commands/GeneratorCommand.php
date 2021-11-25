<?php

namespace Bit\Skeleton\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GeneratorCommand extends Command
{
     /**
     * The base path of the generator.
     * 
     * @var string
     */
    protected $basepath;

    /**
     * The file system for the generator.
     * 
     * @var \Illuminate\Filesystem\Filesystem 
     */
    protected $files;

    /**
     * Create a new generator
     * 
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        
        $this->files = $files;
    }

    /**
     * Get a path with the base path of generator prefix.
     * 
     * @param  string|null  $path
     * @return string
     */
    public function basepath($path = null)
    {
        return $this->basepath 
            ? rtrim($this->basepath, '/').'/'.$path 
            : app_path($path); 
    }

    /**
     * Get a stub path of the generator.
     * 
     * @param  string  $name
     * @return string
     */
    protected function getStubPath($name)
    {
        return __DIR__ . '/stubs/' . trim($name, '/');
    }

    /**
     * Replace the stub of the generator.
     * 
     * @param  string  $stub
     * @param  array  $data
     */
    protected function replaceStub($stub, $data)
    {
        foreach ($data as $key => $value) {
            $stub = str_replace(
                ['{{'.$key.'}}', '{{ '.$key.' }}'], 
                $value, 
                $stub
            );
        }

        return $stub;
    }

    /**
     * Get the stub content of the generator.
     * 
     * @param  string  $name
     * @param  array  $data
     * @return string
     */
    protected function getStub($name, $data = [])
    {
        $stub = $this->files->get($this->getStubPath($name));
        $stub = $this->replaceStub($stub, $data);

        return $stub;
    }
}