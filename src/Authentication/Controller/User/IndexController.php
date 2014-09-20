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
        if ($this->isPost()) {
            $username = $this->getFromPost('username');
            $password = $this->getFromPost('password');

            if (!$this->authService->authenticate($username, $password)) {
                return array(
                    'error' => $this->authService->getMessage()
                );
            }
        }
    }

    public function logoutAction()
    {

    }

    protected function getFromPost($name, $default = null)
    {
        return $this->params()->fromPost($name, $default);
    }

    protected function isPost()
    {
        return $this->getRequest()->isPost();
    }
}
