<?php

namespace Gutenberg\Adapter\CloudKit;

use Gutenberg\CloudKit\CKRecordInterface;

class Book implements CKRecordInterface
{

    public static string $recordType = "Book";
    public static string $recordNameKey = "id";

    public static function getRecordType(): string
    {
        return self::$recordType;
    }

    public static function getRecordName(array $json): string
    {
        return $json[self::$recordNameKey];
    }

    public static function recordFromJson(array $json): array
    {
        $fields = [];
        foreach($json as $key => $value) {
            $fields[$key] = ["value" => $value];
        }
        return [
            "recordType" => self::getRecordType(),
            "fields" => $fields,
            "recordName" => self::$recordType . "_" . self::getRecordName($json),
        ];
    }
}