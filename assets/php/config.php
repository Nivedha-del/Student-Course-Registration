<?php
// Database connection file

// 1. Connect to MySQL (XAMPP default: user = root, no password)
$mysqli = new mysqli("localhost", "root", "", "student_portal");

// 2. Check connection
if ($mysqli->connect_errno) {
    http_response_code(500); // server error
    header("Content-Type: application/json");
    echo json_encode([
        "success" => false,
        "message" => "MySQL connection failed"
    ]);
    exit;
}

// 3. Set character set (optional but good)
$mysqli->set_charset("utf8mb4");

// 4. Default response type for all PHP files that include this
header("Content-Type: application/json");
?>
