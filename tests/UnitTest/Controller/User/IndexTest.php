<?php
namespace Authentication\UnitTest\Controller\User;

use Authentication\Controller\User\IndexController;

class IndexTest extends \PHPUnit_Framework_TestCase
{

    private $controller;
    private $authService;

    protected function setUp()
    {
        $this->authService = $this->getMockBuilder('Authentication\Service')
            ->disableOriginalConstructor()
            ->getMock();
        $this->controller = new IndexController($this->authService);
    }

    public function testLoginFormAction()
    {
        $result = $this->controller->loginFormAction();

        $this->assertEmpty($result);
    }

}