<?php

namespace Bit\Skeleton\Tests;

use Bit\Skeleton\Tests\TestCase;
use Bit\Skeleton\Entities\Service;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Events\CommandFinished;

class ServicesTest extends TestCase
{
    public function setUp(): void
    {
        parent::setup();
    }

    public function tearDown(): void
    {
        parent::setup();
    }

    public function test_can_run_service_list_command_when_has_available_services()
    {
        $this->artisan('bit.service:make FooBar');

        $this->artisan('bit.service:list')->expectsTable(
            ['Name', 'Path'],
            [['FooBar', service_path('FooBar')]]
        )->assertSuccessful();

        $this->artisan('bit.service:delete FooBar');
    }

    public function test_can_run_service_list_command_when_no_available_services()
    {
        $this->artisan('bit.service:list')->assertFailed();
    }
}