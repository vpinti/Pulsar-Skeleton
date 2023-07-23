<?php

declare(strict_types=1);

namespace Pulsar\Framework\Tests;

use PHPUnit\Framework\TestCase;
use Pulsar\Framework\Container\Container;
use Pulsar\Framework\Container\ContainerException;

class ContainerTests extends TestCase
{
    /** @test */
    public function a_service_can_be_retrieved_from_the_container()
    {
        // Setup
        $container = new Container();

        // Do something
        // id string, concrete class name string | object
        $container->add('dependant-class', DependantClass::class);

        // Make assertions
        $this->assertInstanceOf(DependantClass::class, $container->get('dependant-class'));
    }

    /** @test */
    public function a_ContainerException_is_thrown_if_a_service_cannot_be_found()
    {
        // Setup
        $container = new Container();

        // Expect exception
        $this->expectException(ContainerException::class);

        // Do something
        $container->add('foobar');
    }
}