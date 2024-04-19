<?php

namespace Gutenberg\Models;

use Gutenberg\Traits\JsonSerialize;

class Book implements \JsonSerializable
{
    protected string $id;
    protected string $title;
    protected string $alternativeTitle;
    protected string $language;
    protected string $releaseDate;
    protected string $originalPublications;
    protected string $notes;
    protected string $credits;
    protected string $rights;
    protected string $contents;
    protected string $authorIds;
    protected string $compilerIds;
    protected string $subjects;
    protected string $locc;
    protected string $categories;
    protected string $bookshelves;
    protected string $downloads;
    protected string $mediumCover;
    protected string $smallCover;

    Use JsonSerialize;
}