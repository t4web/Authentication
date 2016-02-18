<?php

namespace T4web\Authentication;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ControllerProviderInterface,
    BootstrapListenerInterface
{
    public function onBootstrap(EventInterface $e)
    {
        $em  = $e->getApplication()->getEventManager();
        $sm  = $e->getApplication()->getServiceManager();

        $authChecker = $sm->get(Service\Checker::class);

        $em->attach(MvcEvent::EVENT_ROUTE, [$authChecker, 'check'], -100);
    }

    public function getConfig($env = null)
    {
        return include dirname(__DIR__) . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => dirname(__DIR__) . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\User\IndexController::class => function (ControllerManager $cm) {
                    $sl = $cm->getServiceLocator();

                    return new Controller\User\IndexController(
                        $sl->get(Service\Authenticator::class)
                    );
                },
            ]
        ];
    }
}
