<?php

namespace Gutenberg\CloudKit;

use Gutenberg\Adapter\CloudKit\Author;

interface CKRecordInterface
{

    public static function getRecordType() : string;

    public static function getRecordName(array $json) : string;

    public static function recordFromJson(array $json): array;

}