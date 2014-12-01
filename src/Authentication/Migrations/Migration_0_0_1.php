<?php

namespace Authentication\Migrations;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Migration_0_0_1 implements ServiceLocatorAwareInterface {

    private $serviceLocator;

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function __invoke()
    {
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $table = "auth";
        $query = "CREATE TABLE IF NOT EXISTS `{$table}` (
                    `identity_id` int(11) NOT NULL,
                    `login` varchar(255) CHARACTER SET utf8 NOT NULL,
                    `password` varchar(255) CHARACTER SET utf8 NOT NULL,
                    PRIMARY KEY (`identity_id`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

        $dbAdapter->query($query)->execute();
    }

} 