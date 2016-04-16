<?php

namespace T4web\AuthenticationTest\Controller;

use Prophecy\Argument;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\Controller\Plugin\Redirect;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\View\Model\ViewModel;
use T4web\Authentication\Controller\User\IndexController;
use T4web\Authentication\Controller\User\IndexControllerFactory;
use T4web\Authentication\Service\InteractiveAuth;

class IndexControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class);

        $controllerManager = $this->prophesize(ControllerManager::class);
        $controllerManager->getServiceLocator()->willReturn($serviceLocator);

        $plugins = $this->prophesize(ControllerManager::class);
        $serviceLocator->get('ControllerPluginManager')->willReturn($plugins);

        $app = $this->prophesize(Application::class);
        $serviceLocator->get('Application')->willReturn($app);

        $event = $this->prophesize(MvcEvent::class);
        $app->getMvcEvent()->willReturn($event);

        $routeMatch = $this->prophesize(RouteMatch::class);
        $event->getRouteMatch()->willReturn($routeMatch);

        $routeMatch->getParam('layout')->willReturn('some/layout');

        $viewModel = $this->prophesize(ViewModel::class);
        $event->getViewModel()->willReturn($viewModel);

        $routeMatch->getParam('redirect-to-url')->willReturn('/some/uri');

        $viewModel->setTemplate('some/layout')->willReturn(null);

        $redirect = $this->prophesize(Redirect::class);
        $plugins->get('redirect')->willReturn($redirect->reveal());

        $auth = $this->prophesize(InteractiveAuth::class);
        $serviceLocator->get(InteractiveAuth::class)->willReturn($auth->reveal());

        $factory = new IndexControllerFactory();

        $controller = $factory->createService($controllerManager->reveal());

        $this->assertTrue($controller instanceof IndexController);
        $this->assertAttributeSame($auth->reveal(), 'auth', $controller);
        $this->assertAttributeSame($redirect->reveal(), 'redirect', $controller);
        $this->assertAttributeSame('/some/uri', 'redirectToUrl', $controller);
    }
}
