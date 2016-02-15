<?php
namespace T4web\Authentication\UnitTest;

use T4web\Authentication\Service as AuthService;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AuthService
     */
    private $authService;

    protected function setUp()
    {
        $authServiceMock = $this->getMockBuilder('Zend\Authentication\AuthenticationService')
            ->disableOriginalConstructor()
            ->getMock();

        $dbAdapterMock = $this->getMockBuilder('Zend\Db\Adapter\Adapter')
            ->disableOriginalConstructor()
            ->getMock();

        $this->authService = new AuthService($authServiceMock, $dbAdapterMock);
    }
/*
    public function testAuthenticate()
    {
        $user = 'user1';
        $pass = 'pass1';
        $message = 'some error message';

        $this->authService->authenticate($user, $pass);
    }
*/
}