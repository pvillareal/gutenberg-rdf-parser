<?php

namespace Gutenberg\Managers;

class CompilerManager extends Manager
{

    protected string $table = "Author";

    public function getTable(): string
    {
        return $this->table;
    }

}