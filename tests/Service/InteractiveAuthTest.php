<?php

namespace T4web\AuthenticationTest\Service;

use Zend\Session\SessionManager;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\Storage\Session;
use Zend\Authentication\Adapter\ValidatableAdapterInterface;
use Zend\Authentication\Adapter\AdapterInterface;
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

    public function testLogin()
    {
        $adapter = $this->prophesize(ValidatableAdapterInterface::class);
        $this->authService->getAdapter()->willReturn($adapter->reveal());

        $adapter->setIdentity('aaa')->willReturn($adapter);
        $adapter->setCredential('111')->willReturn($adapter);

        $this->authService->authenticate()->willReturn(true);

        $result = $this->auth->login('aaa', '111');

        $this->assertTrue($result);

    }

    public function testLogout()
    {
        $this->authService->clearIdentity()->willReturn(null);

        $this->sessionManager->destroy([
            'send_expire_cookie'    => true,
            'clear_storage'         => true,
        ])->willReturn(null);

        $this->auth->logout();

    }

    public function testConnect()
    {
        $this->authService->clearIdentity()->willReturn(null);

        $adapter = $this->prophesize(AdapterInterface::class);

        $this->authService->authenticate($adapter->reveal())->willReturn(true);

        $result = $this->auth->connect($adapter->reveal());

        $this->assertTrue($result);
    }
}
