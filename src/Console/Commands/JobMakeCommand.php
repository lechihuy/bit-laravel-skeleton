<?php

namespace Bit\Skeleton\Console\Commands;

use Bit\Skeleton\Support\Job;
use InvalidArgumentException;
use Illuminate\Console\Command;
use Bit\Skeleton\Support\Domain;

class JobMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bit.job:make 
                            {name : The name of the job} 
                            {--D|domain= : The domain that owns the job}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new job for domain.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return rescue(function() {
            $name = $this->argument('name');
            $domain = $this->option('domain');

            if (is_null($domain))
                throw new InvalidArgumentException('Domain option is required!');

            Job::generate($name, $domain);
            $this->info('Job created successfully!');
            
            return Command::SUCCESS;
        }, function($e) {
            $this->error($e->getMessage());

            return Command::FAILURE;
        });
    }
}
