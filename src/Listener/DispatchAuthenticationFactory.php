<?php
namespace T4web\Authentication\Listener;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\Session\SessionManager;
use Zend\Authentication\AuthenticationService;

class DispatchAuthenticationFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return SessionWrite
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new DispatchAuthentication(new AuthenticationService());
    }
}
