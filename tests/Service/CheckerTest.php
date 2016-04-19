<?php

namespace T4web\AuthenticationTest\Service;

use Zend\Authentication\AuthenticationService;
use Zend\EventManager\StaticEventManager;
use Zend\Console\Request as ConsoleRequest;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\RouteStackInterface;
use Zend\Mvc\Application;
use Prophecy\Argument;
use T4web\Authentication\Service\Checker;

class CheckerTest extends \PHPUnit_Framework_TestCase
{
    private $authService;
    private $event;
    private $checker;

    public function setUp()
    {
        $this->authService = $this->prophesize(AuthenticationService::class);
        $this->event = $this->prophesize(MvcEvent::class);

        $this->checker = new Checker($this->authService->reveal());
    }

    public function testInvokeConsoleRequest()
    {
        $this->event->getRequest()->willReturn($this->prophesize(ConsoleRequest::class)->reveal());

        $result = $this->checker->__invoke($this->event->reveal());

        $this->assertNull($result);
    }

    public function test404Request()
    {
        $this->event->getRequest()->willReturn(true);
        $this->event->getRouteMatch()->willReturn(true);

        $result = $this->checker->__invoke($this->event->reveal());

        $this->assertNull($result);

    }

    public function testSkipLoginRequestWhenAuthorized()
    {
        $routeMatch = $this->prophesize(RouteMatch::class);
        $router = $this->prophesize(RouteStackInterface::class);
        $router->assemble(Argument::cetera())->willReturn('/');

        $this->event->getRouter()->willReturn($router->reveal());
        $this->event->getRequest()->willReturn(true);
        $this->event->getRouteMatch()->willReturn($routeMatch->reveal());
        $this->authService->hasIdentity()->willReturn(true);

        $routeMatch->getMatchedRouteName()->willReturn('auth-login');

        $app = $this->prophesize(Application::class);
        $this->event->getParam('application')->willReturn($app->reveal());

        $app->getConfig()->willReturn([
            'authorized-redirect-to-route' => function ($match, $authService) use ($routeMatch) {
                $this->assertSame($routeMatch->reveal(), $match);
                $this->assertSame($this->authService->reveal(), $authService);
                return 'home';
            }
        ]);

        $response = new Response();
        $this->event->getResponse()->willReturn($response);

        $result = $this->checker->__invoke($this->event->reveal());

        $this->assertSame($response, $result);

    }

    public function testAuthorizationCallback()
    {
        $routeMatch = $this->prophesize(RouteMatch::class);

        $this->event->getRequest()->willReturn(true);
        $this->event->getRouteMatch()->willReturn($routeMatch->reveal());
        $this->authService->hasIdentity()->willReturn(false);

        $routeMatch->getMatchedRouteName()->willReturn('some');

        $app = $this->prophesize(Application::class);
        $this->event->getParam('application')->willReturn($app->reveal());

        $app->getConfig()->willReturn([
            'need-authorization-callback' => function ($match, $authService) use ($routeMatch) {
                $this->assertSame($routeMatch->reveal(), $match);
                $this->assertSame($this->authService->reveal(), $authService);
                return;
            },
            'authorized-redirect-to-route' => function ($match, $authService) use ($routeMatch) {}
        ]);

        $result = $this->checker->__invoke($this->event->reveal());

        $this->assertNull($result);
    }

    public function testRedirectToLoginPage()
    {
        $routeMatch = $this->prophesize(RouteMatch::class);
        $router = $this->prophesize(RouteStackInterface::class);
        $router->assemble(Argument::cetera())->willReturn('/');

        $this->event->getRouter()->willReturn($router->reveal());
        $this->event->getRequest()->willReturn(true);
        $this->event->getRouteMatch()->willReturn($routeMatch->reveal());
        $this->authService->hasIdentity()->willReturn(false);

        $routeMatch->getMatchedRouteName()->willReturn('some');

        $app = $this->prophesize(Application::class);
        $this->event->getParam('application')->willReturn($app->reveal());

        $app->getConfig()->willReturn([
            'need-authorization-callback' => function ($match, $authService) use ($routeMatch) {
                $this->assertSame($routeMatch->reveal(), $match);
                $this->assertSame($this->authService->reveal(), $authService);
                return true;
            },
            'authorized-redirect-to-route' => function ($match, $authService) use ($routeMatch) {}
        ]);

        $response = new Response();
        $this->event->getResponse()->willReturn($response);

        $result = $this->checker->__invoke($this->event->reveal());

        $this->assertSame($response, $result);
    }
}
