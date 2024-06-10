<?php
namespace Gutenberg\Parser;

use Gutenberg\CloudKit\ServerService;
use Gutenberg\Managers\BookManager;

class BatchList
{

    public function __construct(
        protected ServerService $service,
        protected BookManager $manager
    )
    {
    }

    public function __invoke(): void
    {
        $manager = $this->manager;
        $output = "1" . PHP_EOL;
        foreach ($manager->getBatchList() as $batch) {
            $output .= $batch["id"] . PHP_EOL;
        }
        fwrite(STDOUT, $output);
    }

}