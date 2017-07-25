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
use App\Container;
use App\Util;

/**
 * DependencyInjection
 */
$container = new Container();
$rabConn = new RabConn();

$rabConn->consume("router", "msgs", "consumer", function($message) use ($container) {

    $result = Util\PdoUtil::selectPrepared($container->dbConnection->connection, "SELECT id, email FROM users");
    foreach ($result as $user) {
        echo "\n--------------\n";
        echo sprintf("userId: %s, userName: %s", $user["id"], $user["email"]);
        echo "\n--------------\n";
    }

    echo "\n--------------\n";
    echo $message->body;
    echo "\n--------------\n";

    $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
    // Send a message with the string "quit" to cancel the consumer.
    if ($message->body === 'quit') {
        $message->delivery_info['channel']->basic_cancel($message->delivery_info['consumer_tag']);
    }
});
