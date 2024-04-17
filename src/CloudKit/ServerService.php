<?php

namespace Gutenberg\CloudKit;

use DateTime;
use DateTimeZone;
use Exception;
use Gutenberg\CloudKit\Enums\CKEnvironments;
use Gutenberg\CloudKit\Enums\DatabaseTypes;
use Gutenberg\CloudKit\Enums\OperationUri;
use GuzzleHttp\Exception\GuzzleException;
use OpenSSLAsymmetricKey;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class ServerService
{

    protected string $path = "https://api.apple-cloudkit.com";
    protected string $version = "1";
    protected OperationUri $operationUri = OperationUri::MODIFY_RECORDS;

    public function __construct(
        protected string $container,
        protected string $keyId,
        protected OpenSSLAsymmetricKey $privateKey,
        protected CKEnvironments $environment,
        protected DatabaseTypes $database,
        protected ClientInterface $client
    )
    {
    }

    public function getServiceUrl(OperationUri $uri, bool $subPath = false) : string
    {
        $environment = $this->environment->value;
        $uri = $uri->value;
        $database = $this->database->value;
        $url = [$this->path, "database", $this->version, $this->container, $environment, $database, $uri];
        if ($subPath === true) {
            $url[0] = "";
        }
        return implode("/", $url);
    }

    public function getIsoDate() : string
    {
        try {
            $date = new DateTime('NOW', new DateTimeZone('UTC'));
            return $date->format('Y-m-d\TH:i:s\Z');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getHeaders(OperationUri $uri, string $body) : array
    {
        $iso = $this->getIsoDate();
        $base64 = base64_encode(hash('sha256', $body, true));
        $requestUrl = $this->getServiceUrl($uri, true);
        $keyChain = "$iso:$base64:$requestUrl";
        $pem = $this->privateKey;
        $keyId = $this->keyId;
        openssl_sign($keyChain, $signature, $pem, "sha256WithRSAEncryption");
        return [
            "content-type" => "text/plain",
            "X-Apple-CloudKit-Request-KeyID" => $keyId,
            "X-Apple-CloudKit-Request-ISO8601Date" => $iso,
            "X-Apple-CloudKit-Request-SignatureV1" => base64_encode($signature)
        ];
    }

    public function post(OperationUri $uri, string $body) : ResponseInterface
    {
        $url = $this->getServiceUrl($uri);
        $client = $this->client;
        $headers = $this->getHeaders($uri, $body);
        try {
            return $client->request('POST', $url, ['body' => $body, 'headers' => $headers]);
        } catch (GuzzleException $e) {
            echo $e->getMessage();
        }
    }

}