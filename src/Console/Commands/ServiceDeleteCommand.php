<?php

namespace Bit\Skeleton\Console\Commands;

use Bit\Skeleton\Support\Service;
use Illuminate\Console\Command;

class ServiceDeleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bit.service:delete {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a registered service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        if (!Service::has($name)) {
            $this->error('Service does not exist!');

            return Command::FAILURE;
        }

        Service::delete($name);
        $this->info('Service deleted succesfully!');
        $this->warn('Please cancel the service registration in your code.');

        return Command::SUCCESS;
    }
}
