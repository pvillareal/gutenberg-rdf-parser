#!/usr/bin/env php
<?php

use DI\Container;
use Gutenberg\Parser\BatchList;

include "./bootstrap.php";

/** @global Container $container */


$container->call(BatchList::class);