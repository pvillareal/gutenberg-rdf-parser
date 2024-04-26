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

class TestCloudkit
{

    public function __construct(
        protected ServerService $service,
        protected BookManager $manager
    )
    {
    }

    public function __invoke() : void
    {
        $manager = $this->manager;
        $service = $this->service;
        $id = "15070";
        $total = $manager->count();
        while($total > 0) {
            $strId = $id + 1;
            $result = $manager->getBatch((int) $strId);
            echo "Getting batch $id + 200" . PHP_EOL;
            $operations = new Operations();
            foreach ($result as $datum) {
                $operation = new Operation(ModifyOperationTypes::FORCE_UPDATE);
                /** @var \Gutenberg\Models\Book $book */
                $book = DatabaseModelMapper::map($datum, new \Gutenberg\Models\Book());
                $id = $book->id;
                $operation->setRecord(Book::recordFromJson($book->jsonSerialize()));
                $operations->addOperation($operation);
            }
            $service->post(OperationUri::MODIFY_RECORDS, json_encode($operations));
            $total -= 200;
        }
    }

}