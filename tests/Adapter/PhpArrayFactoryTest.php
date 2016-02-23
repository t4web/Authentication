<?php

namespace T4web\AuthenticationTest\Adapter;

use Zend\ServiceManager\ServiceLocatorInterface;
use T4web\Authentication\Adapter\PhpArray;
use T4web\Authentication\Adapter\PhpArrayFactory;

class PhpArrayFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $serviceLocator;

    public function setUp()
    {
        $this->serviceLocator = $this->prophesize(ServiceLocatorInterface::class);
        $config = [
            'auth-accounts' => [
                'admin' => '111',
            ]
        ];
        $this->serviceLocator->get('Config')->willReturn($config);
    }

    public function testCreateService()
    {
        $factory = new PhpArrayFactory();

        $adapter = $factory->createService($this->serviceLocator->reveal());

        $this->assertTrue($adapter instanceof PhpArray);
    }
}
