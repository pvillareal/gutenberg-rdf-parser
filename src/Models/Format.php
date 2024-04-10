<?php

namespace Gutenberg\Models;

use AllowDynamicProperties;
use Gutenberg\Traits\JsonSerialize;

class Format implements \JsonSerializable
{
    
    public string $fileUrl;
    public string $isFormatOf;
    public string $modifiedDate;
    public string $httpHeaderFormat;

    use JsonSerialize;
}