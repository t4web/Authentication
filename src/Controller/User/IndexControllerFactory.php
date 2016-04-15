<?php

namespace T4web\Authentication\Controller\User;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Controller\Plugin\Redirect;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\Mvc\Application;
use T4web\Authentication\Service\InteractiveAuth;

class IndexControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $cm
     * @return IndexController
     */
    public function createService(ServiceLocatorInterface $cm)
    {
        $sl = $cm->getServiceLocator();

        $plugins = $sl->get('ControllerPluginManager');

        /** @var Application $app */
        $app = $sl->get('Application');
        $event = $app->getMvcEvent();

        /** @var RouteMatch $routeMatch */
        $routeMatch = $event->getRouteMatch();

        if ($routeMatch->getParam('layout')) {
            $viewModel = $event->getViewModel();
            $viewModel->setTemplate($routeMatch->getParam('layout'));
        }

        /** @var Redirect $redirect */
        $redirect = $plugins->get('redirect');

        $controller = new IndexController(
            $sl->get(InteractiveAuth::class),
            $redirect
        );

        $redirect->setController($controller);

        return $controller;
    }
}
