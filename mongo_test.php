<?php
require __DIR__ . '/vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->student_portal;

// insert example data
$result = $db->students->insertOne([
    'name' => 'Nivedha',
    'email' => 'nivedha@mail.com',
    'course' => 'Full Stack'
]);

echo "Inserted with ID: " . $result->getInsertedId();
