<?php

namespace T4web\AuthenticationTest\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use T4web\Authentication\Service\Checker;
use T4web\Authentication\Service\CheckerFactory;

class ChackerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class);

        $factory = new CheckerFactory();

        $service = $factory->createService($serviceLocator->reveal());

        $this->assertTrue($service instanceof Checker);
    }
}
