<?php

namespace T4web\AuthenticationTest\Controller;

use Zend\Mvc\Controller\Plugin\Redirect;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Stdlib\Parameters;
use Zend\Authentication\Result;
use T4web\Authentication\Controller\User\IndexController;
use T4web\Authentication\Service\InteractiveAuth;

class IndexControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IndexController
     */
    private $controller;

    private $redirect;

    private $auth;

    public function setUp()
    {
        $this->redirect = $this->prophesize(Redirect::class);
        $this->auth = $this->prophesize(InteractiveAuth::class);

        $this->controller = new IndexController(
            $this->auth->reveal(),
            $this->redirect->reveal()
        );
    }

    public function testNotPostLogin()
    {
        /** @var Request $request */
        $request = $this->controller->getRequest();
        $request->setMethod(Request::METHOD_GET);

        $res = $this->controller->loginFormAction();

        $this->assertNull($res);
    }

    public function testValidPostLogin()
    {
        /** @var Request $request */
        $request = $this->controller->getRequest();
        $request->setMethod(Request::METHOD_POST);
        $request->setPost(new Parameters([
            'username' => 'aaa',
            'password' => '111',
        ]));

        $result = $this->prophesize(Result::class);

        $this->auth->login('aaa', '111')->willReturn($result->reveal());

        $result->isValid()->willReturn(true);

        $response = $this->prophesize(Response::class);
        $this->redirect->toUrl('/')->willReturn($response->reveal());

        $res = $this->controller->loginFormAction();

        $this->assertSame($response->reveal(), $res);
    }

    public function testNotValidPostLogin()
    {
        /** @var Request $request */
        $request = $this->controller->getRequest();
        $request->setMethod(Request::METHOD_POST);
        $request->setPost(new Parameters([
            'username' => 'aaa',
            'password' => '111',
        ]));

        $result = $this->prophesize(Result::class);

        $this->auth->login('aaa', '111')->willReturn($result->reveal());

        $result->isValid()->willReturn(false);
        $result->getMessages()->willReturn(['Some error']);

        $res = $this->controller->loginFormAction();

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $res);
    }

    public function testLogout()
    {
        $this->auth->logout()->willReturn(null);
        $response = $this->prophesize(Response::class);
        $this->redirect->toUrl('/')->willReturn($response->reveal());

        $res = $this->controller->logoutAction();

        $this->assertSame($response->reveal(), $res);
    }
}
