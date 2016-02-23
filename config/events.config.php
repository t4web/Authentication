<?php

namespace T4web\Authentication;

use Zend\Mvc\MvcEvent;

return [
    Service\Authenticator::class => [
        AuthenticationEvent::EVENT_AUTH => [
            Listener\DispatchAuthentication::class,
            Listener\SessionWrite::class,
        ]
    ],

    'Zend\Mvc\Application' => [
        MvcEvent::EVENT_ROUTE => [
            Service\Checker::class,
        ]
    ]
];
