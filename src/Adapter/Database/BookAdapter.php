<?php

namespace Gutenberg\Adapter\Database;

use Gutenberg\CloudKit\Author;
use Gutenberg\Models\Book;
use Gutenberg\Models\Compiler;
use Gutenberg\Models\GutenbergBook;

class BookAdapter implements \JsonSerializable
{
    protected Book $book;

    public function __construct(
        protected GutenbergBook $gutenbergBook
    )
    {
        $this->init($this->gutenbergBook);
    }

    private function init(GutenbergBook $gutenbergBook) : void
    {
        $book = new Book();
        $gutenbergBookfields = get_object_vars($gutenbergBook);
        foreach ($gutenbergBookfields as $field => $value) {
            if (property_exists($book, $field)) {
                $book->$field = $gutenbergBook->$field;
            }
        }
        foreach ($gutenbergBook->authors as $author) {
            $book->authorIds[] = $author->id;
        }
        foreach ($gutenbergBook->compilers as $compiler) {
            $book->compilerIds[] = $compiler->id;
        }

        $mediumCover = "/app/tmp/{$gutenbergBook->id}.medium.cover.jpg";
        $smallCover = "/app/tmp/{$gutenbergBook->id}.small.cover.jpg";

        $book->mediumCover = $this->getBase64Image($mediumCover);
        $book->smallCover = $this->getBase64Image($smallCover);

        unlink($mediumCover);
        unlink($smallCover);
        $this->book = $book;
    }


    public function jsonSerialize(): array
    {
        return $this->book->jsonSerialize();
    }

    private function getBase64Image(string $mediumCover) : string
    {
        $contents = file_get_contents($mediumCover);
        return empty($contents) ? "" : base64_encode($contents);
    }
}