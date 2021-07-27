<?php

namespace kkchaulagain\phpQueue;

use kkchaulagain\phpQueue\Bus\Pipeline;
use kkchaulagain\phpQueue\Exceptions\ParameterNotFoundException;

class Consumer
{
    public static function consume(array $config)
    {
        if(array_key_exists('queue',$config)){
            $queue = $config['queue'];
        }else{
            throw new ParameterNotFoundException('queue name is required');
        }
        $vhost = isset($config['vhost'])?$config['vhost']:'/';
        $pipeline = new Pipeline($config);
        $pipeline->executeMqJobs($vhost);
    }
}
