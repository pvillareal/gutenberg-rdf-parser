#!/usr/bin/env php
<?php

use DI\Container;
use Gutenberg\Parser\Enums\Parser;
use Gutenberg\Parser\TermsParser;
use Gutenberg\Parser\TestCloudkit;

include "./bootstrap.php";

/** @global Container $container */


$options = getopt("p:", ["process:"]);

$process = strtolower($options["p"] ?? "none");

echo "processing $process" . PHP_EOL;
if ($process === "all") {
    $container->call(TermsParser::class);
}

if ($process === "terms") {
    $container->call(TermsParser::class);
}

if ($process === "test") {

}