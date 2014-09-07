Authentication
==============

Authentication module for zf2

Introduction
------------

Requirements
------------

Features / Goals
----------------

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
Unit test runnig from box.
    ```bash
    $ codeception run unit
    ```
For running Functional tests create symbolic link to functional test directory:
    ```bash
    $ cd /root/path/to/zf/project
    $ ln -s /root/path/to/zf/project/vendor/t4web/authentication/tests/functional tests/
    ```
After this you may run functional tests
    ```bash
    $ codeception run functional
    ```