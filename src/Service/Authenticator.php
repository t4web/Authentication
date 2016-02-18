<?php

namespace T4web\Authentication\Service;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result as AuthResult;
use Zend\Authentication\Adapter\AdapterInterface;

class Authenticator
{

    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * @var AuthResult
     */
    protected $result;

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    public function __construct(AuthenticationService $authService, AdapterInterface $adapter)
    {
        $this->authService = $authService;
        $this->adapter = $adapter;
    }

    public function authenticate($username, $password)
    {
        $this->adapter->setIdentity($username);
        $this->adapter->setCredential($password);

        // Attempt authentication, saving the result
        /* @var $result AuthResult */
        $this->result = $this->authService->authenticate($this->adapter);

        if (!$this->result->isValid()) {
            return false;
        }

        $this->authService->getStorage()->write(
            ['id' => $this->result->getIdentity()]
        );

        return true;
    }

    public function getMessages()
    {
        return $this->result->getMessages()[0];
    }

    public function hasIdentity()
    {
        return $this->authService->hasIdentity();
    }

    public function getIdentity()
    {
        return $this->authService->getIdentity();
    }

    public function getUserId()
    {
        $storage = $this->authService->getStorage()->read();

        if (!isset($storage['id'])) {
            return false;
        }

        return $storage['id'];
    }

    public function logout()
    {
        $this->authService->clearIdentity();
    }
}
