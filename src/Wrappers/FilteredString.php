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
        $str = str_replace("  ", " ", $str);
        $str = preg_replace('(\s?:\s?)', ":", $str);
        $str = preg_replace('(([a-zA-Z]):([a-zA-Z]))', '${1} : ${2}', $str);
        $str = trim($str);
        return str_replace("  ", " ", $str);
    }

}