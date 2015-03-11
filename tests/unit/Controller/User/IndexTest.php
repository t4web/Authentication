<?php
namespace Authentication\UnitTest\Controller\User;

class IndexTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Authentication\Controller\User\IndexController
     */
    private $controller;

    /**
     * @var \Authentication\Service
     */
    private $authServiceMock;

    protected function setUp()
    {
        $this->authServiceMock = $this->getMockBuilder('Authentication\Service')
            ->disableOriginalConstructor()
            ->getMock();
        $this->controller = $this->getMock(
            'Authentication\Controller\User\IndexController',
            array('getFromPost', 'isPost', 'redirect'),
            array($this->authServiceMock)
        );
    }

    public function testLoginFormActionThroughGet()
    {
        $this->controller->expects($this->once())
            ->method('isPost')
            ->will($this->returnValue(false));

        $this->authServiceMock->expects($this->never())
            ->method('authenticate');

        $result = $this->controller->loginFormAction();

        $this->assertEmpty($result);
    }

    public function testLoginFormActionWithBadParamsThroughPost()
    {
        $user = 'user1';
        $pass = 'pass1';
        $message = 'some error message';

        $this->controller->expects($this->once())
            ->method('isPost')
            ->will($this->returnValue(true));

        $this->controller->expects($this->at(1))
            ->method('getFromPost')
            ->with($this->equalTo('username'))
            ->will($this->returnValue($user));

        $this->controller->expects($this->at(2))
            ->method('getFromPost')
            ->with($this->equalTo('password'))
            ->will($this->returnValue($pass));

        $this->authServiceMock->expects($this->once())
            ->method('authenticate')
            ->with($user, $pass)
            ->will($this->returnValue(false));

        $this->authServiceMock->expects($this->once())
            ->method('getMessages')
            ->will($this->returnValue($message));

        $result = $this->controller->loginFormAction();

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $this->assertNotEmpty($result->errorMessage);
    }

    public function testLoginFormActionWithGoodParamsThroughPost()
    {
        return $this->markTestIncomplete();

        $user = 'user1';
        $pass = 'pass1';

        $this->controller->expects($this->once())
            ->method('isPost')
            ->will($this->returnValue(true));

        $this->controller->expects($this->at(1))
            ->method('getFromPost')
            ->with($this->equalTo('username'))
            ->will($this->returnValue($user));

        $this->controller->expects($this->at(2))
            ->method('getFromPost')
            ->with($this->equalTo('password'))
            ->will($this->returnValue($pass));

        $this->authServiceMock->expects($this->once())
            ->method('authenticate')
            ->with($user, $pass)
            ->will($this->returnValue(true));

        $result = $this->controller->loginFormAction();

        //$this->assertEmpty($result);
    }
}