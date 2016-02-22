<?php

namespace T4web\Authentication;

use Zend\Mvc\Controller\ControllerManager;

return [
    'factories' => [
        Controller\User\IndexController::class => function (ControllerManager $cm) {
            $sl = $cm->getServiceLocator();

            return new Controller\User\IndexController(
                $sl->get(Service\InteractiveAuth::class)
            );
        },
    ],
];
