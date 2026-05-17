<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

$url = $data['url'] ?? null;

if (!$url) {
    http_response_code(400);
    die('Missing URL');
}

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false,

    CURLOPT_HTTPHEADER => [
        'Accept: application/json',
        'Accept-Language: en-US,en;q=0.9',
    ],

    CURLOPT_USERAGENT =>
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36'
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    http_response_code(500);
    echo curl_error($ch);
    exit;
}

curl_close($ch);

header('Content-Type: application/json');

echo $response;