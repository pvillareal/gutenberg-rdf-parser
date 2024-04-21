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
        /** @var Author[] $authors */
        $authors = empty($gutenbergBook->authors) ? [] : array_column($gutenbergBook->authors, null, "id");
        $book->authorIds = array_keys($authors);
        /** @var Compiler[] $compilers */
        $compilers = empty($gutenbergBook->compilers) ? [] : array_column($gutenbergBook->authors, null, "id");
        $book->compilerIds = array_keys($compilers);
//        $mediumCover = implode("/", ['https://www.gutenberg.org/cache/epub', $book->id, "pg{$book->id}.cover.medium.jpg"]);
//        $smallCover = implode("/", ['https://www.gutenberg.org/cache/epub', $book->id, "pg{$book->id}.cover.small.jpg"]);

//        $isText = in_array('Text',$book->categories ?? []);
//        $formats = empty($gutenbergBook->formats) ? [] : array_column($gutenbergBook->formats, null, "fileUrl");
//        $hasMediumCover = false;
//        $hasSmallCover = false;
//        foreach (array_keys($formats) as $keys) {
//            if (preg_match("(cover\.medium)", $keys) !== 0) {
//                $hasMediumCover = true;
//            }
//        }
//        if ($hasMediumCover || ($isText && !empty($formats))) {
//            $book->mediumCover = $this->getBase64Image($mediumCover);
//        }
//        if ($hasSmallCover || ($isText && !empty($formats))) {
//            $book->smallCover = $this->getBase64Image($smallCover);
//        }
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