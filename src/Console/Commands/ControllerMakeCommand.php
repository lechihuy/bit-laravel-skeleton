<?php

namespace Bit\Skeleton\Console\Commands;

use InvalidArgumentException;
use Illuminate\Console\Command;
use Bit\Skeleton\Support\Service;
use Bit\Skeleton\Support\Controller;

class ControllerMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bit.controller:make 
                            {name : The name of controller} 
                            {--S|service= : The service that owns the controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller for service.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return rescue(function() {
            $name = $this->argument('name');
            $service = $this->option('service');

            if (is_null($service))
                throw new InvalidArgumentException('Service option is required!');

            Controller::generate($name, $service);
            $this->info('Controller created successfully!');
            
            return Command::SUCCESS;
        }, function($e) {
            $this->error($e->getMessage());

            return Command::FAILURE;
        });
    }
}
