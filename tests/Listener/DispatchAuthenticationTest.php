<?php

namespace T4web\AuthenticationTest\Listener;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use T4web\Authentication\Listener\DispatchAuthentication;
use T4web\Authentication\AuthenticationEvent;

class DispatchAuthenticationTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $authService = $this->prophesize(AuthenticationService::class);

        $listener = new DispatchAuthentication($authService->reveal());

        $authEvent = $this->prophesize(AuthenticationEvent::class);
        $adapter = $this->prophesize(AdapterInterface::class);
        $result = $this->prophesize(Result::class);

        $authEvent->getAdapter()->willReturn($adapter->reveal());

        $authService->authenticate($adapter->reveal())->willReturn($result->reveal());

        $authEvent->setResult($result->reveal())->willReturn(null);

        $listener($authEvent->reveal());
    }
}
