<?php
namespace T4web\Authentication\Service;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Adapter\ValidatableAdapterInterface;
use Zend\Authentication\Result;
use Zend\Authentication\Storage\Session;
use Zend\Session\SessionManager;
use T4web\Authentication\Exception\RuntimeException;

/**
 * Class InteractiveAuth
 */
class InteractiveAuth
{
    /**
     * @var Authenticator
     */
    protected $authService;

    /**
     * @var SessionManager
     */
    protected $sessionManager;

    /**
     * @param Authenticator $authService
     * @param SessionManager $sessionManager
     * @throws RuntimeException
     */
    public function __construct(Authenticator $authService, SessionManager $sessionManager)
    {
        if (!$authService->getStorage() instanceof Session) {
            throw new RuntimeException(__CLASS__ . ' requires SessionStorage');
        }

        $this->authService = $authService;
        $this->sessionManager = $sessionManager;
    }

    /**
     * @param string $identity
     * @param string $credential
     * @throws RuntimeException
     * @return Result
     */
    public function login($identity, $credential)
    {
        $authAdapter = $this->authService->getAdapter();

        if (!$authAdapter instanceof ValidatableAdapterInterface) {
            throw new RuntimeException(__CLASS__ . ' requires ValidatableAdapterInterface');
        }

        $authAdapter->setIdentity($identity)
                    ->setCredential($credential);

        return $this->authService->authenticate();
    }

    /**
     *
     */
    public function logout()
    {
        $this->authService->clearIdentity();
        $this->sessionManager->destroy([
            'send_expire_cookie'    => true,
            'clear_storage'         => true,
        ]);
    }

    /**
     * @param AdapterInterface $adapter
     * @return Result
     */
    public function connect(AdapterInterface $adapter)
    {
        return $this->authService->authenticate($adapter);
    }
}
