<?php

namespace T4web\Authentication\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\Authentication\AuthenticationService;

class CheckerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Authenticator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Checker(new AuthenticationService());
    }
}
