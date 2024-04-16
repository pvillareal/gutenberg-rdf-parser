<?php

use DI\ContainerBuilder as ContainerBuilderAlias;

include "./vendor/autoload.php";

global $container;
$containerBuilder = new ContainerBuilderAlias();
$containerBuilder->addDefinitions(include "./config/config.php");
$containerBuilder->addDefinitions(include "./config/di.php");
$containerBuilder->addDefinitions(include "./config/parsers.php");

try {
    $container = $containerBuilder->build();
} catch (Exception $e) {
}