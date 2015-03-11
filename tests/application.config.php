<?php

$pathToApplicatonConfig = dirname(dirname(dirname(dirname(__DIR__))));

return require_once $pathToApplicatonConfig . '/config/application.config.php';