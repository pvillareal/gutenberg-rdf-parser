<?php

namespace Gutenberg\Managers;

use Gutenberg\Models\Author;

class AuthorManager extends Manager
{
    protected string $table = "Author";

    public function getTable(): string
    {
        return $this->table;
    }

}