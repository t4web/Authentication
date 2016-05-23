<?php

namespace T4web\Authentication\Adapter;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter as AuthenticationAdapter;
use Zend\Db\Adapter\Adapter as DbAdapter;
use T4web\Authentication\Exception\RuntimeException;
use T4webInfrastructure\Config;

class TableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var DbAdapter $dbAdapter */
        $dbAdapter = $serviceLocator->get(DbAdapter::class);

        /** @var Config $userInfrastructureConfig */
        $config = $serviceLocator->get('config');

        if (!isset($config['auth']) || !isset($config['auth']['table-adapter'])) {
            throw new RuntimeException('For authentication with table adapter, you must describe config[auth][table-adapter]');
        }
        if (!isset($config['auth']['table-adapter']['table-name'])
            || !isset($config['auth']['table-adapter']['identity-column'])
            || !isset($config['auth']['table-adapter']['credential-column'])) {
            throw new RuntimeException('For authentication with table adapter, you must describe table-name, '
                . 'identity-column and credential-column keys in config[auth][table-adapter]');
        }

        $tableName = $config['auth']['table-adapter']['table-name'];
        $identityColumn = $config['auth']['table-adapter']['identity-column'];
        $credentialColumn = $config['auth']['table-adapter']['credential-column'];

        $credentialCallback = function ($passwordInDatabase, $passwordProvided) {
            return password_verify($passwordProvided, $passwordInDatabase);
        };

        return new AuthenticationAdapter($dbAdapter, $tableName, $identityColumn, $credentialColumn, $credentialCallback);
    }
}
