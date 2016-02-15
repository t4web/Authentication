<?php

namespace T4web\Authentication\Entry;

use T4webBase\Domain\Entity;

class Entry extends Entity {
    
    protected $login;
    protected $password;

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }
}