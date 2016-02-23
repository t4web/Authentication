<?php

namespace T4web\AuthenticationTest\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Adapter\AdapterInterface;
use T4web\Authentication\Service\Authenticator;
use T4web\Authentication\Service\AuthenticatorFactory;

class AuthenticatorFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class);
        $adapter = $this->prophesize(AdapterInterface::class);

        $serviceLocator->get(AdapterInterface::class)->willReturn($adapter->reveal());

        $factory = new AuthenticatorFactory();

        $service = $factory->createService($serviceLocator->reveal());

        $this->assertTrue($service instanceof Authenticator);
    }
}
