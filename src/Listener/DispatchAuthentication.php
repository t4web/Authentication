<?php

namespace T4web\Authentication\Listener;

use Zend\Authentication\AuthenticationService;
use T4web\Authentication\AuthenticationEvent;

class DispatchAuthentication
{
    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * @param AuthenticationService $authService
     */
    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function __invoke(AuthenticationEvent $e)
    {
        $e->setResult($this->authService->authenticate($e->getAdapter()));
    }
}
