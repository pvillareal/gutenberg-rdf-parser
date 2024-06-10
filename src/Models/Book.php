<?php

namespace Gutenberg\Models;

use Gutenberg\Traits\JsonSerialize;

class Book implements \JsonSerializable
{
    public string $id;
    public string $title;
    public string $alternativeTitle;
    public string $language;
    public string $releaseDate;
    public string $originalPublications;
    public string $notes;
    public string $credits;
    public string $rights;
    public string $contents;
    public array $authorIds;
    public array $compilerIds;
    public array $subjects;
    public array $locc;
    public array $categories;
    public array $bookshelves;
    public string $downloads;
    public string $mediumCover;
    public string $smallCover;
    public string $featureType;

    public bool $hasCover;

    Use JsonSerialize;
}