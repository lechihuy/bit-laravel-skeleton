<?php

namespace Bit\Skeleton\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Bit\Skeleton\Entities\Service;

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
        try {
            $name = $this->argument('name');
            
            Service::generate($name);
            $this->info('Service created successfully!');
            $this->info('Please register the service in your code.');

            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error($e->getMessage());

            return COMMAND::FAILURE;
        }
    }
}
