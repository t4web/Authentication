<?php

namespace T4web\Authentication\Adapter;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class PhpArray implements AdapterInterface
{
    private $accounts;
    private $identity;
    private $credential;

    public function __construct(array $accounts)
    {
        $this->accounts = $accounts;
    }

    public function setIdentity($identity)
    {
        $this->identity = $identity;
    }

    public function setCredential($credential)
    {
        $this->credential = $credential;
    }

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
