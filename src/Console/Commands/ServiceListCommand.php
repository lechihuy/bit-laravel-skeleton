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
     * @return int
     */
    public function handle()
    {
        if (Service::isEmpty()) {
            $this->error('No avaiable services!');

            return Command::FAILURE;
        }

        $this->table(
            ['Name', 'Path', 'Enabled'],
            $this->formatTableData(Service::all()->toArray())
        );

        return Command::SUCCESS;
    }

    /**
     * Formating the table data.
     * 
     * @param  array  $data
     * @return array
     */
    protected function formatTableData($data)
    {
        foreach ($data as $key => $service) {
            $data[$key]['enabled'] = $data[$key]['enabled'] ? 'Yes' : 'No';
        }

        return $data;
    }
}
