<?php

namespace kkchaulagain\phpQueue;

use kkchaulagain\phpQueue\Bus\Pipeline;

class Consumer
{
    public static function consume(array $config)
    {
        if(array_key_exists('queue',$config)){
            $queue = $config['queue'];
        }
        $vhost = $config['vhost']?$config['vhost']:'/';
        $pipeline = new Pipeline($queue);
        $pipeline->executeMqJobs($vhost);
    }
}
