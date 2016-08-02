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
     * @var string
     */
    private $redirectToUrl;

    /**
     * IndexController constructor.
     *
     * @param InteractiveAuth $auth
     * @param Redirect        $redirect
     * @param string          $redirectToUrl
     */
    public function __construct(
        InteractiveAuth $auth,
        Redirect $redirect,
        $redirectToUrl = '/'
    )
    {
        $this->auth = $auth;
        $this->redirect = $redirect;
        $this->redirectToUrl = $redirectToUrl;
    }

    public function loginFormAction()
    {
        if (!$this->getRequest()->isPost()) {
            return;
        }

        $username = $this->getRequest()->getPost('username');
        $password = $this->getRequest()->getPost('password');
        
        if (empty($username) || empty($password)) {
            $view = new ViewModel();
            $view->errorMessage = 'User name or pass cannot be empty.';
            return $view;
        }

        $result = $this->auth->login($username, $password);

        if (!$result->isValid()) {
            $view = new ViewModel();
            $view->errorMessage = $result->getMessages()[0];
            return $view;
        }

        return $this->redirect->toUrl($this->redirectToUrl);
    }

    public function logoutAction()
    {
        $this->auth->logout();
        return $this->redirect->toUrl($this->redirectToUrl);
    }
}
