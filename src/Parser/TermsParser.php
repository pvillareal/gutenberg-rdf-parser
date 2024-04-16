<?php

namespace Gutenberg\Parser;

use Gutenberg\Managers\Enums\TermsTables;
use Gutenberg\Managers\TermsManager;
use Symfony\Component\DomCrawler\Crawler;

class TermsParser
{
    
    public function __construct(
        protected TermsManager $manager
    )
    {
    }

    public function __invoke()
    {
        $manager = $this->manager;
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
            $description = explode(" ", $parse[1]);
            array_shift($description);
            $map[$parse[0]] = implode(" ", $description);
        }

        $records = $manager->buildLookUp($map, TermsTables::LCC->value);
        assert($records === count($map), "LCC Lookup Incomplete data");

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

        $records = $manager->buildLookUp($map, TermsTables::FILETYPE->value);
        assert($records === count($map), "Files Lookup Incomplete data");

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

        $records = $manager->buildLookUp($map, TermsTables::LANGUAGE->value);
        assert($records === count($map), "Language Lookup Incomplete data");

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

        $records = $manager->buildLookUp($map, TermsTables::CATEGORY->value);
        assert($records === count($map), "Category Lookup Incomplete data");
    }

}