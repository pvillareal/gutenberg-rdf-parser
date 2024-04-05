<?php

namespace Gutenberg\Models;

class Author implements \JsonSerializable
{

    public string $id;
    public string $name;
    public array $alias;
    public string $birthDate;
    public string $deathDate;

    use JsonSerialize;
}