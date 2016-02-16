<?php

namespace T4web\Authentication\Adapter;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class PhpArray implements AdapterInterface
{
    public function authenticate()
    {
        return new Result(Result::SUCCESS, 111);
    }
}