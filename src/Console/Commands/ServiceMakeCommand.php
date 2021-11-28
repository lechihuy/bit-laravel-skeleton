<?php

namespace Bit\Skeleton\Console\Commands;

use Bit\Skeleton\Support\Service;
use Illuminate\Console\Command;

class ServiceMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bit.service:make {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        
        return rescue(function() use ($name ) {
            Service::generate($name);

            $this->info('Service created successfully!');
            $this->info('Let\'s register the service in your code to get started');

            return Command::SUCCESS;
        }, function($e) {
            $this->error($e->getMessage());

            return Command::FAILURE;
        });
    }
}
