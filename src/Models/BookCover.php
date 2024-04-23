<?php

namespace Gutenberg\Models;

class BookCover
{

    const MAX_AUTHORS = 3;

    protected string $title;
    protected string $subTitle;
    protected array $authors = [];
    public function __construct(
        protected GutenbergBook $book
    )
    {
        $this->init();
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getSubtitle() : string
    {
        return $this->subTitle;
    }

    /**
     * @return void
     */
    public function init(): void
    {
        $mainTitle = explode(":", $this->book->getTitle());
        $title = "";
        $subTitle = "";
        if (count($mainTitle) === 2) {
            $title = trim($mainTitle[0]);
            $subTitle = trim($mainTitle[1]);

            $title = wordwrap($title, 24);
            $title = explode(PHP_EOL, $title, 2);
            $title = (count($title) === 1) ? trim($title[0]) : trim($title[0]) . "...";

            $subTitle = wordwrap($subTitle, 90);
            $subTitle = explode(PHP_EOL, $subTitle, 2);
            $subTitle = (count($subTitle) === 1) ? $subTitle[0] : $subTitle[0] . "...";
        } else {
            $title = trim($this->book->getTitle());
            $title = wordwrap($title, 120);
            $title = explode(PHP_EOL, $title, 2);
            $title = (count($title) === 1) ? trim($title[0]) : trim($title[0]) . "...";
        }
        $this->title = $title;
        $this->subTitle = $subTitle;
        $authors = $this->book->getAuthors() ?? [];
        foreach ($authors as $author) {
            $this->authors[] = (strlen($author->name) >= 30) ? substr($author->name,0,30) . '...' : $author->name;
            if (count($this->authors) === self::MAX_AUTHORS) {
                break;
            }
        }
    }

    public function hasSubtitle() : bool
    {
        return !empty($this->subTitle);
    }

    public function getAuthors() : array
    {
        return $this->authors;
    }
}
