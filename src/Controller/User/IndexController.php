<?php

namespace T4web\Authentication\Controller\User;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\Plugin\Redirect;
use T4web\Authentication\Service\InteractiveAuth;

class IndexController extends AbstractActionController
{
    /**
     * @var InteractiveAuth
     */
    private $auth;

    /**
     * @var Redirect
     */
    private $redirect;

    /**
     * @param InteractiveAuth $auth
     * @param Redirect $redirect
     */
    public function __construct(InteractiveAuth $auth, Redirect $redirect)
    {
        $this->auth = $auth;
        $this->redirect = $redirect;
    }

    public function loginFormAction()
    {
        if (!$this->getRequest()->isPost()) {
            return;
        }

        $username = $this->getRequest()->getPost('username');
        $password = $this->getRequest()->getPost('password');

        $result = $this->auth->login($username, $password);

        if (!$result->isValid()) {
            $view = new ViewModel();
            $view->errorMessage = $result->getMessages()[0];
            return $view;
        }

        return $this->redirect->toUrl('/');
    }

    public function logoutAction()
    {
        $this->auth->logout();
        return $this->redirect->toRoute('auth-login');
    }
}
