<?php

namespace kkchaulagain\phpQueue\Bus\traits;

use kkchaulagain\phpQueue\Exceptions\ParameterNotFoundException;
use kkchaulagain\phpQueue\RabbitMQ\RabbitMQ;

trait Queueable
{
    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $connection;

    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $driver = 'rabbitmq';

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'default';


    /**
     * The number of seconds before the job should be made available.
     *
     * @var \DateTimeInterface|\DateInterval|int|null
     */
    public $delay;

    /**
     * For internal mechanism . don't change this
     *
     */
    public $nosave = false;

    /**
     * Set the desired driver for the job.
     *
     * @param string|null $driver
     * @return $this
     */
    public function onDriver($driver)
    {
        $this->driver = $driver;

        return $this;
    }


    public function onConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * Set the desired queue for the job.
     *
     * @param string|null $queue
     * @return $this
     */
    public function onQueue($queue)
    {
        $this->queue = $queue;
        return $this;
    }



    /**
     * Set the desired delay for the job.
     *
     * @param \DateTimeInterface|\DateInterval|int|null $delay
     * @return $this
     */
    public function delay($delay)
    {
        $this->delay = $delay;

        return $this;
    }

    public function save($payload)
    {

        $date = new \DateTime();
        $timestamp = $date->getTimestamp();
        $model = new \stdClass();
        $model->queue = $this->queue;
        $model->payload = $payload;
        $model->reserved_at = $timestamp;
        $model->created_at = $timestamp;
        $this->saveToRabbitMq($model);
    }

    public function saveToRabbitMq($payload)
    {
        if (is_null($this->connection)) {
            throw new ParameterNotFoundException('RabbitMq Connection configuration not found');
        }
        $data = [
            'queue' => $this->queue,
            'delay' => $this->delay,
            'user' => 'guest',
            'password' => 'guest',
            'host' => 'rabbitmqqueue',
            'port' => 5672
        ];
        RabbitMQ::publishMessage($data, json_encode($payload));
    }


    public function getNameOfClass()
    {
        return get_called_class();
    }

    public function setProperties($properties)
    {
        foreach ($properties as $key => $property) {
            $this->$key = $property;
        }
        $this->nosave = true;
    }
}
