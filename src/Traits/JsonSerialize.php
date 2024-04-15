<?php

namespace Gutenberg\Traits;

trait JsonSerialize
{

    public function jsonSerialize() : array
    {
        $json = get_object_vars($this);
        foreach ($json as $key => $value) {
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