<?php

namespace Authentication;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\ServiceManager\ServiceLocatorInterface;

class Service {

    public function authenticate($userName, $password)
    {
        return true;
    }

    public function getMessage(){
        return "";
    }

}