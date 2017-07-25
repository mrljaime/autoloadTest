<?php
/**
 * Created by PhpStorm.
 * User: jaime
 * Date: 24/07/17
 * Time: 20:45
 */

namespace App\Interfaces;

interface RabConnInterface
{
    /**
     * RabConnInterface constructor.
     *
     *
     * Just to start connection on RabbitMQ
     *
     */
    public function __construct();


    /**
     * Is calling when connection is used to send messages
     *
     * @param string $queue
     * @param string $exchange
     * @return mixed
     */
    public function queue($queue = "msgs", $exchange = "router");


    /**
     * Receive a message to write on RabbitMQ
     *
     * @param $message
     * @param $contentType
     * @return mixed
     */
    public function sendMessage($message, $contentType = "text/plain");


    /**
     * Consumes on message queue
     *
     * @param string $exchange
     * @param string $queue
     * @param string $consumerTag
     * @return mixed
     */
    public function consume($exchange = "router", $queue = "msgs", $consumerTag = "consumer", $callback);

    /**
     * Close all comunication with RabbitMQ
     *
     * @return mixed
     */
    public function disconnect();

}