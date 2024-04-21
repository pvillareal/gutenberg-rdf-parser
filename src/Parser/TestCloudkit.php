<?php

namespace Gutenberg\Parser;

use Gutenberg\CloudKit\ServerService;
use Gutenberg\CloudKit\Enums\OperationUri;
use Psr\Http\Client\ClientInterface;

class TestCloudkit
{

    public function __construct(
        protected ServerService $service,
    )
    {
    }

    public function __invoke()
    {
//        $json = ["cover"=>"https://www.gutenberg.org/cache/epub/16780/pg16780.cover.medium.jpg"];
        $data = file_get_contents("https://www.gutenberg.org/cache/epub/16780/pg16780.cover.medium.jpg");
        $base64 = base64_encode($data);
        var_dump($base64);
    }

}