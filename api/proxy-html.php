<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    
    $data = json_decode(file_get_contents('php://input'), true);
    $url = $data['url'];
    
    if (!$url) {
        die('Please, inform URL');
    }
    
    $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
    
    $html = file_get_contents($url);
    echo $html;
?>