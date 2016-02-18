<?php

namespace T4web\Authentication\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\AuthenticationService;

class AuthenticatorFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Authenticator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Authenticator(
            new AuthenticationService(),
            $serviceLocator->get(AdapterInterface::class)
        );
    }
}
