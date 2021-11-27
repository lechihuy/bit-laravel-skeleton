<?php

namespace Bit\Skeleton\Tests\Cli;

use Bit\Skeleton\Tests\TestCase;
use Bit\Skeleton\Entities\Service;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Events\CommandFinished;

class ServicesTest extends TestCase
{
    public function tearDown(): void
    {
        parent::setup();

        (new Filesystem)->cleanDirectory(service_path());
    }

    public function test_can_display_service_table_if_has_available_services()
    {
        $this->artisan('bit.service:make FooBar');
        $this->artisan('bit.service:list')->expectsTable(
            ['Name', 'Path', 'Enabled'],
            [['FooBar', service_path('FooBar'), 'No']]
        )->assertSuccessful();
    }

    public function test_must_throw_exception_if_no_available_services()
    {
        $this->artisan('bit.service:list')
            ->expectsOutput('No avaiable services!')
            ->assertFailed();
    }

    public function test_can_diplay_enabled_service_when_registerd_provider()
    {
        $this->artisan('bit.service:list')->assertFailed();
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