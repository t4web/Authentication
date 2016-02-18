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
        $config = $serviceLocator->get('Config');

        $authAccounts = [];
        if (isset($config['auth-accounts']) && is_array($config['auth-accounts'])) {
            $authAccounts = $config['auth-accounts'];
        }

        return new PhpArray($authAccounts);
    }
}
