<?php

require_once __DIR__ . "/autoload.php";
require_once __DIR__ . "/vendor/autoload.php";


use App\RabConn;

/**
 * Set dir config
 */
$rabConn = new RabConn();

$start = microtime(true);
for ($i = 1; $i <= 1000; $i++) {
    $rabConn->queue()->sendMessage("{\"from\": 1, \"to\": $i}");
    if ($i == 1000) {
        echo "\n-------------\n";
        echo "On 1000 message";
        echo "\n-------------\n";
    }
}

$end = microtime(true);

echo "\n-------------\n";
echo sprintf("I send 1000 message on %s", ($end - $start));
echo "\n-------------\n";


$rabConn->disconnect();