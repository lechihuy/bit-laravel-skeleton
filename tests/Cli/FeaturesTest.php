<?php

namespace Bit\Skeleton\Tests\Cli;

use Bit\Skeleton\Tests\TestCase;

class FeaturesTest extends TestCase
{
    public function test_can_execute_feature_make_command_when_it_does_not_exist()
    {
        $this->artisan('bit.service:make FooBar');
        $this->artisan('bit.feature:make FooFeature -S FooBar')
            ->expectsOutput('Feature created successfully!')
            ->assertSuccessful();    
    }

    public function test_cannot_execute_feature_make_command_when_it_already_exists()
    {
        $this->artisan('bit.service:make FooBar');
        $this->artisan('bit.feature:make FooFeature -S FooBar');
        $this->artisan('bit.feature:make FooFeature -S FooBar')
            ->expectsOutput('Feature already exists!')
            ->assertFailed();    
    }

    public function test_cannot_execute_feature_make_command_when_the_service_does_not_exist()
    {
        $this->artisan('bit.feature:make FooFeature -S FooBar')
            ->expectsOutput('Service [FooBar] does not exist!')
            ->assertFailed();    
    }
}