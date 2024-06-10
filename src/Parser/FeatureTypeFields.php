<?php

namespace Gutenberg\Parser;

use Gutenberg\Adapter\CloudKit\Book;
use Gutenberg\CloudKit\Enums\ModifyOperationTypes;
use Gutenberg\CloudKit\Enums\OperationUri;
use Gutenberg\CloudKit\Operation;
use Gutenberg\CloudKit\Operations;
use Gutenberg\CloudKit\ServerService;
use Gutenberg\Managers\BookManager;
use Gutenberg\Mapper\DatabaseModelMapper;

class FeatureTypeFields
{

    public function __construct(
        protected BookManager $manager
    )
    {
    }

    public function __invoke(array $featureBookIds = []) : void
    {
        $manager = $this->manager;
        $manager->resetFeatureTypes();
        $manager->setFeatureBooks($featureBookIds);
        $manager->setPopularItems();
        $manager->setRecentItems();
    }

}