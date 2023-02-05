<?php

namespace kkchaulagain\phpQueue\RabbitMQ;

use kkchaulagain\phpQueue\Exceptions\ParameterNotFoundException;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

class RabbitMQ
{

    private $queue;
    private $exchange;
    private $user;
    private $password;
    private $host;
    private $port;
    private $delay;
    private $headers = [];
    private $vhost = '/';



    public function __construct($params)
    {
        if (array_key_exists('queue', $params)) {
            $this->queue = $params['queue'];
        } else {
            throw new ParameterNotFoundException('Queue Name is Required', 422);
        }

        if (array_key_exists('exchange', $params)) {
            $this->exchange = $params['exchange'];
        } else {
            $this->exchange = $this->queue . 'queue.live';
        }
        if (array_key_exists('user', $params)) {
            $this->user = $params['user'];
        } else {
            throw new ParameterNotFoundException('User is Required', 422);
        }

        if (array_key_exists('password', $params)) {
            $this->password = $params['password'];
        } else {
            throw new ParameterNotFoundException('Password is Required', 422);
        }

        if (array_key_exists('vhost', $params)) {
            $this->vhost = $params['vhost'];
        }

        if (array_key_exists('host', $params)) {
            $this->host = $params['host'];
        } else {
            throw new ParameterNotFoundException('Host Name is Required', 422);
        }
        if (array_key_exists('port', $params)) {
            $this->port = $params['port'];
        } else {
            $this->port = 5672;
        }
        if (array_key_exists('delay', $params)) {
            $this->delay = $params['delay'];
            $this->headers[]['x-delay'] = $this->delay;
        }


        $this->connect();
        $this->prepareChannel();
    }

    public function connect()
    {
        $this->connection = RabbitMQConnection::getInstance([
            'host' => $this->host,
            'port' => $this->port,
            'user' => $this->user,
            'password' => $this->password,
            'vhost' => $this->vhost
        ]);
    }


    public function prepareChannel()
    {
        $channel = $this->connection->channel();


        $channel->queue_declare($this->queue, false, false, false, false);

        $channel->exchange_declare($this->exchange, AMQPExchangeType::DIRECT, false, false, false);


        $channel->queue_bind($this->queue, $this->exchange);

        $this->channel = $channel;
    }


    public function listen($callback = false)
    {
        if ($callback !== false) {
            $this->channel->basic_qos(null, 1, null);

            $this->channel->basic_consume($this->queue, '', false, false, false, false, $callback);

            while ($this->channel->is_consuming()) {
                $this->channel->wait();
            }
        }
    }


    public function setMessage($message)
    {
        $extrainfo = [
            'content_type' => 'application/json',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
            'application_headers' => new AMQPTable($this->headers)
        ];


        $this->message = new AMQPMessage(
            json_encode($message),
            $extrainfo
        );
        return $this;
    }


    public function publish()
    {
        $this->channel->basic_publish($this->message, $this->exchange);
        $this->close();
    }


    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }

    public static function publishMessage(array $config, $message)
    {
        (new static($config))->setMessage($message)->publish();
    }

    public static function listenAndCallBack(array $config, $callback = false)
    {
        (new static($config))->listen($callback);
    }
}
