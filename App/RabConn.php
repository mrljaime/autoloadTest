<?php

namespace App;


use App\Interfaces\RabConnInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabConn implements RabConnInterface
{
    private $amqpStreamConnection;
    private $channel;
    private $queue;
    private $exchange;

    /**
     * RabConnInterface constructor.
     *
     *
     * Just to start connection on RabbitMQ
     *
     * @param $host
     * @param $port
     * @param $user
     * @param $pass
     * @param $vhost
     */
    public function __construct($host, $port, $user, $pass, $vhost)
    {
        $this->amqpStreamConnection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost);
        $this->channel = $this->amqpStreamConnection->channel();
    }

    /**
     * Is calling when connection is used to send messages
     *
     * @param string $queue
     * @param string $exchange
     * @return $this
     */
    public function queue($queue = "msgs", $exchange = "router")
    {
        $this->queue = $queue;
        $this->exchange = $exchange;
        $this->channel->queue_declare($this->queue, false, true, false, false);
        $this->channel->exchange_declare($this->exchange, "direct", false, true, false);
        $this->channel->queue_bind($this->queue, $this->exchange);

        return $this;
    }

    /**
     * Consumes on message queue
     *
     * @param string $exchange
     * @param string $queue
     * @param string $consumerTag
     * @return mixed
     */
    public function consume($exchange = "router", $queue = "msgs", $consumerTag = "consumer", $callback)
    {
        $this->queue = $queue;
        $this->exchange = $exchange;

        $this->channel->queue_declare($this->queue, false, true, false, false);
        $this->channel->exchange_declare($this->exchange, "direct", false, true, false);

        $this->channel->basic_consume($this->queue, $consumerTag, false, false, false, false, $callback);

        // Loop as long as the channel has callbacks registered
        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }

    /**
     * Close all comunication with RabbitMQ
     *
     * @return mixed
     */
    public function disconnect()
    {
        $this->channel->close();
        $this->amqpStreamConnection->close();
    }

    /**
     * Receive a message to write on RabbitMQ
     *
     * @param $message
     * @param $contentType
     * @return mixed
     */
    public function sendMessage($message, $contentType = "text/plain"): bool
    {
        $message = new AMQPMessage($message, array(
            "content_type"  => $contentType,
            "delivery_mode" => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ));

        try {
            $this->channel->basic_publish($message, $this->exchange);

            return true;
        } catch (\Exception $e) {

            return false;
        }
    }
}
