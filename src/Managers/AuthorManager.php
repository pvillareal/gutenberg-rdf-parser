<?php

namespace Gutenberg\Managers;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;
use Psr\Container\ContainerInterface;

class AuthorManager extends Manager
{

    public function testInsert()
    {
        $db = $this->connection;
//        $db = DriverManager::getConnection($params);
        $query = "insert into Author (id, name, alias, birthDate, deathDate)
            VALUES ('1638', 'Jefferson, Thomas', '[\"United States President (1801-1809)\"]', '1743', '1826')";
        try {
            $stmt = $db->prepare($query);
//            $db->exec($query);
            $result = $stmt->executeQuery();
        } catch (Exception $e) {
            var_dump($e);
        }

    }

}