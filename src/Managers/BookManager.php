<?php

namespace Gutenberg\Managers;

use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\ParameterType;
use Gutenberg\Managers\Enums\FeatureType;

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
                categories, bookshelves, downloads, mediumCover, smallCover, featureType
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

    public function getBatchList() : array
    {
        $db = $this->connection;
        $query = "select id from (select (row_number() over (ORDER BY NATURAL_SORT_KEY(id) ASC) mod 200) + 1 as batch, id from Book) as lookup where batch = 1";
        $stmt = $db->prepare($query);
        $results = $stmt->executeQuery();
        return $results->fetchAllAssociative();
    }

    public function count() : int
    {
        $db = $this->connection;
        $query = "SELECT COUNT(id) FROM Book";
        $stmt = $db->prepare($query);
        $result = $stmt->executeQuery();
        return $result->fetchOne();
    }

    public function resetFeatureTypes() : void
    {
        $db = $this->connection;
        $query = "UPDATE Book SET featureType = DEFAULT where featureType IS NOT NULL";
        $stmt = $db->prepare($query);
        $stmt->executeStatement();
    }

    public function setFeatureBooks(array $bookIds = []) : void
    {
        $db = $this->connection;
        $query = "UPDATE Book SET featureType = '1' where id IN (?)";
        $db->executeQuery($query,
            [$bookIds],
            [ArrayParameterType::STRING]
        );
    }

    public function setPopularItems() : void
    {
        $db = $this->connection;
        $popular = FeatureType::POPULAR;
        $query = "UPDATE Book SET featureType = {$popular} where featureType IS NULL ORDER BY NATURAL_SORT_KEY(downloads) desc limit 20";
        $db->executeQuery($query);
    }

    public function setRecentItems() : void
    {
        $db = $this->connection;
        $recent = FeatureType::RECENT;
        $query = "UPDATE Book SET featureType = {$recent} where featureType IS NULL ORDER BY NATURAL_SORT_KEY(releaseDate) desc limit 20";
        $db->executeQuery($query);
    }


}