<?php
require_once "src/user/UsersApi.php";

if(isset($_SERVER['HTTP_ORIGIN'])){
    $url = $_SERVER['HTTP_ORIGIN'];
    header("Access-Control-Allow-Origin: {$url}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
}

try {
    $api = new UsersApi();
    echo $api->run();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}



