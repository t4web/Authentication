<?php

namespace T4webAuthentication;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;
use Zend\Authentication\Result as AuthResult;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Console\Request as ConsoleRequest;

class Service {

    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     *
     * @var AuthResult
     */
    protected $result;

    /**
     * @var DbAdapter
     */
    protected $dbAdapter;

    public function __construct(AuthenticationService $authService, DbAdapter $dbAdapter) {
        $this->authService = $authService;
        $this->dbAdapter = $dbAdapter;
    }

    public function checkAuthentication(MvcEvent $event)
    {
        $match = $event->getRouteMatch();

        // No route match, this is a 404
        if (!$match instanceof RouteMatch) {
            return;
        }

        if ($event->getRequest() instanceof ConsoleRequest) {
            return;
        }

        $name = $match->getMatchedRouteName();
        if ($name == 'auth-login') {
            return;
        }

        // User is authenticated
        if ($this->hasIdentity()) {
           return;
        }

        // Redirect to the user login page, as an example
        $router   = $event->getRouter();
        $url      = $router->assemble(array(), array('name' => 'auth-login'));

        $response = $event->getResponse();
        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->setStatusCode(302);
        $response->setReasonPhrase('Unauthorized');

        return $response;
    }

    public function authenticate($username, $password, $isEncrypted = false) {
        // Set up the authentication adapter
        $authAdapter = new AuthAdapter(
            $this->dbAdapter,
            'auth',
            'login',
            'password'
        );

        if (!$isEncrypted) {
            $password = md5($password);
        }

        $authAdapter->setIdentity($username)
            ->setCredential($password);

        // Attempt authentication, saving the result
        /* @var $result AuthResult */
        $this->result = $this->authService->authenticate($authAdapter);

        if (!$this->result->isValid()) {
            return false;
        }

        $resultRow = $authAdapter->getResultRowObject();

        $this->authService->getStorage()->write(
            array('id' => $resultRow->id)
        );

        return true;
    }

    public function getMessages() {
        return $this->result->getMessages()[0];
    }

    public function hasIdentity() {
        return $this->authService->hasIdentity();
    }

    public function getIdentity() {
        return $this->authService->getIdentity();
    }

    public function getUserId() {
        $storage = $this->authService->getStorage()->read();

        if (!isset($storage['id'])) {
            return false;
        }

        return $storage['id'];
    }

    public function logout() {
        $this->authService->clearIdentity();
    }

}