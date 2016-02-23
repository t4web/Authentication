<?php

namespace T4web\AuthenticationTest\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\SessionManager;
use Zend\Authentication\Storage\Session;
use T4web\Authentication\Service\InteractiveAuth;
use T4web\Authentication\Service\InteractiveAuthFactory;
use T4web\Authentication\Service\Authenticator;

class InteractiveAuthFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class);
        $authenticator = $this->prophesize(Authenticator::class);
        $sessionManager = $this->prophesize(SessionManager::class);

        $serviceLocator->get(Authenticator::class)->willReturn($authenticator->reveal());
        $serviceLocator->get(SessionManager::class)->willReturn($sessionManager->reveal());

        $storage = $this->prophesize(Session::class);
        $authenticator->getStorage()->willReturn($storage->reveal());

        $factory = new InteractiveAuthFactory();

        $service = $factory->createService($serviceLocator->reveal());

        $this->assertTrue($service instanceof InteractiveAuth);
    }
}
