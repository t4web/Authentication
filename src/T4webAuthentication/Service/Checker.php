<?php

namespace T4webAuthentication\Service;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\Application;

class Checker {

    /**
     * @var AuthenticationService
     */
    protected $authService;

    public function __construct(AuthenticationService $authService) {
        $this->authService = $authService;
    }

    public function check(MvcEvent $event)
    {
        if ($event->getRequest() instanceof ConsoleRequest) {
            return;
        }

        $match = $event->getRouteMatch();

        // No route match, this is a 404
        if (!$match instanceof RouteMatch) {
            return;
        }

        /** @var Application $app */
        $app = $event->getParam('application');
        $config = $app->getConfig();

        $checkCallback = $config['need-authorization-callback'];

        // if true = authorization needed
        if (!$checkCallback($match)) {
            return;
        }

        // User is authenticated
        if ($this->authService->hasIdentity()) {
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
}