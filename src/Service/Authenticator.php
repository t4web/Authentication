<?php

namespace T4web\Authentication\Service;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result as AuthResult;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\EventManager\EventManager;
use T4web\Authentication\AuthenticationEvent;

class Authenticator extends AuthenticationService
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

    /**
     * @param AuthenticationService $authService
     * @param AdapterInterface $adapter
     */
    public function __construct(AuthenticationService $authService, AdapterInterface $adapter)
    {
        $this->authService = $authService;
        $this->adapter = $adapter;
    }

    /**
     * @param AdapterInterface|null $adapter
     * @return AuthResult
     */
    public function authenticate(AdapterInterface $adapter = null)
    {
        // Attempt authentication, saving the result
//        /* @var $result AuthResult */
//        $this->result = $this->authService->authenticate($this->adapter);
//
//        if (!$this->result->isValid()) {
//            return false;
//        }
//
//        $this->authService->getStorage()->write(
//            ['id' => $this->result->getIdentity()]
//        );
//
//        return true;

        $event = new AuthenticationEvent();
        $event->setTarget($this);

        if (!$adapter) {
            $adapter = $this->getAdapter();
        }

        if ($adapter) {
            $event->setAdapter($adapter);
        }

        $eventManager = new EventManager();
        $eventManager->setIdentifiers(get_class($this));

        $eventManager->trigger($event);

        return $event->getResult();
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
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
