<?php

namespace Gutenberg\Models;

use AllowDynamicProperties;
use Gutenberg\Traits\JsonSerialize;

#[AllowDynamicProperties] class Format implements \JsonSerializable
{
    
    public string $fileUrl;
    public string $isFormatOf;
    public string $modifiedDate;

    use JsonSerialize;
}