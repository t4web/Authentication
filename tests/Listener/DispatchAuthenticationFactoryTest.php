<?php

namespace T4web\AuthenticationTest\Listener;

use Zend\ServiceManager\ServiceLocatorInterface;
use T4web\Authentication\Listener\DispatchAuthentication;
use T4web\Authentication\Listener\DispatchAuthenticationFactory;

class DispatchAuthenticationFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class);

        $factory = new DispatchAuthenticationFactory();

        $listener = $factory->createService($serviceLocator->reveal());

        $this->assertTrue($listener instanceof DispatchAuthentication);
    }
}
