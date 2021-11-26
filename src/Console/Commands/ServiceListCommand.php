<?php

namespace Bit\Skeleton\Console\Commands;

use Illuminate\Console\Command;
use Bit\Skeleton\Entities\Service;

class ServiceListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bit.service:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all registered services';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->table(
            ['Service', 'Path'],
            Service::all()->toArray()
        );
    }
}
