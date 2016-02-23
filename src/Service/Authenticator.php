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
        $event = new AuthenticationEvent();
        $event->setTarget($this);

        if (!$adapter) {
            $adapter = $this->adapter;
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

    public function hasIdentity()
    {
        return $this->authService->hasIdentity();
    }
}
