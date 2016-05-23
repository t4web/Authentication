<?php

namespace T4web\Authentication;

use Zend\Mvc\Router\RouteMatch;

return array(

    'service_manager' => require_once 'service_manager.config.php',
    'controllers' => require_once 'controllers.config.php',
    'events' => require_once 'events.config.php',

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'router' => array(
        'routes' => array(
            'auth-login' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/login-form',
                    'defaults' => array(
                        'controller'    => Controller\User\IndexController::class,
                        'action'        => 'login-form',
                    ),
                ),
            ),
            'auth-logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        'controller'    => Controller\User\IndexController::class,
                        'action'        => 'logout',
                    ),
                ),
            ),
        ),
    ),

    // if true = authorization needed
    'need-authorization-callback' => function(RouteMatch $match) {
        $name = $match->getMatchedRouteName();

        if ($name == 'auth-login') {
            return false;
        }

        if (strpos($name, 'admin') !== false) {
            return true;
        }

        return false;
    },

    'authorized-redirect-to-route' => function(RouteMatch $match) {
        $name = $match->getMatchedRouteName();

        if ($name == 'auth-login') {
            return 'home';
        }
    },

    // for php array adapter
    'auth-accounts' => [
        'admin' => '111',
    ],

    // for table adapter
    'auth' => [
        'table-adapter' => [
            'table-name' => 'users',
            'identity-column' => 'email',
            'credential-column' => 'password',
        ],
    ],
);
