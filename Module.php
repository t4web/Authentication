<?php

namespace T4webAuthentication;

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
use T4webBase\Domain\Service\BaseFinder as ServiceFinder;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface,
                        ControllerProviderInterface, ServiceProviderInterface,
                        BootstrapListenerInterface, ConsoleUsageProviderInterface
{
    public function onBootstrap(EventInterface $e)
    {
        $em  = $e->getApplication()->getEventManager();
        $sm  = $e->getApplication()->getServiceManager();

        $auth = $sm->get('T4webAuthentication\Service');

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
                'T4webAuthentication\Service' => function (ServiceManager $sm) {
                    return new Service(
                        new AuthenticationService(),
                        $sm->get('Zend\Db\Adapter\Adapter')
                    );
                },

                'T4webAuthentication\Entry\Repository\DbRepository' => function (ServiceManager $sm) {
                    $eventManager = $sm->get('EventManager');
                    $eventManager->addIdentifiers('T4webAuthentication\Entry\Repository\DbRepository');

                    return new Entry\Repository\DbRepository(
                        $sm->get('T4webAuthentication\Entry\Db\Table'),
                        $sm->get('T4webAuthentication\Entry\Mapper\DbMapper'),
                        $sm->get('T4webBase\Db\QueryBuilder'),
                        clone $sm->get('T4webBase\Domain\Repository\IdentityMap'),
                        clone $sm->get('T4webBase\Domain\Repository\IdentityMap'),
                        $eventManager
                    );
                },

                'T4webAuthentication\Entry\Service\Finder' => function (ServiceManager $sm) {
                    return new ServiceFinder(
                        $sm->get('T4webAuthentication\Entry\Repository\DbRepository'),
                        $sm->get('T4webAuthentication\Entry\Criteria\CriteriaFactory')
                    );
                },
            )
        );
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'T4webAuthentication\Controller\Console\Init' => function (ControllerManager $cm) {
                    $sl = $cm->getServiceLocator();

                    return new Controller\Console\InitController(
                        $sl->get('Zend\Db\Adapter\Adapter')
                    );
                },

                'T4webAuthentication\Controller\User\Index' => function (ControllerManager $cm) {
                    $sl = $cm->getServiceLocator();

                    return new Controller\User\IndexController(
                        $sl->get('T4webAuthentication\Service')
                    );
                },
            )
        );
    }
}
