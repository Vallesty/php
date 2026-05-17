<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Method Not Allowed');
}

$data = json_decode(file_get_contents('php://input'), true);

$url = $data['url'] ?? null;

if (!$url) {
    http_response_code(400);
    die('Please inform URL');
}

$agent = 'Mozilla/5.0';

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$html = curl_exec($ch);

if (curl_errno($ch)) {
    http_response_code(500);
    echo curl_error($ch);
    exit;
}

curl_close($ch);

header('Content-Type: text/html');

echo $html;