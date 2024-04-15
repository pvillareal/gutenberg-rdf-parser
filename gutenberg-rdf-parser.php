<?php

include "./bootstrap.php";

/** @global \Laminas\Config\Config $config */

use Gutenberg\CloudKit\Author;
use Gutenberg\CloudKit\Enums\ModifyOperationTypes;
use Gutenberg\CloudKit\Enums\OperationUri;
use Gutenberg\CloudKit\ModifyOperation;
use Gutenberg\CloudKit\Operation;
use Gutenberg\CloudKit\Operations;
use Gutenberg\CloudKit\Service;
use Gutenberg\Parser\GutenbergRDFParser;

//TODO: gracefully catch this and note all files that fail.
$ignored = [56057]; // These files are not parsable at the moment

$folders = explode(PHP_EOL, shell_exec('ls -1 "$(pwd)/cache/epub"'));

//TODO: I want to remove this, one possible solution would be to rewrite the loops in bash so as to free up memory per loop.
ini_set('memory_limit', '512M');

$parser = new GutenbergRDFParser();
$batchSize = 5000;
$batchNumber = 1;
$batch = 0;
$books = [];

/**
 * @param float|int $file
 * @param array $books
 * @return void
 */
function writeFile(float|int $file, array $books): void
{
    $fp = fopen("./tmp/$file.json", 'w');
    fwrite($fp, json_encode($books, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    fclose($fp);
}
$modifyService = new ModifyOperation($config['services']['cloudkit']['container'], OperationUri::MODIFY_RECORDS);
$modifyService->setPrivateKey($config['services']['cloudkit']['private_key']);
$modifyService->setKeyId($config['services']['cloudkit']['key_id']);
$operations = new Operations();
foreach ($folders as $folder) {
    if (!is_numeric($folder) || in_array((int) $folder, $ignored)) {
        continue;
    }
    $batch++;
    $book = $parser((int) $folder);
    $books[] = $book;
    if (!empty($book->authors)) {
        foreach ($book->authors as $author) {
            /** @var \Gutenberg\Models\Author $author */
            $operation = new Operation(ModifyOperationTypes::FORCE_UPDATE);
            $operation->setRecord(Author::recordFromJson($author->jsonSerialize()));
            $operations->addOperation($operation);
        }
        if ($operations->isMax()) {
            $modifyService->setRequestBody(json_encode($operations->jsonSerialize()));
            try {
                $url = $modifyService->getServiceUrl();
                $body = $modifyService->getRequestBody();
                $headers = $modifyService->getHeaders();
                Service::post($url, $body, $headers);
            } catch (\GuzzleHttp\Exception\GuzzleException $e) {
                echo $e->getCode();
                echo $e->getMessage();
            }
            $operations->clear();
        }
    }
    if ($batch === $batchSize) {
        $file = $batch * $batchNumber;
        writeFile($file, $books);
        $books = [];
        $batch = 0;
        $batchNumber++;
    }
}

