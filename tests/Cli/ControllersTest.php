<?php

namespace Bit\Skeleton\Tests\Cli;

use Bit\Skeleton\Tests\TestCase;

class ControllersTest extends TestCase
{
    public function test_can_execute_controller_make_command_when_it_does_not_exist()
    {
        $this->artisan('bit.service:make FooBar');
        $this->artisan('bit.controller:make FooController -S FooBar')
            ->expectsOutput('Controller created successfully!')
            ->assertSuccessful();    
    }

    public function test_cannot_execute_controller_make_command_when_missing_service_option()
    {
        $this->artisan('bit.service:make FooBar');
        $this->artisan('bit.controller:make FooController')
            ->expectsOutput('Service option is required!')
            ->assertFailed();    
    }

    public function test_cannot_execute_controller_make_command_when_it_already_exists()
    {
        $this->artisan('bit.service:make FooBar');
        $this->artisan('bit.controller:make FooController -S FooBar');
        $this->artisan('bit.controller:make FooController -S FooBar')
            ->expectsOutput('Controller already exists!')
            ->assertFailed();    
    }

    public function test_cannot_execute_controller_make_command_when_the_service_does_not_exist()
    {
        $this->artisan('bit.controller:make FooController -S FooBar')
            ->expectsOutput('Service [FooBar] does not exist!')
            ->assertFailed();    
    }
}