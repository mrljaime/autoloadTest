<?php
/**
 * Created by PhpStorm.
 * User: jaime
 * Date: 24/07/17
 * Time: 21:08
 */
require_once __DIR__ . "/autoload.php";
require_once __DIR__ . "/vendor/autoload.php";


use App\RabConn;

$rabConn = new RabConn("localhost", 5672, "guest", "guest", "/");

$rabConn->consume("router", "msgs", "consumer", function($message) {
    echo "\n--------------\n";
    echo $message->body;
    echo "\n--------------\n";

    $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
    // Send a message with the string "quit" to cancel the consumer.
    if ($message->body === 'quit') {
        $message->delivery_info['channel']->basic_cancel($message->delivery_info['consumer_tag']);
    }
});
