<?php

namespace Gutenberg\CloudKit;

use Gutenberg\CloudKit\Enums\ModifyOperationTypes;
use Gutenberg\CloudKit\Enums\OperationUri;

class ModifyOperation extends CloudKitService
{

    public function __construct(
        protected string $container,
        protected OperationUri $operationUri
    )
    {
        parent::__construct($this->container, $this->operationUri);
    }



}