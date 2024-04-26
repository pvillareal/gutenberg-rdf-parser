<?php

namespace Gutenberg\Managers;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\ParameterType;

class BookManager extends Manager
{

    protected string $table = "Book";

    public function getTable(): string
    {
        return $this->table;
    }

    public function getBatch(int $startId, int $batchSize = 200) : array
    {
        $db = $this->connection;
        $query = "SELECT b.id as id, title, alternativeTitle, l.description as language, releaseDate, 
                originalPublications, notes, credits, rights, contents, authorIds, compilerIds, subjects, locc, 
                categories, bookshelves, downloads, mediumCover, smallCover
                FROM Book b JOIN Language l on b.language = l.id WHERE b.id >= :id ORDER BY b.id + 0 LIMIT :batchId";

        try {
            $stmt = $db->prepare($query);
            $stmt->bindValue("id", $startId, ParameterType::INTEGER);
            $stmt->bindValue("batchId", $batchSize, ParameterType::INTEGER);
            $results = $stmt->executeQuery();
            return $results->fetchAllAssociative();
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    public function count() : int
    {
        $db = $this->connection;
        $query = "SELECT COUNT(id) FROM Book";
        $stmt = $db->prepare($query);
        $result = $stmt->executeQuery();
        return $result->fetchOne();
    }
}