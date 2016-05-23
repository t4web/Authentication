<?php

namespace T4web\Authentication;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\AuthenticationService;

return [
    'factories' => [
        AdapterInterface::class => Adapter\PhpArrayFactory::class,
        Service\Checker::class => Service\CheckerFactory::class,
        Service\Authenticator::class => Service\AuthenticatorFactory::class,
        Service\InteractiveAuth::class => Service\InteractiveAuthFactory::class,

        Listener\DispatchAuthentication::class => Listener\DispatchAuthenticationFactory::class,
        Listener\SessionWrite::class => Listener\SessionWriteFactory::class,
    ],
    'aliases' => [
        AuthenticationService::class => Service\Authenticator::class,
    ],
];
