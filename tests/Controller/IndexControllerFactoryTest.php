<?php

namespace T4web\AuthenticationTest\Controller;

use Prophecy\Argument;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\Controller\Plugin\Redirect;
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

        $redirect = $this->prophesize(Redirect::class);
        $plugins->get('redirect')->willReturn($redirect->reveal());

        $auth = $this->prophesize(InteractiveAuth::class);
        $serviceLocator->get(InteractiveAuth::class)->willReturn($auth->reveal());

        $factory = new IndexControllerFactory();

        $controller = $factory->createService($controllerManager->reveal());

        $this->assertTrue($controller instanceof IndexController);
        $this->assertAttributeSame($auth->reveal(), 'auth', $controller);
        $this->assertAttributeSame($redirect->reveal(), 'redirect', $controller);
    }
}
