<?php
namespace T4webAuthentication\UnitTest\ServiceLocator\Controller\User;

use T4webAuthentication\Module;
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\Config;
use Zend\Mvc\Controller\PluginManager as ControllerPluginManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\SharedEventManager;
use T4webAuthentication\Controller\User\IndexController;
use Codeception\Util\Stub;
use T4webAuthentication\Service as AuthService;

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
        $authServiceMock = $this->getMockBuilder('Zend\Authentication\AuthenticationService')
            ->disableOriginalConstructor()
            ->getMock();

        $dbAdapterMock = $this->getMockBuilder('Zend\Db\Adapter\Adapter')
            ->disableOriginalConstructor()
            ->getMock();

        $authService = new AuthService($authServiceMock, $dbAdapterMock);

        $this->serviceManager->setService('T4webAuthentication\Service', $authService);

        $this->assertTrue($this->controllerManager->has('T4webAuthentication\Controller\User\Index'));

        $controller = $this->controllerManager->get('T4webAuthentication\Controller\User\Index');

        $this->assertAttributeSame($authService, 'authService', $controller);
    }

}