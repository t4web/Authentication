<?php

namespace T4web\Authentication\Controller\User;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use T4web\Authentication\Service as AuthService;

class IndexController extends AbstractActionController
{

    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function loginFormAction()
    {
        $this->layout('layout/auth');

        if ($this->isPost()) {
            $username = $this->getFromPost('username');
            $password = $this->getFromPost('password');

            if (!$this->authService->authenticate($username, $password)) {
                $view = new ViewModel();
                $view->errorMessage = $this->authService->getMessages();
                return $view;
            }

            return $this->redirect()->toUrl('/');
        }
    }

    public function logoutAction()
    {
        $this->authService->logout();
        return $this->redirect()->toRoute('auth-login');
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
