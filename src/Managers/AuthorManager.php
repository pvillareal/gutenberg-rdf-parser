<?php

namespace Gutenberg\Managers;

use Gutenberg\Models\Author;

class AuthorManager extends Manager
{
    public function upsert(Author $author) : int
    {
        $db = $this->connection;
        $query = "INSERT INTO Author (id, name, alias, birthDate, deathDate)
                VALUES (:id, :name, :alias, :birthDate, :deathDate) 
                ON DUPLICATE KEY UPDATE 
                name = VALUES(name), alias = VALUES(alias), birthDate = VALUES(birthDate), deathDate = VALUES(deathDate)";
        try {
            $stmt = $db->prepare($query);
            $stmt->bindValue("id", $author->id);
            $stmt->bindValue("name", $author->name);
            $stmt->bindValue("alias", json_encode($author->alias));
            $stmt->bindValue("birthDate", $author->birthDate);
            $stmt->bindValue("deathDate", $author->deathDate);
            return $stmt->executeStatement();
        } catch (\Doctrine\DBAL\Exception $e) {
            echo $e->getMessage();
            return 0;
        }
    }

}