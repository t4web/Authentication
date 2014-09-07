<?php

namespace Authentication\Controller\User;

use Zend\Mvc\Controller\AbstractActionController;
use Authentication\Service as AuthService;

class IndexController extends AbstractActionController
{

    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function loginFormAction()
    {
        // instantiate the authentication service
    }

    public function logoutAction()
    {

    }
}
