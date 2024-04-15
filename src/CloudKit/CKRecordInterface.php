<?php

namespace Gutenberg\CloudKit;

interface CKRecordInterface
{

    public static function getRecordType() : string;

    public static function getRecordName(array $json) : string;

}