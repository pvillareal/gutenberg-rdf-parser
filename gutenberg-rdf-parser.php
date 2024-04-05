<?php

include "./vendor/autoload.php";

use Gutenberg\Parser\GutenbergRDFParser;

$folders = explode(PHP_EOL, shell_exec('ls -1 "$(pwd)/cache/epub"'));
$gutenbergBook = new GutenbergRDFParser();
//foreach ($folders as $folder) {
//    if (!is_numeric($folder)) {
//        continue;
//    }
//
//
//    $gutenbergBook->id = $folder;
//
//    break;
//}
//$book = $gutenbergBook(30872);
//$book->title = "short";
$book = $gutenbergBook(2591);
//$book = $gutenbergBook(1);
echo json_encode($book, JSON_PRETTY_PRINT);
//var_dump($book);


//$nodes = $doc->filterXPath("//rdf:RDF/pgterms:ebook/dcterms:publisher");
//
//var_dump($nodes->text());