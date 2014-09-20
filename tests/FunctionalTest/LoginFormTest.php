<?php

namespace Authentication\FunctionalTest;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class LoginFormTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $sitepath = dirname(dirname(dirname(dirname(dirname(__DIR__)))));

        $this->setApplicationConfig(
            include $sitepath . '/config/application.config.php'
        );
        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/login-form');
        $this->assertResponseStatusCode(200);

        $this->assertQuery('input[name="username"]');
        $this->assertQuery('input[name="password"]');
        $this->assertQuery('button[type="submit"]');
    }
}