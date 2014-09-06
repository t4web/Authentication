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

    protected function _before()
    {
        $this->controller = new IndexController();
    }

    protected function _after()
    {
    }

    public function testLoginFormAction()
    {
        $result = $this->controller->loginFormAction();

        $this->tester->assertEmpty($result);
    }

}