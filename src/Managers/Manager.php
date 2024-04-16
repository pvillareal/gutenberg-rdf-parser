<?php

namespace Gutenberg\Managers;

use Doctrine\DBAL\Connection;

class Manager
{

    public function __construct(
        protected Connection $connection
    )
    {
    }
}