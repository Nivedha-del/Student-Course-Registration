<?php
header('Content-Type: application/json');

require __DIR__ . '/db.php';
$redis  = require __DIR__ . '/redis.php';

$action = $_POST['action'] ?? '';
$token  = $_POST['token']  ?? '';

if (!$token) {
    echo json_encode([
        'success' => false,
        'message' => 'No session token provided'
    ]);
    exit;
}

// Look up user id from Redis
$userId = $redis->get("session:$token");

if (!$userId) {
    echo json_encode([
        'success' => false,
        'message' => 'Session expired. Please login again.'
    ]);
    exit;
}

try {

    if ($action === 'load') {
        $stmt = $pdo->prepare(
            "SELECT full_name, email, age, dob, contact, courses, semester
             FROM users WHERE id = ?"
        );
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode([
            'success' => true,
            'data'    => $user
        ]);
        exit;
    }

    if ($action === 'update_profile') {
        $full_name = $_POST['full_name'] ?? '';
        $age       = $_POST['age']       ?? null;
        $dob       = $_POST['dob']       ?? null;
        $contact   = $_POST['contact']   ?? '';

        $stmt = $pdo->prepare(
            "UPDATE users 
             SET full_name = ?, age = ?, dob = ?, contact = ?
             WHERE id = ?"
        );
        $stmt->execute([$full_name, $age, $dob, $contact, $userId]);

        echo json_encode([
            'success' => true,
            'message' => 'Profile updated successfully'
        ]);
        exit;
    }

    if ($action === 'save_courses') {
        $courses  = $_POST['courses'] ?? [];
        if (!is_array($courses)) $courses = [];
        $semester = $_POST['semester'] ?? '';

        $coursesJson = json_encode($courses);

        $stmt = $pdo->prepare(
            "UPDATE users 
             SET courses = ?, semester = ?
             WHERE id = ?"
        );
        $stmt->execute([$coursesJson, $semester, $userId]);

        echo json_encode([
            'success' => true,
            'message' => 'Courses saved successfully'
        ]);
        exit;
    }

    echo json_encode([
        'success' => false,
        'message' => 'Invalid action'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}
