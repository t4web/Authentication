<?php

namespace T4webAuthentication\Entry\Criteria;

use T4webBase\Db\QueryBuilderInterface;
use T4webBase\Domain\Criteria\AbstractCriteria;

class LoginExists extends AbstractCriteria {

    private $login;
    private $excludeId;
    protected $table = 'auth';

    public function __construct($data) {
        $this->login = $data['login'];
        $this->excludeId = $data['excludeId'];
    }

    public function build(QueryBuilderInterface $queryBuilder) {
        $queryBuilder->from($this->table);
        $queryBuilder->addFilterEqual("$this->table.login", $this->login);
        $queryBuilder->addFilterNotEqual("$this->table.id", $this->excludeId);
    }

}
