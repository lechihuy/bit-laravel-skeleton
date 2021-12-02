<?php

namespace Bit\Skeleton\Tests\Cli;

use Bit\Skeleton\Tests\TestCase;

class DomainsTest extends TestCase
{
    public function test_can_execute_domain_make_command_when_it_does_not_exist()
    {
        $this->artisan('bit.domain:make FooBar')
            ->expectsOutput('Domain created successfully!')
            ->assertSuccessful();    
    }

    public function test_cannot_execute_domain_make_command_when_it_already_exists()
    {
        $this->artisan('bit.domain:make FooBar');
        $this->artisan('bit.domain:make FooBar')
            ->expectsOutput('Domain already exists!')
            ->assertFailed();    
    }
}