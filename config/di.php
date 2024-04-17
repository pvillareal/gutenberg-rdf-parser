<?php

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Gutenberg\CloudKit\ServerService;
use Gutenberg\CloudKit\Enums\CKEnvironments;
use Gutenberg\CloudKit\Enums\DatabaseTypes;
use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;
use Psr\Http\Client\ClientInterface;

return array(
    Connection::class => DI\factory(function (ContainerInterface $c) {
        $dbParams = $c->get("database");
        return DriverManager::getConnection($dbParams);
    }),
    ServerService::class => DI\factory(function (ContainerInterface $c) {
        $env = $c->get('env');
        $services = $c->get('services');
        $cloudkit = $services['cloudkit'];
        $environment = $env === "dev" ? CKEnvironments::DEV : CKEnvironments::PROD;
        $container = $cloudkit['container'];
        $keyId = $cloudkit['key_id'];
        $privateKey = $cloudkit['private_key'];
        return new ServerService(
            $container,
            $keyId,
            $privateKey,
            $environment,
            DatabaseTypes::PUBLIC,
            new Client()
        );
    })
);