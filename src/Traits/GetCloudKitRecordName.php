<?php

namespace Gutenberg\Traits;

trait GetCloudKitRecordName
{


    public function getRecordName(array $json): string
    {
        $key = $this->record;
        if (array_key_exists($key, $json)) {
            return $json[$key];
        }
        throw new \InvalidArgumentException("Missing key in supplied JSON: $key");
    }

}