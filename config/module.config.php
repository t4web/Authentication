<?php

return array(

    'view_manager' => array(
        'template_path_stack' => array(
            'authentication' => __DIR__ . '/../view',
        ),
    ),

    'router' => array(
        'routes' => array(
            'auth-login' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/login-form',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Authentication\Controller\User',
                        'controller'    => 'Index',
                        'action'        => 'login-form',
                    ),
                ),
            ),
        ),
    ),
);
