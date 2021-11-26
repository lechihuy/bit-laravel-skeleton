<?php

namespace Bit\Skeleton\Console\Commands;

use Illuminate\Console\Command;
use Bit\Skeleton\Entities\Service;

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
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');

        if (!Service::has($name)) {
            return $this->error('Service does not exist!');
        }

        Service::delete($name);

        $this->info('Service deleted succesfully!');
        $this->warn('Please cancel the service registration in your code.');
    }
}
