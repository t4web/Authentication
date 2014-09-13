<?php
namespace Controller\User;

use Authentication\Controller\User\IndexController;

class IndexTest extends \Codeception\TestCase\Test
{
   /**
    * @var \UnitTester
    */
    protected $tester;

    private $controller;
    private $authService;

    protected function _before()
    {
//        $this->authService = $this->getMockBuilder('Authentication\Service')
//            ->disableOriginalConstructor()
//            ->getMock();
//        $this->controller = new IndexController($this->authService);
    }

    protected function _after()
    {
    }

    public function testLoginFormAction()
    {
//        $result = $this->controller->loginFormAction();
//
//        $this->tester->assertEmpty($result);
    }

}