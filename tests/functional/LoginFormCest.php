<?php

namespace T4web\Authentication\FunctionalTest;
/*
use T4web\Authentication\FunctionalTester;
use T4web\Authentication\Controller\User\IndexController;
use Zend\Http\Request as HttpRequest;
use Zend\Mvc\Router\RouteMatch;

class LoginFormCest
{
    protected $event;
    protected $routeMatch;
    protected $stdOutWriter;
    protected $application;

    public function _before(FunctionalTester $I)
    {
        $this->application = $I->getApplication();
        $this->event = $this->application->getMvcEvent();

        $this->routeMatch = new RouteMatch(
            array(
                'controller' => 'T4web\Authentication\Controller\User\Index',
            )
        );
        $this->event->setRouteMatch($this->routeMatch);
    }

    // tests
    public function tryLoginForm(FunctionalTester $I)
    {
        $I->wantTo("Check Login form");

        $this->routeMatch->setParam('action', 'loginForm');

        $controller = new IndexController(
            $this->application->getServiceManager()->get('T4web\Authentication\Service')
        );

        $controller->setEvent($this->event);
        $controller->setEventManager($this->application->getEventManager());
        $controller->setServiceLocator($this->application->getServiceManager());

        $result = $controller->dispatch(new HttpRequest());

        /** @var Zend\Http\PhpEnvironment\Response $response /
        $response = $controller->getResponse();

        \PHPUnit_Framework_Assert::assertEquals(200, $response->getStatusCode());
        \PHPUnit_Framework_Assert::assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }
}
*/