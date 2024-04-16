<?php

namespace Gutenberg\Managers;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\ParameterType;

class TermsManager extends Manager
{


    /**
     * This truncates and rebuilds the data on provided lookup tables
     * @param array $map
     * @param string $table
     * @return int
     * @throws Exception
     */
    public function buildLookUp(array $map, string $table) : int
    {
        $results = 0;
        $db = $this->connection;
        $truncate = "truncate table $table";
        $db->executeQuery($truncate);

        $query = "insert into $table (id, description) VALUES (?, ?)";
        try {
            $db->beginTransaction();
            foreach ($map as $id => $description) {
                $statement = $db->prepare($query);
                $statement->bindValue(1, $id, ParameterType::STRING);
                $statement->bindValue(2, $description, ParameterType::STRING);
                $resultSet = $statement->executeQuery();
                $results += $resultSet->rowCount();
            }
            $db->commit();
            $db->close();
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage() . PHP_EOL;
        }
        return $results;
    }



}