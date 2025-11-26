<?php
// register.php – handle signup
require_once "config.php";

$full_name        = $_POST['full_name']        ?? '';
$email            = $_POST['email']            ?? '';
$password         = $_POST['password']         ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if (!$full_name || !$email || !$password || !$confirm_password) {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}

if ($password !== $confirm_password) {
    echo json_encode(["success" => false, "message" => "Passwords do not match"]);
    exit;
}

// hash password
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// check if email already exists
$stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    echo json_encode(["success" => false, "message" => "Email already registered"]);
    exit;
}
$stmt->close();

// insert new user
$stmt = $mysqli->prepare("INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $full_name, $email, $password_hash);
$ok = $stmt->execute();
$stmt->close();

if ($ok) {
    echo json_encode(["success" => true, "message" => "Registration successful"]);
} else {
    echo json_encode(["success" => false, "message" => "Registration failed"]);
}
