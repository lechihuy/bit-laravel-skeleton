<?php

namespace Bit\Skeleton\Console\Commands;

use InvalidArgumentException;
use Illuminate\Console\Command;
use Bit\Skeleton\Support\Feature;

class FeatureMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bit.feature:make 
                            {name : The name of feature} 
                            {--S|service= : The service that owns the feature}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new feature for service.';

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

            Feature::generate($name, $service);
            $this->info('Feature created successfully!');
            
            return Command::SUCCESS;
        }, function($e) {
            $this->error($e->getMessage());

            return Command::FAILURE;
        });
    }
}
