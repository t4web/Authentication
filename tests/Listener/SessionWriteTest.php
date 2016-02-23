<?php

namespace T4web\AuthenticationTest\Listener;

use Zend\Session\SessionManager;
use Zend\Authentication\Result;
use T4web\Authentication\Listener\SessionWrite;
use T4web\Authentication\AuthenticationEvent;

class SessionWriteTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $sessionManager = $this->prophesize(SessionManager::class);
        $result = $this->prophesize(Result::class);

        $listener = new SessionWrite($sessionManager->reveal());

        $authEvent = $this->prophesize(AuthenticationEvent::class);
        $authEvent->getResult()->willReturn($result->reveal());

        $result->isValid()->willReturn(true);
        $sessionManager->writeClose()->willReturn(null);

        $listener($authEvent->reveal());
    }
}
