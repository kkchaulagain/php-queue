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
        $queue = array_key_exists('queue', $config) ? $config['queue'] : 'default';
        $vhost = array_key_exists('vhost', $config) ? $config['vhost'] : '/';
        if (!array_key_exists($queue, self::$instances)) {
            self::$instances[$queue]  =  new AMQPStreamConnection($config['host'], $config['port'], $config['user'], $config['password'], $vhost);
        }
        return self::$instances[$queue];
    }

    // check if connection is alive
    public static function isConnected(array $config): bool
    {
        $queue = array_key_exists('queue', $config) ? $config['queue'] : 'default';
        $vhost = array_key_exists('vhost', $config) ? $config['vhost'] : '/';
        if (!array_key_exists($queue, self::$instances)) {
            // if connection is not initialized,  return false
            return false;
        }
        return self::$instances[$queue]->isConnected();
    }
}
