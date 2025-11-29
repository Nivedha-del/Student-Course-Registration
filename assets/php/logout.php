<?php
header("Content-Type: application/json");

$redis = require __DIR__ . '/redis.php';

$token = $_POST['token'] ?? null;

if (!$token) {
    echo json_encode(["success" => false, "message" => "Token missing"]);
    exit;
}

// Remove login session from Redis
$redis->del($token);

echo json_encode(["success" => true, "message" => "Logged out"]);
?>
