<?php

namespace T4web\AuthenticationTest\Listener;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\SessionManager;
use T4web\Authentication\Listener\SessionWrite;
use T4web\Authentication\Listener\SessionWriteFactory;

class SessionWriteFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class);
        $sessionManager = $this->prophesize(SessionManager::class);

        $serviceLocator->get(SessionManager::class)->willReturn($sessionManager->reveal());

        $factory = new SessionWriteFactory();

        $listener = $factory->createService($serviceLocator->reveal());

        $this->assertTrue($listener instanceof SessionWrite);
    }
}
