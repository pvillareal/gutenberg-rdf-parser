<?php

namespace Gutenberg\Wrappers;

class FilteredString
{

    public function __construct(protected string $str)
    {
    }

    public function __toString() : string
    {
        $str = $this->str;
        $str = preg_replace('(\$[a-z]|\$)', "", $str);
        $str = trim($str);
        return str_replace("  ", " ", $str);
    }

}