<?php

namespace T4web\Authentication\Service;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\Application;

class Checker
{
    /**
     * @var AuthenticationService
     */
    protected $authService;

    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function __invoke(MvcEvent $event)
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

        $disableForAuthorizedCallback = $config['authorized-redirect-to-route'];
        $redirectTo = $disableForAuthorizedCallback($match, $this->authService);
        if ($this->authService->hasIdentity() && !empty($redirectTo)) {
            $response = $this->redirectTo($event, $redirectTo);
            return $response;
        }

        $checkCallback = $config['need-authorization-callback'];

        // if true = authorization needed
        if (!$checkCallback($match, $this->authService)) {
            return;
        }

        // User is authenticated
        if ($this->authService->hasIdentity()) {
            return;
        }

        $response = $this->redirectTo($event, 'auth-login');

        return $response;
    }

    private function redirectTo(MvcEvent $event, $routeName, $reasonPhrase = 'Unauthorized')
    {
        // Redirect to the user login page, as an example
        $router   = $event->getRouter();
        $url      = $router->assemble([], ['name' => $routeName]);

        /** @var \Zend\Http\Response $response */
        $response = $event->getResponse();
        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->setStatusCode(302);
        $response->setReasonPhrase($reasonPhrase);

        return $response;
    }
}
