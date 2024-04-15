<?php

namespace Gutenberg\CloudKit;

use DateTime;
use DateTimeZone;
use Exception;
use Gutenberg\CloudKit\Enums\CKEnvironments;
use Gutenberg\CloudKit\Enums\DatabaseTypes;
use Gutenberg\CloudKit\Enums\OperationUri;
use OpenSSLAsymmetricKey;

class CloudKitService
{

    public string $path = "https://api.apple-cloudkit.com";
    public string $version = "1";
    protected string $requestBody = "";
    protected string $keyId = "";

    protected OpenSSLAsymmetricKey $privateKey;

    public function __construct(
        protected string $container,
        protected OperationUri $operationUri,
        protected CKEnvironments $environment = CKEnvironments::DEV,
        protected DatabaseTypes $database = DatabaseTypes::PUBLIC
    )
    {
    }

    public function getServiceUrl(bool $subpath = false) : string
    {
        $environment = $this->environment->value;
        $uri = $this->operationUri->value;
        $database = $this->database->value;
        $url = [$this->path, "database", $this->version, $this->container, $environment, $database, $uri];
        if ($subpath === true) {
            array_shift($url);
            $url[0] = "/" . $url[0];
        }
        return implode("/", $url);
    }

    public function getIsoDate() : string
    {
        try {
            $date = new DateTime('NOW', new DateTimeZone('UTC'));
        } catch (Exception $e) {
        }
        return $date->format('Y-m-d\TH:i:s\Z');
    }


    /**
     * @return string
     */
    public function getKeyId(): string
    {
        return $this->keyId;
    }

    /**
     * @param string $keyId
     */
    public function setKeyId(string $keyId): void
    {
        $this->keyId = $keyId;
    }

    /**
     * @return string
     */
    public function getRequestBody(): string
    {
        return $this->requestBody;
    }

    /**
     * @param string $requestBody
     */
    public function setRequestBody(string $requestBody): void
    {
        $this->requestBody = $requestBody;
    }

    public function getHeaders() : array
    {
        $iso = $this->getIsoDate();
        $base64 = base64_encode(hash('sha256', $this->getRequestBody(), true));
        $requestUrl = $this->getServiceUrl(true);
        $keyChain = "$iso:$base64:$requestUrl";
        $pkeyid = $this->getPrivateKey();
        openssl_sign($keyChain, $signature, $pkeyid, "sha256WithRSAEncryption");
        return [
            "content-type" => "text/plain",
            "X-Apple-CloudKit-Request-KeyID" => $this->getKeyId(),
            "X-Apple-CloudKit-Request-ISO8601Date" => $iso,
            "X-Apple-CloudKit-Request-SignatureV1" => base64_encode($signature)
        ];
    }

    /**
     * @return OpenSSLAsymmetricKey
     */
    public function getPrivateKey(): OpenSSLAsymmetricKey
    {
        return $this->privateKey;
    }

    /**
     * @param OpenSSLAsymmetricKey $privateKey
     */
    public function setPrivateKey(OpenSSLAsymmetricKey $privateKey): void
    {
        $this->privateKey = $privateKey;
    }


}