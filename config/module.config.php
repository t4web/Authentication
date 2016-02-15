<?php

use Zend\Mvc\Router\RouteMatch;

return array(

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
                        '__NAMESPACE__' => 'T4webAuthentication\Controller\User',
                        'controller'    => 'Index',
                        'action'        => 'login-form',
                    ),
                ),
            ),
            'auth-logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'T4webAuthentication\Controller\User',
                        'controller'    => 'Index',
                        'action'        => 'logout',
                    ),
                ),
            ),
        ),
    ),

    'console' => array(
        'router' => array(
            'routes' => array(
                'auth-init' => array(
                    'options' => array(
                        'route'    => 'auth init',
                        'defaults' => array(
                            '__NAMESPACE__' => 'T4webAuthentication\Controller\Console',
                            'controller' => 'Init',
                            'action'     => 'run'
                        )
                    )
                ),
            )
        )
    ),

    'db' => array(
        'tables' => array(
            't4webauthentication-entry' => array(
                'name' => 'auth',
                'columnsAsAttributesMap' => array(
                    'id' => 'id',
                    'login' => 'login',
                    'password' => 'password',
                ),
            ),
        ),
    ),

    'criteries' => array(
        'Entry' => array(
            'empty' => array('table' => 'auth'),
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
    }
);
