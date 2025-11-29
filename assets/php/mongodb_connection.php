<?php
require __DIR__ . '/vendor/autoload.php';

try {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $db = $client->student_portal;

    echo "MongoDB Connected Successfully!";
} catch (Exception $e) {
    echo "Connection Failed: " . $e->getMessage();
}
?>
