<?php

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Psr\Container\ContainerInterface;
return array(
    Connection::class => DI\factory(function (ContainerInterface $c) {
        $dbParams = $c->get("database");
        return DriverManager::getConnection($dbParams);
    }),
);