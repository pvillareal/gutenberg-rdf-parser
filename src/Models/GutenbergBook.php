<?php

namespace Gutenberg\Models;
use JsonSerializable;
use function PHPUnit\Framework\isEmpty;

class GutenbergBook implements JsonSerializable
{
    public string $id;
    public string $title;
    public string $language;
    public string $releaseDate;
    public array $authors;
    public array $compilers;
    public array $subjects;
    public array $locc;
    public array $categories;
    public string $notes;
    public string $credits;
    public string $contents;
    public string $downloads;

    use JsonSerialize;
}