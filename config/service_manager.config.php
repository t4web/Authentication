<?php

namespace T4web\Authentication;

use Zend\Authentication\Adapter\AdapterInterface;

return [
    'factories' => [
        AdapterInterface::class => Adapter\PhpArrayFactory::class,
        Service\Checker::class => Service\CheckerFactory::class,
        Service\Authenticator::class => Service\AuthenticatorFactory::class,
    ],
];
