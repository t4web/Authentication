<?php

use authentication\FunctionalTester;

$I = new FunctionalTester($scenario);
$I->wantTo('see login form');
$I->amOnPage('/login-form');
$I->seeResponseCodeIs(200);
$I->seeElement('input', ['name' => 'username']);
$I->seeElement('input', ['name' => 'password']);
$I->seeElement('button', ['type' => 'submit']);
