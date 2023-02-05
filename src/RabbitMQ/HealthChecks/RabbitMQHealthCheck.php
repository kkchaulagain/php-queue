<?php

namespace kkchaulagain\phpQueue\RabbitMQ\HealthChecks;

use kkchaulagain\phpQueue\RabbitMQ\Connections\RabbitMQConnection;

class RabbitMQHealthCheck
{
    public static function check(array $config)
    {
        try{
            $connection = RabbitMQConnection::getInstance($config);
            return $connection->isConnected();
        }
        catch (\Exception $e){
            return false;
        }
    }
}
