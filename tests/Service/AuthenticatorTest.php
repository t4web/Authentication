<?php

namespace T4web\AuthenticationTest\Service;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\EventManager\StaticEventManager;
use T4web\Authentication\Service\Authenticator;
use T4web\Authentication\AuthenticationEvent;

class AuthenticatorTest extends \PHPUnit_Framework_TestCase
{
    public function testAuthenticate()
    {
        $authService = $this->prophesize(AuthenticationService::class);
        $adapter = $this->prophesize(AdapterInterface::class);
        $result = $this->prophesize(Result::class);

        $authenticator = new Authenticator($authService->reveal(), $adapter->reveal());

        $eventManager = StaticEventManager::getInstance();
        // event will be raised
        $eventManager->attach(
            Authenticator::class,
            AuthenticationEvent::EVENT_AUTH,
            function ($e) use ($result) {
                $this->assertInstanceOf(AuthenticationEvent::class, $e);

                $e->setResult($result->reveal());
            }
        );

        $returnedResult = $authenticator->authenticate();

        $this->assertSame($result->reveal(), $returnedResult);
    }

    public function testHasIdentity()
    {
        $authService = $this->prophesize(AuthenticationService::class);
        $adapter = $this->prophesize(AdapterInterface::class);

        $authenticator = new Authenticator($authService->reveal(), $adapter->reveal());

        $authService->hasIdentity()->willReturn(true);

        $result = $authenticator->hasIdentity();

        $this->assertTrue($result);
    }
}
