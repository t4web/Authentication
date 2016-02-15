<?php

namespace T4web\Authentication\Entry\Criteria;

use T4webBase\Domain\Criteria\Id as BaseIdCriteria;

class Id extends BaseIdCriteria {
    
    protected $table = 'auth';
}
