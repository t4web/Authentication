Authentication
==============

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

1. Clone this project into your `./vendor/` directory.

#### With composer

1. Add this project in your composer.json:

    ```json
    "require": {
        "t4web/authentication": "dev-master"
    }
    ```

2. Now tell composer to download Authentication by running the command:

    ```bash
    $ php composer.phar update
    ```

#### Post installation

1. Enabling it in your `application.config.php`file.

    ```php
    <?php
    return array(
        'modules' => array(
            // ...
            'Authentication',
        ),
        // ...
    );
    ```
Testing
------------
Unit test runnig from authentication module directory.
    ```bash
    $ cd vendor/t4web/authentication/tests
    $ phupnit
    ```
For running only Functional tests you need run phpunit, like this:
    ```bash
    $ phupnit --filter Functional
    ```
For running only Unit tests you need run phpunit, like this:
    ```bash
    $ phupnit --filter Unit
    ```
