<?php
namespace T4web\Authentication\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\Session\SessionManager;

class InteractiveAuthFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return InteractiveAuth
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $authService Authenticator */
        $authService = $serviceLocator->get('T4web\Authentication\Service\Authenticator');
        /** @var $sessionManager SessionManager */
        $sessionManager = $serviceLocator->get('Zend\Session\SessionManager');

        return new InteractiveAuth($authService, $sessionManager);
    }
}
