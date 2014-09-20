<?php
namespace Authentication\UnitTest;

use Authentication\Service as AuthService;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AuthService
     */
    private $authService;

    protected function setUp()
    {
        $this->authService = new AuthService();
    }

    public function testAuthenticate()
    {
        $user = 'user1';
        $pass = 'pass1';
        $message = 'some error message';

        $this->authService->authenticate($user, $pass);
    }

}