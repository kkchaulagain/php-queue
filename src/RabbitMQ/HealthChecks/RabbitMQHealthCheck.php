<?php

namespace kkchaulagain\phpQueue\RabbitMQ\HealthChecks;

use kkchaulagain\phpQueue\RabbitMQ\Connections\RabbitMQConnection;

class RabbitMQHealthCheck
{
    public static function check(array $config)
    {
        try {
            return RabbitMQConnection::isConnected($config);
        } catch (\Exception $e) {
            return false;
        }
    }
}
