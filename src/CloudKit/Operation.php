<?php

namespace Gutenberg\CloudKit;

use Gutenberg\CloudKit\Enums\ModifyOperationTypes as OperationType;
use Gutenberg\Traits\JsonSerialize;

class Operation implements \JsonSerializable
{

    protected array $record = [];

    public function __construct(
        protected OperationType $operationType,
    )
    {
    }

    public function setRecord(array $record) : void
    {
        $this->record = $record;
        if ($this->operationType === OperationType::UPDATE) {
            $this->record["recordChangeTag"] = "e";
        }
    }

    use JsonSerialize;
}