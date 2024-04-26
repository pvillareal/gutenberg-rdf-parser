<?php

namespace Gutenberg\Mapper;


use ReflectionProperty;

/**
 * Maps data on to the designated object
 */
class DatabaseModelMapper
{

    public static function map(array $data, object $target) : object
    {
        foreach ($data as $key => $value) {
            $type = "string";
            if (empty($value)) {
                continue;
            }
            if (property_exists($target, $key)) {
                try {
                    $reflection = new ReflectionProperty($target::class, $key);
                    $type = $reflection->getType()->getName();
                } catch (\ReflectionException $e) {
                    echo "Unable to initialize ReflectionProperty";
                }
                $target->$key = ($type === 'array') ? json_decode($value, TRUE) : $value;
            }
        }
        return $target;
    }

}