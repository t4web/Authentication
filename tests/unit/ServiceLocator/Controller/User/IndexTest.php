<?php
namespace Authentication\UnitTest\ServiceLocator\Controller\User;

use Authentication\Module;
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\Config;
use Zend\Mvc\Controller\PluginManager as ControllerPluginManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\SharedEventManager;
use Authentication\Controller\User\IndexController;
use Codeception\Util\Stub;
use Authentication\Service as AuthService;

class IndexTest extends \Codeception\TestCase\Test
{
   /**
    * @var \UnitTester
    */
    protected $tester;

    private $serviceManager;
    private $serviceManagerConfig;

    /**
     * @var ControllerManager
     */
    private $controllerManager;

    protected function _before()
    {
        $module = new Module();

        $events = new EventManager();
        $sharedEvents = new SharedEventManager;
        $events->setSharedManager($sharedEvents);

        $plugins = new ControllerPluginManager();
        $this->serviceManager = new ServiceManager();
        $this->serviceManager->setService('Zend\ServiceManager\ServiceLocatorInterface', $this->serviceManager);
        $this->serviceManager->setService('EventManager', $events);
        $this->serviceManager->setService('SharedEventManager', $sharedEvents);
        $this->serviceManager->setService('ControllerPluginManager', $plugins);

        $this->controllerManager = new ControllerManager(new Config($module->getControllerConfig()));
        $this->controllerManager->setServiceLocator($this->serviceManager);
        $this->controllerManager->addPeeringServiceManager($this->serviceManager);
    }

    protected function _after()
    {
    }

    public function testCreation()
    {
        $authService = new AuthService();

        $this->serviceManager->setService('Authentication\Service', $authService);

        $this->assertTrue($this->controllerManager->has('Authentication\Controller\User\Index'));

        $controller = $this->controllerManager->get('Authentication\Controller\User\Index');

        $this->assertAttributeSame($authService, 'authService', $controller);
    }

}