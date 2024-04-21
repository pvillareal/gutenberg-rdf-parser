<?php

namespace Gutenberg\Managers;

use Gutenberg\Adapter\Database\BookAdapter;

class BookManager extends Manager
{

    protected string $table = "Book";

    public function getTable(): string
    {
        return $this->table;
    }
}