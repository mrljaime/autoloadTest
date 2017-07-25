<?php

require_once __DIR__ . "/autoload.php";
require_once __DIR__ . "/vendor/autoload.php";


use App\RabConn;

$rabConn = new RabConn("localhost", 5672, "guest", "guest", "/");
$rabConn->queue()->sendMessage("{\"from\": 1, \"to\": 2}");

$rabConn->disconnect();