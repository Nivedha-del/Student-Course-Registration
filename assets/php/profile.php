<?php
// assets/php/profile.php
require_once "config.php";   // uses $mysqli from config.php

$action = $_POST['action'] ?? '';

if ($action === 'load') {
    $user_id = intval($_POST['user_id'] ?? 0);

    if (!$user_id) {
        echo json_encode(["success" => false, "message" => "Missing user id"]);
        exit;
    }

    $stmt = $mysqli->prepare("SELECT full_name, email, age, dob, contact, courses, semester FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    if ($data) {
        echo json_encode(["success" => true, "data" => $data]);
    } else {
        echo json_encode(["success" => false, "message" => "User not found"]);
    }
    exit;
}

if ($action === 'update_profile') {
    $user_id   = intval($_POST['user_id'] ?? 0);
    $full_name = $_POST['full_name'] ?? '';
    $age       = $_POST['age'] ?? null;
    $dob       = $_POST['dob'] ?? null;
    $contact   = $_POST['contact'] ?? '';

    $stmt = $mysqli->prepare("UPDATE users SET full_name = ?, age = ?, dob = ?, contact = ? WHERE id = ?");
    $stmt->bind_param("sissi", $full_name, $age, $dob, $contact, $user_id);
    $ok = $stmt->execute();
    $stmt->close();

    echo json_encode([
        "success" => $ok,
        "message" => $ok ? "Profile updated" : "Update failed"
    ]);
    exit;
}

if ($action === 'save_courses') {
    $user_id = intval($_POST['user_id'] ?? 0);
    $courses = $_POST['courses'] ?? [];
    $semester = $_POST['semester'] ?? '';

    $courses_json = json_encode($courses);

    $stmt = $mysqli->prepare("UPDATE users SET courses = ?, semester = ? WHERE id = ?");
    $stmt->bind_param("ssi", $courses_json, $semester, $user_id);
    $ok = $stmt->execute();
    $stmt->close();

    echo json_encode([
        "success" => $ok,
        "message" => $ok ? "Courses saved" : "Failed to save courses"
    ]);
    exit;
}

echo json_encode(["success" => false, "message" => "Invalid action"]);
