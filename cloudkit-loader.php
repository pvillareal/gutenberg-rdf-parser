<?php

use GuzzleHttp\Exception\GuzzleException;

include "./vendor/autoload.php";

$client = new \GuzzleHttp\Client();

$baseUrl = "https://api.apple-cloudkit.com";
$requestUrl = "/database/1/iCloud.pvillareal_cloudkit_test/development/public/records/modify";
//try {
//    $query = [
//        "zoneID" => [
//            "zoneName" => '_defaultZone'
//        ],
//        "query" => [
//            "recordType" => "BookData",
//            "filterBy" => [
//                [
//                    "systemFieldName" => "id",
//                    "comparator" => "EQUALS",
//                    "fieldValue" => [
//                        "value" => [
//                            "recordName" => 1
//                        ]
//                    ],
//                    "type" => "REFERENCE"
//                ]
//            ]
//        ]
//    ];
//    $json = json_encode($query);
//    $response = $client->request('POST', $requestUrl, ['cert' => ['./certs/eckey.pem', ''], 'body' => $json]);
//    echo $response->getBody();
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//}

$request = [
    "operationType" => "create",
    "record" => [
        "recordType" => "BookData",
        "fields" => [
            "id" => ["value" => 1],
            "title" => ["value" => "The Declaration of Independence of the United States of America"],
            "language" => ["value" => "en"],
            "releaseDate" => ["value" => "1971-12-01"],
        ],
        "recordName" => "1"
    ]
];

$operations = [
    "operations" => []
];

$operations["operations"][] = $request;

$json = json_encode($operations);
$hashedStr = hash('sha256', $json, true);
$base64 = base64_encode($hashedStr);
$date = new DateTime('NOW', new DateTimeZone('UTC'));
$iso = $date->format('Y-m-d\TH:i:s\Z');
$dateOnly = $date->format('Y-m-d');
$keyChain = "$iso:$base64:$requestUrl";
echo $keyChain;
$pkeyid = openssl_pkey_get_private("file://" . 'certs/eckey.pem');
openssl_sign($keyChain, $signature, $pkeyid, "sha256WithRSAEncryption");

$headers = [
    "content-type" => "text/plain",
    "X-Apple-CloudKit-Request-KeyID" => "a9e157f9014e6ca5d1aecd9f92b55ad8bc82f8074e1417936b6328d5b3779178",
    "X-Apple-CloudKit-Request-ISO8601Date" => $iso,
    "X-Apple-CloudKit-Request-SignatureV1" => base64_encode($signature)
];

$test = [
    "uri" => $baseUrl . $requestUrl,
    "body" => $json,
    "headers" => $headers,
];

try {
    $response = $client->request('POST', $baseUrl . $requestUrl, ['body' => $json, 'headers' => $headers]);
    echo $response->getStatusCode() . PHP_EOL;
    echo $response->getBody();
} catch (GuzzleException $e) {

}

var_dump($test);

