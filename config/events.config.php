<?php

namespace T4web\Authentication;

return [
    Service\Authenticator::class => [
        AuthenticationEvent::EVENT_AUTH => [
            Listener\DispatchAuthentication::class,
            Listener\SessionWrite::class,
        ]
    ],
];
