<?php

include "./vendor/autoload.php";

use Gutenberg\Parser\GutenbergRDFParser;

$ignored = [56057]; // These files are not parsable at the moment TODO: gracefully catch this and note all files that fail.
$folders = explode(PHP_EOL, shell_exec('ls -1 "$(pwd)/cache/epub"'));
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

foreach ($folders as $folder) {
    if (!is_numeric($folder) || in_array((int) $folder, $ignored)) {
        continue;
    }
    $batch++;
    $book = $parser((int) $folder);
    $books[] = $book;
    if ($batch === $batchSize) {
        $file = $batch * $batchNumber;
        writeFile($file, $books);
        $books = [];
        $batch = 0;
        $batchNumber++;
    }
}

