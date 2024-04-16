#!/usr/bin/env php
<?php

use DI\Container;
use Gutenberg\Parser\Enums\Parser;

include "./bootstrap.php";

/** @global Container $container */


$options = getopt("p::");

$process = $options["p"] ?? "all";

if (strtolower($process) === "all") {
    $container->get(Parser::TERMS->value);
}

if (strtolower($process) === "terms") {
    $container->get(Parser::TERMS->value);
}