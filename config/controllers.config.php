<?php

namespace T4web\Authentication;

use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\Controller\Plugin\Redirect;

return [
    'factories' => [
        Controller\User\IndexController::class => function (ControllerManager $cm) {
            $sl = $cm->getServiceLocator();

            $plugins = $sl->get('ControllerPluginManager');

            /** @var Redirect $redirect */
            $redirect = $plugins->get('redirect');

            $controller = new Controller\User\IndexController(
                $sl->get(Service\InteractiveAuth::class),
                $redirect
            );

            $redirect->setController($controller);

            return $controller;
        },
    ],
];
