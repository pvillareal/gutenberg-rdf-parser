<?php

namespace Gutenberg\Middleware;

use Doctrine\DBAL\Driver\Middleware;
use Gutenberg\Adapter\Database\BookAdapter;
use Gutenberg\Managers\AuthorManager;
use Gutenberg\Managers\BookManager;
use Gutenberg\Models\Author;
use Gutenberg\Models\GutenbergBook;

class MySQLSave
{

    public function __construct(
        protected AuthorManager $authorManager,
        protected BookManager $bookManager
    )
    {
    }

    public function __invoke(GutenbergBook $gutenbergBook) : GutenbergBook
    {
        $authors = $gutenbergBook->authors ?? [];
        foreach ($authors as $author) {
            $this->authorManager->upsert($author);
        }

        $book = new BookAdapter($gutenbergBook);
        $this->bookManager->upsert($book);
        echo "data inserted for: {$gutenbergBook->id}" . PHP_EOL;
        return $gutenbergBook;
    }

}