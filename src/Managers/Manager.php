<?php

namespace Gutenberg\Managers;

use Doctrine\DBAL\Connection;

abstract class Manager
{

    public function __construct(
        protected Connection $connection
    )
    {
    }

    public function upsert(\JsonSerializable $book): int
    {
        $db = $this->connection;
        $bookFields = implode(",", array_keys($book->jsonSerialize()));
        $valuesFields = ":" . implode(",:", array_keys($book->jsonSerialize()));
        $updateFields = [];
        foreach ($book->jsonSerialize() as $field => $value) {
            $updateFields[] = "$field = VALUES($field)";
        }
        $updateFields = implode(',', $updateFields);
        $query = "INSERT INTO {$this->getTable()} ({$bookFields})
                VALUES ({$valuesFields}) 
                ON DUPLICATE KEY UPDATE {$updateFields}";
        try {
            $stmt = $db->prepare($query);
            foreach ($book->jsonSerialize() as $field => $value) {
                $data = is_array($value) ? json_encode($value) : $value;
                $stmt->bindValue($field, $data);
            }
            return $stmt->executeStatement();
        } catch (\Doctrine\DBAL\Exception $e) {
            echo $e->getMessage();
            return 0;
        }
    }

    abstract public function getTable() : string;
}