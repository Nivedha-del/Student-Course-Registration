<?php
require __DIR__ . '/../../vendor/autoload.php';

return new Predis\Client([
    'scheme' => 'tcp',
    'host'   => '127.0.0.1',
    'port'   => 6379,
]);
