<?php

use Symfony\Component\DomCrawler\Crawler;

include "./vendor/autoload.php";


$doc = new Crawler(file_get_contents("https://www.gutenberg.org/ebooks/"));
$lccs = $doc->filterXPath('//*[@id="locc"]/option')->each(function (Crawler $parent) : string {
    $key = $parent->filterXPath('node()')->attr('value');
    $value = $parent->filterXPath('node()')->text();
    return "$key|$value";
});

$map = [];
foreach ($lccs as $lcc) {
    if (strtolower($lcc) === "|any") {
        continue;
    }
    $parse = explode('|', $lcc);
    $map[$parse[0]] = $parse[1];
}

$fp = fopen("./tmp/lcc.json", 'w');
fwrite($fp, json_encode($map, JSON_PRETTY_PRINT));
fclose($fp);

$fileTypes = $doc->filterXPath('//*[@id="filetype"]/option')->each(function (Crawler $parent) : string {
    $key = $parent->filterXPath('node()')->attr('value');
    $value = $parent->filterXPath('node()')->text();
    return "$key|$value";
});

$map = [];
foreach ($fileTypes as $fileType) {
    if (strtolower($fileType) === "|any") {
        continue;
    }
    $parse = explode('|', $fileType);
    $map[$parse[0]] = $parse[1];
}

$fp = fopen("./tmp/filetype.json", 'w');
fwrite($fp, json_encode($map, JSON_PRETTY_PRINT));
fclose($fp);

$languages = $doc->filterXPath('//*[@id="lang"]/option')->each(function (Crawler $parent) : string {
    $key = $parent->filterXPath('node()')->attr('value');
    $value = $parent->filterXPath('node()')->text();
    return "$key|$value";
});

$map = [];
foreach ($languages as $language) {
    if (strtolower($language) === "|any") {
        continue;
    }
    $parse = explode('|', $language);
    $map[$parse[0]] = $parse[1];
}

$fp = fopen("./tmp/language.json", 'w');
fwrite($fp, json_encode($map, JSON_PRETTY_PRINT));
fclose($fp);

$categories = $doc->filterXPath('//*[@id="category"]/option')->each(function (Crawler $parent) : string {
    $key = $parent->filterXPath('node()')->attr('value');
    $value = $parent->filterXPath('node()')->text();
    return "$key|$value";
});

$map = [];
foreach ($categories as $category) {
    if (strtolower($category) === "|any") {
        continue;
    }
    $parse = explode('|', $category);
    $map[$parse[0]] = $parse[1];
}

$fp = fopen("./tmp/category.json", 'w');
fwrite($fp, json_encode($map, JSON_PRETTY_PRINT));
fclose($fp);