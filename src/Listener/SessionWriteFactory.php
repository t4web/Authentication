<?php
namespace T4web\Authentication\Listener;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\Session\SessionManager;

class SessionWriteFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return SessionWrite
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new SessionWrite($serviceLocator->get('Zend\Session\SessionManager'));
    }
}
