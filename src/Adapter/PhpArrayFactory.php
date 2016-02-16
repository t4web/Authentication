<?php

namespace T4web\Authentication\Adapter;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class PhpArrayFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return PhpArray
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new PhpArray();
    }
}