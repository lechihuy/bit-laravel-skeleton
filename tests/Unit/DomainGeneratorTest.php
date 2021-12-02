<?php

namespace Bit\Skeleton\Tests\Unit;

use Mockery;
use Mockery\MockInterface;
use Bit\Skeleton\Tests\TestCase;
use Illuminate\Filesystem\Filesystem;
use Bit\Skeleton\Generators\DomainGenerator;
use Bit\Skeleton\Exceptions\EntityAlreadyExistsException;

class DomainGeneratorTest extends TestCase
{
    public function test_can_generate_a_domain_when_it_does_not_exist()
    {
        app(DomainGenerator::class)->generate('FooBar');

        $domainExists = (new Filesystem)->exists(domain_path('FooBar'));

        $this->assertEquals(true, $domainExists);
    }

    public function test_cannot_generate_a_domain_when_it_already_exists()
    {
        $this->expectException(EntityAlreadyExistsException::class);
        $this->expectExceptionMessage('Domain already exists!');

        app(DomainGenerator::class)->generate('FooBar');
        app(DomainGenerator::class)->generate('FooBar');
    }
}