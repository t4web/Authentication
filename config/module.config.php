<?php

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
                        '__NAMESPACE__' => 'T4web\Authentication\Controller\User',
                        'controller'    => 'IndexController',
                        'action'        => 'login-form',
                    ),
                ),
            ),
            'auth-logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'T4web\Authentication\Controller\User',
                        'controller'    => 'IndexController',
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

    'auth-accounts' => [
        'admin' => '111',
    ],
);
