<?php
//TODO: RDF Parser is now being used instead.
include "./GutenbergBook.php";

$csv = array_map('str_getcsv', file('/Users/philippe/Downloads/pg_catalog.csv'));

$open = fopen("/Users/philippe/Downloads/pg_catalog.csv", "r");
$ctr = 0;

while (($val = fgetcsv($open, 1000, ",")) !== FALSE) {
    if ($val[0] == "Text#") {
        continue;
    }
    $number = $val[0];
    echo($number . PHP_EOL);
    $book = new GutenbergBook();
    $book->id = preg_replace('/\s+/', ' ', $val[0]);
    $book->type = preg_replace('/\s+/', ' ', $val[1]) ?? "";
    $book->published_date = preg_replace('/\s+/', ' ', $val[2]) ?? "";
    $book->title = preg_replace('/\s+/', ' ', $val[3]) ?? "";
    $book->language = preg_replace('/\s+/', ' ', $val[4]) ?? "";
    $authors = explode(';', $val[5] ?? "");
    $authors = array_map('trim', $authors);
    $book->authors = $authors;
    $subjects = explode(';', $val[6] ?? "");
    $subjects = array_map('trim', $subjects);
    $book->subjects = $subjects;
    $locc = explode(';', $val[7] ?? "");
    $locc = array_map('trim', $locc);
    $book->locc = $locc;
    $categories = explode(';', $val[8] ?? "");
    $categories = array_map('trim', $categories);
    $book->categories = $categories;

    $jsonString = json_encode($book, JSON_PRETTY_PRINT);
    $fp = fopen("./data/$number.json", 'w');
    fwrite($fp, $jsonString);
    fclose($fp);
}