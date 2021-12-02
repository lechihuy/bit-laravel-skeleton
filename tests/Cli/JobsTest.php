<?php

namespace Bit\Skeleton\Tests\Cli;

use Bit\Skeleton\Tests\TestCase;

class JobsTest extends TestCase
{
    public function test_can_execute_job_make_command_when_it_does_not_exist()
    {
        $this->artisan('bit.domain:make FooBar');
        $this->artisan('bit.job:make FooJob -D FooBar')
            ->expectsOutput('Job created successfully!')
            ->assertSuccessful();    
    }

    public function test_cannot_execute_job_make_command_when_missing_domain_option()
    {
        $this->artisan('bit.job:make FooJob')
            ->expectsOutput('Domain option is required!')
            ->assertFailed();    
    }

    public function test_cannot_execute_job_make_command_when_it_already_exists()
    {
        $this->artisan('bit.domain:make FooBar');
        $this->artisan('bit.job:make FooJob -D FooBar');
        $this->artisan('bit.job:make FooJob -D FooBar')
            ->expectsOutput('Job already exists!')
            ->assertFailed();    
    }
}