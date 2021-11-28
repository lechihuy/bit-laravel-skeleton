<?php

namespace Bit\Skeleton\Tests\Cli;

use Bit\Skeleton\Tests\TestCase;

class ServicesTest extends TestCase
{
    public function test_cannot_execute_service_list_command_when_no_available_services()
    {
        $this->artisan('bit.service:list')
            ->expectsOutput('No avaiable services!')
            ->assertFailed();
    }

    public function test_can_display_service_table_when_has_available_services()
    {
        $this->artisan('bit.service:make FooBar');
        $this->artisan('bit.service:list')->expectsTable(
            ['Name', 'Path', 'Enabled'],
            [['FooBar', service_path('FooBar'), 'No']]
        )->assertSuccessful();
    }

    public function test_can_execute_service_make_command_when_it_does_not_exist()
    {
        $this->artisan('bit.service:make FooBar')
            ->expectsOutput('Service created successfully!')
            ->assertSuccessful();
    }

    public function test_cannot_execute_service_make_command_when_it_already_exists()
    {
        $this->artisan('bit.service:make FooBar');
        $this->artisan('bit.service:make FooBar')
            ->expectsOutput('Service already exists!')
            ->assertFailed();
    }

    public function test_can_execute_service_delte_command_when_it_already_exists()
    {
        $this->artisan('bit.service:make FooBar');
        $this->artisan('bit.service:delete FooBar')
            ->expectsOutput('Service deleted succesfully!')
            ->assertSuccessful();
    }

    public function test_cannot_execute_service_delte_command_when_it_does_not_exist()
    {
        $this->artisan('bit.service:delete FooBar')
            ->expectsOutput('Service does not exist!')
            ->assertFailed();
    }
}