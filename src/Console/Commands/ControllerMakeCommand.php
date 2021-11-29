<?php

namespace Bit\Skeleton\Console\Commands;

use Illuminate\Console\Command;

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
        return Command::SUCCESS;
    }
}
