<?php

namespace Gutenberg\CloudKit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class Service
{

    private static ?Client $client = null;

    /**
     * @throws GuzzleException
     */
    public static function post(string $url, string $body, array $headers) : ResponseInterface
    {
        $client = self::getClient();
        return $client->request('POST', $url, ['body' => $body, 'headers' => $headers]);
    }

    public static function getClient() : Client
    {
        if (is_null(self::$client)) {
            self::$client = new Client();
        }
        return self::$client;
    }

}