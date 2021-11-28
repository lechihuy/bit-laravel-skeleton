<?php

namespace Bit\Skeleton\Tests;

use Mockery;
use Bit\Skeleton\Support\Service;
use Illuminate\Filesystem\Filesystem;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Bit\Skeleton\Providers\SkeletonServiceProvider;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        (new Filesystem)->cleanDirectory(service_path());
        Mockery::close();
    }

    protected function getPackageProviders($app)
    {
        return [
            SkeletonServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        //
    }
}