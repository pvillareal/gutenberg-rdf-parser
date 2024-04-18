<?php

namespace Gutenberg\Traits;

use Gutenberg\Wrappers\FilteredString;

trait JsonSerialize
{

    public function jsonSerialize() : array
    {
        $json = get_object_vars($this);
        foreach ($json as $key => $value) {
            if (is_string($value)) {
                $string = new FilteredString($value);
                $json[$key] = $string->__toString();
            }
            if (empty($value)) {
                unset($json[$key]);
            }
            if ($value instanceof \UnitEnum) {
                $json[$key] = $value->value;
            }
        }
        return $json;
    }

}