<?php

namespace Gutenberg\Models;

trait JsonSerialize
{

    public function jsonSerialize() : array
    {
        $json = get_object_vars($this);
        foreach ($json as $key => $value) {
            if (empty($value)) {
                unset($json[$key]);
            }
        }
        return $json;
    }

}