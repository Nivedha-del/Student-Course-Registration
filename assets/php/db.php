<?php
// assets/php/db.php

$host = 'localhost';
$db   = 'student_portal';   // your MySQL database name
$user = 'root';             // XAMPP default user
$pass = '';                 // XAMPP default password (empty)

// PDO connection
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

$pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
