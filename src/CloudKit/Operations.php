<?php

namespace Gutenberg\CloudKit;

class Operations implements \JsonSerializable
{

    public array $operationsMap = [];

    public function addOperation(Operation $operation) : bool
    {
        if ($this->isMax()) {
            return false;
        }
        $operation = $operation->jsonSerialize();
        $this->operationsMap[$operation['record']['recordName']] = $operation;
        return true;
    }

    public function isMax() : bool
    {
        return count($this->operationsMap) === 200;
    }

    public function clear() : void
    {
        $this->operationsMap = [];
    }

    public function jsonSerialize(): array
    {
        return ["operations" => array_values($this->operationsMap)];
    }
}