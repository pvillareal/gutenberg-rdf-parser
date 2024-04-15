<?php

namespace Gutenberg\CloudKit;

class Author implements CKRecordInterface
{
    public static string $recordType = "Author";
    public static string $recordNameKey = "id";

    public static function recordFromJson(array $json) : array
    {
        $fields = [];
        foreach($json as $key => $value) {
            $fields[$key] = ["value" => $value];
        }
        return [
            "recordType" => self::getRecordType(),
            "fields" => $fields,
            "recordName" => self::getRecordName($json),
        ];
    }

    public static function getRecordType(): string
    {
        return self::$recordType;
    }

    public static function getRecordName(array $json): string
    {
        return $json[self::$recordNameKey];
    }
}