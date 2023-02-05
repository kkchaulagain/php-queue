<?php

namespace kkchaulagain\phpQueue\RabbitMQ\Connections;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQConnection
{
    private static $instances = [];

    private function __construct()
    {
    }
    private function __clone()
    {
    }

    public static function getInstance(array $config): AMQPStreamConnection
    {
        $vhost = array_key_exists('vhost', $config) ? $config['vhost'] : '/';
        if (!array_key_exists($vhost, self::$instances)) {
            self::$instances[$vhost]  =   new AMQPStreamConnection($config['host'], $config['port'], $config['user'], $config['password'], $vhost);
        }
        return self::$instances[$vhost];
    }
}
