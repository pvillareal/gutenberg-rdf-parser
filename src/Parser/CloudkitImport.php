<?php

namespace Gutenberg\Parser;

use Gutenberg\Adapter\CloudKit\Book;
use Gutenberg\CloudKit\Enums\ModifyOperationTypes;
use Gutenberg\CloudKit\Operation;
use Gutenberg\CloudKit\Operations;
use Gutenberg\CloudKit\ServerService;
use Gutenberg\CloudKit\Enums\OperationUri;
use Gutenberg\Managers\BookManager;
use Gutenberg\Mapper\DatabaseModelMapper;

class CloudkitImport
{

    public function __construct(
        protected ServerService $service,
        protected BookManager $manager
    )
    {
    }

    public function __invoke(int $batch) : void
    {
        $manager = $this->manager;
        $service = $this->service;
        $result = $manager->getBatch($batch);
        $operations = new Operations();
        foreach ($result as $datum) {
            $operation = new Operation(ModifyOperationTypes::FORCE_REPLACE);
            /** @var \Gutenberg\Models\Book $book */
            $book = DatabaseModelMapper::map($datum, new \Gutenberg\Models\Book());
            $operation->setRecord(Book::recordFromJson($book->jsonSerialize()));
            $operations->addOperation($operation);
        }
        try {
            $service->post(OperationUri::MODIFY_RECORDS, json_encode($operations));
        } catch (\Exception $e) {
            echo "reprocessing batch - $batch" . PHP_EOL;
            self::__invoke($batch);
        }

        $total = $batch + 200;
        echo "Processed $batch - $total" . PHP_EOL;
    }

}