<?php

namespace T4web\AuthenticationTest\Service;

use Zend\Session\SessionManager;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\Storage\Session;
use Zend\Authentication\Adapter\ValidatableAdapterInterface;
use Prophecy\Argument;
use T4web\Authentication\Service\InteractiveAuth;
use T4web\Authentication\Service\Authenticator;

class InteractiveAuthTest extends \PHPUnit_Framework_TestCase
{
    private $authService;
    private $sessionManager;
    private $event;
    private $auth;

    public function setUp()
    {
        $this->authService = $this->prophesize(Authenticator::class);
        $this->sessionManager = $this->prophesize(SessionManager::class);
        $this->event = $this->prophesize(MvcEvent::class);

        $this->authService->getStorage()->willReturn($this->prophesize(Session::class));

        $this->auth = new InteractiveAuth(
            $this->authService->reveal(),
            $this->sessionManager->reveal()
        );
    }

    public function testInvokeConsoleRequest()
    {
        $adapter = $this->prophesize(ValidatableAdapterInterface::class);
        $this->authService->getAdapter()->willReturn($adapter->reveal());

        $adapter->setIdentity('aaa')->willReturn($adapter);
        $adapter->setCredential('111')->willReturn($adapter);

        $this->authService->authenticate()->willReturn(true);

        $result = $this->auth->login('aaa', '111');

        $this->assertTrue($result);

    }
}
