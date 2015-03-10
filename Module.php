<?php

namespace Authentication;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as ConsoleAdapterInterface;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;
use Zend\Authentication\AuthenticationService;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface,
                        ControllerProviderInterface, ServiceProviderInterface,
                        BootstrapListenerInterface, ConsoleUsageProviderInterface
{
    public function onBootstrap(EventInterface $e)
    {
        $em  = $e->getApplication()->getEventManager();
        $sm  = $e->getApplication()->getServiceManager();

        $auth = $sm->get('Authentication\Service');

        $em->attach(MvcEvent::EVENT_ROUTE, array($auth, 'checkAuthentication'), -100);
    }

    public function getConfig($env = null)
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConsoleUsage(ConsoleAdapterInterface $console)
    {
        return array(
            'auth init' => 'Initialize module',
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Authentication\Service' => function (ServiceManager $sm) {
                    return new Service(
                        new AuthenticationService(),
                        $sm->get('Zend\Db\Adapter\Adapter')
                    );
                },
            )
        );
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'Authentication\Controller\Console\Init' => function (ControllerManager $cm) {
                    $sl = $cm->getServiceLocator();

                    return new Controller\Console\InitController(
                        $sl->get('Zend\Db\Adapter\Adapter')
                    );
                },

                'Authentication\Controller\User\Index' => function (ControllerManager $cm) {
                    $sl = $cm->getServiceLocator();

                    return new Controller\User\IndexController(
                        $sl->get('Authentication\Service')
                    );
                },
            )
        );
    }
}
