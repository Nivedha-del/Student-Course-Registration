<?php
// assets/php/login.php
header('Content-Type: application/json');

// TEMP: show PHP errors in browser so we can debug if needed
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // 1) DB connection (this file must define $pdo = new PDO(...))
  require __DIR__ . '/db.php';



    if (!isset($pdo)) {
        throw new Exception('DB connection ($pdo) not defined in db.php');
    }

    // 2) Redis client
    $redis = require __DIR__ . '/redis.php';

    $email    = $_POST['email']    ?? '';
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        echo json_encode([
            'success' => false,
            'message' => 'Email and password are required'
        ]);
        exit;
    }

    // 3) Find user in MySQL
    $stmt = $pdo->prepare("
        SELECT id, full_name, email, password_hash
        FROM users
        WHERE email = ?
        LIMIT 1
    ");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user['password_hash'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid email or password'
        ]);
        exit;
    }

    // 4) Generate random session token
    $token = bin2hex(random_bytes(32));

    // Store in Redis with a TTL (e.g. 30 minutes = 1800 seconds)
    $redisKey = "session:" . $token;
    $redis->setex($redisKey, 1800, $user['id']);

    // 5) Reply JSON
    echo json_encode([
        'success'   => true,
        'message'   => 'Login successful',
        'user_id'   => $user['id'],
        'full_name' => $user['full_name'],
        'email'     => $user['email'],
        'token'     => $token
    ]);
} catch (Throwable $e) {
    // If anything fails, send error message so we can see it in Network → Response
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}
