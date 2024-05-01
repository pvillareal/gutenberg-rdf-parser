<?php

namespace Gutenberg\Middleware;

use Gutenberg\Adapter\Database\BookAdapter;
use Gutenberg\Managers\AuthorManager;
use Gutenberg\Managers\BookManager;
use Gutenberg\Models\GutenbergBook;

class MySQLSave
{

    public function __construct(
        protected AuthorManager $authorManager,
        protected BookManager $bookManager
    )
    {
    }

    public function __invoke(GutenbergBook $gutenbergBook) : void
    {
        $authors = $gutenbergBook->authors ?? [];
        foreach ($authors as $author) {
            $this->authorManager->upsert($author);
        }

        $book = new BookAdapter($gutenbergBook);
        $this->bookManager->upsert($book);
        echo "data inserted for: {$gutenbergBook->id}" . PHP_EOL;
        $book = null;
    }

}