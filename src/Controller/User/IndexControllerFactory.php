<?php

namespace T4web\Authentication\Controller\User;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Controller\Plugin\Redirect;
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
