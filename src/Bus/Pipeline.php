<?php

namespace kkchaulagain\phpQueue\Bus;

use kkchaulagain\phpQueue\RabbitMQ\RabbitMQ;

class Pipeline
{

    private $method = 'handle';
    private $classname;
    public $data, $type;
    public $job;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function executeMqJobs($vhost='/')
    {

        $config = [
            'queue' => $this->type,
            'exchange' => $this->type . '.queue.live',
            'vhost' => $vhost,
            'host' => 'rabbitmqqueue',
            'user' => 'guest',
            'password' => 'guest'
        ];
        $callback = function ($msg) {
            try {
                $this->data = json_decode(json_decode($msg->body), true);
                $this->handleRequest();
                $msg->ack();
            } catch (\Exception $e) {
                $message = "Error: {$e->getMessage()} \n File :{$e->getFile()} \n Line No : {$e->getLine()}\n\n";
                echo $message;
                $msg->nack(true);
            }
        };
        RabbitMQ::listenAndCallBack($config, $callback);
    }



    public function handleRequest()
    {
        if (is_string($this->data['payload'])) {
            $payload = (object) json_decode($this->data['payload']);
        } else {
            $payload = (object) $this->data['payload'];
        }

        $this->classname  = $payload->classname;
        if ($this->classname) {
            echo $this->classname . '::Processing' . PHP_EOL;
            $this->initClass($this->classname, $payload->data);
            $this->callHandleMethod();
            echo $this->classname . '::Completed' . PHP_EOL . PHP_EOL;
        }
    }

    public function initClass($classname, $params)
    {
        $queue = new $classname();
        $properties = json_decode($params);
        $queue->setProperties($properties);
        $this->job = $queue;
    }

    public function callHandleMethod()
    {
        $methodName = $this->method;
        $this->job->$methodName();
    }
}
