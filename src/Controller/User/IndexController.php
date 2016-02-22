<?php

namespace T4web\Authentication\Controller\User;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use T4web\Authentication\Service\InteractiveAuth;

class IndexController extends AbstractActionController
{
    /**
     * @var InteractiveAuth
     */
    private $auth;

    /**
     * @param InteractiveAuth $auth
     */
    public function __construct(InteractiveAuth $auth)
    {
        $this->auth = $auth;
    }

    public function loginFormAction()
    {
        if ($this->isPost()) {
            $username = $this->getFromPost('username');
            $password = $this->getFromPost('password');

            $result = $this->auth->login($username, $password);

            if (!$result->isValid()) {
                $view = new ViewModel();
                $view->errorMessage = $result->getMessages()[0];
                return $view;
            }

            return $this->redirect()->toUrl('/');
        }
    }

    public function logoutAction()
    {
        $this->auth->logout();
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
