<?php

namespace T4web\AuthenticationTest\Adapter;

use T4web\Authentication\Adapter\PhpArray;
use Zend\Authentication\Result;

class PhpArrayTest extends \PHPUnit_Framework_TestCase
{
    private $adapter;

    public function setUp()
    {
        $accounts = [
            'admin' => '111',
        ];

        $this->adapter = new PhpArray($accounts);
    }

    public function testAuthenticate()
    {
        $this->adapter->setIdentity('admin');
        $this->adapter->setCredential('111');

        /** @var Result $result */
        $result = $this->adapter->authenticate();

        $this->assertInstanceOf(Result::class, $result);
        $this->assertTrue($result->isValid());
        $this->assertEquals(Result::SUCCESS, $result->getCode());
        $this->assertEquals('admin', $result->getIdentity());
        $this->assertEmpty($result->getMessages());
    }

    public function testIdentityNotFound()
    {
        $this->adapter->setIdentity('john');
        $this->adapter->setCredential('111');

        /** @var Result $result */
        $result = $this->adapter->authenticate();

        $this->assertInstanceOf(Result::class, $result);
        $this->assertFalse($result->isValid());
        $this->assertEquals(Result::FAILURE_IDENTITY_NOT_FOUND, $result->getCode());
        $this->assertNull($result->getIdentity());
        $this->assertNotEmpty($result->getMessages());
    }

    public function testCredentialInvalid()
    {
        $this->adapter->setIdentity('admin');
        $this->adapter->setCredential('xxx');

        /** @var Result $result */
        $result = $this->adapter->authenticate();

        $this->assertInstanceOf(Result::class, $result);
        $this->assertFalse($result->isValid());
        $this->assertEquals(Result::FAILURE_CREDENTIAL_INVALID, $result->getCode());
        $this->assertNull($result->getIdentity());
        $this->assertNotEmpty($result->getMessages());
    }
}
