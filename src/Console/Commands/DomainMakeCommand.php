<?php

namespace Bit\Skeleton\Console\Commands;

use InvalidArgumentException;
use Illuminate\Console\Command;
use Bit\Skeleton\Support\Domain;

class DomainMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bit.domain:make 
                            {name : The name of the domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new domain.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return rescue(function() {
            $name = $this->argument('name');

            Domain::generate($name);
            $this->info('Domain created successfully!');
            
            return Command::SUCCESS;
        }, function($e) {
            $this->error($e->getMessage());

            return Command::FAILURE;
        });
    }
}
