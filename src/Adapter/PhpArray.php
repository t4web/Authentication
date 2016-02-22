<?php

namespace T4web\Authentication\Adapter;

use Zend\Authentication\Adapter\ValidatableAdapterInterface;
use Zend\Authentication\Result;

class PhpArray implements ValidatableAdapterInterface
{
    /**
     * @var array
     */
    private $accounts;

    /**
     * @var string
     */
    private $identity;

    /**
     * @var string
     */
    private $credential;

    /**
     * @param array $accounts
     */
    public function __construct(array $accounts)
    {
        $this->accounts = $accounts;
    }

    /**
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @param string $identity
     * @return ValidatableAdapterInterface
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
        return $this;
    }

    /**
     * @return string
     */
    public function getCredential()
    {
        return $this->credential;
    }

    /**
     * @param mixed $credential
     * @return ValidatableAdapterInterface
     */
    public function setCredential($credential)
    {
        $this->credential = $credential;
        return $this;
    }

    /**
     * @return Result
     */
    public function authenticate()
    {
        if (!isset($this->accounts[$this->identity])) {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null, ['Login does not exists']);
        }

        if ($this->accounts[$this->identity] !== $this->credential) {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, ['Invalid credentials']);
        }

        return new Result(Result::SUCCESS, $this->identity);
    }
}
