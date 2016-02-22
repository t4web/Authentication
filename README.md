Authentication
==============

Master:
[![Build Status](https://travis-ci.org/t4web/Authentication.svg?branch=master)](https://travis-ci.org/t4web/Authentication)
[![codecov.io](http://codecov.io/github/t4web/Authentication/coverage.svg?branch=master)](http://codecov.io/github/t4web/Authentication?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/t4web/Authentication/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/t4web/Authentication/?branch=master)

Authentication module for zf2

Introduction
------------

Requirements
------------
* [Zend Framework 2](https://github.com/zendframework/zf2) (latest master)

Features / Goals
----------------
* Authenticate via username, email, or both [IN PROGRESS]

Installation
------------
### Main Setup

#### By cloning project

Clone this project into your `./vendor/` directory.

#### With composer

Add this project in your composer.json:

```json
"require": {
    "t4web/authentication": "1.0.*"
}
```

Now tell composer to download Authentication by running the command:

```bash
$ php composer.phar update
```

#### Post installation

Enabling it in your `application.config.php`file.

```php
<?php
return array(
    'modules' => array(
        // ...
        'T4web\Authentication',
    ),
    // ...
);
```

Testing
------------
Unit test runnig from authentication module directory.
```bash
$ codeception run unit
```
For running Functional tests you need create codeception.yml in you project root, like this:
```yml
include:
    - vendor/t4web/authentication  # <- add authentication module tests to include

paths:
    log: tests/_output

settings:
    colors: true
    memory_limit: 1024M
```
After this you may run functional tests from your project root
```bash
$ codeception run
```
